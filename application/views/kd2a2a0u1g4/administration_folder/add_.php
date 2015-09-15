<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replaceAll('tinymce')
</script>
<!--<script src="<?php echo base_url(); ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    	//selector: "specific_textareas",
		mode : "specific_textareas",
        editor_selector : "tinymce",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	relative_urls : false,
	remove_script_host : false,
	convert_urls : true,
});
</script>-->
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
    // echo '<pre>'; print_r($category);
      echo form_open_multipart('kd2a2a0u1g4/newsletter/add', $attributes);
      ?>
        <fieldset>
          <div class="control-group">
            <label for="inputError" class="control-label">Newsletter Name<span class="star">*</span></label>
            <div class="controls">
              <input type="text" id="" name="newsletter_name" value="<?php echo set_value('newsletter_name'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Headline<span class="star">*</span></label>
            <div class="controls">
              <input type="text" id="" name="headline" value="<?php echo set_value('headline'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Category<span class="star">*</span></label>
            <div class="controls">
              <select multiple="multiple" name="newsletter_category_id[]">
              	<option  value="">-Select Category-</option>
               <?php for($c=0;$c<count($category);$c++){?>
                <option <?php echo set_select('newsletter_category_id[]', $category[$c]['newsletter_category_id']); ?> value="<?php echo $category[$c]['newsletter_category_id']; ?>"><?php echo $category[$c]['en'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Keywords</label>
            <div class="controls">
             <!-- <input name="keywords" value="<?php echo set_value('keywords'); ?>" type="text" />-->
             <select multiple="multiple" name="newsletter_keyword_id[]">
              	<option  value="">-Select keyword-</option>
               <?php for($k=0;$k<count($keyword);$k++){?>
                <option <?php echo custom_set_select('newsletter_keyword_id',$keyword[$k]['newsletter_keyword_id'])?>  value="<?php echo $keyword[$k]['newsletter_keyword_id']; ?>"><?php echo $keyword[$k]['en'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Newsletter Sender Email</label>
            <div class="controls">
              <input type="text" id="" name="newsletter_email" value="<?php echo custom_set_value('newsletter_email'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Screenshot</label>
            <div class="controls">
              <input name="screenshot" type="file" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Description</label>
            <div class="controls">
              <textarea  name="description" class="tinymce ckeditor"><?php echo custom_set_value('description'); ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Unsubscribe Url</label>
            <div class="controls">
             <textarea class="" name="unsubscribe_url"><?php echo custom_set_value('unsubscribe_url'); ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
           <div class="control-group">
            <label for="inputError" class="control-label">Unsubscribe Text</label>
            <div class="controls">
             <textarea class="" name="unsubscribe_text"><?php echo custom_set_value('unsubscribe_text'); ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Author<span class="star">*</span></label>
            <div class="controls">
              <input name="author_name" value="<?php echo set_value('author_name'); ?>" type="text" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">About Author</label>
            <div class="controls">
             <textarea class="tinymce ckeditor" name="about_author"><?php echo custom_set_value('about_author'); ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Author Country</label>
            <div class="controls">
             <?php /*?><input name="author_country" value="<?php echo set_value('author_country'); ?>" type="text" /><?php */?>
             <select name="author_country">
             <?php for($l=0;$l<count($countries);$l++){?>
              <option <?php  echo custom_set_select('author_country',$countries[$l]['id'])?>  value="<?php echo $countries[$l]['id']?>"><?php echo $countries[$l]['country_name']?></option>
              <?php }?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Author Zip-code</label>
            <div class="controls">
            <input name="author_zipcode" value="<?php echo custom_set_value('author_zipcode'); ?>" type="text" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Author City</label>
            <div class="controls">
             <input name="author_city" value="<?php echo custom_set_value('author_city'); ?>" type="text" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
       
            <div class="control-group">
            <label for="inputError" class="control-label">Website URL<span class="star">*</span></label>
            <div class="controls">
              <input name="website_url" type="text" value="<?php echo set_value('website_url'); ?>"/>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
           <?php /*?><div class="control-group">
            <label for="inputError" class="control-label">E-mail</label>
            <div class="controls">
              <input name="email" type="text" value="<?php echo set_value('email'); ?>" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div><?php */?>
          <div class="control-group">
            <label for="inputError" class="control-label">Videos</label>
            <div class="controls">
            <input type="hidden" value="2" name="autoid" id="autoid" />
            <span style="float:left; width:246px;" id="add_inputs">
            	  <textarea class="video_input" name="video[]" id="id_1"></textarea>
             </span>
             	<button onclick="addinput();" type="button" class="btn btn-primary">+</button>
                <button onclick="removeinput();" type="button" class="btn btn-primary">-</button>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <div class="control-group">
            <label for="inputError" class="control-label">Black list index</label>
            <div class="controls">
             <select name="blacklist_index">
             	<option <?php echo custom_set_select('blacklist_index','0') ?> value="0">0</option>
                <option <?php echo custom_set_select('blacklist_index','1') ?> value="1">1</option>
                <option <?php echo custom_set_select('blacklist_index','2') ?> value="2">2</option>
                <option <?php echo custom_set_select('blacklist_index','3') ?> value="3">3</option>
                <option <?php echo custom_set_select('blacklist_index','4') ?> value="4">4</option>
                <option <?php echo custom_set_select('blacklist_index','5') ?> value="5">5</option>
                <option <?php echo custom_set_select('blacklist_index','6') ?> value="6">6</option>
                <option <?php echo custom_set_select('blacklist_index','7') ?> value="7">7</option>
                <option <?php echo custom_set_select('blacklist_index','8') ?> value="8">8</option>
                <option <?php echo custom_set_select('blacklist_index','9') ?> value="9">9</option>
                <option <?php echo custom_set_select('blacklist_index','10') ?> value="10">10</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <div class="control-group">
            <label for="inputError" class="control-label">Black List Flag</label>
            <div class="controls">
              <div class="radio_div"><input  name="blacklist_flag" type="radio" value="YES" <?php if(!empty($_POST["blacklist_flag"])){ if($_POST["blacklist_flag"]=="YES"){ echo "checked='checked'"; } }?> />&nbsp;<span>Yes</span></div>
              <div class="radio_div"><input  name="blacklist_flag" type="radio" value="NO" <?php if(!empty($_POST["blacklist_flag"])){ if($_POST["blacklist_flag"]=="NO"){ echo "checked='checked'"; } }?> />&nbsp;<span>NO
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <div class="control-group">
            <label for="inputError" class="control-label">Adult Content tag</label>
            <div class="controls">
              <div class="radio_div"><input  name="adult_content" type="radio" <?php echo custom_set_radio('adult_content','YES'); /*if(!empty($_POST["adult_content"])){ if($_POST["blacklist_flag"]=="YES"){ echo "checked='checked'"; } }*/?> value="YES" />&nbsp;<span>Yes</span></div>
              <div class="radio_div"><input name="adult_content" type="radio" <?php echo custom_set_radio('adult_content','NO'); /*if(!empty($_POST["adult_content"])){ if($_POST["blacklist_flag"]=="NO"){ echo "checked='checked'"; } }*/?> value="NO" />&nbsp;<span>NO
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Language</label>
            <div class="controls">
            	<?php /*?><input type="text" name="language_id" value="<?php echo custom_set_value('language_id');?>" /><?php */?>
                <select name="language_id">
              	<option  value="">-Select Language-</option>
               <?php for($l=0;$l<count($language);$l++){?>
                <option <?php echo custom_set_select('language_id',$language[$l]['language_id'])?> value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform'];?></option>
              <?php }?>
              </select>
            <?php /*?><select multiple="multiple" name="language_id[]">
              	<option  value="">-Select Language-</option>
               <?php for($l=0;$l<count($language);$l++){?>
                <option <?php echo custom_set_select('language_id',$language[$l]['language_id'])?> value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform'];?></option>
              <?php }?>
              </select><?php */?>
               <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Frequency</label>
            <div class="controls">
             <?php /*?> <input type="text" id="" name="frequency" value="<?php echo custom_set_value('frequency'); ?>" ><?php */?>
             <select name="frequency">
             	<option <?php echo custom_set_select('frequency','daily') ?> value="daily">daily</option>
                <option <?php echo custom_set_select('frequency','several times per week') ?> value="several times per week">several times per week</option>
                <option <?php echo custom_set_select('frequency','weekly') ?> value="weekly">weekly</option>
                <option <?php echo custom_set_select('frequency','several times per month') ?> value="several times per month">several times per month</option>
                <option <?php echo custom_set_select('frequency','monthly') ?> value="monthly">monthly</option>
                <option <?php echo custom_set_select('frequency','less than monthly') ?> value="less than monthly">less than monthly</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
             <select name="status">
             	<option <?php  echo custom_set_select('status','Active');?>  value="Active">Active</option>
                <option <?php echo custom_set_select('status','Inactive');?> value="Inactive">Inactive</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a class="btn" href="<?php echo site_url('kd2a2a0u1g4')?>/newsletter">Cancel</a>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>