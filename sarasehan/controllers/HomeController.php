<?php
require_once __DIR__ . '/../models/RundownModel.php';

class HomeController {
    private $rundownModel;

    public function __construct() {
        $this->rundownModel = new RundownModel();
    }

    public function index() {
        $rundowns = $this->rundownModel->getAll();
        require_once __DIR__ . '/../views/home.php';
    }
}
?>