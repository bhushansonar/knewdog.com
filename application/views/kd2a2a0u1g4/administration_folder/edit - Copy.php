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
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
      	   <a href="<?php echo site_url('kd2a2a0u1g4')?>/newsletter/issues/<?php echo $this->uri->segment(4);?>" class="btn btn-info">Issues</a>
        <h2>
          Updating <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
      echo validation_errors();
		if(!empty($url_segment_5)){
      		echo form_open_multipart('kd2a2a0u1g4/newsletter/update/'.$this->uri->segment(4).'/'.$url_segment_5.'', $attributes);
		}else{
			echo form_open_multipart('kd2a2a0u1g4/newsletter/update/'.$this->uri->segment(4).'', $attributes);
			}
      ?>
         <fieldset>
         <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
         <?php if(!empty($url_segment_5)){?>
         	<input type="hidden" name="url_segment_5" value="<?php echo $url_segment_5;?>"  />
         <?php }?>
         <div class="control-group">
            <label for="inputError" class="control-label">ID<span class="star">*</span></label>
            <div class="controls">
            	<div style="margin-top:5px;"><?php echo $newsletter_clone[0]['newsletter_rand_id']; ?></div>
              <input type="hidden" id="" name="old_newsletter_rand_id" value="<?php echo $newsletter_clone[0]['newsletter_rand_id']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Newsletter Name<span class="star">*</span></label>
            <div class="controls">
              <input type="text" id="" name="newsletter_name" value="<?php echo $newsletter_clone[0]['newsletter_name']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Headline<span class="star">*</span></label>
            <div class="controls">
              <input type="text" id="" name="headline" value="<?php echo $newsletter_clone[0]['headline']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Category<span class="star">*</span></label>
            <div class="controls">
              <select multiple="multiple" name="newsletter_category_id[]">
              	<option  value="">-Select Category-</option>
                <?php //echo in_array($options->addon_name,$addons)?"SELECTED":"" 
				$newsletter_category_ids = explode(",",$newsletter_clone[0]['newsletter_category_id']);
				?>
               <?php for($c=0;$c<count($category);$c++){?>
                <option  <?php echo (in_array($category[$c]['newsletter_category_id'],$newsletter_category_ids)) ? 'selected="selected"' : ''?> value="<?php echo $category[$c]['newsletter_category_id']; ?>"><?php echo $category[$c]['en'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Keywords</label>
            <div class="controls">
             <select multiple="multiple" name="newsletter_keyword_id[]">
              	<option  value="">-Select Keyword-</option>
                <?php //echo in_array($options->addon_name,$addons)?"SELECTED":"" 
				$newsletter_keyword_ids = explode(",",$newsletter_clone[0]['newsletter_keyword_id']);
				?>
               <?php for($k=0;$k<count($keyword);$k++){?>
                <option  <?php echo (in_array($keyword[$k]['newsletter_keyword_id'],$newsletter_keyword_ids)) ? 'selected="selected"' : ''?> value="<?php echo $keyword[$k]['newsletter_keyword_id']; ?>"><?php echo $keyword[$k]['en'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Newsletter Sender Email</label>
            <div class="controls">
              <input type="text" id="" name="newsletter_email" value="<?php echo $newsletter_clone[0]['newsletter_email']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Screenshot</label>
            <div class="controls">
              <input style="float:left;" name="screenshot" type="file" />
              <?php if($newsletter_clone[0]['screenshot']){?>
              	<div style="float:left;"><img width="100" src="<?php echo base_url(); ?>uploads/<?php echo $newsletter_clone[0]['screenshot']?>" /></div>
              <?php }?>
              <input type="hidden" name="old_screenshot" value="<?php echo $newsletter_clone[0]['screenshot'] ?>" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Description</label>
            <div class="controls">
            <?php if($newsletter_clone[0]['newsletter_relation'] == 'parent'){?>
              <textarea class="tinymce ckeditor" name="description"><?php echo stripslashes($newsletter_clone[0]['description']);?></textarea>
              <?php } else{?>
              <div style="max-height:500px; overflow:auto;"><?php echo stripslashes($newsletter_clone[0]['description']);?></div>
              <?php }?>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Unsubscribe Url</label>
            <div class="controls">
             <textarea class="" name="unsubscribe_url"><?php echo $newsletter_clone[0]['unsubscribe_url'] ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
           <div class="control-group">
            <label for="inputError" class="control-label">Unsubscribe Text</label>
            <div class="controls">
             <textarea class="" name="unsubscribe_text"><?php echo $newsletter_clone[0]['unsubscribe_text'] ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Author<span class="star">*</span></label>
            <div class="controls">
              <input name="author_name" value="<?php echo $newsletter_clone[0]['author_name'];?>" type="text" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">About Author</label>
            <div class="controls">
             <textarea class="tinymce ckeditor" name="about_author"><?php echo htmlentities($newsletter_clone[0]['about_author']);?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          	<div class="control-group">
            <label for="inputError" class="control-label">Author Country</label>
            <div class="controls">
             <?php /*?><input name="author_country" value="<?php echo $newsletter_clone[0]['author_country'];?>" type="text" /><?php */?>
             <select name="author_country">
             <?php for($l=0;$l<count($countries);$l++){?>
              <option <?php echo $newsletter_clone[0]['author_country'] == $countries[$l]['id'] ? 'selected="selected"' : ''?>  value="<?php echo $countries[$l]['id']?>"><?php echo $countries[$l]['country_name']?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Author Zip-code</label>
            <div class="controls">
            <input name="author_zipcode" value="<?php echo $newsletter_clone[0]['author_zipcode'];?>" type="text" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Author City</label>
            <div class="controls">
             <input name="author_city" value="<?php echo $newsletter_clone[0]['author_city'];?>" type="text" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Website URL<span class="star">*</span></label>
            <div class="controls">
              <input name="website_url" type="text" value="<?php echo $newsletter_clone[0]['website_url'];?>"/>
              <span class="help-inline" style="color:#2d2d2d;">ex: http://www.example.com</span>
            </div>
          </div>
          <?php /*?> <div class="control-group">
            <label for="inputError" class="control-label">E-mail</label>
            <div class="controls">
              <input name="email" type="text" value="<?php echo $newsletter_clone[0]['email'];?>" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div><?php */?>
          <div class="control-group">
            <label for="inputError" class="control-label">Videos</label>
            <div class="controls">
            <span style="float:left; width:246px;" id="add_inputs">
            <?php //echo in_array($options->addon_name,$addons)?"SELECTED":"" 
				$video = explode("@@@",$newsletter_clone[0]['video']);
			//echo '<pre>'; print_r($video);
				?>
            <input type="hidden" value="<?php echo (count($video)+1);?>" name="autoid" id="autoid" />
            <?php for($v=0;$v<count($video);$v++){?>
            	  <textarea class="video_input" name="video[]" id="id_<?php echo ($v+1)?>" ><?php echo $video[$v]?></textarea>
                  <?php }?>
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
             	<option  <?php echo ($newsletter_clone[0]['blacklist_index'] == "0") ? 'selected="selected"' : ""; ?> value="0">0</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "1") ? 'selected="selected"' : ""; ?> value="1">1</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "2") ? 'selected="selected"' : ""; ?> value="2">2</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "3") ? 'selected="selected"' : ""; ?> value="3">3</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "4") ? 'selected="selected"' : ""; ?> value="4">4</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "5") ? 'selected="selected"' : ""; ?> value="5">5</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "6") ? 'selected="selected"' : ""; ?> value="6">6</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "7") ? 'selected="selected"' : ""; ?> value="7">7</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "8") ? 'selected="selected"' : ""; ?> value="8">8</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "9") ? 'selected="selected"' : ""; ?> value="9">9</option>
                <option <?php echo ($newsletter_clone[0]['blacklist_index'] == "10") ? 'selected="selected"' : ""; ?> value="10">10</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
             <div class="control-group">
            <label for="inputError" class="control-label">Black List Flag</label>
            <div class="controls">
              <div class="radio_div"><input  name="blacklist_flag" type="radio" <?php echo ($newsletter_clone[0]['blacklist_flag'] == "YES") ? 'checked="checked"' : ""; ?> value="YES" />&nbsp;<span>Yes</span></div>
              <div class="radio_div"><input  name="blacklist_flag" type="radio" <?php echo ($newsletter_clone[0]['blacklist_flag'] == "NO") ? 'checked="checked"' : ""; ?> value="NO" />&nbsp;<span>NO
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <div class="control-group">
            <label for="inputError" class="control-label">Adult Content tag</label>
            <div class="controls">
              <div class="radio_div"><input  name="adult_content" type="radio" <?php echo ($newsletter_clone[0]['adult_content'] == "YES") ? 'checked="checked"' : ""; ?> value="YES" />&nbsp;<span>Yes</span></div>
              <div class="radio_div"><input  name="adult_content" type="radio" <?php echo ($newsletter_clone[0]['adult_content'] == "NO") ? 'checked="checked"' : ""; ?> value="NO" />&nbsp;<span>NO
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <div class="control-group">
            <label for="inputError" class="control-label">Language</label>
            <div class="controls">
            <?php /*?><?php //echo in_array($options->addon_name,$addons)?"SELECTED":"" 
				//$language_id = explode(",",$newsletter_clone[0]['newsletter_keyword_id']);
				$language_id = explode(",",$newsletter_clone[0]['language_id']);
				?>
            <select multiple="multiple" name="language_id[]">
              	<option value="">-Select Language-</option>
               <?php for($l=0;$l<count($language);$l++){?>
                <option <?php echo (in_array($language[$l]['language_id'],$language_id)) ? 'selected="selected"' : ''?>  value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform'];?></option>
              <?php }?>
              </select><?php */?>
              <?php /*?><input type="text" name="language_id" value="<?php echo $newsletter_clone[0]['language_id']?>" /><?php */?>
              <select name="language_id">
              	<option value="">-Select Language-</option>
               <?php for($l=0;$l<count($language);$l++){?>
                <option <?php echo ($language[$l]['language_id'] == $newsletter_clone[0]['language_id']) ? 'selected="selected"' : ''?>  value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform'];?></option>
              <?php }?>
              </select>
                           <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Frequency</label>
            <div class="controls">
              <!--<input type="text" id="" name="frequency" value="<?php echo $newsletter_clone[0]['frequency']; ?>" >-->
              <select name="frequency">
             	<option <?php echo $newsletter_clone[0]['frequency'] == "daily" ? 'selected="selected"':"" ?> value="daily">daily</option>
                <option <?php echo $newsletter_clone[0]['frequency'] == "several times per week" ? 'selected="selected"':"" ?> value="several times per week">several times per week</option>
                <option <?php echo $newsletter_clone[0]['frequency'] == "weekly" ? 'selected="selected"':"" ?> value="weekly">weekly</option>
                <option <?php echo $newsletter_clone[0]['frequency'] == "several times per month" ? 'selected="selected"':"" ?> value="several times per month">several times per month</option>
                <option <?php echo $newsletter_clone[0]['frequency'] == "monthly" ? 'selected="selected"':"" ?> value="monthly">monthly</option>
                <option <?php echo $newsletter_clone[0]['frequency'] == "less than monthly" ? 'selected="selected"':"" ?> value="less than monthly">less than monthly</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
            <?php //echo $newsletter_clone[0]['status'];?>
             <select name="status">
             	<option <?php  echo trim($newsletter_clone[0]['status']) == 'Active' ? 'selected="selected"' : ''?>  value="Active">Active</option>
                <option <?php echo trim($newsletter_clone[0]['status']) == 'Inactive' ? 'selected="selected"' : ''?> value="Inactive">Inactive</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <?php if(!empty($url_segment_5)){?>
           <?php /*?><a class="btn" href="<?php echo site_url('kd2a2a0u1g4')?>/newsletter/issues/<?php echo $url_segment_5;?>">Cancel</a><?php */?>
           <a class="btn" href="<?php echo $this->session->userdata('redirect_url');?>">Cancel</a>
          <?php }else{?>  
           <a class="btn" href="<?php echo $this->session->userdata('redirect_url');?>">Cancel</a>
           <?php }?>
           <a href="#" class="btn btn-success">Preview Page</a>
          	<span style="display:none"; id="delete_msg">Are you really sure to delete this Newsletter?</span>
            <?php if(!empty($url_segment_5)){?>
           <a style="margin-left:30px;" class="btn btn-danger complexConfirm" href="<?php echo site_url("kd2a2a0u1g4")?>/newsletter/delete/<?php echo $this->uri->segment(4);?>/<?php echo $url_segment_5;?>">Delete Newsletter</a>
           <?php }else{?>
           <a style="margin-left:30px;" class="btn btn-danger complexConfirm" href="<?php echo site_url("kd2a2a0u1g4")?>/newsletter/delete/<?php echo $this->uri->segment(4);?>">Delete Newsletter</a>
           <?php }?>
           
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
 <?php //if(!empty($url_segment_5)){?>
 <script>
	$(":input").prop("disabled", true);
	$("textarea").attr("disabled",true);
</script>
 <?php //}?>    