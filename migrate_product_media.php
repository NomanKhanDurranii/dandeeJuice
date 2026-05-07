<?php

// Run with: php migrate_product_media.php

$privatePath = __DIR__ . '/storage/app/private';
$publicPath  = __DIR__ . '/storage/app/public';

// IDs already in public (carousel slides moved earlier)
$alreadyMoved = ['3', '4'];

$dirs = array_filter(scandir($privatePath), fn($d) => is_numeric($d) && !in_array($d, $alreadyMoved));

foreach ($dirs as $id) {
    $src = "$privatePath/$id";
    $dst = "$publicPath/$id";

    if (!is_dir($src)) continue;

    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }

    foreach (scandir($src) as $file) {
        if ($file === '.' || $file === '..') continue;
        $from = "$src/$file";
        $to   = "$dst/$file";
        if (rename($from, $to)) {
            echo "Moved: $id/$file\n";
        } else {
            echo "FAILED: $id/$file\n";
        }
    }

    // Remove empty source dir
    @rmdir($src);
}

echo "\nDone. Now update the database:\n";
echo "UPDATE media SET disk='public', conversions_disk='public' WHERE disk='local';\n";
