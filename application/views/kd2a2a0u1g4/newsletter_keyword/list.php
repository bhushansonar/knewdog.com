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
            echo '<strong>Well done!</strong> new keyword created with success.';
          echo '</div>';       
        }else if($this->session->flashdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> keyword updated with success.';
          echo '</div>'; 
		}else if($this->session->flashdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> keyword deleted with success.';
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
            $options_keyword = array();    
            foreach ($keyword as $array) {
              foreach ($array as $key => $value) {
                $options_keyword[$key] = $key;
              }
              break;
            }

            echo form_open('kd2a2a0u1g4/keyword', $attributes);
     
              echo form_label('Search:', 'search_string');?>
              <select name="order" class="span2">
              		  <?php for($i=0;$i<count($site_language);$i++){?>
                      	<option <?php echo ($order == $site_language[$i]['language_shortcode']) ? 'selected="selected"' :""?> value="<?php echo $site_language[$i]['language_shortcode']?>"><?php echo $site_language[$i]['language_shortcode']?></option>
                      <?php }?>
						<?php /*?><option <?php echo ($order == 'en') ? 'selected="selected"' :""?> value="en">English</option>
						<option <?php echo ($order == 'de') ? 'selected="selected"' :""?> value="de">German</option>
                        <option <?php echo ($order == 'fr') ? 'selected="selected"' :""?> value="fr">French</option><?php */?>
                        <option <?php echo ($order == 'status') ? 'selected="selected"' :""?> value="status">Status</option>
					</select>
          <?php
		      echo form_input('search_string', $search_string_selected);

              echo form_label('Order by:', 'order');
              //echo form_dropdown('order', $options_keyword, $order, 'class="span2"');

              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

              $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              echo form_submit($data_submit);
			  if($search_string_selected){
			echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="'.site_url("kd2a2a0u1g4/keyword/").'">Reset</a>';
			}
            echo form_close();
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">#</th>
                <th class="yellow header headerSortDown">en</th>
                <th class="yellow header headerSortDown">de</th>
               <?php  if(empty($search_string_selected)){?>
                <th class="yellow header headerSortDown">Fr</th>
                <?php }else{?>
                <th class="yellow header headerSortDown">Search in <?php echo $order?></th>
                <?php }?>
                 <th class="yellow header headerSortDown">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($keyword as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['newsletter_keyword_id'].'</td>';
               	echo '<td>'.$row['en'].'</td>';
				echo '<td>'.$row['de'].'</td>';
			if(empty($search_string_selected)){
				echo '<td>'.$row['fr'].'</td>';
			}else{
				echo '<td>'.$row[$order].'</td>';
			}
				echo '<td>'.$row['status'].'</td>';
                echo '<td class="crud-actions">
                  <a  href="'.site_url("kd2a2a0u1g4").'/keyword/update/'.$row['newsletter_keyword_id'].'" class="btn btn-info">view & edit</a>  
                  <a href="'.site_url("kd2a2a0u1g4").'/keyword/delete/'.$row['newsletter_keyword_id'].'" class="btn btn-danger complexConfirm">delete</a>
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