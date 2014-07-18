<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leads_m extends CI_Model {

    public $variable = 0;

    public function fetch() {
        $this->db->select('*');
        $this->db->where('assigned_to', 0);
        $this->db->where('follow_up_status', 0);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function all_leads() {
        $this->db->select('leadsource');
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function ind_lead_source($id) {
        $this->db->select('*');
        $this->db->where('leadsource', $id);
        $sql = $this->db->get('leads');
        return $sql->num_rows();
    }

    public function ind_lead_source_todays($id) {
        $this->db->select('*');
        $this->db->where('leadsource', $id);
        $this->db->where('date', date("Y-m-d"));
        $sql = $this->db->get('leads');
        return $sql->num_rows();
    }

    public function ind_lead_source_last_week($id) {
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $newdate = date('Y-m-d', strtotime("-7 days"));
        $this->db->select('*');
        $this->db->where('leadsource', $id);
        $this->db->where("date BETWEEN '$newdate%' AND '$yesterday%'", NULL, FALSE);
        $sql = $this->db->get('leads');
        return $sql->num_rows();
    }

    public function ind_lead_source_month($id) {
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $newdate = date('Y-m-d', strtotime("-30 days"));
        $this->db->select('*');
        $this->db->where('leadsource', $id);
        $this->db->where("date BETWEEN '$newdate%' AND '$yesterday%'", NULL, FALSE);
        $sql = $this->db->get('leads');
        return $sql->num_rows();
    }

    public function ind_lead_source_date_wise($id) {
        $d_f = $this->input->post('d_f');
        $d_t = $this->input->post('d_t');
        $this->db->select('*');
        $this->db->where('leadsource', $id);
        $this->db->where("date BETWEEN '$d_f%' AND '$d_t%'", NULL, FALSE);
        $sql = $this->db->get('leads');
        return $sql->num_rows();
    }

    public function ind_sale($id) {
        $this->db->select('*');
        $this->db->where('entered_by', $id);
        $sql = $this->db->get('leads');
        return $sql->num_rows();
    }

    public function ind_salesman($id, $value) {
        if ($value == 1) {
            $this->db->select('*');
            $this->db->where('entered_by', $id);
            $this->db->where('date', date("Y-m-d"));
            $sql = $this->db->get('leads');
            return $sql->num_rows();
        } elseif ($value == 2) {
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $newdate = date('Y-m-d', strtotime("-7 days"));
            $this->db->select('*');
            $this->db->where('entered_by', $id);
            $this->db->where("date BETWEEN '$newdate%' AND '$yesterday%'", NULL, FALSE);
            $sql = $this->db->get('leads');
            return $sql->num_rows();
        } elseif ($value == 3) {
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $newdate = date('Y-m-d', strtotime("-30 days"));
            $this->db->select('*');
            $this->db->where('entered_by', $id);
            $this->db->where("date BETWEEN '$newdate%' AND '$yesterday%'", NULL, FALSE);
            $sql = $this->db->get('leads');
            return $sql->num_rows();
        } elseif ($value == 4) {
            $d_f = $this->input->post('d_f');
            $d_t = $this->input->post('d_t');
            $this->db->select('*');
            $this->db->where('entered_by', $id);
            $this->db->where("date BETWEEN '$d_f%' AND '$d_t%'", NULL, FALSE);
            $sql = $this->db->get('leads');
            return $sql->num_rows();
        }
    }

    public function delivered_lead() {
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function delivered_lead_today() {
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where('account_status_date', date("Y-m-d"));
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function delivered_lead_week() {
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $newdate = date('Y-m-d', strtotime("-7 days"));
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where("account_status_date BETWEEN '$newdate%' AND '$yesterday%'", NULL, FALSE);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function delivered_lead_month() {
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $newdate = date('Y-m-d', strtotime("-30 days"));
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where("account_status_date BETWEEN '$newdate%' AND '$yesterday%'", NULL, FALSE);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function delivered_lead_date_wise() {
        $d_f = $this->input->post('d_f');
        $d_t = $this->input->post('d_t');
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where("account_status_date BETWEEN '$d_f%' AND '$d_t%'", NULL, FALSE);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function fetch_delivered_lead_by_salesman($id) {
        $salesman_product = array();
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where("assigned_to", $id);
        $sql = $this->db->get('leads');
        foreach ($sql->result() as $value) {
            $temp_salesman_product = unserialize($value->product);
            foreach ($temp_salesman_product as $key => $value) {
                $salesman_product[] = $key;
            }
        }
        return $salesman_product;
    }

    public function fetch_delivered_lead_by_salesman_today($id) {
        $salesman_product = array();
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where('account_status_date', date("Y-m-d"));
        $this->db->where("assigned_to", $id);
        $sql = $this->db->get('leads');
        foreach ($sql->result() as $value) {
            $temp_salesman_product = unserialize($value->product);
            foreach ($temp_salesman_product as $key => $value) {
                $salesman_product[] = $key;
            }
        }
        return $salesman_product;
    }

    public function fetch_delivered_lead_by_salesman_week($id) {
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $newdate = date('Y-m-d', strtotime("-7 days"));
        $salesman_product = array();
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where("account_status_date BETWEEN '$newdate%' AND '$yesterday%'", NULL, FALSE);
        $this->db->where("assigned_to", $id);
        $sql = $this->db->get('leads');
        foreach ($sql->result() as $value) {
            $temp_salesman_product = unserialize($value->product);
            foreach ($temp_salesman_product as $key => $value) {
                $salesman_product[] = $key;
            }
        }
        return $salesman_product;
    }

    public function fetch_delivered_lead_by_salesman_month($id) {
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $newdate = date('Y-m-d', strtotime("-30 days"));
        $salesman_product = array();
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where("account_status_date BETWEEN '$newdate%' AND '$yesterday%'", NULL, FALSE);
        $this->db->where("assigned_to", $id);
        $sql = $this->db->get('leads');
        foreach ($sql->result() as $value) {
            $temp_salesman_product = unserialize($value->product);
            foreach ($temp_salesman_product as $key => $value) {
                $salesman_product[] = $key;
            }
        }
        return $salesman_product;
    }

    public function fetch_delivered_lead_by_salesman_date($id) {
        $d_f = $this->input->post('d_f');
        $d_t = $this->input->post('d_t');

        $salesman_product = array();
        $this->db->select('*');
        $this->db->where('account_status', 3);
        $this->db->where("account_status_date BETWEEN '$d_f%' AND '$d_t%'", NULL, FALSE);
        $this->db->where("assigned_to", $id);
        $sql = $this->db->get('leads');
        foreach ($sql->result() as $value) {
            $temp_salesman_product = unserialize($value->product);
            foreach ($temp_salesman_product as $key => $value) {
                $salesman_product[] = $key;
            }
        }
        return $salesman_product;
    }

    public function assigned_count() {
        $this->db->select('*');
        $this->db->where('assigned_to', 0);
        $sql = $this->db->get('leads');
        return $sql->num_rows();
    }

    public function archive_leads() {
        $this->db->select('*');
        $this->db->where('follow_up_status =', 2);
        $this->db->or_where('follow_up_status =', 4);
        $this->db->or_where('follow_up_status =', 3);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function fetch_a() {
        $this->db->select('*');
        $this->db->where('assigned_to !=', 0);
        $this->db->where('follow_up_status', 0);
        $this->db->or_where('follow_up_status', 1);
        $this->db->order_by("assigned_on", "desc");
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function save() {
        $date_array = explode('/', $this->input->post('lead_dob'));
        $date = $date_array[2] . "-" . $date_array[1] . "-" . $date_array[0];
        $temp = $this->input->post('is_dealer');
        if ($temp == 'on') {
            $is_dealer = 1;
        } else {
            $is_dealer = 0;
        }

        $sex = $this->input->post('lead_sex');
        if ($sex == 'on') {
            $l_sex = 'Female';
        } else {
            $l_sex = 'Male';
        }
        $user = $this->ion_auth->user()->row();
        if ($user->user_type == 4) {
            $assigned_to = $user->id;
        } else {
            $assigned_to = 0;
        }
        $entered_by = $user->id;
        $entered_by_name = $user->first_name . " " . $user->last_name;
        $product = $this->input->post('lead_product');
        $serialized_product = serialize($product);
        $data = array(
            'name_title' => $this->input->post('name_title'),
            'first_name' => $this->input->post('lead_first_name'),
            'last_name' => $this->input->post('lead_last_name'),
            'email' => $this->input->post('lead_email'),
            'phone' => $this->input->post('lead_phone'),
            'landline' => $this->input->post('lead_landline_phone'),
            'is_dealer' => $is_dealer,
            'sex' => $l_sex,
            'any_disease' => $this->input->post('lead_disease'),
            'dob' => $date,
            'wellness_product' => $this->input->post('lead_wellness_product'),
            'wellness_product_name' => $this->input->post('lead_wellness_product_name'),
            'address' => $this->input->post('lead_address'),
            'state' => $this->input->post('lead_state'),
            'place' => $this->input->post('lead_place'),
            'pincode' => $this->input->post('lead_pincode'),
            'country' => $this->input->post('lead_country'),
            'leadsource' => $this->input->post('lead_source'),
            'freelancer_name' => $this->input->post('lead_freelancer_name'),
            'product' => $serialized_product,
            'other_details' => $this->input->post('lead_other_details'),
            'date' => date("Y-m-d"),
            'time' => date("h:i:s"),
            'entered_by' => $entered_by,
            'assigned_to' => $assigned_to
        );
        /*
          action type = 1 => added new lead
          action type = 2 => delete new lead
          action type = 3 => assign salesman to leads
         */
        $result = $this->db->insert('leads', $data);
        if ($result) {
            $insert_id = $this->db->insert_id();
            $data1 = array(
                'action_type' => 1,
                'action_per_on_id' => $insert_id,
                'action_per_on_name' => $this->input->post('lead_first_name') . " " . $this->input->post('lead_last_name'),
                'action_per_by_id' => $user->id,
                'action_per_by_name' => $entered_by_name,
                'action_time' => date("h:i:s"),
                'action_date' => date("Y-m-d")
            );
            return $this->db->insert('pulse_action', $data1);
        }
    }

    public function get_lead_source() {
        $this->db->select('*');
        $sql = $this->db->get('lead_source');
        return $sql->result();
    }

    //function to add new lead source
    public function add_lead_source($new_lead_source) {
        $data = array(
            'lead_source_name' => $new_lead_source
        );
        return $this->db->insert('lead_source', $data);
    }

    //function for fetch new added lead source
    public function fetch_new_lead_source($new_lead_source) {
        $this->db->select('*');
        $this->db->where('lead_source_name', $new_lead_source);
        $sql = $this->db->get('lead_source');
        return $sql->row();
    }

    //function for fetching templates which is saved in mailer, fetching for use in send product mailer 
    public function fetch_template() {
        $this->db->select('id, template_name');
        $sql = $this->db->get('templates');
        return $sql->result();
    }

    //function for tetching template content for lead's send product mailer
    public function fetch_template_content($template_id) {
        $this->db->select('template_content, template_image');
        $this->db->where('id', $template_id);
        $sql = $this->db->get('templates');
        return $sql->row();
    }

    public function fetch_product_att() {
        $this->db->select('*');
        $sql = $this->db->get('product_attachment');
        return $sql->result();
    }

    public function get_state() {
        $this->db->select('*');
        $this->db->where('region_id', 356);
        $sql = $this->db->get('subregions');
        return $sql->result();
    }
    
    public function fetch_states($id)
    {
        $value = explode('-', $id);
        $country_id = $value[0];
        
        $this->db->select('*');
        $this->db->where('region_id', $country_id);
        $sql = $this->db->get('subregions');
        return $sql->result();
    }

    public function fetch_lead($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function edit_update_lead($id) {
        $temp = $this->input->post('is_dealer');
        if ($temp == 'on') {
            $is_dealer = 1;
        } else {
            $is_dealer = 0;
        }

        $sex = $this->input->post('lead_sex');
        if ($sex == 'on') {
            $l_sex = 'Female';
        } else {
            $l_sex = 'Male';
        }
        $product = $this->input->post('lead_product');
        $serialized_product = serialize($product);
        $data = array(
            'name_title' => $this->input->post('name_title'),
            'first_name' => $this->input->post('lead_first_name'),
            'last_name' => $this->input->post('lead_last_name'),
            'email' => $this->input->post('lead_email'),
            'phone' => $this->input->post('lead_phone'),
            'landline' => $this->input->post('lead_landline_phone'),
            'is_dealer' => $is_dealer,
            'sex' => $l_sex,
            'any_disease' => $this->input->post('lead_disease'),
            'dob' => $this->input->post('lead_dob'),
            'wellness_product' => $this->input->post('lead_wellness_product'),
            'wellness_product_name' => $this->input->post('lead_wellness_product_name'),
            'address' => $this->input->post('lead_address'),
            'state' => $this->input->post('lead_state'),
            'place' => $this->input->post('lead_place'),
            'pincode' => $this->input->post('lead_pincode'),
            'country'  => $this->input->post('lead_country'),
            'leadsource' => $this->input->post('lead_source'),
            'freelancer_name' => $this->input->post('lead_freelancer_name'),
            'product' => $serialized_product,
            'other_details' => $this->input->post('lead_other_details'),
            'date' => $this->input->post('lead_reg_date'),
            'time' => $this->input->post('lead_reg_time')
        );
        $this->db->where('id', $id);
        return $this->db->update('leads', $data);
    }

    public function delete_lead($lead_id) {

        $this->db->select('*');
        $this->db->where('id', $lead_id);
        $sql = $this->db->get('leads');

        $l_name = $sql->row()->first_name . " " . $sql->row()->last_name;

        $this->db->where('id', $lead_id);
        $this->db->delete('leads');

        $this->db->where('lead_id', $lead_id);
        $result = $this->db->delete('leads_follow_up_details');

        $user = $this->ion_auth->user()->row();

        if ($result) {
            $data1 = array(
                'action_type' => 2,
                'action_per_on_id' => $lead_id,
                'action_per_on_name' => $l_name,
                'action_per_by_id' => $user->id,
                'action_per_by_name' => $user->first_name . " " . $user->last_name,
                'action_time' => date("h:i:s"),
                'action_date' => date("Y-m-d")
            );
            $this->db->insert('pulse_action', $data1);
        }

        echo "Lead Deleted..!";
    }

    //follow up status
    public function fetch_follow_up_status() {
        $this->db->select('*');
        $sql = $this->db->get('follow_up_status');
        return $sql->result();
    }

    public function add_lead_follow_up_details($lead_id, $lead_name) {
        date_default_timezone_set('Asia/Kolkata'); // CDT
        $current_date = date('Y/m/d');
        $user = $this->ion_auth->user()->row();
        $entered_by = $user->id;
        $f_status = $this->input->post('follow_up_status');

        if ($f_status == 4 || $f_status == 2 || $f_status== 3) {
            $data1 = array(
                'follow_up_status' => $f_status
            );
        } else {
            $data1 = array(
                'follow_up_status' => 1
            );
        }

        $this->db->where('id', $lead_id);
        $this->db->update('leads', $data1);

        $data = array(
            'lead_id' => $lead_id,
            'lead_name' => $lead_name,
            'next_follow_up_date' => $this->input->post('next_follow_up_date'),
            'follow_up_time' => $this->input->post('follow_up_time'),
            'follow_up_date' => $current_date,
            'follow_up_status' => $f_status,
            'lead_comment' => $this->input->post('lead_comment'),
            'expected_revenue' => $this->input->post('expected_revenue'),
            'entered_by' => $entered_by
        );

        $result = $this->db->insert('leads_follow_up_details', $data);

        if ($result) {
            //code for update pulse table
            $this->db->select('*');
            $this->db->where('id', $f_status);
            $sql = $this->db->get('follow_up_status');

            $follow_up = $sql->row()->follow_up_status;

            $user = $this->ion_auth->user()->row();

            if ($f_status == 2 || $f_status == 4) {
                $action_type = 6; //action type 6 for lead close or for lead not enterested
            } else {
                $action_type = 5; //action type 5 is for lead other follow ups
            }

            $data1 = array(
                'action_type' => $action_type,
                'action_per_on_id' => $lead_id,
                'action_per_on_name' => $lead_name,
                'action_per_by_id' => $user->id,
                'action_per_by_name' => $user->first_name . " " . $user->last_name,
                'action_time' => date("h:i:s"),
                'action_date' => date("Y-m-d"),
                'follow_up_id' => $f_status,
                'follow_up_status' => $follow_up,
            );
            return $this->db->insert('pulse_action', $data1);
        }
    }

    //lead's Follow Up Details
    public function fetch_follow_up_details($lead_id) {
        $this->db->select('*');
        $this->db->where('lead_id', $lead_id);
        $sql = $this->db->get('leads_follow_up_details');
        return $sql->result();
    }

    public function fetch_salesman() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_type', 4);
        $this->db->where('active', 1);
        $sql = $this->db->get();
        return $sql->result();
    }

    public function fetch_sales($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $sql = $this->db->get('users');
        return $sql->row();
    }

    public function fetch_dealers() {
        $this->db->select('*');
        $this->db->where('is_dealer', 1);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function assign_salesman($s_id, $l_id) {
        date_default_timezone_set('Asia/Calcutta'); // CDT

        $sDate = date("Y-m-d H:i:s");

        $data = array(
            'assigned_to' => $s_id,
            'assigned_time' => $sDate
        );

        $this->db->where('id', $l_id);
        $result = $this->db->update('leads', $data);

        if ($result) {
            //code for update pulse table
            $this->db->select('*');
            $this->db->where('id', $l_id);
            $sql = $this->db->get('leads');

            $l_name = $sql->row()->first_name . " " . $sql->row()->last_name;

            $user = $this->ion_auth->user()->row();
            $user1 = $this->ion_auth->user($s_id)->row();

            $data1 = array(
                'action_type' => 3,
                'action_per_on_id' => $l_id,
                'action_per_on_name' => $l_name,
                'action_per_by_id' => $user->id,
                'action_per_by_name' => $user->first_name . " " . $user->last_name,
                'action_time' => date("h:i:s"),
                'action_date' => date("Y-m-d"),
                'assigned_to' => $s_id,
                'assigned_to_name' => $user1->first_name . " " . $user1->last_name,
            );
            return $this->db->insert('pulse_action', $data1);
        }
    }

    public function fetch_state($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $sql = $this->db->get('state');
        return $sql->row();
    }

    public function add_product() {
        $lead_id = $this->input->post('lead_id');
        $this->db->select('*');
        $this->db->where('id', $lead_id);
        $sql = $this->db->get('leads');
        return $sql->row();
    }

    public function add_lead_product() {
        $lead_id = $this->input->post('lead_id');
        $product_id = $this->input->post('product_id');

        $this->db->select('*');
        $this->db->where('id', $lead_id);
        $sql = $this->db->get('leads');
        $temp_product_array = unserialize($sql->row()->product);
        $temp_product_array[$product_id] = 'on';

        $update_product = serialize($temp_product_array);

        $data = array(
            'product' => $update_product
        );

        $this->db->where('id', $lead_id);
        return $this->db->update('leads', $data);
    }

    public function delete_lead_product() {
        $update_product_array = array();

        $product_id = $this->input->post('product_id');
        $lead_id = $this->input->post('lead_id');

        $this->db->select('*');
        $this->db->where('id', $lead_id);
        $sql = $this->db->get('leads');
        $temp_product_array = unserialize($sql->row()->product);

        foreach ($temp_product_array as $key => $value) {
            if ($key != $product_id) {
                $update_product_array[$key] = 'on';
            }
        }

        $ser_update_product_array = serialize($update_product_array);

        $data = array(
            'product' => $ser_update_product_array
        );

        $this->db->where('id', $lead_id);
        return $this->db->update('leads', $data);
    }

    public function fetch_lead_qty($id) {
        $this->db->select('*');
        $this->db->where('lead_id', $id);
        $sql = $this->db->get('lead_product_qty');
        return $sql->row();
    }

    public function save_lead_product_qty($lead_id, $p_qty) {
        $ser_qty = serialize($p_qty);


        $this->db->select('*');
        $this->db->where('lead_id', $lead_id);
        $sql = $this->db->get('lead_product_qty');
        if ($sql->num_rows() > 0) {
            $data = array(
                'qty' => $ser_qty
            );
            $this->db->where('lead_id', $lead_id);
            return $this->db->update('lead_product_qty', $data);
        } else {
            $data = array(
                'lead_id' => $lead_id,
                'qty' => $ser_qty
            );
            return $this->db->insert('lead_product_qty', $data);
        }
    }

    public function empty_db_table() {
        $sql = $this->db->empty_table('lead_product_qty');
    }

    public function empty_discount_table() {
        $sql = $this->db->empty_table('lead_total_amount_n_discount');
    }

    public function fetch_tatal_discount($lead_id) {
        $this->db->select('*');
        $this->db->where('lead_id', $lead_id);
        $sql = $this->db->get('lead_total_amount_n_discount');
        return $sql->row();
    }

    public function fetch_product($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $sql = $this->db->get('product');
        return $sql->row();
    }

    public function fetch_product_qty($lead_id) {
        $this->db->select('*');
        $this->db->where('lead_id', $lead_id);
        $sql = $this->db->get('lead_product_qty');
        return $sql->row();
    }

    public function save_total_n_discount() {
        $lead_id = $this->input->post('lead_id');
        $total_amount = $this->input->post('total_amount');
        $discount = $this->input->post('discount');

        $data = array(
            'lead_id' => $lead_id,
            'total' => $total_amount,
            'discount' => $discount
        );
        return $this->db->insert('lead_total_amount_n_discount', $data);
    }

    public function save_lead_product_rate() {
        $lead_product_array = array();
        $lead_product_rate = array();

        $lead_id = $this->input->post('lead_id');
        $product_id = $this->input->post('pro_id');
        $product_rate = $this->input->post('pro_rate');

        $this->db->select('*');
        $this->db->where('id', $lead_id);
        $sql = $this->db->get('leads');

        $result1 = $sql->row();
        $uns_product = unserialize($result1->product);

        foreach ($uns_product as $key => $value) {
            $lead_product_array[] = $key;
        }

        //fetching actual product rate from product table
        foreach ($lead_product_array as $key1 => $value1) {
            $this->db->select('*');
            $this->db->where('id', $value1);
            $sql1 = $this->db->get('product');
            $lead_product_rate[$sql1->row()->id] = $sql1->row()->product_rate;
        }

        $lead_product_rate[$product_id] = $product_rate;

        $ser_lead_product_rate = serialize($lead_product_rate);

        $data = array(
            'rate' => $ser_lead_product_rate
        );

        $this->db->select('*');
        $this->db->where('lead_id', $lead_id);
        $sql2 = $this->db->get('lead_product_qty');

        if (count($sql2->row()) === 0) {
            $this->db->where('lead_id', $lead_id);
            $sql3 = $this->db->update('lead_product_qty', $data);
        } else {
            if ($sql2->row()->rate) {
                $unse_pro = unserialize($sql2->row()->rate);
                print_r($unse_pro);

                $unse_pro[$product_id] = $product_rate;

                print_r(serialize($unse_pro));
                $ser_pro = serialize($unse_pro);

                $data1 = array(
                    'rate' => $ser_pro
                );

                $this->db->where('lead_id', $lead_id);
                $sql3 = $this->db->update('lead_product_qty', $data1);
            } else {
                $this->db->where('lead_id', $lead_id);
                $sql3 = $this->db->update('lead_product_qty', $data);
            }
        }
    }

    public function save_quote($file_name) {
        $temp = explode('~', $file_name);

        $data = array(
            'lead_id' => $temp[0],
            'quote' => $file_name
        );
        return $this->db->insert('leads_quote', $data);
    }

    public function fetch_lead_quote($id) {
        $this->db->select('*');
        $this->db->where('lead_id', $id);
        $sql = $this->db->get('leads_quote');
        return $sql->result();
    }

    //function for fetching leads for salesman account
    public function fetch_for_salesman($id) {
        $this->db->select('*');
        $this->db->where('entered_by', $id);
        $this->db->or_where('assigned_to', $id);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    //function for fetching leads for callcener guy
    public function fetch_for_callcenter($id) {
        $this->db->select('*');
        $this->db->where('entered_by', $id);
        $sql = $this->db->get('leads');
        return $sql->result();
    }

    public function reassign_salesman($lead_id, $salesman_id) {
        date_default_timezone_set('Asia/Calcutta'); // CDT

        $sDate = date("Y-m-d H:i:s");
        $data = array(
            'assigned_to' => $salesman_id,
            'assigned_time' => $sDate
        );

        $this->db->where('id', $lead_id);
        $sql = $this->db->update('leads', $data);

        if ($sql) {
            //code for update pulse table
            $this->db->select('*');
            $this->db->where('id', $lead_id);
            $sql1 = $this->db->get('leads');

            $l_name = $sql1->row()->first_name . " " . $sql1->row()->last_name;

            $user = $this->ion_auth->user()->row();
            $user1 = $this->ion_auth->user($salesman_id)->row();

            //action type is for reaasigning leads
            $data1 = array(
                'action_type' => 4,
                'action_per_on_id' => $lead_id,
                'action_per_on_name' => $l_name,
                'action_per_by_id' => $user->id,
                'action_per_by_name' => $user->first_name . " " . $user->last_name,
                'action_time' => date("h:i:s"),
                'action_date' => date("Y-m-d"),
                'assigned_to' => $salesman_id,
                'assigned_to_name' => $user1->first_name . " " . $user1->last_name,
            );
            return $this->db->insert('pulse_action', $data1);
        }
    }

    public function get_countries() {
        $this->db->select('*');
        $sql = $this->db->get('regions');
        return $sql->result();
    }

    public function fetch_country_states() {
        $country_id = $this->input->post('country_id');
        $this->db->select('*');
        $this->db->where('region_id', $country_id);
        $sql = $this->db->get('subregions');
        return $sql->result();
    }

    public function fetch_lead_country($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $sql = $this->db->get('regions');
        return $sql->row();
    }

    public function is_assigned() {
        $user_id = $this->input->post('user_id');
        $this->db->select('*');
        $this->db->where('assigned_to', $user_id);
        $this->db->where('follow_up_status !=', 4);
        $this->db->where('follow_up_status !=', 2);
        $sql = $this->db->get('leads');
        print_r($sql->num_rows());
    }

    public function deactivate_user() {
        $user_id = $this->input->post('user_id');

        $data = array(
            'active' => 0
        );
        $this->db->where('id', $user_id);
        $sql = $this->db->update('users', $data);
        if ($sql) {
            echo 'User Deleted Successfully!';
        }
    }

}
