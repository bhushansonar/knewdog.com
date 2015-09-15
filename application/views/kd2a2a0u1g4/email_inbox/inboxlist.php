<link href="<?php echo base_url(); ?>assets/css/kd2a2a0u1g4/demo.css" rel="stylesheet" type="text/css" />
<div class="container top">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4/emailinbox"); ?>">
                Inbox<?php //echo ucfirst($this->uri->segment(1));     ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            Inbox list<?php //echo ucfirst($this->uri->segment(2));     ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Inbox<?php //echo ucfirst($this->uri->segment(2));     ?>
            <?php /* ?><a  href="<?php echo site_url("kd2a2a0u1g4").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a><?php */ ?>
        </h2>
    </div>
    <?php
    //\\print_r($this->session->userdata('flash_message'));
    //print_r($this->session->flashdata('data'));
    //flash messages

    echo validation_errors();
    //echo $this->session->flashdata('flash_message');
    if ($this->session->flashdata('flash_message')) {
        if ($this->session->flashdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new Newsletter created with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> language Keyword updated with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Mail deleted with success.';
            echo '</div>';
        } else {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
            echo '</div>';
        }
    }
    ?>
    <div class="row">
        <div class="span12 columns">
            <div class="well">
                <div id="mailboxes">
                    <?php
                    $newarray = array();
                    for ($c = 0; $c < count($mailarray); $c++) {
                        $mraray = $mailarray[$c];
                        //echo ''print_r($mraray); die;
                        for ($m = 0; $m < count($mraray); $m++) {
                            $newarray[] = $mraray[$m];
                        }
                    }
                    ?>

                    <?php
                    $array = json_decode(json_encode($newarray), true);
                    /* function cb($a, $b) {
                      return strtotime($a['date']) - strtotime($b['date']);
                      }
                      usort($array, 'cb'); */
                    /* function sortFunction( $a, $b ) {
                      return strtotime($a['MailDate']) - strtotime($b['MailDate']);
                      } */
                    usort($array, "sortFunction");  //Here You can use asort($data,"sortFunction")
                    $rarray = array_reverse($array);
                    //rsort($array);
                    // array_sort_by_column($newarray, 'date');
                    //echo '<pre>'; print_r($rarray); die;
                    ?>
                    <div class="email_item clearfix" style="font-weight:bold;"> <?php // add a different class for seperating read and unread e-mails     ?>
                        <span class="subject" style="text-align:center;" title="Subject">Subject</span>
                        <span class="from" style="text-align:center;" title="From">Sender Name</span>
                  <!--           <span class="to" style="text-align:center;" title="To">To</span>-->
                        <span class="from" style="text-align:center;" title="From">Sender email</span>
                        <span class="to" style="text-align:center;" title="To">To</span>
                        <span style="text-align:center;" class="date">Date</span>
                    </div>
                    <?php
                    $nosub = "no subject";
                    for ($i = 0; $i < count($rarray); $i++) {
//                        echo "<pre>";
//                        print_r($rarray);
//                        exit;
                        //echo decode_imap_text($rarray[$i]['from'][0]['mailbox']);exit;
                        @$subject = ($rarray[$i]['subject'] != "") ? decode_imap_text($rarray[$i]['subject']) : $nosub;
                        ?>
                        <a href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>/body/<?php echo trim($rarray[$i]['Msgno']); ?>/<?php echo base64url_encode($rarray[$i]['to'][1]) ?>">

                            <div class="email_item clearfix <?php echo $rarray[$i]['Unseen'] == "U" ? 'unread' : 'read' ?>"> <?php // add a different class for seperating read and unread e-mails          ?>
                                <span class="subject" title="<?php echo $subject ?>"><?php echo $subject ?></span>
                                <span class="from" title="<?php echo decode_imap_text($rarray[$i]['from'][0]['mailbox']); ?>"><?php echo decode_imap_text($rarray[$i]['from'][0]['mailbox']) ?></span>
                                <span class="to" title="<?php echo decode_imap_text($rarray[$i]['from'][0]['mailbox']) . "@" . decode_imap_text($rarray[$i]['from'][0]['host']) ?>"><?php echo decode_imap_text($rarray[$i]['from'][0]['mailbox']) . "@" . decode_imap_text($rarray[$i]['from'][0]['host']) ?></span>
                                <span class="to" title="<?php echo decode_imap_text($rarray[$i]['to'][1]) ?>"><?php echo decode_imap_text($rarray[$i]['to'][1]) //$rarray[$i]['to'][0]['mailbox']) . "@" . decode_imap_text($rarray[$i]['to'][0]['host']      ?></span>
                                <span class="date"><?php echo decode_imap_text($rarray[$i]['MailDate']) ?></span>
                            </div>
                        </a>
                        <?php
                    }
                    //var_dump($newarray);
                    ?>

                </div>

            </div>
        </div>