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
            Email advertisement<?php //echo ucfirst($this->uri->segment(2));?>
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
      
      echo form_open_multipart('kd2a2a0u1g4/advertisement/add', $attributes);
      //echo '<pre>'; print_r($category);
	  ?>
        <fieldset>
          <div class="control-group">
            <label for="inputError" class="control-label">Keyword<span class="star">*</span></label>
            <div class="controls">
              <select multiple="multiple" name="newsletter_keyword_id[]">
              	<option  value="">-Select keyword-</option>
               <?php for($c=0;$c<count($keyword);$c++){?>
                <option <?php echo (set_value('newsletter_keyword_id') == $keyword[$c]['newsletter_keyword_id']) ? 'selected="selected"' : "" ?>  value="<?php echo $keyword[$c]['newsletter_keyword_id']; ?>"><?php echo $keyword[$c]['en'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Language</label>
            <div class="controls">
              <select name="language_id">
              	<option  value="">-Select language-</option>
               <?php for($l=0;$l<count($language);$l++){?>
                <option <?php echo (set_value('language_id') == $language[$l]['language_id']) ? 'selected="selected"' : "" ?> value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Country</label>
            <div class="controls">
              <select name="country_id">
              	<option  value="">-Select Country-</option>
               <?php for($c=0;$c<count($countries);$c++){?>
                <option <?php echo (set_value('country_id') == $countries[$c]['id']) ? 'selected="selected"' : "" ?>  value="<?php echo $countries[$c]['id']; ?>"><?php echo $countries[$c]['country_name'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Zip code</label>
            <div class="controls">
              <input type="text" name="zip_code" value="<?php echo set_value('zip_code');?>" />
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Town</label>
            <div class="controls">
              <input type="text" name="town" value="<?php echo set_value('town');?>" />
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Advertisement Type</label>
            <div class="controls">
              <div class="radio_div"><input checked="checked" onclick="show_add_type(this.value);" <?php echo (set_value('advertisement_flag') == "advertisement_script") ? 'checked="checked"' : ""; ?>   name="advertisement_flag" type="radio" value="advertisement_script" />&nbsp;<span>Advertisement Script</span></div>
              <div class="radio_div"><input onclick="show_add_type(this.value);"  name="advertisement_flag" type="radio" <?php echo (set_value('advertisement_flag') == "advertisement_image") ? 'checked="checked"' : ""; ?> value="advertisement_image" />&nbsp;<span>Advertisement image
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group adverstisement_script">
            <label for="inputError" class="control-label">Advertisement Script</label>
            <div class="controls">
              <textarea class="adverstisement_script_input" name="advertisement_script"><?php echo set_value('advertisement_script')?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group adverstisement_image">
            <label for="inputError" class="control-label">Advertisement Image</label>
            <div class="controls">
              <input class="adverstisement_image_input" type="file" name="advertisement_image" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Advertisement URL</label>
            <div class="controls">
              <input type="text" name="advertisement_url" value="<?php echo set_value('advertisement_url');?>" />
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
             <select name="status">
             	<option <?php  echo set_value('status') == 'Active' ? 'selected="selected"' : ''?>  value="Active">Active</option>
                <option <?php echo set_value('status') == 'Inactive' ? 'selected="selected"' : ''?> value="Inactive">Inactive</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a class="btn" href="<?php echo site_url('kd2a2a0u1g4')?>/advertisement">Cancel</a>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
<script type="text/javascript">
	var val_add = "advertisement_script";
</script> 
     