<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controller/VNPayController.php';

$vnpayController = new VNPayController();
$vnpayController->handleReturn();
?>
