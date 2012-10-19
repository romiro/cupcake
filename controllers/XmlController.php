<?php
class XmlController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setView('xml/output', 'ajax');
    }
    public function query()
    {

    }
}