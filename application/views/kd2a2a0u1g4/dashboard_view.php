    <div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
            <?php echo ucfirst($this->uri->segment(2));?>
         </ul>
      
      <div class="page-header">
        <h2>
        <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
        <h3 style="margin-top:5px;">Welcome <a href="<?php echo base_url();?>kd2a2a0u1g4/user/update/<?php echo $this->session->userdata['user_id'] ?>"><?php echo $this->session->userdata['username'];?></a> to KnewDog Admin.</h3>
      </div>
	     <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/category" title="Category">
         	<img alt="Add Category" src="<?php echo base_url(); ?>/assets/img/admin/ico/categoryico.png" />
            	<span>Newsletter Category</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/keyword" title="Keyword">
         	<img alt="Add Keyword" src="<?php echo base_url(); ?>/assets/img/admin/ico/keyword.png" />
            	<span>Newsletter Keyword</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/language" title="Language">
         	<img alt="Add Language" src="<?php echo base_url(); ?>/assets/img/admin/ico/language.png" />
            	<span>Newsletter Language</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/newsletter" title="News Letter">
         	<img alt="Add Category" src="<?php echo base_url(); ?>/assets/img/admin/ico/newsletter.png" />
            	<span>Newsletter Library</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/sitelanguage" title="Site Language">
         	<img alt="Add Site Language" src="<?php echo base_url(); ?>/assets/img/admin/ico/language.png" />
            	<span>Site Language</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/languagekeyword" title="Language Keyword">
         	<img alt="Add Language Keyword" src="<?php echo base_url(); ?>/assets/img/admin/ico/keyword.png" />
            	<span>Language Database</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/advertisement" title="Advertisement">
         	<img alt="Add Advertisement" src="<?php echo base_url(); ?>/assets/img/admin/ico/advertisement.png" />
            	<span>Email advertisement</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/wanted-add" title="Wanted add">
         	<img alt="Add Wanted add" src="<?php echo base_url(); ?>/assets/img/admin/ico/advertisement.png" />
            	<span>Website advertisement</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/blog" title="Blog">
         	<img alt="Add Blog" src="<?php echo base_url(); ?>/assets/img/admin/ico/blog_icon.png" />
            	<span>Blog</span>
             </a>
        </div>
        <div style="position: relative">
        <div class="untreated_comment_div"><span class="untreated_commen"><span class="untreated_commen_in"><?php echo $untreated_comment; ?></span></span></div> 
        </div>
        <div  class="quickLink"> 
             
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/comment" title="Comment">
         	<img alt="View Comment" src="<?php echo base_url(); ?>/assets/img/admin/ico/commentico.png" />
            	<span>Comment</span>
              
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/cms" title="CMS">
         	<img alt="Add CMS" src="<?php echo base_url(); ?>/assets/img/admin/ico/static_pageico.png" />
            	<span>CMS</span>
             </a>
        </div>
        <?php /*?><div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/remove-unsubscribe" title="Remove Unsubscribe entry words">
         	<img alt="Remove Unsubscribe entry" src="<?php echo base_url(); ?>/assets/img/admin/ico/remove_unsubscribeicon.png" />
            	<span>Remove Unsubscribe entry</span>
             </a>
        </div><?php */?>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/cpanel" title="Cpanel">
         	<img alt="Add Cpanel" src="<?php echo base_url(); ?>/assets/img/admin/ico/cpanel.png" />
            	<span>Cpanel</span>
             </a>
        </div>
          <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/email_template" title="User">
         	<img alt="Add Email Tempalte" src="<?php echo base_url(); ?>/assets/img/admin/ico/email.png" />
            	<span>Email Template</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/user" title="User">
         	<img alt="Add User" src="<?php echo base_url(); ?>/assets/img/admin/ico/user.png" />
            	<span>Users</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/invoice" title="Invoice">
         	<img alt="View Invoice" src="<?php echo base_url(); ?>/assets/img/admin/ico/invoice.jpg" />
            	<span>Invoice</span>
             </a>
        </div>
        <div class="quickLink"> 
         <a href="<?php echo base_url(); ?>kd2a2a0u1g4/newsletter_email" title="Newsletter email">
         	<img alt="View Newsletter email" src="<?php echo base_url(); ?>/assets/img/admin/ico/email.png" />
            	<span>Newsletter Email list</span>
             </a>
        </div>
    </div>
    <?php //echo '<pre>';print_r($this->session->userdata);?>
     