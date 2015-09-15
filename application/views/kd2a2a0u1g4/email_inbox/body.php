<link href="<?php echo base_url(); ?>assets/css/kd2a2a0u1g4/demo.css" rel="stylesheet" type="text/css">
    <div class="container top">
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4/emailinbox"); ?>">
            Inbox<?php //echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4/emailinbox/inboxlist"); ?>">
            Inbox list<?php //echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
         body
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          Body <?php //echo ucfirst($this->uri->segment(2));?> 
           <span id="delete_msg" style="display:none">Are you really sure to delete this Mail?</span>
          <a  href="<?php echo site_url('kd2a2a0u1g4').'/'.$this->uri->segment(2); ?>/delete_mail/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" class="btn btn-danger complexConfirm">Delete</a>
          <?php /*?><a  href="<?php echo site_url('kd2a2a0u1g4').'/'.$this->uri->segment(2); ?>/process/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" class="btn btn-success">Process</a><?php */?>
        </h2>
      </div>
         <?php
		//flash messages
	  	echo validation_errors();
	  //echo $this->session->flashdata('flash_message');
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'add')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new language Keyword created with success.';
          echo '</div>';       
        }if($this->session->flashdata('flash_message') == 'not_process')
        {
         echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> can not find any Unsubscribe entry from database!';
          echo '</div>';        
        }else if($this->session->flashdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> language Keyword updated with success.';
          echo '</div>'; 
		}else if($this->session->flashdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> language Keyword deleted with success.';
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
           	<div id="mailboxes">
		    	<?php echo $body;?> 
   			</div>
            
      </div>
</div>