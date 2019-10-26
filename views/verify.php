<?php 
$accmgr->requireLoggedOut();

if (isset($_GET['a']) && isset($_GET['t'])) {
    $acc = base64_decode($_GET['a']);
    $token = $_GET['t'];
    $accmgr->verifyEmail($token, $acc);
}

header('Location: login?email_not_verified');