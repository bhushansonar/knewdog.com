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
            Site Language<?php //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating Site Language<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
<?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
     	echo validation_errors();
     	echo form_open_multipart('kd2a2a0u1g4/sitelanguage/update/'.$this->uri->segment(4).'', $attributes);
?>
        <fieldset>
         <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
            <div class="control-group">
            <label for="inputError" class="control-label">Language Shortcode</label>
            <div class="controls">
              <input disabled="disabled" type="text" id="" name="language_shortcode" value="<?php echo $language[0]['language_shortcode'];?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Language longform</label>
            <div class="controls">
              <input type="text" id="" name="language_longform" value="<?php echo $language[0]['language_longform']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Language Flag</label>
            <div class="controls">
              <input style="float:left;" name="language_flag" type="file" />
              <?php if($language[0]['language_flag']){?>
              	<div style="float:left;"><img alt="Language Flag" width="22" src="<?php echo base_url(); ?>uploads/flag/<?php echo $language[0]['language_flag']?>" /></div>
              <?php }?>
              <input type="hidden" name="old_language_flag" value="<?php echo $language[0]['language_flag'] ?>" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
             <select name="status">
             	<option <?php  echo $language[0]['status'] == 'Active' ? 'selected="selected"' : ''?>  value="Active">Active</option>
                <option <?php echo $language[0]['status'] == 'Inactive' ? 'selected="selected"' : ''?> value="Inactive">Inactive</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a class="btn" href="<?php echo $this->session->userdata('redirect_url');?>">Cancel</a>
           <?php /*?><a data-rel="Please make sure." href="<?php echo site_url("kd2a2a0u1g4")?>'/sitelanguage/delete/'<?php echo $this->uri->segment(3); ?>" class="btn btn-danger complexConfirm">delete</a><?php */?>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>