<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
    }

    public function index()
    {
        provideAccessTo("all");
        error_reporting(0);
        $data = [];
        $this->main_lib->getTemplate("dashboard/index", $data);
    }

}

/* End of file Dashboard.php */
