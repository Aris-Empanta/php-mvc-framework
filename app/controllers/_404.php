<?php

namespace App\Controllers;

class _404
{
    public function index() {
        require dirname(__DIR__) . '/views/404.views.php';
    }
}