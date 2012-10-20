<?php

$time_start = microtime(true);

Dispatcher::main();

if (IS_AJAX === FALSE) //print out total time to run script if not an ajax call
{
    $time_end = microtime(true);
    $time = number_format(($time_end - $time_start) * 1000, 2);
    echo "<!-- " . $time . "ms -->";
}


class Dispatcher
{
    private static $controller;

    public static $charset = 'utf-8';

    public static function main()
    {
        require_once('lib/functions.php');
        session_start();
        header('Content-Type: text/html; charset=UTF-8');

        if (!function_exists('apache_request_headers')) {
            exit('Apache server is required because I\'m too lazy to figure out another way to detect for XHR. (PHP function "apache_requestHeaders" not found)');
        }

        $requestHeaders = apache_request_headers(); //get headers for AJAX detection

        define('BASEDIR', dirname(__FILE__));
        define('IS_AJAX', !empty($requestHeaders['X-Requested-With']) OR $requestHeaders['X-Requested-With'] == 'XMLHttpRequest' );
        define('DS', DIRECTORY_SEPARATOR);

        $controller = 'Controller'; //set default controller if there is 1 or none URL frags
        $action = 'index'; //set default action (that runs off of default controller) for empty URL

        if (!empty($_GET['url'])) //parse the URL for pieces
        {
            $params = explode("/", $_GET['url']); //turn URL into an array

            if (count($params) == 1 || $params[1] == '') { //both of these check for URLs with one frag
                $action = preg_replace('/[^a-zA-Z0-9-_]/', '', $params[0]);
            }
            else {
                $controller = ucwords(preg_replace('/[^a-zA-Z0-9-_]/', '', $params[0])) . "Controller";
                $action = preg_replace('/[^a-zA-Z0-9-_]/', '', $params[1]);

                $actionArguments = null;
                if (count($params) > 2) {
                    $actionArguments = array_slice($params, 2); //get an array of arguments
                }
            }
        }

        $controllerFileName = BASEDIR . DS . "controllers". DS ."$controller.php";

        if (!file_exists($controllerFileName)) {
            exit("Could not find controller file <b>$controllerFileName</b>");
        }

        require_once($controllerFileName);

      //create internally usable, externally inaccessible public class methods by prefacing the method with an underscore
      //this is the "externally inaccessible" part being implemented:
        if (substr($action, 0, 1) == '_') {
            exit("Failure to load pseudo-protected controller action <b>$action</b>.");
        }

        if (!method_exists($controller, $action)) {
            exit("Failure to load Controller action <b>$action</b>. Method does not exist.");
        }

      //Whatever string that $controller contains is the name of the class that is created here.
      //The new object is set as Dispatcher's static var $controller, via self::$controller
        self::$controller = new $controller();

      //calls the Controller's action, passing any URL arguments to it
        call_user_func_array(array( self::$controller, $action ), $actionArguments);

        self::$controller->View->render(); //renders the View which has been created by Controller's constructor method
    }
}