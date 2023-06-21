<?php
    /*
        In an associative array, we register all the valid routes
        as keys and the corresponding methods to be triggered as values.
        The method format is the following: {controller}::{method}

        The uri should start with '/', except if it is empty.
    */
    $routes = [
        '' => 'Home::index',
        '/home' => 'Home::index'
    ];