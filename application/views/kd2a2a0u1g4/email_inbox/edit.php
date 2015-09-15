    <div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4").'/'.$this->uri->segment(2); ?>">
            Language Keyword<?php //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating Language keyword<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>

 
      <?php
      //flash messages
     /* if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> keyword updated with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }*/
?>
<?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
     	echo validation_errors();
     	echo form_open('kd2a2a0u1g4/languagekeyword/update/'.$this->uri->segment(4).'', $attributes);
//echo'<pre>'; print_r($language);
?>
        <fieldset>
         <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
        	<div class="control-group">
            <label for="inputError" class="control-label">Location</label>
            <div class="controls">
              <input type="text" id="" name="location" value="<?php echo $language[0]['location']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Language Define</label>
            <div class="controls">
              <input disabled="disabled" type="text" id="" name="language_define" value="<?php echo $language[0]['language_define']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <?php //echo '<pre>'; print_r($site_language);
		  for($i=0;$i<count($site_language);$i++){
		  ?>
          <div class="control-group">
            <label for="inputError" class="control-label"><?php echo $site_language[$i]['language_longform'];?></label>
            <div class="controls">
            <textarea name="<?php echo $site_language[$i]['language_shortcode']?>"><?php    echo $language[0][$site_language[$i]['language_shortcode']]?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <?php }?>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a class="btn" href="<?php echo $this->session->userdata('redirect_url');?>">Cancel</a>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>