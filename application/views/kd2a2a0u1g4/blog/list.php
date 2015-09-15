    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          Blog<?php //echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          Blog<?php //echo ucfirst($this->uri->segment(2));?> 
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
            echo '<strong>Well done!</strong> new blog created with success.';
          echo '</div>';       
        }else if($this->session->flashdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> blog updated with success.';
          echo '</div>'; 
		}else if($this->session->flashdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> blog deleted with success.';
          echo '</div>';
		}else if($this->session->flashdata('flash_message') == 'clone'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> One blog cloned with success.';
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
            $options_language = array();    
            foreach ($blog as $array) {
              foreach ($array as $key => $value) {
                $options_language[$key] = $key;
              }
              break;
            }

            echo form_open('kd2a2a0u1g4/blog', $attributes);
     
              echo form_label('Search:', 'search_string');
              echo form_input('search_string', $search_string_selected);?>
			<select name="order" class="span2">
				<option <?php echo ($order == 'title_en') ? 'selected="selected"' : ""?>  value="title_en">Title</option>
                <option <?php echo ($order == 'status') ? 'selected="selected"' : ""?> value="status">Status</option>
		<option <?php echo ($order == 'published_date') ? 'selected="selected"' : ""?> value="published_date">Published Date</option>
			</select>
           <?php
              echo form_label('Order by:', 'order');
              //echo form_dropdown('order', $options_language, $order, 'class="span2"');

              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

              $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              echo form_submit($data_submit);
			if($search_string_selected){
			echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="'.site_url("kd2a2a0u1g4/blog/").'">Reset</a>';
			}
            echo form_close();
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">#</th>
                <th class="yellow header headerSortDown">Title</th>
                <th class="yellow header headerSortDown">Published Date</th>
                <th style="text-align:center" class="yellow header headerSortDown">Published</th>
                <th class="yellow header headerSortDown">Status</th>
                <th style="width:211px;" class="yellow header headerSortDown"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($blog as $row)
              {
				  $schedule_status = ($row['schedule_status'] == 'Active') ? '<img title="Published" src="'.site_url('assets/img/admin/ico/icoStatusGreen.png').'">' : '<img title="Not published" src="'.site_url('assets/img/admin/ico/icoStatusRed.png').'">';
				  
                echo '<tr>';
                echo '<td>'.$row['blog_id'].'</td>';
                echo '<td>'.$row['title_en'].'</td>';
				echo '<td>'.$row['published_date'].'</td>';
				echo '<td style="text-align:center">'.$schedule_status.'</td>';
				 echo '<td>'.$row['status'].'</td>';
				//html_entity_decode($row['en'])
                echo '<td class="crud-actions">
                  <a  href="'.site_url("kd2a2a0u1g4").'/blog/update/'.$row['blog_id'].'" class="btn btn-info">view & edit</a>  
                  <a href="'.site_url("kd2a2a0u1g4").'/blog/delete/'.$row['blog_id'].'" class="btn btn-danger complexConfirm">delete</a><a style="margin-left:4px;" href="'.site_url("kd2a2a0u1g4").'/blog/clone/'.$row['blog_id'].'" class="btn btn-success">Clone</a>
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