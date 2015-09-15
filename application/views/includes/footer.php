<footer>
    <div id="footer">
        <div class="footer">
            <div class="widget-in-footer">
                <h3 class="widget-title"><?php echo _clang(ACCOUNTS) ?></h3>
                <ul id="menu-accounts">
                    <li><a href="<?php echo site_url('signup') ?>"><?php echo _clang(SIGN_UP_F) ?></a></li>
                    <?php if (empty($this->session->userdata['user_id'])) { ?>
                        <li><a onClick="popup('signin')" href="javascript:void(0)"><?php echo _clang(LOGIN_F) ?></a></li>
                    <?php } ?>
                    <li><a href="<?php echo site_url('signup') ?>"><?php echo _clang(LEARN_MORE) ?></a></li>
                    <?php if (show_go_premium_link() == true) { ?>
                                                        <!--<li><a href="<?php //site_url('premium-account')         ?>"><?php //echo _clang(UPGRADE_TO_PRO)         ?></a></li>-->
                    <?php } ?>
                </ul>
            </div>

            <div class="widget-in-footer">
                <h3 class="widget-title"><?php echo _clang(ABOUT) ?></h3>
                <ul id="menu-about">
                    <li><a href="<?php echo site_url('about') ?>"><?php echo _clang(WHAT_FOR) ?></a></li>
                    <li><a href="<?php echo site_url('blog') ?>"><?php echo _clang(BLOG_F) ?></a></li>
                    <li><a href="<?php echo site_url('contactus') ?>"><?php echo _clang(CONTACT_US) ?></a></li>
                    <!--<li><a href="#"><?php //echo _clang(SUPPORT_US)         ?></a></li>-->
                </ul>
            </div>

            <div class="widget-in-footer">
                <h3 class="widget-title"><?php echo _clang(HELP_F) ?></h3>
                <ul id="menu-help">
                    <?php
                    $cms_help_list = cms_help_list();
                    //echo '<pre>'; print_r($cms_help_list);
                    for ($i = 0; $i < count($cms_help_list); $i++) {
                        $display_name = ($cms_help_list[$i]['display_name_' . $this->session->userdata('language_shortcode')] != "") ? $cms_help_list[$i]['display_name_' . $this->session->userdata('language_shortcode')] : $cms_help_list[$i]['display_name_en'];
                        $block_url = ($cms_help_list[$i]['block_name'] == 'HELP_PAGE') ? "" : $cms_help_list[$i]['block_name'];
                        ?>
                        <li><a href="<?php echo site_url('help') . "/" . $block_url ?>"><?php echo $display_name ?></a></li>
                    <?php } ?>
                    <li><a href="<?php echo site_url('contactus') ?>"><?php echo _clang(CONTACT_US) ?></a></li>
                </ul>
            </div>

            <div class="widget-in-footer">
                <h3 class="widget-title"><?php echo _clang(FOLLOW_US) ?></h3>
                <ul id="footer_social" class="">
                    <li><a target="_blank" href="https://twitter.com/knewdog_news"><img src="<?php echo base_url(); ?>assets/img/twitter.png" alt="twitter" height="26" width="26"></a></li>
                    <li><a target="_blank" href="http://www.facebook.com/knewdog"><img src="<?php echo base_url(); ?>assets/img/facebook_footer.png" alt="facebook" height="26" width="26"></a></li>
                    <li><a target="_blank" href="http://plus.google.com/+Knewdog"><img src="<?php echo base_url(); ?>assets/img/googleplus.png" alt="googleplus" height="26" width="26"></a></li>
                    <li><a target="_blank" href="http://www.linkedin.com/company/knewdog-"><img src="<?php echo base_url(); ?>assets/img/linkedin.png" alt="linkedin" height="26" width="26"></a></li>
                    <?php /* ?>    <li><a target="_blank" href="http://www.knewdog.com/blog/feed/"><img src="<?php echo base_url(); ?>assets/img/rss.png" alt="twitter"></a></li><?php */ ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="footeraddress">
        <p><span>
                <small><?php echo _clang(COPYRIGHT); ?></small>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('legal') ?>" title="Legal">
                    <small><?php echo _clang(LEGAL); ?></small></a></span>
            <span style="float:right; margin-right:50px;"><small>Developed by <a class="design_developed" style="" href="http://www.amutechnologies.com">www.amutechnologies.com</a></small></span>
        </p>
    </div>
</footer>

<a href="javascript:void(0)" id="dynamic-to-top" style="display: inline;"><span>&nbsp;</span></a>
<?php
$this->session->set_flashdata('redirect_url', current_url());
include_once("popups.php");
?>
<div id="overlay_ajax"></div>
<div style="display:none;" id="dialog-confirm" title="<?php echo _clang(CONFIRMATION) ?>">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <span id="ui-message"><?php echo _clang(UNSUSCRIBE_MSG) ?></span></p>
</div>

<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.confirm.js"></script>
<script>
                            var val_add = '';
</script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script type="application/javascript">
    $(function(){$('.popup a.popup_close').click(function(){
    var currentPopup = $('.popup:visible').size();
    if($('.popup:visible').size()>1){
    $(this).closest('.popup').fadeOut('slow');
    $(this).closest('#overlay').fadeOut('slow');
    }else{
    $('#overlay').fadeOut('fast',function(){$(currentPopup).attr('style','');});

    }
    return false;});
    });
    //alert("hii");
    function popup(cls){
    //alert(cls);
    var classes = "."+cls;
    $("#overlay").fadeIn('slow');
    $("#overlay").find("."+cls).fadeIn('slow');
    $("#overlay").find(".popup:not("+classes+")").hide();
    }
    $(document).ready(function(e){
    if (window.location.hash == '#_=_') {
    window.location.hash = ''; // for older browsers, leaves a # behind
    history.pushState('', document.title, window.location.pathname); // nice and clean
    e.preventDefault(); // no page reload
    }
    });
</script>

<?php if (!empty($open_popup)) { ?>
    <script>
        popup('<?php echo $open_popup ?>');

    </script>
<?php } ?>
<script type='text/javascript'>
    var a = $(this);
    var href = a.attr('href');
    $(document).ready(function() {

        $("a[href^='http://']").each(function() {
            if (this.href.indexOf(location.hostname) == -1) {
                $(this).attr('target', '_blank');
                $(this).attr('title', 'Click to open ' + this.href + ' in a new window');
                $(this).attr('rel', 'nofollow');
            }
        }
        );
        $("a[href^='https://']").each(function() {
            if (this.href.indexOf(location.hostname) == -1) {
                $(this).attr('target', '_blank');
                $(this).attr('title', 'Click to open ' + this.href + ' in a new window');
                $(this).attr('rel', 'nofollow');
            }
        }
        );

        $('img').each(function() {
            if (!$(this).attr('alt'))
                $(this).attr('alt', '');
        });

        $("#dynamic-to-top").hide(); // hide on page load
        $(window).bind('scroll', function() {
            if ($(this).scrollTop() > 200) { // show after 200 px of user scrolling
                $("#dynamic-to-top").fadeIn("slow");
            }
            if ($(this).scrollTop() == 0) {
                $("#dynamic-to-top").fadeOut("slow");
            }
        });
        $("a[id='dynamic-to-top']").click(function() {

            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        });

    });

</script>
</div>
</div>
</div>
</body>
</html>