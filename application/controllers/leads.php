<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leads extends MY_Controller {

    function __construct() {
        parent::__construct();
      //  $this->load->library('My_PHPMailer');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('leads_m');
        $this->load->model('product_m');
        if (!$this->ion_auth->logged_in())
  {
   redirect('auth/login');
  }
                if (!$this->ion_auth->is_admin())
  {
   $this->session->set_flashdata('message', 'You must be an admin to view this page');
   redirect('welcome/index');
  }
    }

    function index() {
        $user = $this->ion_auth->user()->row();
        if ($user->user_type == 1) {
            $data['salesman_list'] = $this->leads_m->fetch_salesman();
            $leadslist = $this->leads_m->fetch();
            $data['pro'] = $this->product_m->fetch();
            foreach ($leadslist as $value) {

                $data['product_list'][$value->id] = $this->product_m->get_productlist($value->product);
            }
            $data['leads'] = $leadslist;
            $data['leads_a'] = $this->leads_m->fetch_a();
            $data['archive_leads'] = $this->leads_m->archive_leads();
            $this->load->view('view_leads', $data);
        } elseif ($user->user_type == 4) {
            $data['leadslist'] = $this->leads_m->fetch_for_salesman($user->id);
            $data['pro'] = $this->product_m->fetch();
            $this->load->view('view_leads', $data);
        } elseif ($user->user_type == 2) {
            $data['leadslist'] = $this->leads_m->fetch_for_callcenter($user->id);
            $data['pro'] = $this->product_m->fetch();
            $this->load->view('view_leads', $data);
        } elseif ($user->user_type == 3) {
            redirect('account/');
        }
    }

    function create_quote($id) {
        $this->load->model('product_m');
        $product = $this->product_m->fetch();
        $data['product'] = $product;
        $data['lead_details'] = $this->leads_m->fetch_lead($id);
        $state_id = $data['lead_details'][0]->state;
        $count = $data['lead_details'][0]->country;
        $exp_count = explode('-', $count);
        $data['country'] = $this->leads_m->fetch_lead_country($exp_count[0]);
        $data['state_name'] = $this->leads_m->fetch_state($state_id);
        $this->load->view('create_quote', $data);
    }

    function add_leads() {
        $this->load->model('product_m');
        $product = $this->product_m->fetch();
        $data['product'] = $product;

        $lead_source = $this->leads_m->get_lead_source();
        $data['lead_source'] = $lead_source;

        $data['countries'] = $this->leads_m->get_countries();

        $data['state'] = $this->leads_m->get_state();

        $this->form_validation->set_rules('lead_first_name', 'First Name', 'required');
        $this->form_validation->set_rules('lead_last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('lead_email', 'Email', 'required');
        $this->form_validation->set_rules('lead_dob', 'DOB', 'required');
        $this->form_validation->set_rules('lead_wellness_product', 'Wellness Product', 'required');
        $this->form_validation->set_rules('lead_address', 'Address', 'required');
        $this->form_validation->set_rules('lead_state', 'State', 'required');
        $this->form_validation->set_rules('lead_place', 'Place', 'required');
        $this->form_validation->set_rules('lead_phone', 'Phone', 'required');
        $this->form_validation->set_rules('lead_pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('lead_source', 'Lead Source', 'required');
        $this->form_validation->set_rules('lead_product', 'Check Product', 'required');
        $this->form_validation->set_rules('lead_country', 'Country', 'required');

        if ($this->form_validation->run()) {
            if ($this->input->post('identify')) {
                if ($this->leads_m->save()) {
                    redirect('leads');
                }
            } else {
                if ($this->leads_m->save()) {
                    $this->load->view('add_lead', $data);
                }
            }
        } else {
            $this->load->view('add_lead', $data);
        }
    }

    function fetch_country_states() {
        $result = $this->leads_m->fetch_country_states();
        ?>
        <option value="">--Select--</option>
        <?php
        foreach ($result as $value) {
            ?>
            <option><?php echo $value->name; ?></option>
            <?php
        }
    }

    function edit_lead($id) {
        $this->load->model('leads_m');
        $data['lead'] = $this->leads_m->fetch_lead($id);

        $lead_details = $this->leads_m->fetch_lead($id);

        $data['countries'] = $this->leads_m->get_countries();

        $this->load->model('product_m');
        $data['product'] = $this->product_m->fetch();

        $this->load->model('leads_m');
        $lead_source = $this->leads_m->get_lead_source();
        $data['lead_source'] = $lead_source;

        $this->load->model('leads_m');
        $data['state'] = $this->leads_m->fetch_states($lead_details[0]->country);

        $this->load->view('edit_lead', $data);
    }

    function edit_update_lead() {
        $this->form_validation->set_rules('lead_first_name', 'First Name', 'required');
        $this->form_validation->set_rules('lead_last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('lead_email', 'Email', 'required');
        $this->form_validation->set_rules('lead_dob', 'DOB', 'required');
        $this->form_validation->set_rules('lead_phone', 'Phone', 'required');
        $this->form_validation->set_rules('lead_wellness_product', 'Wellness Product', 'required');
        $this->form_validation->set_rules('lead_address', 'Address', 'required');
        $this->form_validation->set_rules('lead_state', 'State', 'required');
        $this->form_validation->set_rules('lead_place', 'Place', 'required');
        $this->form_validation->set_rules('lead_pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('lead_source', 'Lead Source', 'required');
        $this->form_validation->set_rules('lead_product', 'Check Product', 'required');
        $this->form_validation->set_rules('lead_reg_date', 'Register Date', 'required');
        $this->form_validation->set_rules('lead_reg_time', 'Register Time', 'required');
        if ($this->form_validation->run()) {
            $id = $this->input->post('lead_id');
            $this->load->model('leads_m');
            $this->leads_m->edit_update_lead($id);
        }
        $this->index();
    }

    function delete_lead() {
        $lead_id = $this->input->post('lead_id');
        $this->load->model('leads_m');
        $this->leads_m->delete_lead($lead_id);
    }

    //function to add lead source
    function add_lead_source() {
        $new_lead_source = $this->input->post('new_lead_source');
        $this->leads_m->add_lead_source($new_lead_source);
        echo 'Lead Source Added';
    }

    //function for fetching new add lead source
    function fetch_new_lead_source() {
        $new_lead_source = $this->input->post('n_lead_source');
        $result = $this->leads_m->fetch_new_lead_source($new_lead_source);
        print_r($result->id);
    }

    //controller function for view lead profile and for update Follow Up Details
    function view_lead_profile($id) {
        $lead_details = $this->leads_m->fetch_lead($id);

        $data['lead_state'] = $lead_details[0]->state;

        $count = $lead_details[0]->country;
        $exp_count = explode('-', $count);
        $data['country'] = $this->leads_m->fetch_lead_country($exp_count[0]);
        
        
        $data['lead_details'] = $lead_details;

        $data['lead_source'] = $this->leads_m->get_lead_source();

        $data['templates'] = $this->leads_m->fetch_template();

        $data['product_att'] = $this->leads_m->fetch_product_att();

        $data['follow_up_status'] = $this->leads_m->fetch_follow_up_status();

        $data['follow_up_details'] = $this->leads_m->fetch_follow_up_details($id);

        $data['lead_qoute'] = $this->leads_m->fetch_lead_quote($id);

        $this->load->model('product_m');
        $data['product'] = $this->product_m->fetch();

        $this->form_validation->set_rules('next_follow_up_date', 'Next Follow-Up Date', 'required');
        $this->form_validation->set_rules('follow_up_time', 'Follow Up Time', 'required');
        $this->form_validation->set_rules('follow_up_status', 'Follow Up Status', 'required');
        $this->form_validation->set_rules('lead_comment', 'Lead Comment', 'required');
        $this->form_validation->set_rules('expected_revenue', 'Expected Revenue', 'required');

        if ($this->form_validation->run()) {
            $temp_lead = $this->leads_m->fetch_lead($id);
            $l_name = $temp_lead[0]->first_name . " " . $temp_lead[0]->last_name;

            $this->leads_m->add_lead_follow_up_details($id, $l_name);
            $data['follow_up_details'] = $this->leads_m->fetch_follow_up_details($id);
        }

        $this->load->view('view_profile_lead', $data);
    }

    //Function for fetching the template content for lead's send product mailer
    function fetch_template_content() {
        $template_id = $this->input->post('template_id');
        $result = $this->leads_m->fetch_template_content($template_id);
        echo html_entity_decode($result->template_content);
    }

    //Function for adding row thorgh ajax
    function add_ajax_row() {
        $lead_id = $this->input->post('lead_id');
        $salesman_id = $this->input->post('salesman_id');

        $lead_details = $this->leads_m->fetch_lead($lead_id);
        print_r($lead_details);
        $salesman = $this->leads_m->fetch_salesman();

        $this->load->model('product_m');
        $pro = $this->product_m->fetch();
        ?>
        <tr id="tr<?php echo $lead_details[0]->id; ?>" class="tr<?php echo $lead_details[0]->id; ?>">
            <td><a href="<?php echo site_url('leads/view_lead_profile') . '/' . $lead_details[0]->id; ?>"><?php echo $lead_details[0]->first_name . " " . $lead_details[0]->last_name; ?> </a></td>
            <td><?php echo $lead_details[0]->email; ?></td>
            <td><?php echo $lead_details[0]->phone; ?></td>
            <td>
                <?php
                $lead_pro_array = array();
                $un_l_pro = unserialize($lead_details[0]->product);
                foreach ($un_l_pro as $key8 => $value8) {
                    $lead_pro_array[] = $key8;
                }
                foreach ($lead_pro_array as $key9 => $value9) {
                    foreach ($pro as $key10 => $value10) {
                        if ($value10->id == $value9) {
                            ?>
                            <a href="<?php echo site_url('product/View_product_profile') . '/' . $value9; ?>" ><?php echo $value10->product_name; ?></a><br>
                            <?php
                        }
                    }
                }
                ?>
            </td>
            <td class="hidden-xs"><?php echo $lead_details[0]->address; ?></td>
            <td>
                <?php
                $date = explode('-', $lead_details[0]->date);
                echo $date[2] . "/" . $date[1] . "/" . $date[0];
                ?>
            </td>
            <td>
                <?php
                $user = $this->ion_auth->user($lead_details[0]->entered_by)->row();
                echo $user->first_name . " " . $user->last_name;
                ?>
            </td>
            <td>
                <select class="form-control form-group assigned_select" style="width:100%;"  name="salesman_list">
                    <option value="default_select">--Select--</option>
                    <?php
                    foreach ($salesman as $key11 => $value11) {
                        ?>
                        <option value="<?php echo $lead_details[0]->id . "-" . $value11->id; ?>"
                        <?php
                        if ($lead_details[0]->assigned_to == $value11->id) {
                            echo 'selected="selected"';
                        }
                        ?>

                                ><?php echo $value11->first_name . " " . $value11->last_name; ?></option>
                                <?php
                            }
                            ?>

                </select>
            </td>

            <td id="<?php echo $lead_details[0]->id; ?>">
                <a href="<?php echo site_url('leads/edit_lead') . '/' . $lead_details[0]->id; ?>"><button class="btn btn-xs btn-info"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                <a href="<?php echo site_url('leads/view_lead_profile') . '/' . $lead_details[0]->id; ?>#f"><button class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o"></i> Follow Up</button></a>
                <button class="btn btn-xs btn-danger delete" data-toggle="confirmation-singleton"><i class="fa fa-trash-o"></i> Delete</button>
            </td>
        </tr>
        <?php
    }

    //Function for assign sales man to lead and changes will be on leads table assigned_to colomn
    function assign_salesman() {
        $salesman_id = $this->input->post('salesman_id');
        $lead_id = $this->input->post('lead_id');

        $result = $this->leads_m->assign_salesman($salesman_id, $lead_id);
        if ($result) {
            $lead_details = $this->leads_m->fetch_lead($lead_id);
            $salesman_details = $this->leads_m->fetch_sales($salesman_id);

            $email = $salesman_details->email;
            
            $salesman_phone = $salesman_details->phone;
            $lead_name = $lead_details[0]->first_name . "%20" . $lead_details[0]->last_name;
            $lead_address = $lead_details[0]->address;
            $today = date("Y-m-d");
            
            $l_details = "Lead " . $lead_details[0]->first_name . " " . $lead_details[0]->last_name . " Assign to You.<br />Email : " . $lead_details[0]->email . "<br/>Phone : " . $lead_details[0]->phone;

            $ch = curl_init();
            
            $sms = "http://u.vsms.in/SendSMS/sendmsg.php?uname=CamexTr&pass=w@9Ib~2O&send=CMAXIN&dest=".$salesman_phone."&msg=Dear%20".$salesman_details->first_name."%20".$salesman_details->last_name."%20you%20have%20been%20assigned%20".$lead_name."%20".$lead_details[0]->phone."%20".$lead_address."%20".$today."%20CMAXIN";
            

            echo $sms;

            // set url 
            curl_setopt($ch, CURLOPT_URL, $sms);

            //return the transfer as a string 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // $output contains the output string 
            $output = curl_exec($ch);

            // close curl resource to free up system resources 
            curl_close($ch);
            echo $output;

            $mail = new PHPMailer();
            $mail->setFrom('Cmax@spydernet.in', 'Cmax');
            $mail->IsHTML(true);
            $mail->Subject = "Assigned Lead";
            $mail->addAddress($email);
            $mail->Body = $l_details;
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                
            }
            //$mail = new PHPMailer();
            // $mail->isSendmail();
            /* $message = "Assigned";
              //Start assembly of Email
              $to = $email;
              $from = "info@pocketcollege.in";
              $headers = "From: $from\n";
              $headers .= "MIME-Version: 1.0\n";
              $headers .= "Content-type: text/html; charset=iso-8859-1\n";
              $subject = 'Lead Assign Details';

              if (mail($to, $subject, $message, $headers)) {
              echo "Send";
              } else {
              echo "Error";
              }

              //$mail->IsHTML(true);
              //Enable SMTP debugging
              // 0 = off (for production use)
              // 1 = client messages
              // 2 = client and server messages
              /* $mail->SMTPDebug = 2;

              //Tell PHPMailer to use SMTP
              //$mail->isSMTP();

              //Set the hostname of the mail server
              $mail->Host = 'smtp.gmail.com';

              //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
              $mail->Port = 587;

              //Set the encryption system to use - ssl (deprecated) or tls
              $mail->SMTPSecure = 'tls';

              //Whether to use SMTP authentication
              $mail->SMTPAuth = true;

              //Username to use for SMTP authentication - use full email address for gmail
              $mail->Username = "jogendra@hexwhale.com";

              //Password to use for SMTP authentication
              $mail->Password = "getinside"; */

            //Set who the message is to be sent from
            //$mail->setFrom('cmax@spydernet.in', 'Cmax');
            //Set an alternative reply-to address
            //$mail->addReplyTo('cmax@spydernet.in', 'Cmax');
            //Set who the message is to be sent to
            //$mail->addAddress($email, 'Lead');
            //Set the subject line
            //$mail->Subject = 'Cmax Lead Assigned';
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            //Replace the plain text body with one created manually
            //$mail->Body = $l_details;
            //send the message, check for errors
            /* if (!$mail->send()) {
              echo $email;
              echo "Error" . $mail->ErrorInfo;
              } else {
              echo $email;
              echo 'Lead Successfuly Assign to Salesman';
              } */
        }
    }

    function add_product() {
        $result = $this->leads_m->add_product();
        $product = unserialize($result->product);

        $product_array = array();

        foreach ($product as $key => $value) {
            $product_array[] = $key;
        }

        $this->load->model('product_m');
        $all_product = $this->product_m->fetch();

        foreach ($all_product as $key1 => $value1) {
            if (in_array($value1->id, $product_array) == false) {
                ?>
                <option value="<?php echo $value1->id; ?>"><?php echo $value1->product_name; ?></option>
                <?php
            }
        }
    }

    function add_lead_product() {
        $old_product = array();
        $new_product = array();
        $id = $this->input->post('lead_id');
        $result0 = $this->leads_m->fetch_lead($id);

        $unser_old_pro = unserialize($result0[0]->product);
        foreach ($unser_old_pro as $key0 => $value0) {
            $old_product[] = $key0;
        }

        $this->leads_m->add_lead_product();

        $result = $this->leads_m->fetch_lead($id);
        foreach (unserialize($result[0]->product) as $key => $value) {
            if (in_array($key, $old_product) == false) {
                $result1 = $this->leads_m->fetch_product($key);
                foreach ($result1 as $key1 => $value1) {
                    $new_product[$key1] = $value1;
                }
                echo json_encode($new_product);
            }
        }
        ?>
        <?php
    }

    function delete_lead_product() {
        $this->leads_m->delete_lead_product();
        echo "Deleted";
    }

    function save_lead_product_qty() {
        $p_id = array();
        $p_qty = array();

        $lead_id = $this->input->post('lead_id');
        $product_id = $this->input->post('pro_id');
        $product_qty = $this->input->post('pro_qty');
        $result = $this->leads_m->fetch_lead($lead_id);
        $product = unserialize($result[0]->product);

        foreach ($product as $key => $value) {
            if ($key !== "No more product available")
                $p_id[] = $key;
        }

        $result1 = $this->leads_m->fetch_lead_qty($lead_id);


        if (count($result1) == 0) {
            foreach ($p_id as $key1 => $value1) {
                if ($product_id == $value1) {
                    $p_qty[$value1] = $product_qty;
                } else {
                    $p_qty[$value1] = 1;
                }
            }

            $result2 = $this->leads_m->save_lead_product_qty($lead_id, $p_qty);
        } else {
            $un_qty = unserialize($result1->qty);
            foreach ($un_qty as $key2 => $value2) {
                if ($product_id == $key2) {
                    $un_qty[$key2] = $product_qty;
                }
            }
            print_r($un_qty);
            $result2 = $this->leads_m->save_lead_product_qty($lead_id, $un_qty);
        }
    }

    /* Delete Lead_product_qty Table */

    function empty_db_table() {
        $result = $this->leads_m->empty_db_table();
    }

    function send_quote($id) {
        $qty = array();
        $product_name = array();
        $product_rate = array();

        $this->load->helper('pdf_helper');
        $this->load->library('My_PHPMailer');
        $temp_lead = $this->leads_m->fetch_lead($id);

        $result = $this->leads_m->fetch_product_qty($id);

        if (count($result) === 0) {
            $data['qty'] = 1;

            $product = unserialize($temp_lead[0]->product);
            foreach ($product as $key => $value) {
                if ($key !== "No more product available") {
                    $result1 = $this->leads_m->fetch_product($key);
                    $product_name[] = $result1->product_name;
                    $product_rate[] = $result1->product_rate;
                }
            }
            $data['product_name'] = $product_name;
            $data['product_rate'] = $product_rate;
        } else {
            $temp_qyt = unserialize($result->qty);
            $temp_rate = unserialize($result->rate);

            $product = unserialize($temp_lead[0]->product);
            foreach ($temp_qyt as $key1 => $value1) {
                $qty[$key1] = $value1;
            }

            foreach ($temp_rate as $key2 => $value2) {
                $product_rate[] = $value2;
            }

            $data['qty'] = $qty;
            foreach ($product as $key => $value) {
                if ($key !== "No more product available") {
                    $result1 = $this->leads_m->fetch_product($key);
                    $product_name[] = $result1->product_name;
                }
            }
            $data['product_name'] = $product_name;
            $data['product_rate'] = $product_rate;
        }

        //code to fetch total amount and discount
        $result2 = $this->leads_m->fetch_tatal_discount($id);
        $data['data_total'] = $result2->total;
        $data['data_discount'] = $result2->discount;

        $data['state'] = $this->leads_m->fetch_state($temp_lead[0]->state);

        $count = $temp_lead[0]->country;
        $exp_count = explode('-', $count);
        $data['country'] = $this->leads_m->fetch_lead_country($exp_count[0]);

        $data['lead'] = $temp_lead[0];
        $this->load->view('new_quote', $data);
    }

    //function for add product discount
    function add_product_discount() {
        $product_name = array();
        $product_discount = array();

        $lead_id = $this->input->post('lead_id');
        $temp_lead = $this->leads_m->fetch_lead($lead_id);

        $lead_product_ids = unserialize($temp_lead[0]->product);
        ?>
        <h4 style="margin-top: 20px; margin-bottom:20px;" class="modal-title" id="myModalLabel">Product Discount</h4>

        <?php
        foreach ($lead_product_ids as $key => $value) {
            $result = $this->leads_m->fetch_product($key);
            $product_name[$key] = $result->product_name;
            $product_discount[$key] = $result->product_discount;
            ?>
            <input class="check_discount" type="checkbox" value="<?php echo $result->product_discount; ?>"/>&nbsp;&nbsp;<font style="font-size: 15px;"><?php echo $result->product_name; ?></font><br/>
            <?php
        }
    }

    function save_total_n_discount() {
        $this->leads_m->save_total_n_discount();
    }

    function empty_discount_table() {
        $this->leads_m->empty_discount_table();
    }

    function save_lead_product_rate() {
        $result = $this->leads_m->save_lead_product_rate();
    }

    function save_quote($file_name) {
        $temp = explode('~', $file_name);
        $this->leads_m->save_quote($file_name);
        redirect('leads/create_quote/' . $temp[0]);
    }

    function qoute_open($path) {
        fopen("pdf/$path", "");
    }

    function send_product_mailer() {
        $this->load->library('My_PHPMailer');
        $user = $this->ion_auth->user()->row();
        $attachment = $this->input->post('checked');
        $content = $this->input->post('temp_content');
        $lead_email = $this->input->post('lead_email');
        print_r($attachment);
        echo $content;
        echo $lead_email;

        $mail = new PHPMailer();

        foreach ($attachment as $key => $value) {
            $mail->addAttachment($value);
        }

        $mail->setFrom('Cmax@spydernet.in', 'Cmax');
        $mail->IsHTML(true);
        $mail->Subject = 'CMAX Product Details';
        $mail->addAddress($lead_email);
        $mail->Body = $content;
        //Tell PHPMailer to use SMTP
        /* $mail->isSMTP();

          $mail->IsHTML(true);
          //Enable SMTP debugging
          // 0 = off (for production use)
          // 1 = client messages
          // 2 = client and server messages
          $mail->SMTPDebug = 0;



          //Set the hostname of the mail server
          $mail->Host = 'smtp.gmail.com';

          //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
          $mail->Port = 587;

          //Set the encryption system to use - ssl (deprecated) or tls
          $mail->SMTPSecure = 'tls';

          //Whether to use SMTP authentication
          $mail->SMTPAuth = true;

          //Username to use for SMTP authentication - use full email address for gmail
          $mail->Username = "jogendra@hexwhale.com";

          //Password to use for SMTP authentication
          $mail->Password = "getinside";

          $sender_name = $user->first_name . " " . $user->last_name;
          $sender_email = $user->email;

          //Set who the message is to be sent from
          $mail->setFrom($sender_email, $sender_name);

          //Set an alternative reply-to address
          $mail->addReplyTo($sender_email, 'First Last');

          //Set who the message is to be sent to
          $mail->addAddress($lead_email, 'Jogendra Yadav');


          //Set the subject line
          $mail->Subject = 'CMAX quotation';

          //Read an HTML message body from an external file, convert referenced images to embedded,
          //convert HTML into a basic plain-text alternative body
          //Replace the plain text body with one created manually
          $mail->Body = $content;
         */
        //send the message, check for errors
        if (!$mail->send()) {
            echo "Error";
        } else {
            echo "Product Mail is Send";
        }
    }

    //function for callcenter guy to view lead's profile

    function lead_profile($id) {
        $data['lead_details'] = $this->leads_m->fetch_lead($id);
        $data['lead_source'] = $this->leads_m->get_lead_source();
        $data['product'] = $this->product_m->fetch();
        $this->load->view('lead_profile', $data);
    }

    //function for reassign the salesman to the lead in assign tab in view leads
    function reassign_salesman() {
        $lead_id = $this->input->post('lead_id');
        $salesman_id = $this->input->post('salesman_id');
        $user = $this->ion_auth->user()->row();
        $sender_name = $user->first_name . " " . $user->last_name;
        $sender_email = $user->email;

        $result = $this->leads_m->reassign_salesman($lead_id, $salesman_id);
        if ($result) {
            $lead_details = $this->leads_m->fetch_lead($lead_id);
            $salesman_details = $this->leads_m->fetch_sales($salesman_id);

            $email = $salesman_details->email;

            $l_details = "Lead " . $lead_details[0]->first_name . " " . $lead_details[0]->last_name . " Assign to You.<br />Email : " . $lead_details[0]->email . "<br/>Phone : " . $lead_details[0]->phone;

            /* $mail = new PHPMailer();

              //Tell PHPMailer to use SMTP
              $mail->isSMTP();

              $mail->IsHTML(true);
              //Enable SMTP debugging
              // 0 = off (for production use)
              // 1 = client messages
              // 2 = client and server messages
              $mail->SMTPDebug = 0;



              //Set the hostname of the mail server
              $mail->Host = 'smtp.gmail.com';

              //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
              $mail->Port = 587;

              //Set the encryption system to use - ssl (deprecated) or tls
              $mail->SMTPSecure = 'tls';

              //Whether to use SMTP authentication
              $mail->SMTPAuth = true;

              //Username to use for SMTP authentication - use full email address for gmail
              $mail->Username = "jogendra@hexwhale.com";

              //Password to use for SMTP authentication
              $mail->Password = "getinside";

              //Set who the message is to be sent from
              $mail->setFrom('jogendra@hexwhale.com', $sender_name);

              //Set an alternative reply-to address
              $mail->addReplyTo('jogendra@hexwhale.com', 'First Last');

              //Set who the message is to be sent to
              $mail->addAddress('jogendra@hexwhale.com', 'Jogendra Yadav');


              //Set the subject line
              $mail->Subject = 'Cmax Lead Assigned';

              //Read an HTML message body from an external file, convert referenced images to embedded,
              //convert HTML into a basic plain-text alternative body
              //Replace the plain text body with one created manually
              $mail->Body = $l_details; */
            $mail = new PHPMailer();
            $mail->setFrom('Cmax@spydernet.in', 'Cmax');
            $mail->IsHTML(true);
            $mail->Subject = "Assigned Lead";
            $mail->addAddress($email);
            $mail->Body = $l_details;
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo 'Lead Successfuly Re-Assign to Salesman';
            }

            //send the message, check for errors
        }
    }

    function priview_quote($id) {
        $qty = array();
        $product_name = array();
        $product_rate = array();

        $this->load->helper('pdf_helper');
        $this->load->library('My_PHPMailer');
        $temp_lead = $this->leads_m->fetch_lead($id);

        $result = $this->leads_m->fetch_product_qty($id);

        if (count($result) === 0) {
            $data['qty'] = 1;

            $product = unserialize($temp_lead[0]->product);
            foreach ($product as $key => $value) {
                if ($key !== "No more product available") {
                    $result1 = $this->leads_m->fetch_product($key);
                    $product_name[] = $result1->product_name;
                    $product_rate[] = $result1->product_rate;
                }
            }
            $data['product_name'] = $product_name;
            $data['product_rate'] = $product_rate;
        } else {
            $temp_qyt = unserialize($result->qty);
            $temp_rate = unserialize($result->rate);

            $product = unserialize($temp_lead[0]->product);
            foreach ($temp_qyt as $key1 => $value1) {
                $qty[$key1] = $value1;
            }

            foreach ($temp_rate as $key2 => $value2) {
                $product_rate[] = $value2;
            }

            $data['qty'] = $qty;
            foreach ($product as $key => $value) {
                if ($key !== "No more product available") {
                    $result1 = $this->leads_m->fetch_product($key);
                    $product_name[] = $result1->product_name;
                }
            }
            $data['product_name'] = $product_name;
            $data['product_rate'] = $product_rate;
        }

        //code to fetch total amount and discount
        $result2 = $this->leads_m->fetch_tatal_discount($id);
        $data['data_total'] = $result2->total;
        $data['data_discount'] = $result2->discount;

        $data['state'] = $this->leads_m->fetch_state($temp_lead[0]->state);

        $count = $temp_lead[0]->country;
        $exp_count = explode('-', $count);
        $data['country'] = $this->leads_m->fetch_lead_country($exp_count[0]);

        $data['lead'] = $temp_lead[0];
        $this->load->view('preview_quote', $data);
    }

    //this function is to check any lead is assigned to the perticuler user or not while deleting the user
    function is_assigned() {
        $this->leads_m->is_assigned();
    }

    function deactivate_user() {
        $this->leads_m->deactivate_user();
    }

    function get_lead_source() {
        $lead_source = $this->leads_m->get_lead_source();
        print_r($lead_source);
    }

}
?>