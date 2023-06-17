<?php

namespace App\Controllers;

class Error
{
    public static function index() {
        require dirname(__DIR__) . '/views/error.views.php';
    }
}