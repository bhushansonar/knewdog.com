<?php
				$CI =& get_instance(); 
				$CI->load->model('Imap_model');
				$m_count = null;//$CI->Imap_model->get_mail_count();
				$CI->load->model('newsletter_clone_model');
				$m_count_admininbox = $CI->newsletter_clone_model->count_newsletter_clone();
				$CI->load->model('administration_folder_model');
				$m_count_administration_folder = $CI->administration_folder_model->count_administration_folder();
				$total_mails = ((int)$m_count_admininbox + (int)$m_count_administration_folder);
				/*$m_count =0;
				$m_count_administration_folder = 0;
				$total_mails = 0;*/
				
?>
<!DOCTYPE html> 
<html lang="en-US">
<head>
  <title>KnewDog Admin - <?php echo ucfirst($this->uri->segment(2));?></title>
  <meta charset="utf-8">
  <link href="<?php echo base_url(); ?>assets/css/kd2a2a0u1g4/global.css" rel="stylesheet" type="text/css">
  <script type="text/javascript"> var base_url = '<?php echo base_url();?>'</script>
  <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
</head>
<body>
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
        
	      <a class="brand"><!--<img src="<?php echo base_url();?>assets/images/kd2a2a0u1g4/logo.png" />-->KnewDog Admin</a>
          <div class="brand logininfo">logged in as <a title="<?php echo $this->session->userdata('username');?>" href="<?php echo base_url();?>kd2a2a0u1g4/user/update/<?php echo $this->session->userdata('user_id') ?>"><?php echo substr($this->session->userdata('username'), 0, 10);?></a>&nbsp; <a href="<?php echo base_url(); ?>kd2a2a0u1g4/logout">Logout</a></div> 
          <ul class="nav">
	        <li <?php if($this->uri->segment(2) == 'dashboard'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/dashboard">Dashboard</a>
	        </li>
            <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Newsletter Library<b <?php echo ($total_mails > 0) ? 'style="margin-top:11px"' : ''?> class="caret"></b></a>
             <?php  if($total_mails > 0){?> 
              <div class="tip_div"><span class="tip"><span class="tip_in"><?php echo $total_mails;?></span></span></div>
              <?php }?>
	          <ul class="dropdown-menu">
	            <li <?php if($this->uri->segment(2) == 'category'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/category">Category</a>
	        </li>
            <li <?php if($this->uri->segment(2) == 'keyword'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/keyword">Keyword</a>
	        </li>
            <li <?php if($this->uri->segment(2) == 'language'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/language">Language</a>
	        </li>
            <li <?php if($this->uri->segment(2) == 'newsletter'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/newsletter">Newsletter</a>
	        </li>
            <li <?php if($this->uri->segment(2) == 'emailinbox'){echo 'class="active"';}?>>
           
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/emailinbox">Inbox <span style="margin-top:-2px;">(<?php echo $m_count;?>)</span></a>
	        </li>
            <li <?php if($this->uri->segment(2) == 'admin-inbox'){echo 'class="active"';}?>>
           
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/admin-inbox">Admin Unsubscribe Inbox <span style="margin-top:-2px;">(<?php echo $m_count_admininbox;?>)</span></a>
	        </li>
            <li <?php if($this->uri->segment(2) == 'administration-folder'){echo 'class="active"';}?>>
           
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/administration-folder">Administration folder <span style="margin-top:-2px;">(<?php echo $m_count_administration_folder;?>)</span></a>
	        </li>
	          </ul>
	        </li>
            <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Languages <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li <?php if($this->uri->segment(2) == 'sitelanguage'){echo 'class="active"';}?>>
	              <a href="<?php echo base_url(); ?>kd2a2a0u1g4/sitelanguage">Site Languages</a>
	            </li>
                <li <?php if($this->uri->segment(2) == 'languagekeyword'){echo 'class="active"';}?>>
	              <a href="<?php echo base_url(); ?>kd2a2a0u1g4/languagekeyword">Language Database</a>
	            </li>
	          </ul>
	        </li>
            <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Advertises<b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li <?php if($this->uri->segment(2) == 'advertisement'){echo 'class="active"';}?>>
	              <a href="<?php echo base_url(); ?>kd2a2a0u1g4/advertisement">Email advertisement</a>
	            </li>
                <li <?php if($this->uri->segment(2) == 'wanted-add'){echo 'class="active"';}?>>
	              <a href="<?php echo base_url(); ?>kd2a2a0u1g4/wanted-add">Website advertisement</a>
	            </li>
	          </ul>
	        </li>
            
            <li <?php if($this->uri->segment(2) == 'user'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/user">User</a>
	        </li>
            <li <?php if($this->uri->segment(2) == 'cms'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>kd2a2a0u1g4/blog">Blog</a>
	        </li>
            <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li <?php if($this->uri->segment(2) == 'cpanel'){echo 'class="active"';}?>>
	              <a href="<?php echo base_url(); ?>kd2a2a0u1g4/cpanel">Cpanel</a>
	            </li>
	          </ul>
	        </li>
            
	        <?php /*?><li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li>
	              <a href="<?php echo base_url(); ?>kd2a2a0u1g4/logout">Logout</a>
	            </li>
	          </ul>
	        </li><?php */?>
	      </ul>
	    </div>
	  </div>
	</div>