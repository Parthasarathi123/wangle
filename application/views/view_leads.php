<?php
$this->load->view('header');
$this->load->view('sidebar');
?>
    
                        <div class="col-md-10">

                            <!-- DATA TABLES -->
                            <div class="row">
                                <div id="all_tabs" class="col-md-12">

                                    <?php
                                    $user = $this->ion_auth->user()->row();
                                    if ($user->user_type == 1) {
                                        ?>
                                        <div class="box border blue">
                                            <div class="box-title">
                                                <h4><i class="fa fa-columns"></i><span class="hidden-inline-mobile">Leads</span></h4>
                                            </div>
                                            <div class="box-body">
                                                <div class="tabbable header-tabs">

                                                    <ul class="nav nav-tabs">
                                                        <li class=""><a href="#box_tab3" data-toggle="tab"><i class="fa fa-circle-o"></i> <span class="hidden-inline-mobile">Archives</span></a></li>
                                                        <li class=""><a href="#Assigned_tab" data-toggle="tab"><i class="fa fa-laptop"></i> <span class="hidden-inline-mobile">Assigned</span>&nbsp;&nbsp;<span id="ajax_pro_img2" hidden=""><img src="<?php echo base_url(); ?>ajax_img/img.gif"/></span></a></li>
                                                        <li class="active"><a href="#Un-Assigned_tab" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span class="hidden-inline-mobile">Un-Assigned</span>&nbsp;&nbsp;<span id="ajax_pro_img1" hidden=""><img src="<?php echo base_url(); ?>ajax_img/img.gif"/></span></a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade active in" id="Un-Assigned_tab">
                                                            <table id="" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th>                                              
                                                                        <th>Products</th>												
                                                                        <th class="hidden-xs">Address</th>
                                                                        <th>Added On</th>
                                                                        <th>Entered By</th>
                                                                        <th>Assigned To</th>                                                
                                                                        <th style="width:10%;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>	
                                                                    <?php
                                                                    foreach ($leads as $key => $value) {
                                                                        ?>
                                                                        <tr id="tr<?php echo $value->id; ?>">
                                                                            <td style="width: 15%;"><a href="<?php echo site_url('leads/view_lead_profile') . '/' . $value->id; ?>"><?php echo $value->first_name . " " . $value->last_name; ?> </a>
                                                                                <?php
                                                                                date_default_timezone_set('Asia/Calcutta'); // CDT
                                                                                $info = getdate();
                                                                                $date = $info['mday'];
                                                                                $month = $info['mon'];
                                                                                $year = $info['year'];
                                                                                $today_day = $year . "-" . $month . "-" . $date;
                                                                                $today = $expiry_date = date("Y-m-d", strtotime("now"));
                                                                                if ($value->date == $today) {
                                                                                    ?>
                                                                                    <span class="label label-warning pull-right">New</span>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td><?php echo $value->email; ?></td>
                                                                            <td><?php echo $value->phone; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                $plist = $product_list[$value->id];
                                                                                foreach ($plist as $pkey => $pvalue) {
                                                                                    ?>
                                                                                    <a href="<?php echo site_url('product/View_product_profile') . '/' . $pvalue->id; ?>" ><?php echo $pvalue->product_name; ?></a><br>
                                                                                <?php }
                                                                                ?>
                                                                            </td>
                                                                            <td class="hidden-xs"><?php echo $value->address; ?></td>
                                                                            <td class="hidden-xs">
                                                                                <?php
                                                                                $date = explode('-', $value->date);
                                                                                echo $date[2] . "/" . $date[1] . "/" . $date[0];
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $user = $this->ion_auth->user($value->entered_by)->row();
                                                                                echo $user->first_name . " " . $user->last_name;
                                                                                ?>
                                                                            </td>
                                                                            <td style="width: 15%;">
                                                                                <select class="form-control form-group select_salesman_list" style="width:100%;"  name="salesman_list">
                                                                                    <option value='' disabled selected style='display:none;'>Please Choose</option>
                                                                                    <?php
                                                                                    foreach ($salesman_list as $key0 => $value0) {
                                                                                        ?>
                                                                                        <option value="<?php echo $value->id . "-" . $value0->id; ?>"><?php echo $value0->first_name . " " . $value0->last_name; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>

                                                                                </select>
                                                                            </td>

                                                                            <td id="<?php echo $value->id; ?>">
                                                                                <a href="<?php echo site_url('leads/edit_lead') . '/' . $value->id; ?>"><button class="btn btn-xs btn-info"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                                                                <a href="<?php echo site_url('leads/view_lead_profile') . '/' . $value->id; ?>#f"><button class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o"></i> Follow Up</button></a>
                                                                                <button class="btn btn-xs btn-danger delete" data-toggle="confirmation-singleton"><i class="fa fa-trash-o"></i> Delete</button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th>
                                                                        <th>Products</th>
                                                                        <th class="hidden-xs">Address</th>
                                                                        <th>Added On</th>
                                                                        <th>Entered By</th>
                                                                        <th>Assigned To</th>                                                
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                            <!-- Script for assign salesman -->
                                                            <script>
                                                                $(document).ready(function() {


                                                                    $(".select_salesman_list").change(function() {

                                                                        var check = confirm("Are you sureto assign salesman to lead?");

                                                                        if (check)
                                                                        {
                                                                            $("#ajax_pro_img1").show();
                                                                            var temp_salesman_id = $(this).val();
                                                                            if (temp_salesman_id)
                                                                            {
                                                                                var sales_man_array = temp_salesman_id.split('-');
                                                                                var l_id = sales_man_array[0];
                                                                                var s_id = sales_man_array[1];

                                                                                $("#ajax_pro_img1").show();
                                                                                $.ajax({
                                                                                    type: "POST",
                                                                                    url: '<?php echo site_url('leads/assign_salesman'); ?>',
                                                                                    data: {
                                                                                        salesman_id: s_id,
                                                                                        lead_id: l_id
                                                                                    },
                                                                                    success: function(data)
                                                                                    {
                                                                                        $("#ajax_pro_img1").hide();
                                                                                        var temp = data.trim();
                                                                                        
                                                                                        $.ajax({
                                                                                            type: "POST",
                                                                                            url: '<?php echo site_url('leads/add_ajax_row'); ?>',
                                                                                            data: {
                                                                                                salesman_id: s_id,
                                                                                                lead_id: l_id
                                                                                            },
                                                                                            success: function(data1)
                                                                                            {
                                                                                                $("#ajax_pro_img1").hide();
                                                                                                var temp1 = data1.trim();
                                                                                                $("#assigned_tbody").append(temp1);
                                                                                            }
                                                                                        });
                                                                                        //alert(temp);
                                                                                        bootbox.alert("Lead Successfuly Assign to Salesman");
                                                                                        setTimeout(function() {
                                                                                            $(".bootbox").modal("hide");
                                                                                            var t = "<tr>" + $("#" + l_id).html() + "</tr>";
                                                                                            $("#tr" + l_id).hide();
                                                                                            // $("#assigned_tbody").append(t);
                                                                                        }, 3000);
                                                                                    }
                                                                                });
                                                                            }
                                                                        }

                                                                    });
                                                                });
                                                            </script>
                                                        </div>
                                                        <div class="tab-pane fade" id="Assigned_tab">
                                                            <table id="" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th>	
                                                                        <th>Product</th>
                                                                        <th class="hidden-xs">Address</th>
                                                                        <th>Added On</th>
                                                                        <th>Entered By</th>
                                                                        <th>Assigned To</th>
                                                                        <th style="width:10%;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="assigned_tbody">	
                                                                    <?php
                                                                    foreach ($leads_a as $key => $value) {
                                                                        ?>
                                                                    <tr class="gradeA" id="tr<?php echo $value->id; ?>">
                                                                            <td>
                                                                                <a href="<?php echo site_url('leads/view_lead_profile') . '/' . $value->id; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></a>
                                                                                <?php
                                                                                date_default_timezone_set('Asia/Calcutta'); // CDT
                                                                                $sDate = date("Y-m-d H:i:s");

                                                                                $date1 = new DateTime($value->assigned_time);
                                                                                $date2 = new DateTime($sDate);

                                                                                $diff = $date2->diff($date1);

                                                                                $hours = $diff->h;
                                                                                $hours = $hours + ($diff->days * 24);

                                                                                if ($hours > 24) {
                                                                                    if ($value->follow_up_status == 0) {
                                                                                        ?>
                                                                                        <span class="label label-danger pull-right">Not Followed</span>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td><?php echo $value->email; ?></td>
                                                                            <td><?php echo $value->phone; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                $lead_pro_array = array();
                                                                                $un_l_pro = unserialize($value->product);
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
                                                                            <td class="hidden-xs"><?php echo $value->address; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                $date = explode('-', $value->date);
                                                                                echo $date[2] . "/" . $date[1] . "/" . $date[0];
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $user = $this->ion_auth->user($value->entered_by)->row();
                                                                                echo $user->first_name . " " . $user->last_name;
                                                                                ?>
                                                                            </td>
                                                                            <td style="width:15%;">
                                                                                <select class="form-control form-group assigned_select" style="width:100%;"  name="salesman_list">
                                                                                    <?php
                                                                                    foreach ($salesman_list as $key0 => $value0) {
                                                                                        ?>
                                                                                        <option value="<?php echo $value->id . "-" . $value0->id; ?>"
                                                                                        <?php
                                                                                        if ($value->assigned_to == $value0->id) {
                                                                                            echo 'selected="selected"';
                                                                                        }
                                                                                        ?>

                                                                                                ><?php echo $value0->first_name . " " . $value0->last_name; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>

                                                                                </select>
                                                                            </td>
                                                                            <td id="<?php echo $value->id; ?>" >
                                                                                <a href="<?php echo site_url('leads/edit_lead') . '/' . $value->id; ?>"><button class="btn btn-xs btn-info"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                                                                <a href="<?php echo site_url('leads/view_lead_profile') . '/' . $value->id; ?>#f"><button class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o"></i> Follow Up</button></a> <button class="btn btn-xs btn-danger delete" data-toggle="confirmation-singleton"><i class="fa fa-trash-o"></i> Delete</button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th>	
                                                                        <th>Product</th>
                                                                        <th class="hidden-xs">Address</th>
                                                                        <th>Added On</th>
                                                                        <th>Entered By</th>
                                                                        <th>Assigned To</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>

                                                        <script type="text/javascript">
                                                            $("#assigned_tbody").on("change", ".assigned_select", function() {
                                                                var check = confirm("Are you sure to re-assign salesman?");
                                                                if (check)
                                                                {
                                                                    $("#ajax_pro_img2").show();
                                                                    var select_value = $(this).val();
                                                                    var select_split = select_value.split('-');
                                                                    var l_id = select_split[0];
                                                                    var s_id = select_split[1];
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: '<?php echo site_url('leads/reassign_salesman'); ?>',
                                                                        data: {
                                                                            lead_id: l_id,
                                                                            salesman_id: s_id
                                                                        },
                                                                        success: function(data)
                                                                        {
                                                                            $("#ajax_pro_img2").hide();
                                                                            var temp = data.trim();
                                                                            alert(temp);
                                                                        }
                                                                    });
                                                                }

                                                            });
                                                        </script>

                                                        <div class="tab-pane fade" id="box_tab3">
                                                            <table id="" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th> 
                                                                        <th class="hidden-xs">Address</th>
                                                                        <th>Added On</th>
                                                                        <th>Entered By</th>
                                                                        <th>Assigned To</th>
                                                                        <th>Status</th>
                                                                        <th style="width:10%;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody> 
                                                                    <?php
                                                                    if (count($archive_leads)) {
                                                                        foreach ($archive_leads as $key => $value) {
                                                                            ?>
                                                                    <tr class="gradeA" id="tr<?php echo $value->id; ?>">
                                                                                <td>
                                                                                    <a href="<?php echo site_url('leads/view_lead_profile') . '/' . $value->id; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></a>
                                                                                    <?php
                                                                                    if ($value->follow_up_status == 4) {
                                                                                        ?>
                                                                                        <span class="label label-success pull-right">Closed</span>
                                                                                        <?php
                                                                                    }
                                                                                    elseif ($value->follow_up_status == 2) {
                                                                                        ?>
                                                                                        <span class="label label-default pull-right">Not Interested</span>
                                                                                        <?php
                                                                                    }elseif ($value->follow_up_status == 3) {
                                                                                        ?>
                                                                                        <span class="label label-warning pull-right">Not Important</span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $value->email; ?></td>
                                                                                <td><?php echo $value->phone; ?></td>
                                                                                <td class="hidden-xs"><?php echo $value->place . ", " . $value->address; ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    $date = explode('-', $value->date);
                                                                                    echo $date[2] . "/" . $date[1] . "/" . $date[0];
                                                                                    ?> 
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    $user = $this->ion_auth->user($value->entered_by)->row();
                                                                                    echo $user->first_name . " " . $user->last_name;
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($value->assigned_to > 0) {
                                                                                        $user = $this->ion_auth->user($value->assigned_to)->row();
                                                                                        echo $user->first_name . " " . $user->last_name;
                                                                                    } else {
                                                                                        ?>
                                                                                        <p style="color:red">Not Assigned</p>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($value->follow_up_status == 2) {
                                                                                        echo 'Not Intrested';
                                                                                    } else {
                                                                                        echo 'Closed';
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td id="<?php echo $value->id; ?>">
                                                                                    <a href="<?php echo site_url('leads/edit_lead') . '/' . $value->id; ?>"><button class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                                                                    <button class="btn btn-xs btn-danger delete" data-toggle="confirmation-singleton"><i class="fa fa-trash-o"></i> Delete</button>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                        ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th class="hidden-xs">Phone</th>
                                                                        <th class="hidden-xs">Address</th>
                                                                        <th>Added On</th>
                                                                        <th>Entered By</th>
                                                                        <th>Assigned To</th>
                                                                        <th>Status</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End Admin Blue Table Box -->

                                        <?php
                                    } elseif ($user->user_type == 4) {
                                        ?>
                                        <div class="box border blue">
                                            <div class="box-title">
                                                <h4><i class="fa fa-columns"></i><span class="hidden-inline-mobile">Leads</span></h4>
                                            </div>
                                            <div class="box-body">
                                                <table id="" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%;">Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>                                              
                                                            <th>Products</th>												
                                                            <th class="hidden-xs">Address</th>
                                                            <th>Entered By</th>
                                                            <th>Assigned To</th>                                                
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>	
                                                        <?php
                                                        foreach ($leadslist as $key1 => $value1) {
                                                            if ($value1->follow_up_status != 4) {
                                                                ?>
                                                                <tr id="tr<?php echo $value1->id; ?>">
                                                                    <td><a href="<?php echo site_url('leads/view_lead_profile') . '/' . $value1->id; ?>"><?php echo $value1->first_name . " " . $value1->last_name; ?></a></td>
                                                                    <td><?php echo $value1->email; ?></td>
                                                                    <td><?php echo $value1->phone; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $lead_pro_array = array();
                                                                        $un_l_pro = unserialize($value1->product);
                                                                        foreach ($un_l_pro as $key2 => $value2) {
                                                                            $lead_pro_array[] = $key2;
                                                                        }
                                                                        foreach ($lead_pro_array as $key3 => $value3) {
                                                                            foreach ($pro as $key4 => $value4) {
                                                                                if ($value4->id == $value3) {
                                                                                    ?>
                                                                                    <a href="<?php echo site_url('product/View_product_profile') . '/' . $value3; ?>" ><?php echo $value4->product_name; ?></a><br>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $value1->address; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $user = $this->ion_auth->user($value1->entered_by)->row();
                                                                        echo $user->first_name . " " . $user->last_name;
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $user = $this->ion_auth->user()->row();
                                                                        echo $user->first_name . " " . $user->last_name;
                                                                        ?>
                                                                    </td>
                                                                    <td id="<?php echo $value1->id; ?>">
                                                                        <a href="<?php echo site_url('leads/edit_lead') . '/' . $value1->id; ?>"><button class="btn btn-xs btn-info"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                                                        <a href="<?php echo site_url('leads/view_lead_profile') . '/' . $value1->id; ?>#f"><button class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o"></i> Follow Up</button></a>
                                                                        <button class="btn btn-xs btn-danger delete" data-toggle="confirmation-singleton"><i class="fa fa-trash-o"></i> Delete</button>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Products</th>
                                                            <th class="hidden-xs">Address</th>
                                                            <th>Entered By</th>
                                                            <th>Assigned To</th>                                                
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>                    
                                            </div>
                                        </div>

                                        <?php
                                    }
// code for callcener guys
                                    elseif ($user->user_type == 2) {
                                        ?>
                                        <div class="box border blue">
                                            <div class="box-title">
                                                <h4><i class="fa fa-columns"></i><span class="hidden-inline-mobile">Leads</span></h4>
                                            </div>
                                            <div class="box-body">
                                                <table id="" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr id="<?php echo $value1->id; ?>">
                                                            <th style="width: 15%;">Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>                                              
                                                            <th>Products</th>												
                                                            <th class="hidden-xs">Address</th>
                                                            <th>Entered By</th>                                                
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>	
                                                        <?php
                                                        foreach ($leadslist as $key1 => $value1) {
                                                            ?>
                                                            <tr>
                                                                <td><a href="<?php echo site_url('leads/lead_profile') . '/' . $value1->id; ?>"><?php echo $value1->first_name . " " . $value1->last_name; ?></a> <span class="label label-warning pull-right">New</span></td>
                                                                <td><?php echo $value1->email; ?></td>
                                                                <td><?php echo $value1->phone; ?></td>
                                                                <td>
                                                                    <?php
                                                                    $lead_pro_array = array();
                                                                    $un_l_pro = unserialize($value1->product);
                                                                    foreach ($un_l_pro as $key2 => $value2) {
                                                                        $lead_pro_array[] = $key2;
                                                                    }
                                                                    foreach ($lead_pro_array as $key3 => $value3) {
                                                                        foreach ($pro as $key4 => $value4) {
                                                                            if ($value4->id == $value3) {
                                                                                ?>
                                                                                <a href="<?php echo site_url('product/View_product_profile') . '/' . $value3; ?>" ><?php echo $value4->product_name; ?></a><br>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $value1->address; ?></td>
                                                                <td>
                                                                    <?php
                                                                    $user = $this->ion_auth->user($value1->entered_by)->row();
                                                                    echo $user->first_name . " " . $user->last_name;
                                                                    ?>
                                                                </td>
                                                                <td id="<?php echo $value1->id; ?>">
                                                                    <a href="<?php echo site_url('leads/edit_lead') . '/' . $value1->id; ?>"><button class="btn btn-xs btn-info"><i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                                                    <button class="btn btn-xs btn-danger delete" data-toggle="confirmation-singleton"><i class="fa fa-trash-o"></i> Delete</button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Products</th>
                                                            <th class="hidden-xs">Address</th>
                                                            <th>Entered By</th>                                                
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>                    
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <!-- /DATA TABLES -->

                        </div>
                    </div>




                </div><!-- /CONTENT-->
            </div>
        </div>
    </div>
</section>
<!--/PAGE -->
<script src="<?php echo base_url(); ?>assets/js/jquery/jquery-2.0.3.min.js"></script>
<script>
                                                        $(document).ready(function() {
                                                            $("#main-content").on("click", ".delete", function() {
                                                                var tdid = $(this).closest('td').attr('id');
                                                                bootbox.confirm("Are you sure?", function(result) {

                                                                    if (result)
                                                                    {
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: '<?php echo site_url('leads/delete_lead'); ?>',
                                                                            data: {
                                                                                lead_id: tdid
                                                                            },
                                                                            success: function(data)
                                                                            {

                                                                                var temp = data.trim();
                                                                                //alert(temp);
                                                                                bootbox.alert(temp);
                                                                                setTimeout(function() {
                                                                                    $(".bootbox").modal("hide");
                                                                                    $("#tr"+tdid).hide();
                                                                                    $(".tr"+tdid).hide();
                                                                                }, 3000);
                                                                            }
                                                                        });
                                                                    }

                                                                });






                                                            });
                                                        });

</script>

<?php 
$this->load->view('footer');
?>