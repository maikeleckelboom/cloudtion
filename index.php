<?php
require_once('php/AccountManager.php');
$accmgr = new AccountManager();

// Set logged in to false if it doesn't exist.
if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

// Default page
$page = 'login';
if (isset($_GET['page'])) {
    $page = rtrim($_GET['page'], '/');
} else {
    $redir_page = "$page";
    if ($_SESSION['logged_in']) {
        $redir_page = 'dashboard'; // Go to dashboard if already logged in.
    }
    header("Location: $redir_page");
    return;
}

// Request correct view.
$file_location = "views/$page.php";
if (!file_exists($file_location)) {
    require_once('views/error/404.php');
    return;
}

// Require the view once.
require_once($file_location);

function require_login() {
    if (!$_SESSION['logged_in']) {
        header('Location: login?redirect=' . base64_encode($_SERVER['REQUEST_URI']));
        exit;
    }
}
