<link href="<?php echo base_url(); ?>assets/css/kd2a2a0u1g4/demo.css" rel="stylesheet" type="text/css">
<?php
$this->load->model('newsletter_language_model');
?>
<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo "Admin Unsubscribe Inbox"; ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo "Admin Unsubscribe Inbox"; ?> 
        </h2>
        <p>( Info:E-mail Newsletter issue list that doesn't content any Unsubscribe link and Unsubscribe text from Newsletter. )</p>
    </div>
    <?php
    //flash messages
    if ($this->session->userdata('flash_message')) {
        if ($this->session->userdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Newsletter issue created with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if($this->session->userdata('flash_message') == 'add_withoutcheck'){
			
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Newsletter issue created with success. But you have processed it without Unsubscribe link check!';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        
		}else if ($this->session->userdata('flash_message') == 'error') {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> Can`t find any Unsubscribe data!';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->userdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> admin Mail body updated with success.';
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
        } else if ($this->session->userdata('flash_message') == 'error') {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> Can`t find any Unsubscribe data!';
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
            } else if ($this->session->userdata('flash_message') == 'error') {
                echo '<div class="alert alert-error">';
                echo '<a class="close" data-dismiss="alert">&#215;</a>';
                echo '<strong>Oh snap!</strong> Can`t find any Unsubscribe data!';
                echo '</div>';
                $this->session->set_userdata('flash_message', '');
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
    ?>

    <div class="row">
        <div class="span12 columns">
            <div class="well">
                <div id="mailboxes">
                    <div class="email_item clearfix" style="font-weight:bold;">
                        <span class="subject" style="text-align:center;" title="Subject">Subject</span>
                        <span class="from" style="text-align:center;" title="From">From</span>
                        <span class="to" style="text-align:center;" title="To">To</span>
                        <span  class="sender_name">Sender Name</span>
                        <span style="text-align:center;" class="date">Date</span>
                    </div>
                    <?php
                    $nosub = "no subject";
                    for ($i = 0; $i < count($newsletter_clone); $i++) {
                        @$subject = ($newsletter_clone[$i]['headline'] != "") ? $newsletter_clone[$i]['headline'] : $nosub;
                        ?>
                        <a target="_blank" href="<?php echo site_url("kd2a2a0u1g4/admin-inbox/update/" . $newsletter_clone[$i]['newsletter_id']) ?>">

                            <div class="email_item clearfix read"> <?php $get_host = get_admin_detail(); // add a different class for seperating read and unread e-mails    ?>
                                <span class="subject" title="<?php echo $subject ?>"><?php echo $subject ?></span>
                                <span class="from" title="<?php echo $newsletter_clone[$i]['email'] ?>"><?php echo $newsletter_clone[$i]['email'] ?></span>
                                <span class="to" title="<?php echo strtolower($newsletter_clone[$i]['newsletter_rand_id']) . "@" . $get_host['host'] ?>"><?php echo strtolower($newsletter_clone[$i]['newsletter_rand_id']) . "@" . $get_host['host'] ?></span>
                                <span class="sender_name"><?php echo $newsletter_clone[$i]['newsletter_sender_name'] ?></span>
                                <span class="date"><?php echo $newsletter_clone[$i]['added_date'] ?></span>
                            </div>
                        </a>
                        <?php
                    }
//var_dump($newarray);
                    ?>      

                </div>

            </div>
        </div>
    </div>