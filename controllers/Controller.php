<?php
class Controller
{
    /**
     * Application configuration vars
     */
    public $dbDSN   = 'mysql';
    public $dbHost  = 'localhost';
    public $dbName  = 'music';
    public $dbUser  = 'web';
    public $dbPass  = 'public';

    /**
     * Variables passed to view via extract()
     */
    public $vars = array();

    /**
     * Name of view, located in /views directory.  set to default view.
     *
     * @var View
     */
    public $View;

    /**
     * Starts up the mpc interface object and element controller (the view's elements' logic dealie)
     *
     * @return void
     */
    public function __construct()
    {
        $this->mpc = new mpc();
        $this->View = new View($this);
    }

    public function index()
    {
        $this->setView();
    }

    public function saveSetting()
    {
        $this->setAjax();
        $name = $_POST['name'];
        $params = $_POST['params'];
        foreach($params as $key=>$value) {
            $_SESSION[$name][$key] = $value;
        }
    }

    public function resetPositions()
    {
        $this->setAjax();
        foreach($_SESSION as $key=>$value) 
        {
            if (substr($key, -3) === 'Pos') {
                unset($_SESSION[$key]);
            }
        }        
        $this->notice('Positions reset');
    }

    protected function setView($view = null, $layout = null)
    {
        if ($view == null) {
            $view = "index";
        }
        if ($layout == null) {
            $layout = "default";
        }
        $this->View->viewFile = $view;
        $this->View->layoutFile = $layout;
    }

    protected function setAjax($viewFile = 'blank')
    {
        $this->View->viewFile = $viewFile;
        $this->View->layoutFile = 'ajax';
    }

    protected function ajaxError($exit = true)
    {
        header('HTTP/1.x 404 Not Found');
        if ($exit === true) {
            exit('Bad Ajax Request');
        }
    }

    protected function notice($text, $redirect = true, $exit = true)
    {
        $_SESSION['noticeMessage'] = $text;
        if ($redirect === true) {
            $url = $_SERVER['HTTP_REFERER'];
        }
        elseif (is_string($redirect)) {
            $url = $redirect;
        }
        if ($redirect !== false) {
            header("Location:$url");
        }
        if ($exit === true) {
            exit();
        }
    }
}