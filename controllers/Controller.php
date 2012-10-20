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
        $this->View = new View($this);
    }

    public function index()
    {
        $this->setView();
    }

    /**
     * Ajax method to save a name/key to the current session
     */
    public function saveSetting()
    {
        $this->setAjax();
        $name = $_POST['name'];
        $params = $_POST['params'];
        foreach($params as $key=>$value) {
            $_SESSION[$name][$key] = $value;
        }
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

    /**
     * Sets the response to be ajax
     * @param string $viewFile
     * @param string $contentType
     */
    protected function setAjax($viewFile = 'blank', $contentType = 'application/json')
    {
        $this->View->viewFile = $viewFile;
        $this->View->layoutFile = 'ajax';
        header(sprintf("Content-Type: %s; charset=%s", $contentType, Dispatcher::$charset));
    }

    /**
     *
     * @param string $message
     * @param bool $exit
     */
    protected function four04($message = 'Bad request.', $exit = true)
    {
        header('HTTP/1.x 404 Not Found');
        if ($exit === true) {
            exit($message);
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