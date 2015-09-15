    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          Email advertisement<?php //echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          Email advertisement<?php //echo ucfirst($this->uri->segment(2));?> 
          <a href="<?php echo site_url("kd2a2a0u1g4").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
      </div>
         <?php
	 	//\\print_r($this->session->userdata('flash_message'));
		//print_r($this->session->flashdata('data'));
	
	//flash messages
	
	  echo validation_errors();
	  //echo $this->session->flashdata('flash_message');
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'add')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new advertisement created with success.';
          echo '</div>';       
        }else if($this->session->flashdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> advertisement updated with success.';
          echo '</div>'; 
		}else if($this->session->flashdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> advertisement deleted with success.';
          echo '</div>';
		}else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
	  
      
      ?>
      <div class="row">
        <div class="span12 columns">
          <?php /*?><div class="well">
           
            <?php
           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
           
            //save the columns names in a array that we will use as filter         
            $options_advertisement = array();    
            foreach ($advertisement as $array) {
              foreach ($array as $key => $value) {
                $options_advertisement[$key] = $key;
              }
              break;
            }

            echo form_open('kd2a2a0u1g4/advertisement', $attributes);
     
              echo form_label('Search:', 'search_string');
              echo form_input('search_string', $search_string_selected);

              echo form_label('Order by:', 'order');
              echo form_dropdown('order', $options_advertisement, $order, 'class="span2"');

              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

              $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              echo form_submit($data_submit);

            echo form_close();
            ?>

          </div><?php */?>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">#</th>
          	<th class="yellow header headerSortDown">Advertisement</th>
                 <th class="yellow header headerSortDown">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($advertisement as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['advertisement_id'].'</td>';
			if($row['advertisement_flag'] == 'advertisement_script' ){
                echo '<td>'.$row['advertisement_script'].'</td>';
				}else{
				
				echo '<td><img width="50" src="'.site_url("uploads/advertisement")."/".$row['advertisement_image'].'"></td>';
				}
				 echo '<td>'.$row['status'].'</td>';
                echo '<td class="crud-actions">
                  <a  href="'.site_url("kd2a2a0u1g4").'/advertisement/update/'.$row['advertisement_id'].'" class="btn btn-info">view & edit</a>  
                  <a href="'.site_url("kd2a2a0u1g4").'/advertisement/delete/'.$row['advertisement_id'].'" class="btn btn-danger complexConfirm">delete</a>
                </td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>
			
          <?php 
		  $this->session->set_userdata('redirect_url', current_url());
		  echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

      </div>
    </div>