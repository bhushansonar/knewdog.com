<?php
$ci = & get_instance();
$ci->load->model('newsletter_model');
$ci->load->model('subscribe_model');
$ci->load->model('user_model');
$ci->load->model('wanted_add_model');

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
    $newsletter_sidebar_interest = $ci->newsletter_model->get_newsletter_interest("", $order_type = "DESC", '3', '0', $where_field_set_value);
}
//echo '<pre>'; print_r($newsletter_sidebar); die;
//Wanted add
$wanted_add = $ci->wanted_add_model->get_wanted_add('', '', '', '', '', 'Active');
$get_most_three_subscribed_newsletter = $ci->subscribe_model->get_most_three_subscribed_newsletter();
?>
<aside id="sidebar">
    <div id="sidebar_right">
        <aside class="widget"><h3 class="widget-title"><?php echo _clang(NEW_IN); ?></h3>
            <div class="widget_content">
                <div class="thismightalsointerestyou">
                    <?php for ($i = 0; $i < count($newsletter_sidebar); $i++) { ?>
                        <div class="antohernewsletter">
                            <div class="antohernewsletter_img">
                                <a href="<?php echo site_url('newsletter/specific') . "/" . url_title($newsletter_sidebar[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter_sidebar[$i]['newsletter_id'] ?>">
                                    <?php if (!empty($newsletter_sidebar[$i]['screenshot'])) { ?>
                                        <img style="width:40px; height:40px;" src="<?php echo base_url(); ?>uploads/<?php echo $newsletter_sidebar[$i]['screenshot']; ?>" alt="authornewsletter">
                                    <?php } else { ?>
                                        <img style="width:40px; height:40px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png" alt="authornewsletter">
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="antohernewsletter_name"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($newsletter_sidebar[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter_sidebar[$i]['newsletter_id'] ?>"><?php echo $newsletter_sidebar[$i]['newsletter_name'] ?></a></div>
                            <div class="antohernewsletter_name"><span><label><?php echo _clang(AUTHOR_S); ?></label><?php echo $newsletter_sidebar[$i]['author_name'] ?></span></div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </aside>
        <?php if (!empty($user_id)) { ?>
            <aside class="widget"><h3 class="widget-title"><?php echo _clang(THIS_MIGHT); ?></h3>
                <div class="widget_content">
                    <div class="thismightalsointerestyou">
                        <?php
                        if (count($newsletter_sidebar_interest) > 0) {
                            for ($i = 0; $i < count($newsletter_sidebar_interest); $i++) {
                                ?>
                                <div class="antohernewsletter">

                                    <div class="antohernewsletter_img"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($newsletter_sidebar_interest[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter_sidebar_interest[$i]['newsletter_id'] ?>">
                                            <?php if (!empty($newsletter_sidebar_interest[$i]['screenshot'])) { ?>
                                                <img style="width:40px; height:40px;" src="<?php echo base_url(); ?>uploads/<?php echo $newsletter_sidebar_interest[$i]['screenshot']; ?>" alt="screenshot">
                                            <?php } else { ?>
                                                <img style="width:40px; height:40px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png" alt="screenshot">
                                            <?php } ?>
                                        </a></div>
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
                                                <img style="width:40px; height:40px;" src="<?php echo base_url(); ?>uploads/<?php echo $get_most_three_subscribed_newsletter[$i]['screenshot']; ?>" alt="screenshot">
                                            <?php } else { ?>
                                                <img style="width:40px; height:40px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png" alt="authornewsletter">
                                            <?php } ?>
                                        </a> </div>
                                    <div class="antohernewsletter_name"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($get_most_three_subscribed_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $get_most_three_subscribed_newsletter[$i]['newsletter_id'] ?>"><?php echo $get_most_three_subscribed_newsletter[$i]['newsletter_name']; ?></a></div>
                                    <div class="antohernewsletter_name"><span><label>Author:</label><?php echo $get_most_three_subscribed_newsletter[$i]['author_name']; ?></span></div>
                                </div>
                                <?php
                            }
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
                                            <img style="width:40px; height:40px;" src="<?php echo base_url(); ?>uploads/<?php echo $get_most_three_subscribed_newsletter[$i]['screenshot']; ?>" alt="screenshot">
                                        <?php } else { ?>
                                            <img style="width:40px; height:40px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png" alt="authornewsletter">
                                        <?php } ?>
                                    </a></div>
                                <div class="antohernewsletter_name"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($get_most_three_subscribed_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $get_most_three_subscribed_newsletter[$i]['newsletter_id'] ?>"><?php echo $get_most_three_subscribed_newsletter[$i]['newsletter_name']; ?></a></div>
                                <div class="antohernewsletter_name"><span><label>Author:</label><?php echo $get_most_three_subscribed_newsletter[$i]['author_name']; ?></span></div>
                            </div>
                            <?php
                        }
                        //echo '<pre>'; print_r($get_most_three_subscribed_newsletter);
                        ?>

                    </div>
                </div>
            </aside>
        <?php } ?>
        <aside class="widget" style="border-bottom:0;">
            <div class="widget_content">
                <?php
                if (count($wanted_add) > 0) {
                    //for ($w = 0; $w < count($wanted_add); $w++) {
                    $wanted_add_s = array_rand($wanted_add);
                    //print_r($wanted_add_s);
                    ?>
                    <div class="wanted">
                        <?php echo $wanted_add[$wanted_add_s]['wanted_add_script']; ?>
                    </div>
                    <?php
                    //}
                }
                ?>
            </div>
        </aside>
    </div>
</aside>