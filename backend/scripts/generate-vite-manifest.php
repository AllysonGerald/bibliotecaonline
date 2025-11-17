<?php

declare(strict_types=1);

$buildDir = __DIR__ . '/../public/build';
$assetsDir = $buildDir . '/assets';
$manifestPath = $buildDir . '/manifest.json';

if (! is_dir($buildDir)) {
    mkdir($buildDir, 0755, true);
}

if (! is_dir($assetsDir)) {
    mkdir($assetsDir, 0755, true);
}

if (! file_exists($manifestPath)) {
    $manifest = [
        'resources/css/app.css' => [
            'file' => 'assets/app.css',
            'src' => 'resources/css/app.css',
            'isEntry' => true,
        ],
        'resources/js/app.js' => [
            'file' => 'assets/app.js',
            'src' => 'resources/js/app.js',
            'isEntry' => true,
        ],
    ];

    file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    if (! file_exists($assetsDir . '/app.css')) {
        file_put_contents($assetsDir . '/app.css', '/* Tailwind CSS compiled assets */');
    }

    if (! file_exists($assetsDir . '/app.js')) {
        file_put_contents($assetsDir . '/app.js', '// JavaScript compiled assets');
    }

    echo "✅ Vite manifest.json created successfully!\n";
} else {
    echo "ℹ️  Vite manifest.json already exists.\n";
}

