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
      //form validationc
      echo validation_errors();
      echo form_open_multipart('kd2a2a0u1g4/user/add', $attributes);
      ?>
        <fieldset>
          <div class="control-group">
            <label for="inputError" class="control-label">First Name</label>
            <div class="controls">
              <input type="text" id="" name="firstname" value="<?php echo set_value('firstname'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Last Name</label>
            <div class="controls">
              <input type="text" id="" name="lastname" value="<?php echo custom_set_value('lastname'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">User Name<span class="star">*</span></label>
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
            <label for="inputError" class="control-label">Confirm Password<span class="star">*</span></label>
            <div class="controls">
              <input type="password" id="" name="password2" value="<?php echo set_value('password2'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Primary E-mail<span class="star">*</span></label>
            <div class="controls">
              <input type="text" id="" name="primary_email" value="<?php echo set_value('primary_email'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <?php /*?><div class="control-group">
            <label for="inputError" class="control-label">Primary E-mail 2</label>
            <div class="controls">
              <input type="text" id="" name="primary_email_2" value="<?php echo set_value('primary_email_2'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div><?php */?>
          <div class="control-group">
            <label for="inputError" class="control-label">Gender</label>
            <div class="controls">
              <select name="gender">
             	<option <?php  echo custom_set_value('gender') == 'Male' ? 'selected="selected"' : ''?>  value="Male">Male</option>
                <option <?php echo custom_set_value('gender') == 'Female' ? 'selected="selected"' : ''?> value="Female">Female</option>
                <option <?php  echo custom_set_value('gender') == 'Neutral' ? 'selected="selected"' : ''?> value="Neutral">Neutral</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Aavtar</label>
            <div class="controls">
              <input name="avatar" type="file" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Type of memebership</label>
            <div class="controls">
              <select name="type_of_membership">
              	<option value="">-Select Membership type-</option>
                <option <?php echo set_select('type_of_membership','normal_admin');?> value="normal_admin">Normal Admin</option>
                 <?php if(user_access($this->session->userdata('user_id'),'add_power_admin') == true){?>
                <option <?php echo set_select('type_of_membership','power_admin');?> value="power_admin">Power admin</option>
                <?php }?>
                <option <?php echo set_select('type_of_membership','FREE');?> value="FREE">FREE</option>
              	<option <?php echo set_select('type_of_membership','PRE1');?> value="PRE1">PRE1</option>
                <option <?php echo set_select('type_of_membership','PRE2');?> value="PRE2">PRE2</option>
                <option <?php echo set_select('type_of_membership','PUB1');?> value="PUB1">PUB1</option>
                <option <?php echo set_select('type_of_membership','PUB2');?> value="PUB2">PUB2</option>
                <option <?php echo set_select('type_of_membership','CAAD');?> value="CAAD">CAAD</option>
                <option <?php echo set_select('type_of_membership','CAUS');?> value="CAUS">CAUS</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Language interface</label>
            <div class="controls">
              <select name="language_interface">
              <?php for($l=0;$l<count($site_language);$l++){?>
              <option <?php  echo custom_set_value('language_interface') == $site_language[$l]['site_language_id'] ? 'selected="selected"' : ''?>  value="<?php echo $site_language[$l]['site_language_id']?>"><?php echo $site_language[$l]['language_longform']?></option>
              <?php }?>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Language for Newsletter</label>
            <div class="controls">
              <?php /*?><select name="language_id">
              <?php for($l=0;$l<count($language);$l++){?>
              <option <?php  echo set_value('language_id') == $language[$l]['language_id'] ? 'selected="selected"' : ''?>  value="<?php echo $language[$l]['language_id']?>"><?php echo $language[$l]['language_longform']?></option>
              <?php }?>
             </select><?php */?>
             <select multiple="multiple" name="language_id[]">
              	<option  value="">-Select Language-</option>
               <?php for($l=0;$l<count($language);$l++){?>
                <option <?php echo custom_set_select('language_id',$language[$l]['language_id'])?> value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Town</label>
            <div class="controls">
              <input type="text" id="" name="town" value="<?php echo custom_set_value('town'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Zip code</label>
            <div class="controls">
              <input type="text" id="" name="zip_code" value="<?php echo custom_set_value('zip_code'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Country</label>
            <div class="controls">
              <select name="country">
              <?php for($l=0;$l<count($countries);$l++){?>
              <option <?php  echo custom_set_value('country') == $countries[$l]['id'] ? 'selected="selected"' : ''?>  value="<?php echo $countries[$l]['id']?>"><?php echo $countries[$l]['country_name']?></option>
              <?php }?>
             </select>
              <!--<input type="text" id="" name="country_code" value="<?php //echo set_value('country_code'); ?>" >-->
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">User interests</label>
            <div class="controls">
             <!-- <input name="keywords" value="<?php echo set_value('keywords'); ?>" type="text" />-->
             <select multiple="multiple" name="user_interests[]">
              	<option  value="">-Select User interest-</option>
               <?php for($k=0;$k<count($keyword);$k++){?>
                <option <?php echo custom_set_select("user_interests",$keyword[$k]['newsletter_keyword_id'])?> value="<?php echo $keyword[$k]['newsletter_keyword_id']; ?>"><?php echo $keyword[$k]['en'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Additional E-mail 1</label>
            <div class="controls">
              <input type="text" id="" name="additional_email1" value="<?php echo custom_set_value('additional_email1'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Additional E-mail 2</label>
            <div class="controls">
              <input type="text" id="" name="additional_email2" value="<?php echo custom_set_value('additional_email2'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">NO Adds</label>
            <div class="controls">
              <div class="radio_div"><input  name="no_ads" type="radio" <?php echo custom_set_radio('no_ads','YES') //echo (custom_set_value('no_ads') == "YES") ? 'checked="checked"' : ""; ?> value="YES" />&nbsp;<span>Yes</span></div>
              <div class="radio_div"><input  name="no_ads" type="radio" <?php echo custom_set_radio('no_ads','NO',TRUE)//echo (custom_set_value('no_ads') == "NO") ? 'checked="checked"' : ""; ?> value="NO" />&nbsp;<span>NO
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Adult Content tag</label>
            <div class="controls">
              <div class="radio_div"><input  name="adult_content" type="radio" <?php echo custom_set_radio('adult_content','YES')//echo (custom_set_value('adult_content') == "YES") ? 'checked="checked"' : ""; ?> value="YES" />&nbsp;<span>Yes</span></div>
              <div class="radio_div"><input  name="adult_content" type="radio" <?php echo custom_set_radio('adult_content','NO',TRUE)//echo (custom_set_value('adult_content') == "NO") ? 'checked="checked"' : ""; ?> value="NO" />&nbsp;<span>NO
</span> </div>
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Privacy Settings</label>
            <div class="controls">
              <div class="radio_div"><input  name="privacy_settings" type="radio" <?php echo custom_set_radio('privacy_settings','YES')//echo (custom_set_value('privacy_settings') == "YES") ? 'checked="checked"' : ""; ?> value="YES" />&nbsp;<span>Yes</span></div>
              <div class="radio_div"><input  name="privacy_settings" type="radio" <?php echo custom_set_radio('privacy_settings','NO',TRUE)//echo (custom_set_value('privacy_settings') == "NO") ? 'checked="checked"' : ""; ?> value="NO" />&nbsp;<span>NO
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          
          
          <div class="control-group">
            <label for="inputError" style="text-decoration: underline;font-weight: bold;
" class="control-label">Invoice Details:</label>
            <div class="controls">
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">First Name</label>
            <div class="controls">
              <input type="text" id="" name="i_firstname" value="<?php echo custom_set_value('i_firstname'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Last Name</label>
            <div class="controls">
              <input type="text" id="" name="i_lastname" value="<?php echo custom_set_value('i_lastname'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Company Name</label>
            <div class="controls">
              <input type="text" id="" name="i_company_name" value="<?php echo custom_set_value('i_company_name'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
           <div class="control-group">
            <label for="inputError" class="control-label">Street</label>
            <div class="controls">
              <textarea name="i_street"><?php echo custom_set_value('i_street'); ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Town</label>
            <div class="controls">
              <input type="text" id="" name="i_town" value="<?php echo custom_set_value('i_town'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Zip code</label>
            <div class="controls">
              <input type="text" id="" name="i_zip_code" value="<?php echo custom_set_value('i_zip_code'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Country</label>
            <div class="controls">
              <?php /*?><input type="text" id="" name="i_country" value="<?php echo set_value('i_country'); ?>" ><?php */?>
              <select name="i_country">
              <?php for($l=0;$l<count($countries);$l++){?>
              <option <?php  echo custom_set_value('i_country') == $countries[$l]['id'] ? 'selected="selected"' : ''?>  value="<?php echo $countries[$l]['id']?>"><?php echo $countries[$l]['country_name']?></option>
              <?php }?>
             </select>
              <!--<input type="text" id="" name="country_code" value="<?php //echo set_value('country_code'); ?>" >-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
             <select name="status">
             	<option <?php  echo custom_set_value('status') == 'Active' ? 'selected="selected"' : ''?>  value="Active">Active</option>
                <option <?php echo custom_set_value('status') == 'Inactive' ? 'selected="selected"' : ''?> value="Inactive">Inactive</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a class="btn" href="<?php echo site_url('kd2a2a0u1g4')?>/user">Cancel</a>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     