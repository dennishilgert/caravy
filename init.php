<?php

/**
 * Initialize global helper-functions
 */
require __DIR__ . '/src/Caravy/Support/GlobalFunctions.php';

/**
 * Initialize session management
 */
session_start();

/**
 * Initialize the main application
 */
$app = new \Caravy\Core\Application();
