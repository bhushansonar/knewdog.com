<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>">
                Website advertisement<?php //echo ucfirst($this->uri->segment(2));  ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating Website advertisement<?php //echo ucfirst($this->uri->segment(2));  ?>
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
      } */
    ?>

    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open_multipart('kd2a2a0u1g4/wanted-add/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />
        <div class="control-group">
            <label for="inputError" class="control-label">Website advertisement Script</label>
            <div class="controls">
                <textarea class="" name="wanted_add_script"><?php echo $wanted_add[0]['wanted_add_script'] ?></textarea>
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo trim($wanted_add[0]['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo trim($wanted_add[0]['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</div>