<?php
// PageSpeed Insights API endpoint
$apiEndpoint = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
$apiKey = 'AIzaSyBW7DDyJ2eMZrhitv3wMhRl358kVLgUObI'; // Replace with your actual API key

// Parameters for the API request
$params = [
    'url' => 'https://hoolahoop.us/test/pdf_system/certificate2.php?id=3', // Assuming certificate1.php is on your local server
    'screenshot' => true,
    'key' => $apiKey,
];

// Construct API request URL
$requestUrl = $apiEndpoint . '?' . http_build_query($params);

// Send request to PageSpeed Insights API
$response = file_get_contents($requestUrl);

// Check if the response is valid
if ($response !== false) {
    // Use regular expressions to extract base64-encoded screenshot data
    if (preg_match('/"screenshot":\s*{\s*"data":\s*"([^"]+)"/', $response, $matches)) {
        // Extracted base64-encoded screenshot data
        $screenshotData = $matches[1];

        // echo $screenshotData;
        
        // Decode the base64-encoded data
        $decodedScreenshotData = base64_decode($screenshotData);

        // Check if decoding was successful
        if ($decodedScreenshotData !== false) {
            // Set appropriate header for displaying image
            header('Content-Type: image/webp');

            // Output the decoded image data
            // echo $decodedScreenshotData;
        } else {
            echo 'Failed to decode screenshot data.';
        }
    } else {
        echo 'Failed to extract screenshot data from the API response.';
    }
} else {
    echo 'Failed to fetch data from PageSpeed Insights API.';
}
?>
