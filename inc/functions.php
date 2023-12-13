<?php
session_start();
function base_path($path): string
{
    return BASE_PATH . $path;
}

function url($path = ''): string
{
    $config = require base_path('config.php');
    return $config['base_url'] . $path;
}

function redirect($path = '', $status = []): string
{
    $config = require base_path('config.php');
    if (!empty($status)) {
        $_SESSION[key($status)] = $status[key($status)];
    }
    header("Location: " . $config['base_url'] . $path);
    die();
}

function getStatus()
{
    $withErrors = $withSuccess = null;
    if (key_exists('withErrors', $_SESSION)) {
        $withErrors = $_SESSION['withErrors'];
        unset($_SESSION['withErrors']);
        return '<div class="withErrors">' . implode('</div><div class="withErrors">', $withErrors) . '</div>';
    } else if (key_exists('withSuccess', $_SESSION)) {
        $withSuccess = $_SESSION['withSuccess'];
        unset($_SESSION['withSuccess']);
        return '<div class="withSuccess">' . implode('</div><div class="withSuccess">', $withSuccess) . '</div>';
    }

}
