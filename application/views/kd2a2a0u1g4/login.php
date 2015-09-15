<!DOCTYPE html> 
<html lang="en-US">
    <head>
        <title>KnewDog Login</title>
        <meta charset="utf-8">
        <link href="<?php echo base_url(); ?>assets/css/kd2a2a0u1g4/global.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container login">

            <?php
            $attributes = array('class' => 'form-signin');
            echo form_open('kd2a2a0u1g4/login/validate_credentials', $attributes);
            ?>
            <div><img alt="Logo" src="<?php echo base_url(); ?>assets/img/logo.png" height="159" width="295" /></div>
            <?php
            echo '<h2 class="form-signin-heading">Login</h2>';
            echo form_input('username', '', 'placeholder="Username"');
            echo form_password('password', '', 'placeholder="Password"');
            if (isset($message_error) && $message_error) {
                echo '<div class="alert alert-error">';
                echo '<a class="close" data-dismiss="alert">&#215;</a>';
                echo '<strong>Oh snap!</strong> Change a few things up and try submitting again.';
                echo '</div>';
            }
            echo "<br />";
            // echo anchor('kd2a2a0u1g4/signup', 'Signup!');
            echo "<br />";
            echo "<br />";
            echo form_submit('submit', 'Login', 'class="btn btn-large btn-primary"');
            echo form_close();
            ?>      
        </div><!--container-->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    </body>
</html>    
