<?php

return [
    'build_path' => env('VITE_BUILD_PATH', 'build'),
    'manifest' => env('VITE_MANIFEST', 'manifest.json'),
    'hot_file' => env('VITE_HOT_FILE', storage_path('vite.hot')),
];