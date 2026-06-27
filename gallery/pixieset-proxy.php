<?php
/**
 * Pixieset Photo Proxy
 * Fetches paginated photos from the Pixieset API and returns them as JSON.
 * The Pixieset endpoint requires the X-Requested-With: XMLHttpRequest header,
 * which cannot be sent from a cross-origin browser fetch — so this PHP proxy
 * sends it server-side via cURL.
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300'); // cache for 5 minutes

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

$url = 'https://www.shotikotsikura.com/client/loadphotos/'
     . '?cuk=hostilenoise'
     . '&cid=113028891'
     . '&page=' . $page
     . '&gs=highlights';

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; GalleryProxy/1.0)',
    CURLOPT_HTTPHEADER     => [
        'X-Requested-With: XMLHttpRequest',
        'Accept: application/json, text/javascript, */*; q=0.01',
        'Referer: https://www.shotikotsikura.com/hostilenoise/',
    ],
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error    = curl_error($ch);
curl_close($ch);

if ($error || $httpCode !== 200 || empty($response)) {
    http_response_code(502);
    echo json_encode([
        'status'  => 'error',
        'message' => $error ?: "Upstream returned HTTP $httpCode",
    ]);
    exit;
}

// Pass the Pixieset JSON response straight through.
// It has the shape: { status, isLastPage, content }
// where `content` is itself a JSON-encoded string of photo objects.
echo $response;
