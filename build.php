<?php
/**
 * Build script to generate static index.html with clean UTF-8
 */
ob_start();
require_once __DIR__ . '/index.php';
$html = ob_get_clean();

file_put_contents(__DIR__ . '/index.html', $html);
echo "Successfully generated index.html with UTF-8 encoding (" . strlen($html) . " bytes)\n";
