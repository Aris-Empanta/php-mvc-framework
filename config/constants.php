<?php

/* 
    This constants are used through the entire app, so make sure 
    to modify them depending the circumstances and your environment.
*/

//In production you set it to false
define('DEBUG_MODE', true);
//The relative path to the errors' log from the root directory
define('ERRORS_LOG',  '/logs/errors.txt');
//We adjust the project's base path.
define('BASE_PATH', 'http://localhost/mvc_framework/public/');