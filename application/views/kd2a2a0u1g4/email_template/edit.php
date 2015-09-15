<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('tinymce')
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/jquery.datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/jquery.datetimepicker.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/table.css" type="text/css"/>
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
                Email Template<?php //echo ucfirst($this->uri->segment(2));        ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating Email Template<?php //echo ucfirst($this->uri->segment(2));        ?>
        </h2>
    </div>
    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();
    if ($this->session->flashdata('flash_message')) {
        if ($this->session->flashdata('flash_message') == 'delete_image') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> featured image deleted with success.';
            echo '</div>';
        }
    }
    echo form_open_multipart('kd2a2a0u1g4/email_template/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>

        <?php
        //echo '<pre>'; print_r($site_language);
        for ($i = 0; $i < count($site_language); $i++) {
            ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Subject <?php echo $site_language[$i]['language_longform'] ?></label>
                <div class="controls">
                    <input type="text" name="subject_<?php echo $site_language[$i]['language_shortcode'] ?>" value="<?php echo $email_template[0]['subject_' . $site_language[$i]['language_shortcode']] ?>" >
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Description <?php echo $site_language[$i]['language_longform']; ?></label>
                <div class="controls">
                    <textarea class="tinymce ckeditor" id="editor_<?php echo $site_language[$i]['language_shortcode'] ?>" name="description_<?php echo $site_language[$i]['language_shortcode'] ?>"><?php echo $email_template[0]['description_' . $site_language[$i]['language_shortcode']] ?></textarea>
                </div>
            </div>

            <div class="control-group">
                <div style="margin-left: 160px;">
                    <table id="rounded-corner" summary="2007 Major IT Companies' Profit">
                        <thead>
                            <tr>
                                <th scope="col" class="rounded-company"><span class="star">*</span> Available Variable (Use Related below Variable Above Editor)</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($variable as $page_variable) { ?>
                                <tr>
                                    <td><?php echo $page_variable; ?></td>
                                </tr>
                                <?php }  ?>

                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <?php //echo $newsletter[0]['status']; ?>
                <select name="status">
                    <option <?php echo trim($email_template[0]['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo trim($email_template[0]['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
                 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

<!--<script type="text/javascript">
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
        value: '<?php echo date('Y-m-d H:i:00', strtotime($email_template[0]['date'])) ?>',
        format:'Y-m-d H:i:00',
        step:10,
         minDate:'-1970/01/01',//yesterday is minimum date(for today use 0 or -1970/01/01)
        maxDate:'+3000/01/02'//tommorow is maximum date calendar,
});
show_published_date();
</script>-->