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
            <?php echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">New</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Adding <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
      echo validation_errors();
      
      echo form_open_multipart('kd2a2a0u1g4/cpanel/add', $attributes);
      //echo '<pre>'; print_r($category);
	  ?>
        <fieldset>
          <div class="control-group">
            <label for="inputError" class="control-label">Site Domain<span class="star">*</span></label>
            <div class="controls">
            	<input type="text" id="" name="site_domain" value="<?php echo set_value('site_domain'); ?>" >

              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Site Skin<span class="star">*</span></label>
            <div class="controls">
            <input type="text" id="" name="site_skin" value="<?php echo set_value('site_skin'); ?>" >

               <span class="help-inline">( the part underlined /frontend/__/index.html in your cpanel home url )</span>
		</div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Username<span class="star">*</span></label>
            <div class="controls">
				<input type="text" id="" name="username" value="<?php echo set_value('username'); ?>" >
              
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Password<span class="star">*</span></label>
            <div class="controls">
				<input type="password" id="" name="password" value="<?php echo set_value('password'); ?>" >

              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Password Confirmation<span class="star">*</span></label>
            <div class="controls">
				<input type="password" id="" name="password2" value="<?php echo set_value('password2'); ?>" >

              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a class="btn" href="<?php echo site_url('kd2a2a0u1g4')?>/cpanel">Cancel</a>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
<script type="text/javascript">
	var val_add = "cpanel_script";
</script> 
     