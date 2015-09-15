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
          <a href="#">Export User</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
           Export User<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
    </div>
<?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      //form validation
      echo validation_errors();
      echo form_open_multipart('kd2a2a0u1g4/user/exportcsv', $attributes);
      ?>
        <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Type of memebership</label>
            <div class="controls">
              <select name="type_of_membership">
              <option value="">-All Membership-</option>
              <option <?php  echo set_value('type_of_membership') == 'FREE' ? 'selected="selected"' : ''?>  value="FREE">FREE</option>
             	<option <?php  echo set_value('type_of_membership') == 'PRE1' ? 'selected="selected"' : ''?>  value="PRE1">PRE1</option>
                <option <?php set_value('type_of_membership') == 'PRE2' ? 'selected="selected"' : ''?> value="PRE2">PRE2</option>
                <option <?php  echo set_value('type_of_membership') == 'PUB1' ? 'selected="selected"' : ''?>  value="PUB1">PUB1</option>
                <option <?php  echo set_value('type_of_membership') == 'PUB2' ? 'selected="selected"' : ''?>  value="PUB2">PUB2</option>
                <option <?php  echo set_value('type_of_membership') == 'CAAD' ? 'selected="selected"' : ''?>  value="CAAD">CAAD</option>
                <option <?php  echo set_value('type_of_membership') == 'CAUS' ? 'selected="selected"' : ''?>  value="CAUS">CAUS</option>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Language interface</label>
            <div class="controls">
              <select name="language_interface">
              <option value="">-All Language-</option>
              <?php for($l=0;$l<count($site_language);$l++){?>
              <option <?php  echo set_value('language_interface') == $site_language[$l]['site_language_id'] ? 'selected="selected"' : ''?>  value="<?php echo $site_language[$l]['site_language_id']?>"><?php echo $site_language[$l]['language_longform']?></option>
              <?php }?>
             </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit" name="do_export" value="do_export">Export in Excel</button>
           <a class="btn" href="<?php echo site_url('kd2a2a0u1g4')?>/user">Cancel</a>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     