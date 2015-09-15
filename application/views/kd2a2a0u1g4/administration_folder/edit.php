<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('tinymce');
    CKEDITOR.config.fullPage = true;
    /*CKEDITOR.editorConfig = function( config )
     {
     config.fullPage= true;
     //CKEDITOR.config.fullPage= true;
     config.forcePasteAsPlainText = true;
     };*/

</script>
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
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>">
                <?php echo ucfirst($this->uri->segment(2)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating <?php echo ucfirst($this->uri->segment(2)); ?>
            <a  href="<?php echo site_url('kd2a2a0u1g4') . '/' . $this->uri->segment(2); ?>/process/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>" class="btn btn-success">Process</a>
        </h2>
    </div>
    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    //flash messages
    if ($this->session->userdata('flash_message')) {
        if ($this->session->userdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new admin inbox created with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->userdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong>mail updated with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->userdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Mail deleted with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->userdata('flash_message') == 'multi_delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> ' . $this->session->userdata('delete_msg_no') . ' newsletter(s) deleted with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
            echo '</div>';
        }
        if (($this->session->userdata('unsubscribe_count'))) {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Total ' . $this->session->userdata('unsubscribe_count') . ' Unsubscribe entry deleted in newsletter Issue.';
            echo '</div>';
            $this->session->set_userdata('unsubscribe_count', '');
        }
        if ($this->session->userdata('flash_message1')) {
            if ($this->session->userdata('flash_message1') == 'acc_success') {
                echo '<div class="alert alert-success">';
                echo '<a class="close" data-dismiss="alert">&#215;</a>';
                echo '<strong>Well done!</strong> Email Account <strong>' . $this->session->userdata('add_email') . '</strong> created successfully.';
                echo '</div>';
                $this->session->set_userdata('flash_message1', '');
                $this->session->set_userdata('add_email', '');
            } else if ($this->session->userdata('flash_message1') == 'mail_delete') {
                echo '<div class="alert alert-success">';
                echo '<a class="close" data-dismiss="alert">&#215;</a>';
                echo '<strong>Well done!</strong> E-Mail <strong>' . $this->session->userdata('delete_mail') . '</strong> also deleted with success.';
                echo '</div>';
                $this->session->set_userdata('flash_message1', '');
            } else {
                echo '<div class="alert alert-error">';
                echo '<a class="close" data-dismiss="alert">&#215;</a>';
                echo '<strong>Oh snap!</strong> Email Account not created. Please make sure you entered the correct information in Cpanel.';
                echo '</div>';
            }
        }
    }

    if (!empty($url_segment_5)) {
        echo form_open_multipart('kd2a2a0u1g4/administration-folder/update/' . $this->uri->segment(4) . '/' . $url_segment_5 . '', $attributes);
    } else {
        echo form_open_multipart('kd2a2a0u1g4/administration-folder/update/' . $this->uri->segment(4) . '', $attributes);
    }
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />
        <div class="control-group">
            <label for="inputError" class="control-label">From name:</label>
            <div class="controls">
                <div>
                    <input type="text" name="newsletter_sender_name" value="<?php echo $administration_folder[0]['newsletter_sender_name'] ?>" /></div>
                <span class="help-inline">(From name in Newsletter)</span>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">From E-mail:</label>
            <div class="controls">
                <div><input type="text" name="newsletter_email" value="<?php echo $administration_folder[0]['newsletter_email'] ?>" /></div>
                <span class="help-inline">(Newsletter email in Newsletter)</span>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Description</label>
            <div class="controls">

<?php /* ?> <textarea class="tinymce ckeditor" name="description"><?php //echo stripslashes($administration_folder[0]['description']);?></textarea><?php */ ?>
                <div><?php echo stripslashes($administration_folder[0]['description']); ?></div>

<?php /* ?><div style="max-height:500px; overflow:auto;"><?php echo stripslashes($administration_folder[0]['description']);?></div><?php */ ?>

 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>

            <a class="btn" href="<?php echo site_url('kd2a2a0u1g4/administration-folder'); ?>">Cancel</a>


            <span style="display:none"; id="delete_msg">Are you really sure to delete this Mail?</span>

            <a style="margin-left:30px;" class="btn btn-danger complexConfirm" href="<?php echo site_url("kd2a2a0u1g4") ?>/administration-folder/delete/<?php echo $this->uri->segment(4); ?>">Delete</a>


        </div>
    </fieldset>

<?php echo form_close(); ?>

</div>
<?php //if(!empty($url_segment_5)){ ?>

<?php //}?>