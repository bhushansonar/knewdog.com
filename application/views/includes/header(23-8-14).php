<?php
$CI = & get_instance();
$CI->load->model('site_language_model');
$facebook_login = K_facebook();
if (!empty($facebook_login)) {
    $facebookurl = @$facebook_login['login_url'];
} else {
    $facebookurl = '#';
}
$google_login = K_google();
if (!empty($google_login['authUrl'])) { //user is not logged in, show login button
    $googleurl = @$google_login['authUrl'];
} else {
    $googleurl = "#";
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <?php echo show_meta(); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <base href="<?php echo site_url(); ?>" />

        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/styles.css">
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript">var base_url = '<?php echo base_url(); ?>'</script>
        <script type="text/javascript">var unsubscribe_btn = "<?php echo _clang(UNSUSCRIBE_BUTTON); ?>"</script>
        <script type="text/javascript">var delete_msg = "<?php echo _clang(DELETE_MSG); ?>"</script>
        <script type="text/javascript">var delete_btn = "<?php echo _clang(DELETE_BUTTON); ?>"</script>
        <?php echo add_head(); ?>
    </head>
    <body>
        <div class="page indexpage">
            <div id="dashwrapper">
                <div id="wrapper">

                    <header>
                        <?php if ($main_content == 'home_view') { ?>
                            <div class="topheader">
                                <ul>
                                    <?php if (!$this->session->userdata('is_logged_in')) { ?>
                                        <li class="signinwith"><?php echo _clang(SIGN_IN_WITH); ?></li>
                                        <li class="facebook"><a onClick="javascript:void window.open('<?php echo $facebookurl; ?>', 'fb_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                return false;" href="<?php echo $facebookurl; ?>"><img src="<?php echo base_url(); ?>/assets/img/facebook.png" alt=""><?php echo _clang(FACEBOOK); ?></a></li>
                                        <li class="google"><a onClick="javascript:void window.open('<?php echo $googleurl; ?>', 'g_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                        return false;" href="<?php echo $googleurl ?>"><img src="<?php echo base_url(); ?>/assets/img/google.png" alt=""><?php echo _clang(GOOGLE) ?></a></li>
                                        <?php } else { ?>
                                        <li>You are logged in as</li>
                                        <li style="color:#E46C0A;"><?php echo $this->session->userdata('username'); ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div id="header">
                                <div class="header_lt">
                                    <h1 class="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/assets/img/logo.png" alt=""></a></h1>
                                </div>
                                <div class="header_rt">
                                    <ul class="country">
                                        <?php
                                        $get_lang = $CI->site_language_model->get_language('', '', '', '', '', 'Active');
                                        //echo '<pre>';print_r($get_lang);
                                        for ($gl = 0; $gl < count($get_lang); $gl++) {
                                            $lang_short = $get_lang[$gl]['language_shortcode'];
                                            $session_lang = $CI->session->userdata('language_shortcode');
                                            $class = ($session_lang == $lang_short) ? 'active_lang' : "";
                                            ?>
                                            <li style="cursor:pointer;" onClick="set_session('<?php echo $lang_short ?>')" class="<?php echo $class ?>">
                                                <?php //if(is_file(base_url()."/uploads/flag/".$get_lang[$gl]['language_flag'])){ ?>
                                                <img title="<?php echo $get_lang[$gl]['language_longform'] ?>" src="<?php echo base_url(); ?>/uploads/flag/<?php echo $get_lang[$gl]['language_flag'] ?>" alt="">
                                                <?php //}else{ ?>

                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="headertext">
                                        <span style="color:#E46C0A; font-size:xx-large; font-weight:bolder;"><?php echo _clang(HEADER_TITLE); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="headerinner" >
                                <div class="header_lt">
                                    <h1 class="logo logo_inner"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/assets/img/logo_inner.png" alt=""></a></h1>
                                </div>
                                <div class="header_rt">
                                    <ul class="country">
                                        <?php
                                        $get_lang = $CI->site_language_model->get_language('', '', '', '', '', 'Active');
                                        for ($gl = 0; $gl < count($get_lang); $gl++) {
                                            $lang_short = $get_lang[$gl]['language_shortcode'];
                                            $session_lang = $CI->session->userdata('language_shortcode');
                                            $class = ($session_lang == $lang_short) ? 'active_lang' : "";
                                            ?>
                                            <li style="cursor:pointer;" onClick="set_session('<?php echo $lang_short ?>')" class="<?php echo $class ?>">
                                                <?php //if(is_file(base_url()."/uploads/flag/".$get_lang[$gl]['language_flag'])){ ?>
                                                <img title="<?php echo $get_lang[$gl]['language_longform'] ?>" src="<?php echo base_url(); ?>/uploads/flag/<?php echo $get_lang[$gl]['language_flag'] ?>" alt="">
                                                <?php //}else{ ?>

                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="headertext_inner">
                                        <span style="color:#E46C0A; font-size:22px; font-weight:bold;"><?php echo _clang(HEADER_TITLE_SMALL) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <nav>
                            <ul class="menu">
                                <li <?php
                                if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'home') {
                                    echo 'class="current"';
                                }
                                ?>><a href="<?php echo site_url(); ?>"><?php echo _clang(HOME); ?></a></li>
                                <li <?php
                                if ($this->uri->segment(1) == 'signup') {
                                    echo 'class="current"';
                                }
                                ?>><a href="<?php echo site_url('signup'); ?>"><?php echo _clang(SIGN_UP); ?><br/><span>(<?php echo _clang(FREE); ?>!)</span></a></li>
                                <li <?php
                                    if ($this->uri->segment(1) == 'newsletter') {
                                        echo 'class="current"';
                                    }
                                    ?>><a href="<?php echo site_url('newsletter'); ?>"><?php echo _clang(NEWSLETTERS); ?></a></li>
                                <li <?php
                                if ($this->uri->segment(1) == 'blog') {
                                    echo 'class="current"';
                                }
                                ?>><a href="<?php echo site_url("blog") ?>"><?php echo _clang(BLOG); ?></a></li>
                                <li <?php
                                    if ($this->uri->segment(1) == 'help') {
                                        echo 'class="current"';
                                    }
                                    ?> class=""><a href="<?php echo site_url('help') ?>"><?php echo _clang(HELP); ?></a></li>
                                <li <?php
                                    if ($this->uri->segment(1) == 'myknewdog') {
                                        echo 'class="current login"';
                                    } else {
                                        echo 'class="login"';
                                    }
                                    ?> style="width: 319px;text-align:center;">
<?php
if (!empty($this->session->userdata['user_id'])) {
    $CI->load->model('user_model');
    $users_data = $CI->user_model->get_user_by_id($this->session->userdata['user_id']);
    ?>
                                        <a href="<?php echo site_url('myknewdog') ?>"><?php echo _clang(MY_KNEWDOG); ?></a><br/>

                                        <span style="color: white !important; font-style: italic; cursor: pointer; font-size: 17px; text-align: center; float: left; width: 290px; margin-top: -1px;"><a style="margin-top:1px; color: #FFF;" href="<?php echo site_url('home/logout') ?>"><span>Logout</span></a></span>
<?php } else { ?>
                                        <span style="float: right; margin-top:16px;color: white;cursor:pointer; font-style:italic;font-size: 18px;text-align: center;clear: both;margin-right: 22px;" onClick="popup('signin')"><?php echo _clang(LOGIN); ?></span>
<?php } ?>
                                </li>
                            </ul>
                        </nav>
                    </header>
<?php //echo '<pre>';print_r($this->session->userdata);  ?>
