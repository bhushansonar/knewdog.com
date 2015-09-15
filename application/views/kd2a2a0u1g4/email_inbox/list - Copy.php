<?php
$mailboxes = array(
	array(
		'label' 	=> 'Gmail',
		'enable'	=> true,
		'mailbox' 	=> '{imap.gmail.com:993/imap/ssl}INBOX',
		'username' 	=> 'hardik.amutech@gmail.com',
		'password' 	=> 'Hardik@306'
	),
	array(
		'label' => 'Another mail account',
		'enable'	=> true,
		'mailbox' => '{mail.knewdog.com:993/imap/ssl/novalidate-cert}INBOX',
		'username' => 'test@knewdog.com',
		'password' => 'admin123',
	)
);

//Extra function
function getBody($uid, $imap) {
    $body = get_part($imap, $uid, "TEXT/HTML");
    // if HTML body is empty, try getting text body
    if ($body == "") {
        $body = get_part($imap, $uid, "TEXT/PLAIN");
    }
    return $body;
}
 
function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
    if (!$structure) {
	//$imap_uid = imap_uid ($imap, $uid);
	//echo "$uid->".$uid;
	
           $structure = imap_fetchstructure($imap, $uid, FT_UID);
    }
	//echo "<br/>structure-><pre>".print_r($structure)."</pre>";
    if ($structure) {
        if ($mimetype == get_mime_type($structure)) {
            if (!$partNumber) {
                $partNumber = 1;
            }
            $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
            switch ($structure->encoding) {
                case 3: return imap_base64($text);
                case 4: return imap_qprint($text);
                default: return $text;
           }
       }
 
        // multipart 
        if ($structure->type == 1) {
            foreach ($structure->parts as $index => $subStruct) {
                $prefix = "";
                if ($partNumber) {
                    $prefix = $partNumber . ".";
                }
                $data = get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                if ($data) {
                    return $data;
                }
            }
        }
    }
    return false;
}
 
function get_mime_type($structure) {
    $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
 
    if ($structure->subtype) {
       return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
    }
    return "TEXT/PLAIN";
}
//function end
// a function to decode MIME message header extensions and get the text
function decode_imap_text($str){
    $result = '';
    $decode_header = imap_mime_header_decode($str);
    foreach ($decode_header AS $obj) {
        $result .= htmlspecialchars(rtrim($obj->text, "\t"));
	}
    return $result;
}
?>
    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
         Inbox<?php //echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          Inbox<?php //echo ucfirst($this->uri->segment(2));?> 
          <a  href="<?php echo site_url("kd2a2a0u1g4").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
      </div>
         <?php
	 	//\\print_r($this->session->userdata('flash_message'));
		//print_r($this->session->flashdata('data'));
	
	//flash messages
	
	  echo validation_errors();
	  //echo $this->session->flashdata('flash_message');
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'add')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new language Keyword created with success.';
          echo '</div>';       
        }else if($this->session->flashdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> language Keyword updated with success.';
          echo '</div>'; 
		}else if($this->session->flashdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> language Keyword deleted with success.';
          echo '</div>';
		}else{
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
	<?php if (!count($mailboxes)) { ?>
		<p>Please configure at least one IMAP mailbox.</p>
	<?php } else { 
		$count = 0;
		foreach ($mailboxes as $current_mailbox) {
			?>
			<div class="mailbox">
			<h2><?php $current_mailbox['label']?></h2>
			<?php
			if (!$current_mailbox['enable']) {
			?>
				<p>This mailbox is disabled.</p>
			<?php
			} else {
				
				// Open an IMAP stream to our mailbox
				$stream = @imap_open($current_mailbox['mailbox'], $current_mailbox['username'], $current_mailbox['password']);
				
				if (!$stream) {?>
					<p>Could not connect to: <?php $current_mailbox['label']?>. Error: <?php imap_last_error()?></p>
				<?php
				} else {
					// Get our messages from the last week
					// Instead of searching for this week's message you could search for all the messages in your inbox using: $emails = imap_search($stream,'ALL');
					//$emails = imap_search($stream, 'SINCE '. date('d-M-Y',strtotime("-1 week")));
					//echo 'stream <pre>';print_r($stream);
					$emails = imap_search($stream,'ALL');
					if (!count($emails)){
					?>
						<p>No e-mails found.</p>
					<?php
					} else {

						// If we've got some email IDs, sort them from new to old and show them
						rsort($emails);
						foreach($emails as $email_id){
						
							// Fetch the email's overview and show subject, from and date. 
							$overview = imap_fetch_overview($stream,$email_id,0);
							//echo "seen->".$overview[0]->seen."<br/>";
							$setcount = (($overview[0]->seen == 1) ? 0 : 1);
							$count += $setcount;	
												
							?>
                            <?php /*?><a href="body.php?email_id= <?php echo $email_id;?>">
                           
							<div class="email_item clearfix <?php echo $overview[0]->seen?'read':'unread'?>"> <?php // add a different class for seperating read and unread e-mails ?>
								<span class="subject" title="<?php echo decode_imap_text($overview[0]->subject)?>"><?php echo decode_imap_text($overview[0]->subject)?></span>
								<span class="from" title="<?php echo decode_imap_text($overview[0]->from)?>"><?php echo decode_imap_text($overview[0]->from)?></span>
								<span class="date"><?php echo $overview[0]->date?></span>
                                <?php $message = getBody($email_id,$stream);?>
                               <div class="body"><?php //echo $message;?></div>
							</div>
                            </a><?php */?>	
							<?php
						} 
					} 
					imap_close($stream); 
					
				}
				
			} 
			?>
			</div>
			<?php
		} // end foreach 
		echo "Inbox (".$count.")"; 
	} ?>
	</div>
            
      </div>
    </div>