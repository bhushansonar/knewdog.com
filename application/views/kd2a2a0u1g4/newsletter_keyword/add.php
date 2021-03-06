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
      //flash messages
	  //print_r($flash_message);
        /* if(!empty($flash_message))
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new keyword created with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }*/
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
      echo validation_errors();
      
      echo form_open('kd2a2a0u1g4/keyword/add', $attributes);
      ?>
        <fieldset>
          <?php /*?><div class="control-group">
            <label for="inputError" class="control-label">keyword define</label>
            <div class="controls">
              <input type="text" id="" name="keyword_define" value="<?php echo set_value('keyword_define'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div><?php */?>
           <?php //echo '<pre>'; print_r($site_language);
		  for($i=0;$i<count($site_language);$i++){
		  ?>
          <div class="control-group">
            <label for="inputError" class="control-label"><?php echo $site_language[$i]['language_longform'];?></label>
            <div class="controls">
            <textarea name="<?php echo $site_language[$i]['language_shortcode']?>"></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <?php }?>
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
           <a class="btn" href="<?php echo site_url('kd2a2a0u1g4')?>/keyword">Cancel</a>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     