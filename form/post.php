<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function uploadToCloudinary($filePath) {
    $cloudName = $_ENV['CLOUDINARY_CLOUD_NAME'];
    $apiKey = $_ENV['CLOUDINARY_API_KEY'];
    $apiSecret = $_ENV['CLOUDINARY_API_SECRET'];

    $url = "https://api.cloudinary.com/v1_1/$cloudName/image/upload";

    $postData = [
        'file' => new CURLFile($filePath),
        'upload_preset' => 'ml_default' // preset default Cloudinary
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$apiKey:$apiSecret");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function postToInstagram($imageUrl, $caption) {
    $accessToken = $_ENV['ACCESS_TOKEN'];
    $instagramId = $_ENV['INSTAGRAM_ACCOUNT_ID'];

    // 1. Buat media container
    $mediaUrl = "https://graph.facebook.com/v19.0/{$instagramId}/media";
    $postData = [
        'image_url' => $imageUrl,
        'caption' => $caption,
        'access_token' => $accessToken,
    ];

    $ch = curl_init($mediaUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_POST, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $mediaResult = json_decode($response, true);

    if (!isset($mediaResult['id'])) {
        echo "❌ Gagal membuat media container:<br>";
        echo $response;
        exit;
    }

    // 2. Publish media container
    $creationId = $mediaResult['id'];
    $publishUrl = "https://graph.facebook.com/v19.0/{$instagramId}/media_publish";

    $ch = curl_init($publishUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'creation_id' => $creationId,
        'access_token' => $accessToken
    ]));
    curl_setopt($ch, CURLOPT_POST, true);
    $publishResponse = curl_exec($ch);
    curl_close($ch);

    $publishResult = json_decode($publishResponse, true);

    if (isset($publishResult['id'])) {
        echo "✅ Berhasil memposting ke Instagram! Post ID: " . $publishResult['id'];
    } else {
        echo "❌ Gagal mempublikasikan media:<br>";
        echo $publishResponse;
    }
}

// Ambil data dari form
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$caption = $title . "\n\n" . $description;

// Simpan gambar sementara
if (!empty($_FILES['image']['tmp_name'])) {
    $tmpPath = $_FILES['image']['tmp_name'];
    $upload = uploadToCloudinary($tmpPath);

    if (isset($upload['secure_url'])) {
        postToInstagram($upload['secure_url'], $caption);
    } else {
        echo "❌ Upload ke Cloudinary gagal:<br>";
        var_dump($upload);
    }
} else {
    echo "❌ Gambar tidak ditemukan.";
}
