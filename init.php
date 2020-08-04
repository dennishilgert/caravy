<?php

/**
 * Initialize global helper-functions
 */
require __DIR__ . '/src/Caravy/Support/GlobalFunctions.php';

/**
 * Initialize session management
 */
ini_set('session.gc_maxlifetime', 10800);
session_start();

/**
 * Initialize the main application
 */
$app = new \Caravy\Core\Application();