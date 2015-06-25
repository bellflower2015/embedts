<?php
/*
 * ks.php
 * Kikyou Akino <bellflower@web4u.jp>
 *
 * Please put this in the same folder with tyranoscript's root folder
 */

$request = $_REQUEST['ks'];
$response = '';

if (preg_match('/^https?:\/\//', $request)) {
    header("Access-Control-Allow-Origin: *");
    $context = stream_context_create(array(
        'http' => array('ignore_errors' => true)
    ));
    $response = @file_get_contents($request, false, $context);

    $pos = strpos($http_response_header[0], '200');
    if ($pos === false) {
        echo "エラー：シナリオファイルをロードできません。[s]\n";
        exit;
    }
}
else {
    $request = preg_replace('/\?.*$/', '', $request);
    $request = preg_replace('/\.+\//', '', $request);
    $request = preg_replace('/^\//', '', $request);
    $request = trim($request);
    if (!empty($request)) {
        if (!preg_match('/\.ks$/', $request)) {
            $request .= '.ks';
        }
        $request = "data/scenario/{$request}";
        $response = @file_get_contents($request);
    }
}

if (empty($response)) {
    echo "エラー：シナリオファイルをロードできません。[s]\n";
    exit;
}

echo $response;
