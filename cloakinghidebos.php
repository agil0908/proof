<?php
// Settings
$white_page = "white.php"; // White page for bots
$black_page = "black.php"; // Black page for humans
$allowed_countries = []; // Allowed countries
$blocked_countries = []; // Blocked countries
$allow_vpn = true;
$block_apple = false;
$block_android = false;
$block_windows = false;
$block_mobile = false;
$block_desktop = false;
$redirect_method = 'curl'; // Choose 'iframe', 'meta', 'curl', or '302'

// Function to detect crawler
function isCrawler() {
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $crawlers = ['googlebot', 'bingbot', 'yandex', 'baiduspider', 'facebookexternalhit', 'linkedinbot'];
    foreach ($crawlers as $crawler) {
        if (strpos($user_agent, $crawler) !== false) {
            return true;
        }
    }
    return false;
}

// Function to get visitor's country
function getCountry() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $geo_data = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
    return $geo_data->countryCode ?? 'UNKNOWN';
}

// Function to detect operating system
function getOS() {
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (strpos($user_agent, 'windows') !== false) return 'windows';
    if (strpos($user_agent, 'macintosh') !== false) return 'apple';
    if (strpos($user_agent, 'android') !== false) return 'android';
    if (strpos($user_agent, 'mobile') !== false) return 'mobile';
    return 'desktop';
}

// Decide the page
if (isCrawler()) {
    header("Location: $white_page");
    exit;
}

$country = getCountry();
if (in_array($country, $blocked_countries) || (!in_array($country, $allowed_countries) && !$allow_vpn)) {
    header("Location: $white_page");
    exit;
}

$os = getOS();
if (($block_apple && $os === 'apple') ||
    ($block_android && $os === 'android') ||
    ($block_windows && $os === 'windows') ||
    ($block_mobile && $os === 'mobile') ||
    ($block_desktop && $os === 'desktop')) {
    header("Location: $white_page");
    exit;
}



switch ($redirect_method) {
    case 'iframe':
        echo "<iframe src='$black_page' style='width:100%; height:100%; border:none;'></iframe>";
        break;
    case 'meta':
        echo "<meta http-equiv='refresh' content='0;url=$black_page'>";
        break;
case 'curl':
    $ch = curl_init($black_page);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Kembalikan respons sebagai string
    $response = curl_exec($ch);
    curl_close($ch);
    
    // Pastikan konten ditampilkan
    if ($response !== false) {
        echo $response;
    } else {
        echo "Failed to fetch the content.";
    }
    break;
    case '302':
    default:
        header("Location: $black_page");
        exit;
}
?>