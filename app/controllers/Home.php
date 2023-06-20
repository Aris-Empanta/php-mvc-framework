<?php

namespace App\Controllers;
use App\Models\HomeModel;
use PDOException;

class Home
{
    public function index() {


        $homeModel = new HomeModel;
        
        try 
        {
            $row = $homeModel->getDataByCondition('basic', 'name=john');
            $name = $row[0]['name'];

            require dirname(__DIR__) . '/views/home.views.php';
        } 
        catch (PDOException $e) {

            echo "Error executing query: " . $e->getMessage();
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