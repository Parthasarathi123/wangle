   <?php             
$this->load->view('header1');
$this->load->view('sidebar');
?>
<div class="col-md-10">
<table >
                <thead>
                  <tr>
                      <th> <h3>  id</h3></th>
<th><h3>  Name</h3></th>
                    
<th><h3>Action</h3></th>
              </tr>
                
                </thead>
                <tbody>
                   <?php 
    $i=1;
           foreach ($users as $key => $value) {
                                                            
    
          ?>
                    
                    <tr class="record" >
                        <td><h5><?php echo $value['id'];?></h5></td>
                        <td><h5><?php echo $value['username'];?></h5></td>
                   
                    <td style="float:left;">
                       
                        
                        <a  href="<?php echo site_url('auth/edit_user'); echo '/'.$value['id'];?>"><h5> Edit</a>
                        <a href="<?php echo site_url('auth/deactivate'); echo '/'.$value['id'];?>"> Deactivate</a>
                        <a href="<?php echo site_url('auth/activate'); echo '/'.$value['id'];?>"> Activate</h5></a>
                       
                        
                    
                    
                    </td> 
                 </tr>
           <?php }   ?>
                 
                </tbody>
            </table>
   
<?php 
$this->load->view('footer');
?>
<?php
die();
print_r($users);
echo '<br>';
                                                        foreach ($users as $key => $value) {
                                                                print_r($value['id']);
                                                    }?>
