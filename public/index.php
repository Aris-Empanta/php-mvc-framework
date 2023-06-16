<?php

require_once '../vendor/autoload.php';
use Libraries\Errors\ErrorHandler;
use Config\Router;

//Handling non-fatal errors
set_error_handler([ErrorHandler::class, 'handleNonFatalErrors']);

//Handling fatal errors
register_shutdown_function([ErrorHandler::class, 'handleFatalErrors']);

$router = new Router();

$router->handleRoutes();