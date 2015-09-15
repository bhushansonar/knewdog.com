<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replaceAll('tinymce')
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/jquery.datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/jquery.datetimepicker.css"/>
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
            blog<?php //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating blog<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
<?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
     	echo validation_errors();
		if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'delete_image')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> featured image deleted with success.';
          echo '</div>';       
        }
		}
     	echo form_open_multipart('kd2a2a0u1g4/blog/update/'.$this->uri->segment(4).'', $attributes);
?>
        <fieldset>
         <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
         <input type="hidden" value="<?php echo date('Y-m-d H:i:00')?>" name="date" />
         <?php //echo '<pre>'; print_r($site_language);
		  for($i=0;$i<count($site_language);$i++){
		  ?>
          <div class="control-group">
            <label for="inputError" class="control-label">Title <?php echo $site_language[$i]['language_longform'] ?></label>
            <div class="controls">
              <input type="text" name="title_<?php echo $site_language[$i]['language_shortcode']?>" value="<?php echo $blog[0]['title_'.$site_language[$i]['language_shortcode']] ?>" >
            </div>
          </div>
         
          <div class="control-group">
            <label for="inputError" class="control-label">Description <?php echo $site_language[$i]['language_longform'];?></label>
            <div class="controls">
            <textarea class="tinymce ckeditor" id="editor_<?php echo $site_language[$i]['language_shortcode']?>" name="description_<?php echo $site_language[$i]['language_shortcode']?>"><?php echo $blog[0]['description_'.$site_language[$i]['language_shortcode']]?></textarea>
             </div>
          </div>
          <?php }?>
          <div class="control-group">
            <label for="inputError" class="control-label">Featured Image</label>
            <div class="controls">
              <input style="float:left;" name="featured_image" type="file" />
              <?php if($blog[0]['featured_image']){?>
              	<div style="float:left;"><img width="100" src="<?php echo base_url(); ?>uploads/<?php echo $blog[0]['featured_image']?>" /></div>
              <span style="display:none;" id="delete_msg">Are you sure to delete this Featured Image?</span>
              <span class="help-inline"><a href="<?php echo site_url("kd2a2a0u1g4").'/blog/delete_image/'.$blog[0]['blog_id']?>" class="btn btn-danger complexConfirm">Delete</a></span>
              <?php }?>
              
             
              <input type="hidden" name="old_featured_image" value="<?php echo $blog[0]['featured_image'] ?>" />
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Meta Title</label>
            <div class="controls">
              <input type="text" name="meta_title" value="<?php echo $blog[0]['meta_title']; ?>" />
            </div>
          </div>
           <div class="control-group">
            <label for="inputError" class="control-label">Meta Keyword</label>
            <div class="controls">
              <textarea name="meta_keyword"><?php echo $blog[0]['meta_keyword']; ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Meta Description</label>
            <div class="controls">
              <textarea name="meta_description"><?php echo $blog[0]['meta_description']; ?></textarea>
            </div>
          </div>
           <div class="control-group">
            <label for="inputError" class="control-label">Set schedule</label>
            <div class="controls">
              <div class="radio_div"><input onclick="show_published_date();"  name="set_schedule" type="radio" <?php echo ($blog[0]['set_schedule'] == 'YES') ? 'checked="checked"' : '' ?> value="YES" />&nbsp;<span>Yes</span></div>
              <div class="radio_div"><input onclick="show_published_date();" name="set_schedule" type="radio" <?php echo ($blog[0]['set_schedule'] == 'NO') ? 'checked="checked"' : '' ?> value="NO"  />&nbsp;<span>NO
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div style="display:none;" id="published_date_div" class="control-group">
            <label for="inputError" class="control-label">Published date</label>
            <div class="controls">
              <input  id="published_date" type="text" name="published_date" />
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
            <?php //echo $newsletter[0]['status'];?>
             <select name="status">
             	<option <?php  echo trim($blog[0]['status']) == 'Active' ? 'selected="selected"' : ''?>  value="Active">Active</option>
                <option <?php echo trim($blog[0]['status']) == 'Inactive' ? 'selected="selected"' : ''?> value="Inactive">Inactive</option>
             </select>
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
<script type="text/javascript">
function show_published_date(){
	var set_schedule = $("input[name=set_schedule]:checked").val();
	//alert(set_schedule);
		if($("#published_date_div").is(":hidden")){
		if(set_schedule == 'YES'){
			$("#published_date_div").css("display","block");
			//$("#published_date").attr("disabled",false);
			}else{
				$("#published_date_div").css("display","none");
			//$("#published_date").attr("disabled",true);	
				}
		}else {
			$("#published_date_div").css("display","none");
			//$("#published_date").attr("disabled",true);
			}
	}
$('#published_date').datetimepicker()
	.datetimepicker({
		value: '<?php echo date('Y-m-d H:i:00', strtotime($blog[0]['published_date']))?>',
		format:'Y-m-d H:i:00',
		step:10,
		 /*minDate:'-1970/01/01',//yesterday is minimum date(for today use 0 or -1970/01/01)
 		maxDate:'+3000/01/02'//tommorow is maximum date calendar,*/
	});
show_published_date();
</script>