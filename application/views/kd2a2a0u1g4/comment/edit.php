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
            comment<?php //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating comment<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
<?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
     	echo validation_errors();
     	echo form_open_multipart('kd2a2a0u1g4/comment/update/'.$this->uri->segment(4).'', $attributes);
?>
        <fieldset>
         <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
         <div class="control-group">
            <label for="inputError" class="control-label">Name</label>
            <div class="controls">
              <input type="text" name="name" value="<?php echo $comment[0]['name']; ?>" >
            </div>
          </div>
         
          <div class="control-group">
            <label for="inputError" class="control-label">E-mail</label>
            <div class="controls">
            <input type="text" name="email" value="<?php echo $comment[0]['email']; ?>" >
             </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Blog</label>
            <div class="controls">
              <input  type="text" disabled='disabled' name="title_en" value="<?php echo $comment[0]['title_en']; ?>" >
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Comment</label>
            <div class="controls">
              <textarea  name="comment"><?php echo $comment[0]['comment']; ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Published Date</label>
            <div class="controls">
              <input type="text"  disabled='disabled' name="date" value="<?php echo date("j, F Y",strtotime($comment[0]['date'])); ?>"  />
            </div>
          </div>
        
       
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
            <?php //echo $newsletter[0]['status'];?>
             <select name="status">
             	<option <?php  echo trim($comment[0]['status']) == 'Active' ? 'selected="selected"' : ''?>  value="Active">Approved</option>
                <option <?php echo trim($comment[0]['status']) == 'Inactive' ? 'selected="selected"' : ''?> value="Inactive">Unapproved</option>
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
		value: '<?php echo date('Y-m-d H:i:00', strtotime($comment[0]['published_date']))?>',
		format:'Y-m-d H:i:00',
		step:10,
		 minDate:'-1970/01/01',//yesterday is minimum date(for today use 0 or -1970/01/01)
 		maxDate:'+3000/01/02'//tommorow is maximum date calendar,
	});
show_published_date();
</script>