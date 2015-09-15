    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          Remove Unsubscribe<?php //echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          Remove Unsubscribe<?php //echo ucfirst($this->uri->segment(2));?> 
          <a  href="<?php echo site_url("kd2a2a0u1g4").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
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
            echo '<strong>Well done!</strong> new Remove Unsubscribe created with success.';
          echo '</div>';       
        }else if($this->session->flashdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Remove Unsubscribe updated with success.';
          echo '</div>'; 
		}else if($this->session->flashdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Remove Unsubscribe deleted with success.';
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
         <div class="well">
           
            <?php
           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
           
            //save the columns names in a array that we will use as filter      
			$options_newsletter = array();    
            foreach ($remove_unsubscribe as $array) {
              foreach ($array as $key => $value) {
                $options_newsletter[$key] = $key;
              }
              break;
            }
//echo  '<pre>'; print_r($options_newsletter);
//echo  '<pre>'; print_r($newsletter);
            echo form_open('kd2a2a0u1g4/remove-unsubscribe', $attributes);
     
              echo form_label('Search:', 'search_string');
			  ?>
			  		<select name="order" class="span2">
						<option <?php echo ($order == 'unbsubscribe_text') ? 'selected="selected"' :""?> value="unsubscribe_text">Unsubscribe Text</option>
						<option <?php echo ($order == 'unsubscribe_url') ? 'selected="selected"' :""?> value="unsubscribe_url">Unsubscribe URL</option>
						<option <?php echo ($order == 'status') ? 'selected="selected"' :""?> value="status">Status</option>
					</select>
			 <?php echo form_input('search_string', $search_string_selected);

              echo form_label('Order by:', 'order');
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

              $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              echo form_submit($data_submit);
			if($search_string_selected){
			echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="'.site_url("kd2a2a0u1g4/remove-unsubscribe/").'">Reset</a>';
			}
            echo form_close();
			
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">#</th>
          	<th class="yellow header headerSortDown">Remove Unsubscribe</th>
            	<th class="yellow header headerSortDown">Type</th>
                 <th class="yellow header headerSortDown">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($remove_unsubscribe as $row)
              {
				  if($row['remove_unsubscribe'] == 'text'){
					  $un = $row['unsubscribe_text'];
				}else if($row['remove_unsubscribe'] == 'url'){
					$un = $row['unsubscribe_url'];
					}
				  
				$status = ($row['status'] == 'Active') ? 'Inactive' : 'Active';
                echo '<tr>';
                echo '<td>'.$row['remove_unsubscribe_id'].'</td>';
				echo '<td>'. get_excerpt ($un, 100, '...').'</td>';
				echo '<td>'.$row['remove_unsubscribe'].'</td>';
				echo '<td>'.$row['status'].'</td>';
                echo '<td style="width:215px;" class="crud-actions">
                  <a  href="'.site_url("kd2a2a0u1g4").'/remove-unsubscribe/update/'.$row['remove_unsubscribe_id'].'" class="btn btn-info">view & edit</a> 
				  <a href="'.site_url("kd2a2a0u1g4").'/remove-unsubscribe/delete/'.$row['remove_unsubscribe_id'].'" class="btn btn-danger complexConfirm">delete</a>
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