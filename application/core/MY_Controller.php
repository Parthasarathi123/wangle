<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $data = Array(); //protected variables goes here its declaration

    function __construct() {

        parent::__construct();
        $this->output->enable_profiler(FALSE); // I keep this here so I dont have to manualy edit each controller to see profiler or not        
        $this->load->model('ion_auth_model'); //this can be also done in autoload...
        //load helpers and everything here like form_helper etc
    }

    protected function protectedOne() {

    }

    public function publicOne() {

    }

    private function _privateOne() {

    }

    protected function render($view_file) {

        $this->load->view('header_view');
        if ($this->_is_admin()) $this->load->view('admin_menu_view');

        $this->load->view($view_file . '_view', $this->data); //note all my view files are named <name>_view.php
        $this->load->view('footer_view');

    }

    private function _isAdmin() {

        return TRUE;

    }

}