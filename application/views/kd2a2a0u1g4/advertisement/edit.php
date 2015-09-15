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
            Email advertisement<?php //echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header users-header">
        <h2>
          Updating Email advertisement<?php //echo ucfirst($this->uri->segment(2));?>
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

      echo form_open_multipart('kd2a2a0u1g4/advertisement/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url')?>" name="redirect_url" />
          <div class="control-group">
            <label for="inputError" class="control-label">Keyword<span class="star">*</span></label>
            <div class="controls">
              <select multiple="multiple" name="newsletter_keyword_id[]">
              	<option  value="">-Select Keyword-</option>
                <?php //echo in_array($options->addon_name,$addons)?"SELECTED":"" 
				$advertisement_keyword_ids = explode(",",$advertisement[0]['newsletter_keyword_id']);
				?>
               <?php for($c=0;$c<count($keyword);$c++){?>
                <option  <?php echo (in_array($keyword[$c]['newsletter_keyword_id'],$advertisement_keyword_ids)) ? 'selected="selected"' : ''?> value="<?php echo $keyword[$c]['newsletter_keyword_id']; ?>"><?php echo $keyword[$c]['en'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
           <div class="control-group">
            <label for="inputError" class="control-label">Language</label>
            <div class="controls">
              <select name="language_id">
              	<option  value="">-Select language-</option>
               <?php for($l=0;$l<count($language);$l++){?>
                <option <?php echo ($advertisement[0]['language_id'] == $language[$l]['language_id']) ? 'selected="selected"' : "" ?> value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Country</label>
            <div class="controls">
              <select name="country_id">
              	<option  value="">-Select Country-</option>
               <?php for($c=0;$c<count($countries);$c++){?>
                <option <?php echo ($advertisement[0]['country_id'] == $countries[$c]['id']) ? 'selected="selected"' : "" ?>  value="<?php echo $countries[$c]['id']; ?>"><?php echo $countries[$c]['country_name'];?></option>
              <?php }?>
              </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Zip code</label>
            <div class="controls">
              <input type="text" name="zip_code" value="<?php echo $advertisement[0]['zip_code'];?>" />
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Town</label>
            <div class="controls">
              <input type="text" name="town" value="<?php echo $advertisement[0]['town'];?>" />
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Advertisement Type</label>
            <div class="controls">
              <div class="radio_div"><input checked="checked" onclick="show_add_type(this.value);" <?php echo ($advertisement[0]['advertisement_flag'] == "advertisement_script") ? 'checked="checked"' : ""; ?>   name="advertisement_flag" type="radio" value="advertisement_script" />&nbsp;<span>Advertisement Script</span></div>
              <div class="radio_div"><input onclick="show_add_type(this.value);"  name="advertisement_flag" type="radio" <?php echo ($advertisement[0]['advertisement_flag'] == "advertisement_image") ? 'checked="checked"' : ""; ?> value="advertisement_image" />&nbsp;<span>Advertisement image
</span> </div>             <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group adverstisement_script">
            <label for="inputError" class="control-label">Advertisement Script</label>
            <div class="controls">
              <textarea class="adverstisement_script_input" name="advertisement_script"><?php echo $advertisement[0]['advertisement_script']?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group adverstisement_image">
            <label for="inputError" class="control-label">Advertisement Image</label>
            <div class="controls">
              <input style="float:left;" class="adverstisement_image_input" type="file" name="advertisement_image" />
              <?php if($advertisement[0]['advertisement_image']){?>
              	<div style="float:left;"><img width="50" src="<?php echo base_url(); ?>uploads/advertisement/<?php echo $advertisement[0]['advertisement_image']?>" /></div>
              <?php }?>
              <input type="hidden" name="old_advertisement_image" value="<?php echo $advertisement[0]['advertisement_image']?>" />
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Advertisement URL</label>
            <div class="controls">
              <input type="text" name="advertisement_url" value="<?php echo $advertisement[0]['advertisement_url'];?>" />
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
             <select name="status">
             	<option <?php  echo $advertisement[0]['status'] == 'Active' ? 'selected="selected"' : ''?>  value="Active">Active</option>
                <option <?php echo $advertisement[0]['status'] == 'Inactive' ? 'selected="selected"' : ''?> value="Inactive">Inactive</option>
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
	var val_add = "<?php echo $advertisement[0]['advertisement_flag']?>";
</script>   