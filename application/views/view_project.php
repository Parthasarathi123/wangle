  <?php             
$this->load->view('header1');
$this->load->view('sidebar');
?>
<div class="col-md-10">
<table >
                <thead>
                  <tr>
                    <th>id</th>
                    <th>Project name</th>
                    
                    <th>Assigned To</th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
    $i=1;
           foreach ($projects as $key => $value) {
                                                            
    
          ?>
                    
                    <tr class="record">
                    <td><?php echo $value['id'];?></td>
                    <td><?php echo $value['project_name'];?></td>
                   
                    <td><?php echo $value['assigned_to'];?></td> 
                 </tr>
           <?php }   ?>
                </tbody>
            </table>
   
<?php 
$this->load->view('footer');
?>