<?php
$this->CI =& get_instance();
$this->CI->load->model('site_language_model');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home Page</title>
<meta name="description" content="Welcome to my basic template.">
 
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/styles.css">
  <script type="text/javascript"> var base_url = '<?php echo base_url();?>'</script>
</head>
<body>
<div class="page indexpage">
<div id="dashwrapper">
    <div id="wrapper">
    	<header>
            <div class="topheader">
                <ul>
                    <li class="signinwith"><?php echo _clang(SIGN_IN_WITH);?></li>
                    <li class="facebook"><img src="<?php echo base_url();?>/assets/img/facebook.png"><?php echo _clang(FACEBOOK);?></li>
                    <li class="google"><img src="<?php echo base_url();?>/assets/img/google.png"><?php echo _clang(GOOGLE)?></li>
                </ul>
            </div>
            
            <div id="header">
                <div class="header_lt">
                    <h1 class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/assets/img/logo.png"></a></h1>
                </div>
                <div class="header_rt">
                    <ul class="country">
                    	<?php 
						$get_lang = $this->CI->site_language_model->get_language('', '', '', '','','Active');
						//echo '<pre>';print_r($get_lang);
						for($gl=0;$gl<count($get_lang);$gl++){
						$lang_short = $get_lang[$gl]['language_shortcode'];
						?>
                        <li style="cursor:pointer;" onClick="set_session('<?php echo $lang_short?>')" class="">
                        <?php //if(is_file(base_url()."/uploads/flag/".$get_lang[$gl]['language_flag'])){?>
                        <img title="<?php echo $get_lang[$gl]['language_longform']?>" src="<?php echo base_url();?>/uploads/flag/<?php echo $get_lang[$gl]['language_flag']?>">
                   <?php //}else{?>
                       
                        </li>
                        <?php }?>
                    </ul>
                    <div class="headertext">
                    	<span style="color:#E46C0A; font-size:xx-large; font-weight:bolder;"><?php echo _clang(HEADER_TITLE);?></span>
                    </div>
                </div>
            </div>
            <nav>
            	 <ul class="menu">
                    <li class="current"><a href="<?php echo site_url();?>"><?php echo _clang(HOME);?></a></li>
                    <li class=""><a href="#"><?php echo _clang(SIGN_UP);?><br/><span>(<?php echo _clang(FREE);?>!)</span></a></li>
                    <li class=""><a href="#"><?php echo _clang(NEWSLETTERS);?></a></li>
                    <li class=""><a href="#"><?php echo _clang(BLOG);?></a></li>
                    <li class=""><a href="#"><?php echo _clang(HELP);?></a></li>
                    <li class="login"><a href="#"><?php echo _clang(MY_KNEWDOG);?><br/><span>(<?php echo _clang(LOGIN);?>)</span></a></li>
                </ul>
            </nav>
        </header>