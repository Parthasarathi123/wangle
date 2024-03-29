<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        //  $this->load->library('My_PHPMailer');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('admin_model');
        $user = $this->ion_auth->user()->row();
        $this->data['user'] = $user->username;
        $this->data['id'] = $user->id;
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('message', 'You must be an admin to view this page');
            redirect('employee');
        }
    }

    function index() {
        $this->data['title'] = "Admin";
        $this->data['users'] = $this->admin_model->fetch();
        $this->data['projects'] = $this->admin_model->fetch_a();
        $this->load->view('index', $this->data);
    }

    public function home($page = 'home') {


        $this->data['users'] = $this->admin_model->fetch();
        $this->data['projects'] = $this->admin_model->fetch_a();

        $this->load->view($page, $this->data);
    }

    function add_project() {
        
        $this->load->helper('form');
	$this->load->library('form_validation');
        $this->data['users'] = $this->admin_model->fetch();
        $this->data['projects'] = $this->admin_model->fetch_a();
	$data['title'] = 'Create a news item';
        $this->form_validation->set_rules('project_name', 'project_name', 'required');
	$this->form_validation->set_rules('project_description', 'project_description', 'required');
        if ($this->form_validation->run() === FALSE)
	{
		
		$this->load->view('add_project', $this->data);

	}
	else
	{
		$this->admin_model->set_project();
		$this->index();
	}
        }

}