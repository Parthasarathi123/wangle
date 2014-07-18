<?php
class New_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function set_news()
        {
	$this->load->helper('url');

	


		$username = $this->input->post('username');
		$password = $this->input->post('password');
                
        $query = $this->db->get_where('login',array('username'=>$username, 'password' =>md5($password)));
	if ($query->num_rows()==0)
        {
            return 1;
        }
 else {
            return 0;
 }
        
        
	
}
}

