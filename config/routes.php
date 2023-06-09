<?php
    /*
        In an associative array, we register all the valid routes
        as keys and the corresponding methods to be triggered as values.
        The method format is the following: {controller}::{method}
    */
    $routes = [
        '' => 'Home::index',
        'home' => 'Home::index',
        'home/create' => 'Home::create',
        'home/{id}' => 'Home::create'
    ];