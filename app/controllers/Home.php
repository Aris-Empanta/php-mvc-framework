<?php

namespace App\Controllers;
use App\Models\HomeModel;

class Home
{
    public function index() {
        $home = new HomeModel;
        $home->getAllData('basic');
    }

    public function create() {
        echo 'now we create';
    }
}