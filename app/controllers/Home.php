<?php

namespace App\Controllers;
use App\Models\HomeModel;
use Exception;

class Home
{
    public function index() {


        $homeModel = new HomeModel;
        
        try 
        {
            $homeModel->getAllData('basic');
        } 
        catch(Exception $e) 
        {

        } 
        finally 
        {
            $homeModel->closeDbConnection();
        }
    }

    public function create() {
        echo 'now we create';
    }
}