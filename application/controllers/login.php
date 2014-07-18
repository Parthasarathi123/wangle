<?php
class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		 $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('admin_model');
        
         
	}
                
           
            public function home($page = 'home')
            {
                
              

                
                 $this->data['users'] = $this->admin_model->fetch();
                $this->load->view($page,  $this->data);
                

            }
        
      
        public function admin($page = 'home')
            {
                
               

                $this->load->view('auth/'.$page);
                
            }

	
}