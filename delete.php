<?php
function deleteFilesAndDirs($dir, $exclude = []) {
    if (!is_dir($dir)) {
        return false;
    }

    $items = array_diff(scandir($dir), ['.', '..']);

    foreach ($items as $item) {
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        
        if (is_dir($path)) {
            if (!in_array($item, $exclude)) {
                deleteFilesAndDirs($path, $exclude);
                rmdir($path);
            }
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            unlink($path);
        }
    }
}

$targetDir = __DIR__; // Ganti dengan direktori yang diinginkan
$excludeDirs = ['assets']; // Direktori yang tidak akan dihapus

deleteFilesAndDirs($targetDir, $excludeDirs);
echo "Proses selesai!";
?>
