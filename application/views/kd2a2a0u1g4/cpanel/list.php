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
         <?php 
		 if(count($cpanel) == 0){?>
          <a  href="<?php echo site_url("kd2a2a0u1g4").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
          <?php }?>
        </h2>
      </div>
         <?php
	//flash messages
	    
	  //echo $this->session->flashdata('flash_message');
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'add')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new cpanel created with success.';
          echo '</div>';       
        }else if($this->session->flashdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> cpanel updated with success.';
          echo '</div>'; 
		}else if($this->session->flashdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> cpanel deleted with success.';
          echo '</div>';
		}else if($this->session->flashdata('flash_message') == 'already'){
		echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> You already have one Cpanel Set, delete to add another.';
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
          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">#</th>
          		<th class="yellow header headerSortDown">Site Domain</th>
                 <th class="yellow header headerSortDown">Site Skin</th>
                 <th class="yellow header headerSortDown">Username</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($cpanel as $row)
              {
                echo '<tr>';
				 echo '<td>'.$row['cpanel_id'].'</td>';
                echo '<td>'.$row['site_domain'].'</td>';
			    echo '<td>'.$row['site_skin'].'</td>';
				echo '<td>'.$row['username'].'</td>';
				echo '<td class="crud-actions">
                  <a  href="'.site_url("kd2a2a0u1g4").'/cpanel/update/'.$row['cpanel_id'].'" class="btn btn-info">view & edit</a>  
                  <a href="'.site_url("kd2a2a0u1g4").'/cpanel/delete/'.$row['cpanel_id'].'" class="btn btn-danger complexConfirm">delete</a>
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