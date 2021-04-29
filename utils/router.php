<?php
/**
 * Routing helper
 */

 function send_json($content) {
    header('Content-Type: application/json');
    echo json_encode($content, JSON_PRETTY_PRINT);
    exit();
 }
?>