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
		extended_valid_elements : "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],a[href|onclick],"
,
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
            CMS<?php //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating CMS<?php //echo ucfirst($this->uri->segment(2));?>
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
     	echo form_open('kd2a2a0u1g4/cms/update/'.$this->uri->segment(4).'', $attributes);
?>
        <fieldset>
         <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
        <div class="control-group">
            <label for="inputError" class="control-label">Location</label>
            <div class="controls">
              <input type="text" id="" name="location" value="<?php echo $cms[0]['location']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <div class="control-group">
            <label for="inputError" class="control-label">Type</label>
            <div class="controls">
              <select id="type" onchange="startFilter();" name="type">
              	<option <?php echo ($cms[0]['type'] == "block") ? 'selected="selected"' : ""; ?> value="block">Block</option>
                <option class="hide_display_name" <?php echo ($cms[0]['type'] == "help_page") ? 'selected="selected"' : ""; ?> value="help_page">Help Page</option>
                <option class="" <?php echo ($cms[0]['type'] == "page") ? 'selected="selected"' : ""; ?> value="page">CMS Page</option>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <?php /*?><div class="control-group display_name">
            <label for="inputError" class="control-label">Display name</label>
            <div class="controls">
              <input class="display_name" type="text" name="display_name" value="<?php echo $cms[0]['display_name']; ?>" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div><?php */?>
         <div class="control-group">
            <label for="inputError" class="control-label">Block name</label>
            <div class="controls">
              <input disabled="disabled" type="text" id="" name="block_name" value="<?php echo $cms[0]['block_name']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <?php //echo '<pre>'; print_r($site_language);
		  for($i=0;$i<count($site_language);$i++){
		  ?>
          <div style="display:none;" id="display_name" class="control-group display_name">
            <label for="inputError" class="control-label">Display name <?php echo $site_language[$i]['language_longform'] ?></label>
            <div class="controls">
              <input class="display_name" type="text" name="display_name_<?php echo $site_language[$i]['language_shortcode']?>" value="<?php echo $cms[0]['display_name_'.$site_language[$i]['language_shortcode']]?>" >
            </div>
          </div>
         <?php }?>
          <?php //echo '<pre>'; print_r($site_language);
		  for($i=0;$i<count($site_language);$i++){
		  ?>
          <div class="control-group">
            <label for="inputError" class="control-label"><?php echo $site_language[$i]['language_longform'];?></label>
            <div class="controls">
            <textarea class="tinymce ckeditor" name="<?php echo $site_language[$i]['language_shortcode']?>"><?php echo $cms[0][$site_language[$i]['language_shortcode']]?></textarea>
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
<script>
startFilter();
	/*function startFilter(value){
	//var cs1 = $('#type').find(":selected").attr("class");
	
	//var cs1 = $("option:selected", ele).attr("class");
	alert(value)
    if(value == 'help_page'){
		$('.display_name').css("display","block");
		$('.display_name').attr("disabled", false);
        //do something
    }else{
		$('.display_name').css("display","none");
		$('.display_name').attr("disabled", true);
		}
}*/
function startFilter(){
		//alert(ele);
		var cs1 = $('#type').find(":selected").attr("class");
		    //var cs1 = $("option:selected", ele).attr("class");
    if(cs1 == 'hide_display_name'){
		$('.display_name').css("display","block");
		//$('.display_name').attr("disabled", false);
        //do something
    }else{
		$('.display_name').css("display","none");
		//$('.display_name').attr("disabled", true);
		}
}
</script>