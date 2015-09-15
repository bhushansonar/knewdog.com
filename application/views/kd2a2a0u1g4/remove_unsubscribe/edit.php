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
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating Remove Unsubscribe<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>

 
      <?php
      //flash messages
     /* if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> advertisement updated with success.';
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

      echo form_open_multipart('kd2a2a0u1g4/remove-unsubscribe/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
		  <div class="control-group">
            <label for="inputError" class="control-label">Remove Unsubscribe<span class="star">*</span></label>
            <div class="controls">
              <div class="radio_div"><input <?php echo ($remove_unsubscribe[0]['remove_unsubscribe'] == "text") ? 'checked="checked"' : ""; ?>  type="radio" onclick="unsubscribe_open(this.id)" id="unsubscribe_text" value="text" name="remove_unsubscribe">&nbsp;<span>Unsubscribe Text</span></div>
              <div class="radio_div"><input <?php echo ($remove_unsubscribe[0]['remove_unsubscribe'] == "url") ? 'checked="checked"' : ""; ?> type="radio" id="unsubscribe_url" onclick="unsubscribe_open(this.id)" value="url" name="remove_unsubscribe">&nbsp;<span>Unsubscribe Url
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>      
          <div class="control-group unsubscribe_text unsub">
            <label for="inputError" class="control-label">Unsubscribe Text<span class="star">*</span></label>
            <div class="controls">
              <textarea class="" name="unsubscribe_text"><?php echo $remove_unsubscribe[0]['unsubscribe_text']?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group unsubscribe_url unsub">
            <label for="inputError" class="control-label">Unsubscribe Url<span class="star">*</span></label>
            <div class="controls">
              <textarea class="" name="unsubscribe_url"><?php echo $remove_unsubscribe[0]['unsubscribe_url']?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
            <?php //echo $newsletter[0]['status'];?>
             <select name="status">
             	<option <?php  echo trim($remove_unsubscribe[0]['status']) == 'Active' ? 'selected="selected"' : ''?>  value="Active">Active</option>
                <option <?php echo trim($remove_unsubscribe[0]['status']) == 'Inactive' ? 'selected="selected"' : ''?> value="Inactive">Inactive</option>
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
  unsubscribe_open('unsubscribe_<?php echo $remove_unsubscribe[0]['remove_unsubscribe']?>') 
  </script>