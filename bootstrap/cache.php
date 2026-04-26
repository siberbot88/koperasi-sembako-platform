<?php

// Set cache paths for Heroku
if (isset($_ENV['DYNO'])) {
    // Running on Heroku
    $tmpPath = '/tmp';
    
    // Create directories if they don't exist
    @mkdir($tmpPath . '/cache', 0755, true);
    @mkdir($tmpPath . '/views', 0755, true);
    @mkdir($tmpPath . '/sessions', 0755, true);
    
    // Set environment variables
    $_ENV['VIEW_COMPILED_PATH'] = $tmpPath . '/views';
    $_ENV['CACHE_PATH'] = $tmpPath . '/cache';
    $_ENV['SESSION_PATH'] = $tmpPath . '/sessions';
}