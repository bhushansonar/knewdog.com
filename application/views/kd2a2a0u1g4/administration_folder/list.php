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
            <?php echo ucfirst($this->uri->segment(2)); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(2)); ?> 
        </h2>
        <p>( Info:E-mail Newsletter issue list whose subscription email and name does not exitst in knewdog database. )</p>
    </div>
    <?php
    if ($this->session->flashdata('flash_message')) {

        echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo $this->session->flashdata("flash_message");
        echo '</div>';
    }
    //flash messages
    if ($this->session->userdata('flash_message')) {
        if ($this->session->userdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Newsletter issue created with success.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->userdata('flash_message') == 'moved_to_admin_inbox') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo 'Count not find any Ubsubscribe text/link to remove so Newsletter moved to Admin unsubscribe Inbox.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->userdata('flash_message') == 'process') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Newsletter issue is in process.';
            echo '</div>';
            $this->session->set_userdata('flash_message', '');
        } else if ($this->session->userdata('flash_message') == 'error') {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> something went wrong!';
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
			$this->session->set_userdata('flash_message', '');
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
                        <span style="text-align:center;" class="sender_name">Sender Name</span>
                        <span style="text-align:center;" class="date">Date</span>
                    </div>
                    <?php
                    $nosub = "no subject";
                    for ($i = 0; $i < count($administration_folder); $i++) {
                        @$subject = ($administration_folder[$i]['headline'] != "") ? $administration_folder[$i]['headline'] : $nosub;

                        $location = site_url("kd2a2a0u1g4/administration-folder/update/" . $administration_folder[$i]["newsletter_id"]);
                        /* onClick="javascript:void window.open('<?php echo $location;?>', 'mail_popup', 'width=800,height=400,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');return false;" */
                        ?>                

    <!--                    <a onClick="javascript:void window.open('<?php echo site_url("kd2a2a0u1g4/administration-folder/update/" . $administration_folder[$i]["newsletter_id"]) ?>'")></a>-->

                        <div class="email_item clearfix read"> <?php $get_host = get_admin_detail();

                    // add a different class for seperating read and unread e-mails 
                        ?>
                            <span class="subject"  title="<?php echo $subject ?>"><a style="color: #4d4d4d" target="_blank" href="<?php echo $location; ?> "><?php echo $subject ?></a></span>
                            <span class="from" title="<?php echo $administration_folder[$i]['email'] ?>"><?php echo $administration_folder[$i]['email'] ?></span>
                            <span class="to" title="<?php echo strtolower($administration_folder[$i]['newsletter_rand_id']) . "@" . $get_host['host'] ?>"><?php echo strtolower($administration_folder[$i]['newsletter_rand_id']) . "@" . $get_host['host'] ?></span>
                            <span class="sender_name"><?php echo $administration_folder[$i]['newsletter_sender_name'] ?></span>
                            <span class="date"><?php echo $administration_folder[$i]['added_date'] ?></span>
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