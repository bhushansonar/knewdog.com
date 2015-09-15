<?php
$ci = & get_instance();
$ci->load->model('newsletter_model');
$ci->load->model('subscribe_model');
$ci->load->model('user_model');
$ci->load->model('wanted_add_model');
//$search_string, $order, $order_type, $config['per_page'],$limit_end,'Active',$where_field,$where_value,$language_id,$newsletter_category,$rating_id,$author_country,$author_zipcode
//New in our database:
$where_field_sidebar = array("newsletter_relation");
$where_value_sidebar = array("parent");
$newsletter_sidebar = $ci->newsletter_model->get_newsletter_front('', 'newsletter_id', 'DESC', '3', '0', 'Active', $where_field_sidebar, $where_value_sidebar);
//This might also interest you:

if ($ci->session->userdata('user_id')) {
    $user_id = $ci->session->userdata('user_id');
    $user_interest = $ci->user_model->get_user_by_id($user_id);
    $user_int = explode(",", $user_interest[0]['user_interests']);

    $where_field_set_value = array();
    $where_field_set_value = $user_int;
//$where_value = "";
//echo '<pre>'; print_r($where_field_set_value); die;
    $newsletter_sidebar_interest = $ci->newsletter_model->get_newsletter_interest("", $order_type = "DESC", 3, 0, $where_field_set_value);
}
//echo '<pre>'; print_r($newsletter_sidebar); die;
//Wanted add
$wanted_add = $ci->wanted_add_model->get_wanted_add('', '', '', '', '');
$get_most_three_subscribed_newsletter = $ci->subscribe_model->get_most_three_subscribed_newsletter();
?>
<aside id="sidebar">
    <div id="sidebar_right">
        <?php if ($this->session->userdata('is_logged_in')) { ?>
            <aside class="widget">		
                <div class="widget_content">
                    <label style="color: #808080;float: left;font-size: 12px; width:100%;"><?php echo get_type_of_membership_txt($user_interest[0]['type_of_membership']) ?></label>
                    <div class="dash_profilepicture">

                        <div id="sidebar_profilepic" class="profilepicture">
                            <?php if (@getimagesize((site_url('uploads/avatar') . "/" . $user_interest[0]['avatar']))) { ?>
                                <img alt="" style="width:45px; height:45px;" src="<?php echo site_url('uploads/avatar') . "/" . $user_interest[0]['avatar']; ?>" >
                            <?php } else { ?>
                                <img alt="" src="<?php echo base_url(); ?>assets/img/freeuser.png">
                            <?php } ?>
                        </div>
                        <h2 style="float:none; text-align:center;" class="username"><?php echo $user_interest[0]['username'] ?></h2>
                    </div>
    <?php
    if (show_go_premium_link() == true) {
        $user_data = $ci->user_model->get_user_by_id($user_id);
        if ($user_data[0]['type_of_membership'] == 'FREE') {
            ?>
                            <div style="margin-top:0;" class="profilepicture_details"><?php echo _clang(PREMIUM_MEMBERS); ?><br>
                                <span style="margin-top: 10px; float: left; width: 100%; color:#0070C0; text-decoration: underline;"><a href="<?php echo site_url('premium-account') ?>">Learn more...</a></span>
                            </div>
                            <?php } else if ($user_data[0]['type_of_membership'] == 'PRE1') {
                            ?>

                            <div style="margin-top:0;" class="profilepicture_details"><?php echo _clang(YOU_WANT); ?><br>
                                <span style="margin-top: 10px; float: left; width: 100%; color:#0070C0; text-decoration: underline;"><a href="<?php echo site_url('premium-account') ?>"><?php echo _clang(LEARN_MORE_MK_S); ?></a></span>
                            </div>		

                        <?php }
                    }
                    ?>

                </div>
            </aside>
        <?php } ?>


        <aside class="widget">
            <div class="widget_content">
                <ul class="myprofile_sidebarlinks">
                    <!--<li><a href="#" rel="bookmark">Notifications (2 new messages!)</a></li>
                    <li><a href="#" rel="bookmark">Your spam folder (18 junk mails)</a></li>-->
                    <li><a href="<?php echo site_url('help') ?>" rel="bookmark"><?php echo _clang(HELP_F); ?></a></li>
                    <li><a href="<?php echo site_url('contactus') ?>"><?php echo _clang(CONTACT_US); ?></a></li>
                    <?php
                    if (show_go_premium_link() == true) {
                        if ($user_data[0]['type_of_membership'] == 'FREE') {
                            ?>

                            <li><a href="<?php echo site_url('premium-account') ?>" rel="bookmark"><?php echo _clang(UPGRADE_TO); ?></a></li>
                            <?php } else if ($user_data[0]['type_of_membership'] == 'PRE1') {
                            ?>

                            <li><a href="<?php echo site_url('premium-account') ?>" rel="bookmark"><?php echo _clang(UPGRADE_TO_XXL); ?></a></li>									
                        <?php }
                    }
                    ?>
                    <!--<li><a href="#" rel="bookmark">Get free Premium months!</a></li>-->
                </ul>
            </div>
        </aside>
<?php if (!empty($user_id)) { ?>
            <aside style="border:0" class="widget"><h3 class="widget-title"><?php echo _clang(THIS_MIGHT_MK_S); ?>:</h3>			
                <div class="widget_content">
                    <div class="thismightalsointerestyou">
                        <?php
                        if (count($newsletter_sidebar_interest) > 0) {
                            for ($i = 0; $i < count($newsletter_sidebar_interest); $i++) {
                                ?>
                                <div class="antohernewsletter">

                                    <div class="antohernewsletter_img"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($newsletter_sidebar_interest[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter_sidebar_interest[$i]['newsletter_id'] ?>">
                                            <?php if (!empty($newsletter_sidebar_interest[$i]['screenshot'])) { ?>
                                                <img alt="" style="width:40px; height:40px;" src="<?php echo base_url(); ?>uploads/<?php echo $newsletter_sidebar_interest[$i]['screenshot']; ?>">
            <?php } else { ?>
                                                <img alt="" style="width:40px; height:40px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png">
            <?php } ?>
                                        </a>                                   
                                    </div>
                                    <div class="antohernewsletter_name"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($newsletter_sidebar_interest[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter_sidebar_interest[$i]['newsletter_id'] ?>"><?php echo $newsletter_sidebar_interest[$i]['newsletter_name']; ?></a></div>
                                    <div class="antohernewsletter_name"><span><label>Author:</label><?php echo $newsletter_sidebar_interest[$i]['author_name']; ?></span></div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
        <?php for ($i = 0; $i < count($get_most_three_subscribed_newsletter); $i++) { ?>
                                <div class="antohernewsletter">

                                    <div class="antohernewsletter_img"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($get_most_three_subscribed_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $get_most_three_subscribed_newsletter[$i]['newsletter_id'] ?>">
                                            <?php if (!empty($get_most_three_subscribed_newsletter[$i]['screenshot'])) { ?>
                                                <img alt="" style="width:40px; height:40px;" src="<?php echo base_url(); ?>uploads/<?php echo $get_most_three_subscribed_newsletter[$i]['screenshot']; ?>">
                                            <?php } else { ?>
                                                <img alt="" style="width:40px; height:40px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png">
            <?php } ?> 
                                        </a>                                  
                                    </div>
                                    <div class="antohernewsletter_name"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($get_most_three_subscribed_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $get_most_three_subscribed_newsletter[$i]['newsletter_id'] ?>"><?php echo $get_most_three_subscribed_newsletter[$i]['newsletter_name']; ?></a></div>
                                    <div class="antohernewsletter_name"><span><label>Author:</label><?php echo $get_most_three_subscribed_newsletter[$i]['author_name']; ?></span></div>
                                </div>
                            <?php }
                            //echo '<pre>'; print_r($get_most_three_subscribed_newsletter);
                            ?>
    <?php } ?>
                        <!-- <div class="antohernewsletter">
                             <div class="antohernewsletter_img"><a target="_blank" href="#"><img src="<?php echo base_url(); ?>assets/img/authornewsletter.png"></a></div>
                             <div class="antohernewsletter_name"><a target="_blank" href="#">Another Newsletter</a><span><label>Author:</label>Another Author</span></div>
                         </div>
                         <div class="antohernewsletter">
                             <div class="antohernewsletter_img"><a target="_blank" href="#"><img src="<?php echo base_url(); ?>assets/img/authornewsletter.png"></a></div>
                             <div class="antohernewsletter_name"><a target="_blank" href="#">Another Newsletter</a><span><label>Author:</label>Another Author</span></div>
                         </div>-->
                    </div>
                </div>
            </aside>
                    <?php } else { ?>
            <aside style="border:0" class="widget"><h3 class="widget-title"><?php echo _clang(THIS_MIGHT_MK_S); ?>:</h3>			
                <div class="widget_content">
                    <div class="thismightalsointerestyou">
    <?php for ($i = 0; $i < count($get_most_three_subscribed_newsletter); $i++) { ?>
                            <div class="antohernewsletter">

                                <div class="antohernewsletter_img"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($get_most_three_subscribed_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $get_most_three_subscribed_newsletter[$i]['newsletter_id'] ?>">
                                        <?php if (!empty($get_most_three_subscribed_newsletter[$i]['screenshot'])) { ?>
                                            <img alt="" style="width:40px; height:40px;" src="<?php echo base_url(); ?>uploads/<?php echo $get_most_three_subscribed_newsletter[$i]['screenshot']; ?>"> 
                                        <?php } else { ?>
                                            <img alt="" style="width:40px; height:40px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png">
        <?php } ?>
                                    </a>                                   
                                </div>
                                <div class="antohernewsletter_name"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($get_most_three_subscribed_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $get_most_three_subscribed_newsletter[$i]['newsletter_id'] ?>"><?php echo $get_most_three_subscribed_newsletter[$i]['newsletter_name']; ?></a></div>
                                <div class="antohernewsletter_name"><span><label>Author:</label><?php echo $get_most_three_subscribed_newsletter[$i]['author_name']; ?></span></div>
                            </div>
    <?php }
    //echo '<pre>'; print_r($get_most_three_subscribed_newsletter);
    ?>

                    </div>
                </div>
            </aside>
<?php } ?>

    </div>
</aside>