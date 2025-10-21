<?php

$url = 'https://www.alibaba.com/product-detail/Comfortable-Rolling-Office-Chair-Swivel-Wheels_1600204355800.html?spm=a2700.galleryofferlist.p_offer.d_image.693f13a0lKBD9I&priceId=78e70d1c826c41eab9e4b5654f390361';

// initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// set a user agent (some sites serve different content if UA is missing)
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 ' .
    '(KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36');
// Optionally, follow redirects
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// execute
$html = curl_exec($ch);
if ($html === false) {
    die('cURL error: ' . curl_error($ch));
}
curl_close($ch);

// Try to locate “mediaItems” or similar JSON within the HTML
$mediaItems = null;

$html = strip_tags($html);
// var_dump($html);
// die(); 
// Approach: look for a JSON blob in a <script> tag which contains “mediaItems”
if (preg_match('/"mediaItems":\s*(\{.*?\}|\[.*?\])/s', $html, $m)) {    
    $jsonPart = $m[1];
    // Try to decode
    $decoded = json_decode($jsonPart, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $mediaItems = $decoded;
    }
}


// echo "<pre>";
// print_r($mediaItems);
// die();
// Fallback: look for image tags as fallback
if ($mediaItems === null) {
    $mediaItems = [];
    if (preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $imgMatches)) {
        foreach ($imgMatches[1] as $imgUrl) {
            $mediaItems[] = $imgUrl;
        }
    }
}

// Output result
header('Content-Type: application/json');
echo json_encode([
    'url' => $url,
    'mediaItems' => $mediaItems,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
