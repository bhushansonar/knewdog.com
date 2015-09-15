<div class="container top">    <ul class="breadcrumb">        <li>            <a href="<?php echo site_url("kd2a2a0u1g4"); ?>">                <?php echo ucfirst($this->uri->segment(1)); ?>            </a>             <span class="divider">/</span>        </li>        <li>            <a href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>">                <?php echo ucfirst($this->uri->segment(2)); ?>            </a>             <span class="divider">/</span>        </li>        <li class="active">            <a href="#">Update</a>        </li>    </ul>    <div class="page-header users-header">        <h2>            Updating <?php echo ucfirst($this->uri->segment(2)); ?>        </h2>    </div>    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo validation_errors();
    echo form_open_multipart('kd2a2a0u1g4/user/update/' . $this->uri->segment(4) . '', $attributes);
    ?>    <fieldset>        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />        <div class="control-group">            <label for="inputError" class="control-label">Id<span class="star">*</span></label>            <div class="controls">                <span style="line-height:28px;" class="help-inline"><?php echo $user[0]['user_rand_id']; ?></span>              <!--<span class="help-inline">Woohoo!</span>-->            </div>        </div>        <div class="control-group">            <label for="inputError" class="control-label">First Name</label>            <div class="controls">                <input type="text" id="" name="firstname" value="<?php echo $user[0]['firstname']; ?>" >              <!--<span class="help-inline">Woohoo!</span>-->            </div>        </div>        <div class="control-group">            <label for="inputError" class="control-label">Last Name</label>            <div class="controls">                <input type="text" id="" name="lastname" value="<?php echo $user[0]['lastname']; ?>" >              <!--<span class="help-inline">Woohoo!</span>-->            </div>        </div>        <div class="control-group">            <label for="inputError" class="control-label">User Name<span class="star">*</span></label>            <div class="controls">                <input type="text" id="" name="username" value="<?php echo $user[0]['username']; ?>" >              <!--<span class="help-inline">Woohoo!</span>-->            </div>        </div>        <div class="control-group">            <label for="inputError" class="control-label">Password<span class="star">*</span></label>            <div class="controls">                <input disabled="disabled" type="password" class="pass_disabled" name="password" value="<?php echo $user[0]['password']; ?>" >                <span class="help-inline"><a onclick="changepassword();" href="javascript:void(0)">Change</a></span>            </div>        </div>        <div id="confirm_div" style="display:none;" class="control-group">            <label for="inputError" class="control-label">Confirm Password<span class="star">*</span></label>            <div class="controls">                <input disabled="disabled" type="password" class="pass_disabled" name="password2" value="<?php echo $user[0]['password']; ?>" >              <!--<span class="help-inline">Woohoo!</span>-->            </div>        </div>        <div class="control-group">            <label for="inputError" class="control-label">Primary E-mail<span class="star">*</span></label>            <div class="controls">                <input type="text" id="" name="primary_email" value="<?php echo $user[0]['primary_email']; ?>" >              <!--<span class="help-inline">Woohoo!</span>-->            </div>        </div>        <?php /* ?><div class="control-group">          <label for="inputError" class="control-label">Additional E-mail 1</label>          <div class="controls">          <input type="text" id="" name="primary_email_2" value="<?php echo $user[0]['primary_email_2']; ?>" >          <!--<span class="help-inline">Woohoo!</span>-->          </div>          </div><?php */ ?>        <div class="control-group">            <label for="inputError" class="control-label">Gender</label>            <div class="controls">                <select name="gender">                    <option <?php echo $user[0]['gender'] == 'Male' ? 'selected="selected"' : '' ?>  value="Male">Male</option>                    <option <?php echo $user[0]['gender'] == 'Female' ? 'selected="selected"' : '' ?> value="Female">Female</option>                    <option <?php echo $user[0]['gender'] == 'Neutral' ? 'selected="selected"' : '' ?> value="Neutral">Neutral</option>                </select>              <!--<span class="help-inline">Woohoo!</span>-->            </div>        </div>        <div class="control-group">            <label for="inputError" class="control-label">Aavtar</label>            <div class="controls">                <input style="float:left;" name="avatar" type="file" /><?php if ($user[0]['avatar']) { ?>                    <div style="float:left;"><img width="100" src="<?php echo base_url(); ?>uploads/avatar/<?php echo $user[0]['avatar'] ?>" alt="avatar" /></div><?php } ?>               
                <input type="hidden" name="old_avatar" value="<?php echo $user[0]['avatar'] ?>" />     
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Type of memebership</label>
            <div class="controls">
                <select name="type_of_membership">
                    <option value="">-Select Membership type-</option>
                    <option <?php echo $user[0]['type_of_membership'] == 'normal_admin' ? 'selected="selected"' : '' ?> value="normal_admin">Normal Admin</option>
                    <?php if (user_access($this->session->userdata('user_id'), 'add_power_admin') == true) { ?>                       
                        <option <?php echo $user[0]['type_of_membership'] == 'power_admin' ? 'selected="selected"' : '' ?> value="power_admin">Power admin</option><?php } ?>                   
                    <option <?php echo $user[0]['type_of_membership'] == 'FREE' ? 'selected="selected"' : '' ?>  value="FREE">FREE</option>                    
                    <option <?php echo $user[0]['type_of_membership'] == 'PRE1' ? 'selected="selected"' : '' ?>  value="PRE1">PRE1</option>                    
                    <option <?php echo $user[0]['type_of_membership'] == 'PRE2' ? 'selected="selected"' : '' ?> value="PRE2">PRE2</option>                    
                    <option <?php echo $user[0]['type_of_membership'] == 'PUB1' ? 'selected="selected"' : '' ?>  value="PUB1">PUB1</option>                    
                    <option <?php echo $user[0]['type_of_membership'] == 'PUB2' ? 'selected="selected"' : '' ?>  value="PUB2">PUB2</option>                    
                    <option <?php echo $user[0]['type_of_membership'] == 'CAAD' ? 'selected="selected"' : '' ?>  value="CAAD">CAAD</option>                    
                    <option <?php echo $user[0]['type_of_membership'] == 'CAUS' ? 'selected="selected"' : '' ?>  value="CAUS">CAUS</option>               
                </select>                   
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Language interface</label>            
            <div class="controls">                
                <select name="language_interface"><?php for ($l = 0; $l < count($site_language); $l++) { ?>                        
                        <option <?php echo $user[0]['language_interface'] == $site_language[$l]['site_language_id'] ? 'selected="selected"' : '' ?>  value="<?php echo $site_language[$l]['site_language_id'] ?>"><?php echo $site_language[$l]['language_longform'] ?></option><?php } ?>                
                </select> 
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Language for Newsletter</label>            
            <div class="controls">                
                <?php $language_id = explode(",", $user[0]['language_id']); ?>                
                <select multiple="multiple" name="language_id[]">                    
                    <option value="">-Select Language-</option><?php for ($l = 0; $l < count($language); $l++) { ?>                        
                        <option <?php echo (in_array($language[$l]['language_id'], $language_id)) ? 'selected="selected"' : '' ?>  value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform']; ?></option><?php } ?>                
                </select> 
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Town</label>            
            <div class="controls">                
                <input type="text" id="" name="town" value="<?php echo $user[0]['town'] ?>" >
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Zip code</label>            
            <div class="controls">                
                <input type="text" id="" name="zip_code" value="<?php echo $user[0]['zip_code']; ?>" >
            </div>
        </div> 
        <div class="control-group">            
            <label for="inputError" class="control-label">Country</label>
            <div class="controls">
                <select name="country">
                    <?php for ($l = 0; $l < count($countries); $l++) { ?>
                        <option <?php echo $user[0]['country'] == $countries[$l]['id'] ? 'selected="selected"' : '' ?>  value="<?php echo $countries[$l]['id'] ?>"><?php echo $countries[$l]['country_name'] ?></option>
                    <?php } ?>                
                </select>
            </div>        
        </div>
        <div class="control-group">            
            <label for="inputError" class="control-label">User interests</label>            
            <div class="controls">                
                <select multiple="multiple" name="user_interests[]">                    
                    <option  value="">-Select User interests-</option> 
                    <?php
                    $newsletter_keyword_ids = explode(",", $user[0]['user_interests']);
                    for ($k = 0; $k < count($keyword); $k++) {
                        ?>                        
                        <option  <?php echo (in_array($keyword[$k]['newsletter_keyword_id'], $newsletter_keyword_ids)) ? 'selected="selected"' : '' ?> value="<?php echo $keyword[$k]['newsletter_keyword_id']; ?>"><?php echo $keyword[$k]['en']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Additional E-mail 1</label>            
            <div class="controls">                
                <input type="text" id="" name="additional_email1" value="<?php echo $user[0]['additional_email1'] ?>" > 
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Additional E-mail 2</label>           
            <div class="controls">                
                <input type="text" id="" name="additional_email2" value="<?php echo $user[0]['additional_email2'] ?>" > 
            </div>        
        </div>        
        <div class="control-group">            
            <label class="control-label">NO Adds</label>            
            <div class="controls">                
                <div class="radio_div">
                    <input  name="no_ads" type="radio" <?php echo ($user[0]['no_ads'] == "YES") ? 'checked="checked"' : ""; ?> value="YES" />&nbsp;<span>Yes</span>
                </div>                
                <div class="radio_div">                    
                    <input  name="no_ads" type="radio" <?php echo ($user[0]['no_ads'] == "NO") ? 'checked="checked"' : ""; ?> value="NO" />&nbsp;<span>NO</span>                 
                </div>            
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Adult Content tag</label>            
            <div class="controls">                
                <div class="radio_div">
                    <input  name="adult_content" type="radio" <?php echo ($user[0]['adult_content'] == "YES") ? 'checked="checked"' : ""; ?> value="YES" />&nbsp;<span>Yes</span></div>                
                <div class="radio_div">
                    <input name="adult_content" type="radio" <?php echo ($user[0]['adult_content'] == "NO") ? 'checked="checked"' : ""; ?> value="NO" />&nbsp;<span>NO</span> 
                </div>            
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Privacy Settings</label>            
            <div class="controls">                
                <div class="radio_div">
                    <input  name="privacy_settings" type="radio" <?php echo ($user[0]['privacy_settings'] == "YES") ? 'checked="checked"' : ""; ?> value="YES" />&nbsp;<span>Yes</span>
                </div>                
                <div class="radio_div"><input  name="privacy_settings" type="radio" <?php echo ($user[0]['privacy_settings'] == "NO") ? 'checked="checked"' : ""; ?> value="NO" />&nbsp;<span>NO</span> 
                </div>
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" style="text-decoration: underline;font-weight: bold;" class="control-label">Invoice Details</label>            
            <div class="controls">            
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">First Name</label>            
            <div class="controls">                
                <input type="text" id="" name="i_firstname" value="<?php echo $user[0]['i_firstname']; ?>" >
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Last Name</label>            
            <div class="controls">                
                <input type="text" id="" name="i_lastname" value="<?php echo $user[0]['i_lastname']; ?>" > 
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Company Name</label>            
            <div class="controls">                
                <input type="text" id="" name="i_company_name" value="<?php echo $user[0]['i_company_name']; ?>" >   
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Street</label>            
            <div class="controls">                
                <textarea name="i_street"><?php echo $user[0]['i_street']; ?></textarea> 
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Town</label>            
            <div class="controls">                
                <input type="text" id="" name="i_town" value="<?php echo $user[0]['i_town']; ?>" > 
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Zip code</label>            
            <div class="controls">                
                <input type="text" id="" name="i_zip_code" value="<?php echo $user[0]['i_zip_code']; ?>" >
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Country</label>
            <div class="controls">                
                <select name="i_country">                    
                    <?php for ($l = 0; $l < count($countries); $l++) { ?>                        
                        <option <?php echo $user[0]['i_country'] == $countries[$l]['id'] ? 'selected="selected"' : '' ?>  value="<?php echo $countries[$l]['id'] ?>"><?php echo $countries[$l]['country_name'] ?></option><?php } ?>                
                </select>            
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Account Confirmed</label>            
            <div class="controls">                
                <span style="line-height:28px;" class="help-inline"><?php echo $user[0]['account_confirmed']; ?></span>
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Date of registration</label>            
            <div class="controls">                
                <span style="line-height:28px;" class="help-inline"><?php echo $user[0]['date_of_registration']; ?></span> </div>
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Date of Last login</label>            
            <div class="controls">                
                <span style="line-height:28px;" class="help-inline"><?php echo $user[0]['last_login']; ?></span>            
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">End of term is calculated:</label>            
            <div class="controls">                
                <?php
                $end_term = "";
                $year_data = "No date availabel";
                if ($user[0]['type_of_membership'] == 'FREE') {
                    echo $end_term = "Your account is valid for an unlimited period of time";
                } else {
                    $start = $user[0]['date_from'];
                    echo "<span style='display:none;'class='start_date'>" . $start . "</span>";
                    $end = $user[0]['date_to'];
                    $diff = abs(strtotime($end) - strtotime($start));
                    if (!empty($diff)) {
                        $years = floor($diff / (365 * 60 * 60 * 24));


                        echo $end_term = $start . ' + ';
                        ?>
                        <select class='end_term' name="end_term" style='width: 16%'>

                            <?php for ($i = $years; $i <= 6; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i . ' year' ?></option>
                                <?php
                                if ($i == 6) {
                                    $i = 1;
                                }
                            }
                            ?>

                        </select>
                        <!--                        . $years . " years = ";
                                                }   -->

                        <?php
                        echo " = " . $end;
                    }
                    echo "<span class='modified_date'>
                        </span>";
                }
                // echo $end_term = $start .'+ <span>dfd</span>=' . $end; }
                ?>          
            </div>        
        </div>        
        <div class="control-group">            
            <label for="inputError" class="control-label">Status</label>            
            <div class="controls">
                <select name="status">                    
                    <option <?php echo trim($user[0]['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>                    
                    <option <?php echo trim($user[0]['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>                
                </select>
            </div>        
        </div>        
        <div class="form-actions">            
            <button class="btn btn-primary" type="submit">Save changes</button>            
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>            
            <span style="display:none"; id="delete_msg">Are you really sure to delete this User?</span>
            <?php if (user_access($this->session->userdata('user_id'), 'delete_users') == true) { ?>                
                <a style="margin-left:30px;" href="<?php echo site_url("kd2a2a0u1g4") ?>/user/delete/<?php echo $this->uri->segment(4) ?>" class="btn btn-danger complexConfirm">Delete User</a><?php } ?>        
        </div>    
    </fieldset>
    <?php echo form_close(); ?>
</div>
<script>
        $('.end_term').on('change', function() {
            var dropdown_value = this.value;
            var from_date = $('.start_date').text();
            duration = parseInt(dropdown_value, 10);
            var new_date = new Date(from_date);
            var dd = new_date.getDate();
            var mm = new_date.getMonth() + 1; //January is 0!
            var yyyy = new_date.getFullYear() + duration;
            new_date1 = yyyy + '-' + mm + '-' + dd;
            $('.modified_date').html("<input type='hidden' name='date_to' value='" + new_date1 + "'>");
        });
</script>