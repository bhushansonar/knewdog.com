<?php 
$this->load->model('newsletter_language_model');
?>
    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php echo ucfirst($this->uri->segment(2));?> 
          <a  href="<?php echo site_url("kd2a2a0u1g4").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
      </div>
<?php
	//flash messages
      if($this->session->userdata('flash_message')){
        if($this->session->userdata('flash_message') == 'add')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new newsletter created with success.';
          echo '</div>'; 
		  $this->session->set_userdata('flash_message', '');      
        }else if($this->session->userdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> newsletter updated with success.';
          echo '</div>'; 
		  $this->session->set_userdata('flash_message', ''); 
		}else if($this->session->userdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> newsletter deleted with success.';
          echo '</div>';
		  $this->session->set_userdata('flash_message', ''); 
		}else if($this->session->userdata('flash_message') == 'multi_delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> '.$this->session->userdata('delete_msg_no').' newsletter(s) deleted with success.';
          echo '</div>';
		  $this->session->set_userdata('flash_message', ''); 
		}else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
		if(($this->session->userdata('unsubscribe_count')))
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Total '.$this->session->userdata('unsubscribe_count').' Unsubscribe entry deleted in newsletter Issue.';
          echo '</div>'; 
		  $this->session->set_userdata('unsubscribe_count', '');      
        }
	if($this->session->userdata('flash_message1')){
		 if($this->session->userdata('flash_message1') == 'acc_success'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Email Account <strong>'.$this->session->userdata('add_email').'</strong> created successfully.';
          echo '</div>';
		  $this->session->set_userdata('flash_message1', '');
		  $this->session->set_userdata('add_email', ''); 
		}else if($this->session->userdata('flash_message1') == 'mail_delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> E-Mail <strong>'.$this->session->userdata('delete_mail').'</strong> also deleted with success.';
          echo '</div>';
		  $this->session->set_userdata('flash_message1', ''); 
		  }else {
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> Email Account not created. Please make sure you entered the correct information in Cpanel.';
          echo '</div>';          
        	}
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
            foreach ($newsletter as $array) {
              foreach ($array as $key => $value) {
                $options_newsletter[$key] = $key;
              }
              break;
            }
//echo  '<pre>'; print_r($options_newsletter);
//echo  '<pre>'; print_r($newsletter);
            echo form_open('kd2a2a0u1g4/newsletter', $attributes);
     
              echo form_label('Search:', 'search_string');
			  ?>
			  		<select name="order" class="span2">
						<option <?php echo ($order == 'newsletter_rand_id') ? 'selected="selected"' :""?> value="newsletter_rand_id">Id</option>
						<option <?php echo ($order == 'newsletter_name') ? 'selected="selected"' :""?> value="newsletter_name">Name</option>
						<option <?php echo ($order == 'author_name') ? 'selected="selected"' :""?> value="author_name">Author</option>
						<option <?php echo ($order == 'website_url') ? 'selected="selected"' :""?> value="website_url">Website</option>
						<option <?php echo ($order == 'status') ? 'selected="selected"' :""?> value="status">Status</option>
					</select>
			 <?php echo form_input('search_string', $search_string_selected);

              echo form_label('Order by:', 'order');
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

              $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              echo form_submit($data_submit);
			if($search_string_selected){
			echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="'.site_url("kd2a2a0u1g4/newsletter/").'">Reset</a>';
			}
            echo form_close();
			
            ?>

          </div>
        <form name="frmList" id="frmList" method="post" action="<?php echo site_url('kd2a2a0u1g4/newsletter/multidelete')?>">
         <?php if(count($newsletter)>0){?>
        	<button onclick="doAction('Delete')" style="margin-bottom:8px; float:right;" class="btn btn-danger" type="button">Delete Newsletters</button>
           <?php }?>
          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
              	<th align="center" style="text-align:center;" class="header"><input type="checkbox" name="abc" id="abc" onclick="checkAll();" value="1"></th>
                <th align="center" style="text-align:center;" class="header">Id</th>
                <th class="yellow header headerSortDown">Name</th>
                <th class="yellow header headerSortDown">Author</th>
               <!-- <th class="yellow header headerSortDown">Category</th>-->
                <th class="yellow header headerSortDown">Website</th>
                <th style="text-align:center;" class="yellow header headerSortDown">Language</th>
                 <th class="yellow header headerSortDown">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
			  $i = 0;
              foreach($newsletter as $row)
              {
				
                echo '<tr>';
				echo '<td align="center" style="text-align:center;"><input id="list" type="checkbox" name="row_'.$i.'" value="'.$row['newsletter_id'].'"></td>';
                echo '<td style="text-align:center;">'.$row['newsletter_rand_id'].'</td>';
                echo '<td>'.$row['newsletter_name'].'</td>';
				echo '<td>'.$row['author_name'].'</td>';
				//echo '<td>'.$row['newsletter_category_id'].'</td>';
				echo '<td>'.$row['website_url'].'</td>';
				if($row['language_id'] != 0){
				$lang = $this->newsletter_language_model->get_language_by_id($row['language_id']);
				$display_lang = $lang[0]['language_longform'];
				}else{
				$display_lang = "--";
				}
				echo '<td style="text-align:center;">'.$display_lang.'</td>';
				 echo '<td>'.$row['status'].'</td>';
                echo '<td style="text-align:center;" class="crud-actions">
                  <a  href="'.site_url("kd2a2a0u1g4").'/newsletter/update/'.$row['newsletter_id'].'" class="btn btn-info">view & edit</a>  
				  <a  href="'.site_url("kd2a2a0u1g4").'/newsletter/issues/'.$row['newsletter_id'].'" class="btn btn-info">Issues</a>  
                </td>';
				/*<a href="'.site_url("kd2a2a0u1g4").'/newsletter/delete/'.$row['newsletter_id'].'" class="btn btn-danger complexConfirm">delete</a>*/
                echo '</tr>';
				$i++;
              }
              ?>      
            </tbody>
          </table>
         <?php 
		 $this->session->set_userdata('redirect_url', current_url());
		 echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>
         <input type="hidden" name="tot_rec" value="<?php echo $i?>" />
		</form>
      </div>
    </div>