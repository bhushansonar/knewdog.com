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
            Remove Unsubscribe<?php //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">New</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Adding Remove Unsubscribe<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
      echo validation_errors();
      
      echo form_open_multipart('kd2a2a0u1g4/remove-unsubscribe/add', $attributes);
      //echo '<pre>'; print_r($category);
	  ?>
        <fieldset>
		  <div class="control-group">
            <label for="inputError" class="control-label">Remove Unsubscribe<span class="star">*</span></label>
            <div class="controls">
              <div class="radio_div"><input <?php echo custom_set_radio('remove_unsubscribe','text',true); ?>  type="radio" onclick="unsubscribe_open(this.id)" id="unsubscribe_text" value="text" name="remove_unsubscribe">&nbsp;<span>Unsubscribe Text</span></div>
              <div class="radio_div"><input <?php echo custom_set_radio('remove_unsubscribe','url'); ?>  type="radio" id="unsubscribe_url" onclick="unsubscribe_open(this.id)" value="url" name="remove_unsubscribe">&nbsp;<span>Unsubscribe Url
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>      
          <div class="control-group unsubscribe_text unsub">
            <label for="inputError" class="control-label">Unsubscribe Text<span class="star">*</span></label>
            <div class="controls">
              <textarea class="" name="unsubscribe_text"><?php echo set_value('unsubscribe_text')?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group unsubscribe_url unsub">
            <label for="inputError" class="control-label">Unsubscribe Url<span class="star">*</span></label>
            <div class="controls">
              <textarea class="" name="unsubscribe_url"><?php echo set_value('unsubscribe_url')?></textarea>
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
           <a class="btn" href="<?php echo site_url('kd2a2a0u1g4')?>/remove-unsubscribe">Cancel</a>
          </div>
        </fieldset>
      <?php echo form_close(); ?>
    </div>
  <script>
  	function unsubscribe_open(id){
		$(".unsub").hide();
		$("."+id).css("display","block");
		}
  unsubscribe_open('unsubscribe_text') 
  </script>