<?php

namespace App\Controllers;
use App\Models\HomeModel;

class Home
{
    public function index() {
        echo 'this is the home view';
    }

    public function create() {
        echo 'now we create';
    }
}