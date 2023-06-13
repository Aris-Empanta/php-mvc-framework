<?php

namespace App\Controllers;
use App\Models\HomeModel;

class Home
{
    public function index() {
        $homeModel = new HomeModel;
        $homeModel->getAllData('basic');

        $homeModel->closeDbConnection();
    }

    public function create() {
        echo 'now we create';
    }
}