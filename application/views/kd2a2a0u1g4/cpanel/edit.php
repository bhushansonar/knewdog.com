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
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
      echo validation_errors();
      echo form_open_multipart('kd2a2a0u1g4/cpanel/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
         <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
          <div class="control-group">
            <label for="inputError" class="control-label">Site Domain<span class="star">*</span></label>
            <div class="controls">
            	<input type="text" id="" name="site_domain" value="<?php echo $cpanel[0]['site_domain']; ?>" >

              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Site Skin<span class="star">*</span></label>
            <div class="controls">
            <input type="text" id="" name="site_skin" value="<?php echo $cpanel[0]['site_skin']; ?>" >

               <span class="help-inline">( the part underlined /frontend/__/index.html in your cpanel home url )</span>
		</div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Username<span class="star">*</span></label>
            <div class="controls">
				<input type="text" id="" name="username" value="<?php echo $cpanel[0]['username']; ?>" >
              
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Password<span class="star">*</span></label>
            <div class="controls">
				<input disabled="disabled" name="password" type="password" class="pass_disabled"  value="<?php echo $cpanel[0]['password']; ?>" >
			<span class="help-inline"><a onclick="changepassword();" href="javascript:void(0)">Change</a></span>
            </div>
          </div>
          <div id="confirm_div" style="display:none;" class="control-group">
            <label for="inputError" class="control-label">Confirm Password<span class="star">*</span></label>
            <div class="controls">
              <input disabled="disabled" type="password" class="pass_disabled" name="password2" value="<?php echo $cpanel[0]['password']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a class="btn" href="<?php echo $this->session->userdata('redirect_url');?>">Cancel</a>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div> 