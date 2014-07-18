<?php

class Admin_model extends CI_Model{
     public function fetch() {

             $this->db->select('username, id');
             $this->db->where('id !=', 1);
             $q = $this->db->get('users');
             return $q->result_array();
         }
          public function fetch_a() {
             $q = $this->db->get('projects');
             return $q->result_array();
         }
         public function set_project()
        {
            $this->load->helper('url');
           // echo $this->input->post('assigned_to');
           // die();
           // 

            $data = array(
		'project_name' => $this->input->post('project_name'),
		
		'project_description' => $this->input->post('project_description'),
                'assigned_to' => $this->input->post('assigned_to')
                           );

	return $this->db->insert('projects', $data);
        

             $sql = $this->db->get_where('users','id',1);
             return $sql->result();
         }
}