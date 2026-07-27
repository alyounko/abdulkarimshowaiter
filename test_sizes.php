<?php
$files = glob('c:\wamp64\www\abdulkarimshowaiter\2025\*\*.{png,jpg,jpeg}', GLOB_BRACE);

$seenSizes = [];
foreach($files as $f) {
    $size = filesize($f);
    if (!isset($seenSizes[$size])) {
        $seenSizes[$size] = [];
    }
    $seenSizes[$size][] = basename($f);
}

foreach($seenSizes as $size => $names) {
    if (count($names) > 1) {
        echo "Size $size has " . count($names) . " duplicates: \n";
        echo "   " . implode(", ", $names) . "\n";
    }
}
