<main>
    <!--<link href="<?php echo site_url('assets/css') ?>/rateit.css" rel="stylesheet" type="text/css">-->

    <script type="text/javascript">
        $(document).ready(function() {
            /*
             *  Simple image gallery. Uses default settings
             */

            $('.fancybox').fancybox({
                scrolling: 'auto',
                preload: true,
                afterLoad: function() {

                    //alert("call");
                    $(".fancybox-iframe").contents().find("a").each(function() {
                        //$(".fancybox-iframe a[href^='http://']").each(function () {
                        if (this.href.indexOf(location.hostname) == -1) {
                            $(this).attr('target', '_blank');
                            $(this).attr('title', 'Click to open ' + this.href + ' in a new window');
                            $(this).attr('rel', 'nofollow');
                        }
                    }
                    );
                    $(".fancybox-iframe").contents().find("a").each(function() {
                        // $(".fancybox-iframe a[href^='https://']").each(function () {
                        if (this.href.indexOf(location.hostname) == -1) {
                            $(this).attr('target', '_blank');
                            $(this).attr('title', 'Click to open ' + this.href + ' in a new window');
                            $(this).attr('rel', 'nofollow');
                        }
                    }
                    );
                }
            });

            /*var cssLink = document.createElement("link")
             cssLink.href = "style.css";
             cssLink .rel = "stylesheet";
             cssLink .type = "text/css";
             frames['frame1'].document.body.appendChild(cssLink);
             */
        });
    </script>
    <div class="set_errors">
        <?php
        $this->load->model('newsletter_model');
        $this->load->model('user_model');
        $this->load->model('newsletter_language_model');
        $this->load->model('newsletter_keyword_model');
        $this->load->model('schedule_model');
        $ci = & get_instance();
        $ci->load->model('subscribe_model');


        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {
            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        ?>
    </div>
    <section class="knewdog findnewsletter" id="container">
        <section id="knewdog_leftbar">
            <div class="knewdog_leftbar_inner">
                <!--<div id="tabsholder">
                    <ul class="tabs">
                        <li class="current" id="tab1" style="">Find<br/>Newsletters</li>
                        <li class="" id="tab2">My<br/>Newsletters</li>
                    </ul>
                </div>-->
                <section>
                    <div class="reviewlist">
                        <div class="dashreview fullwidth_left">
                            <div class="review_img">
                                <?php if (!empty($newsletter[0]['screenshot'])) { ?>
                                    <a class="fancybox" href="<?php echo base_url(); ?>uploads/<?php echo $newsletter[0]['screenshot']; ?>">
                                        <img alt="" style="width:100px; " src="<?php echo base_url(); ?>uploads/<?php echo $newsletter[0]['screenshot']; ?>" >
                                    </a>
                                <?php } else { ?>
                                    <a  href="javascript:void(0)">
                                        <img alt="" style="width:100px; " src="<?php echo base_url(); ?>assets/img/authornewsletter.png">
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="review_detail specific_review_detail">
                                <div style="color: #e46c0a !important; font-size: 16px;"><b><?php echo $newsletter[0]['newsletter_name'] ?></b></div>
                                <div class="subscription"><?php echo $newsletter[0]['headline']; ?></div>
                                <div class="subscriptiondetail specific_subscriptiondetail">
                                    <label style="color: rgb(128, 128, 128); float: left; width: 13px;">by: </label><span style="float: right; width: 231px;"><?php echo $newsletter[0]['author_name'] ?></span>
                                    <?php
                                    $get_rate = $this->newsletter_model->get_rate_by_user($newsletter[0]['newsletter_id']);
                                    include("rating/rating_calculation.php");

                                    $user_id = $this->session->userdata("user_id");
                                    //echo "user_id->".$newsletter[$i]["user_id"];
                                    $wherefield = array("join_newsletter_id");
                                    $wherevalue = array($newsletter[0]["newsletter_id"]);
                                    $get_news_user_id = $this->newsletter_model->get_rate_by_field($wherefield, $wherevalue);
                                    /* if(!empty($user_id)){
                                      if(count($get_news_user_id) > 0){
                                      $readonly = "true";
                                      }else{
                                      $readonly = "false";
                                      }
                                      }else{
                                      $readonly = "true";
                                      } */
                                    $readonly = "true";
                                    //echo '<pre>'; print_r($get_news_user_id);
                                    //$data['get_rate'] = $get_rate;
                                    ?>
                                    <div style="position:relative;" class="rating_hover">
                                        <div title="<?php echo $avg_round; ?>" style="display: inline-block; vertical-align: text-bottom;" data-productid="<?php echo $newsletter[0]['newsletter_id']; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $avg_round; ?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="<?php echo $readonly ?>" class="rateit rateit9"></div>

                                        <?php if (count($get_news_user_id) > 0) { ?>
                                            <img alt="" style="margin-left: 5px; vertical-align: text-top; display: inline-block;" src="<?php echo base_url(); ?>assets/img/review_down.png">
                                        <?php } ?>
                                        <a style="text-decoration: none; margin-left: 3px; display: inline-block; vertical-align: top;" href="<?php echo site_url("newsletter/display-rate" . "/" . $newsletter[0]['newsletter_id']); ?>">(<?php echo (!empty($total_user_rate)) ? $total_user_rate : "0"; ?>)</a>
                                        <?php if (count($get_news_user_id) > 0) { ?>
                                            <div style="top:49px; left:0;" class="rating_popup">
                                                <?php $popupcss = "style='float:none; width:100%;'"; ?>
                                                <?php include("rating/rating_view.php"); ?>
                                                <a href="<?php echo site_url("newsletter/display-rate" . "/" . $newsletter[0]['newsletter_id']); ?>"><?php echo _clang(SEE_ALL_NS); ?> <?php echo (!empty($total_user_rate)) ? $total_user_rate : "0"; ?> <?php echo _clang(CUST_REVIEW); ?></a>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <?php /* ?><img style="margin-left:20px; margin-top:2px;" src="<?php echo base_url(); ?>assets/img/yelloreviews.png"><img src="<?php echo base_url(); ?>assets/img/yelloreviews.png">
                                      <img src="<?php echo base_url(); ?>assets/img/yelloreviews.png"><img src="<?php echo base_url(); ?>assets/img/yelloreviews.png">
                                      <img src="<?php echo base_url(); ?>assets/img/yelloreviews.png"><img style="margin-left:5px;" src="<?php echo base_url(); ?>assets/img/review_down.png">
                                      <a style="text-decoration:none; margin-left:3px;" href="#">(64)</a><?php */ ?>
                                    <br/>
                                    <?php
                                    $where_s_field_3 = array('s_newsletter_id');
                                    $where_s_value_3 = array($newsletter[0]['newsletter_id']);
                                    $subscribed_3 = $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_s_field_3, $where_s_value_3);
                                    $count_subscribed_3 = count($subscribed_3);
                                    ?>
                                    <label style="color:#808080; margin-top:10px; float:left; width:100%;"><?php echo $count_subscribed_3; ?> <?php echo _clang(SUBSCRIBERS); ?><br/>
                                        <!-- 4 newsletters last month<br/>-->
                                        <?php echo _clang(FREQUENCY); ?>: <?php echo!empty($newsletter[0]['frequency']) ? $newsletter[0]['frequency'] : "N/A"; ?><br/>
                                        <?php echo _clang(LANGUAGE_NS); ?>: <?php echo!empty($newsletter[0]['language_longform']) ? $newsletter[0]['language_longform'] : "N/A"; ?><br/>
                                        <?php echo _clang(LATEST_EDITION); ?>: <?php echo date('j, F Y', strtotime($last_newsletter_issue[0]['added_date'])); ?><br/>
                                    </label>
                                </div>
                                <div class="review_subscribe review_subscribe_<?php echo $newsletter[0]['newsletter_id']; ?>">
                                    <?php
                                    if (!empty($user_id)) {


                                        $where_Sfield = array('s_newsletter_id', 's_user_id');
                                        $where_Svalue = array($newsletter[0]['newsletter_id'], $user_id);
                                        $subscribe = $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_Sfield, $where_Svalue);
                                        if (count($subscribe) > 0) {
                                            ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <!-- <span style="float: right; margin-top: 20px; text-align: center; color:#808080; font-size: 11px;">You are already subscribed<br>Go to ”<u><span style="cursor:pointer;" onclick="display_tabs('tab_2')">My Newsletters</u>”<br>to manage<br>your subscriptions.</span>-->
                                        <?php } else { ?>
                                            <img alt="" style="cursor:pointer;" onclick="popups_ajax('subscribe_1', '<?php echo $newsletter[0]['newsletter_id'] ?>', '<?php echo $user_id ?>')" src="<?php echo base_url(); ?>assets/img/subscribe_specificpage.png">
                                            <span style="position: absolute; color: rgb(154, 127, 130); font-weight: bold; font-size: 10px; margin-left: 54px; margin-top: 77px; cursor: pointer;"><?php echo _clang(SUBSCRIBE_BUTTON) ?></span> <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <!--<div class="review_subscribe"><a href="#"><img src="<?php echo base_url(); ?>assets/img/subscribe_specificpage.png"></a></div>-->
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="fullwidth_left details specific_detail">
                            <div class="title" style="color: #e46c0a"><b><?php echo _clang(DETAILS); ?>:</b></div>
                            <div><label><?php echo _clang(CATEGORY_NS); ?>:</label>
                                <div class="move_content_right"><?php echo str_replace(",", ", ", ($newsletter[0]['g_en'])); ?>
                                </div>
                            </div>
                            <div>
                                <label><?php echo _clang(KEYWORDS); ?>: </label>
                                <div class="move_content_right">
                                    <?php echo (!empty($newsletter[0]['g_keyword_name']) ? str_replace(",", ", ", ($newsletter[0]['g_keyword_name'])) : "N/A"); ?>
                                </div>
                            </div>
                            <div>
                                <label><?php echo _clang(PUBLISHER); ?>:</label>
                                <div class="move_content_right"><a href="<?php echo $newsletter[0]['website_url'] ?>"><?php echo $newsletter[0]['website_url'] ?></a>
                                </div>
                            </div>
                            <div><label><?php echo _clang(LOCATION_NS); ?>:</label>
                                <div class="move_content_right"><?php echo!empty($newsletter[0]['country_name']) ? $newsletter[0]['country_name'] : "N/A"; ?>
                                </div>
                            </div>
                            <!--<div style="margin-bottom:5px;" class="control-group">
                                <label style="float: left;width: 140px;padding-top: 5px;text-align: right;margin: 0 20px 0 12px;" for="inputError" class="control-label">ID</label>
                                <div style="margin-left: 60px;px;" class="controls">
                                    <div style="margin-top:5px;">APR1412172N</div>
                                </div>
                              </div>-->
                        </div>
                    </div>

                    <div>
                        <?php if (!empty($newsletter[0]['description'])) { ?>
                            <div class="fullwidth_left description_content">
                                <div class="title" style="color: #e46c0a;" ><b><?php echo _clang(DESCRIPTION); ?>:</b></div>
                                <?php echo!empty($newsletter[0]['description']) ? stripslashes($newsletter[0]['description']) : "No Description found!" ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="videos">


                        <?php if (!empty($newsletter[0]['video'])) { ?>
                            <div class=" fullwidth_left details specific_detail">
                                <div class="title" style="color: #e46c0a;"><b><?php echo _clang(VIDEO); ?>:</b></div>
                                <?php
                                $videos = explode("@@@", $newsletter[0]['video']);
                                for ($v = 0; $v < count($videos); $v++) {
                                    $link = get_youtube_code($videos[$v]);
                                    $hostname = $link['hostname'];

                                    $path = $link['path'];
                                    $query = $link['query'];
                                    @$Arr = @explode('v=', $query);
// from video id, until to end of the string like 5sRDHnTApSw&feature=youtu.be The master Bob Haro......
                                    @$videoIDwithString = @$Arr[1];

                                    @$videoID = substr($videoIDwithString, 0, 11); // 5sRDHnTApSw
                                    if (($v % 2) == 0) {
                                        $class = "video1";
                                    } else {
                                        $class = "video2";
                                    }
                                    ?>

                                    <div class="<?php echo $class; ?>">
                                        <?php
                                        if ((isset($videoID)) && (isset($hostname)) && ($hostname == 'www.youtube.com' || $hostname == 'youtube.com')) {
                                            ?>
                                            <iframe width="278" height="189" src="https://www.youtube.com/embed/<?php echo $videoID ?>"></iframe>
                                            <?php
                                        } else if ((isset($hostname)) && $hostname == 'vimeo.com') {
                                            $ArrV = explode('://vimeo.com/', $path); // from ID to end of the string
                                            $videoID = substr($ArrV[0], 1, 8); // to get video ID
                                            $vimdeoIDInt = intval($videoID); // ID must be integer
                                            //print_r($vimdeoIDInt);
                                            ?>
                                            <iframe width="278" height="189" src="https://player.vimeo.com/video/<?php echo $vimdeoIDInt; ?>"></iframe>
                                            <?php
                                        } else {
                                            $link = get_youtube_code_only($videos[$v]);
                                            ?>
                                            <iframe width="278" height="189" src="https://www.youtube.com/embed/<?php echo $link ?>"></iframe>
                                        <?php } ?>
                                    </div>
                                <?php }
                                ?> </div>
                        <?php }
                        ?>
                        <!-- <div class="video2">
                         <img src="<?php //echo base_url();                                                          ?>assets/img/video2.png">
                         <div class="title">Lorem ipsum dolor sit amet</div>
                         </div>-->

                    </div>

                    <div>

                        <?php if (!empty($newsletter[0]['about_author'])) { ?>
                            <div class="fullwidth_left description">
                                <div class="title" style="color: #e46c0a;"><b><?php echo _clang(ABOUT_AUTHER); ?>:</b></div>
                                <?php echo!empty($newsletter[0]['about_author']) ? $newsletter[0]['about_author'] : _clang(NO_CONTENT); ?>

                            </div> <?php } ?>
                    </div>

                    <div>
                        <?php
//                        echo "<pre>";
//                        print_r($archive_newsletter);
//                        exit;

                        if (!empty($archive_newsletter)) {
                            ?>
                            <div class="fullwidth_left details">
                                <div class="title" style="color: #e46c0a;"><b><?php echo _clang(NEWS_ARCHIVE); ?>:</b></div>
                                <?php if (count($archive_newsletter) > 0 && $newsletter[0]['newsletter_relation'] == 'parent') { ?>
                                    <div class="datte_time">
                                        <?php
                                        for ($d = 0; $d < count($archive_newsletter); $d++) {

                                            if ($d > 5) {
                                                $class = 'hide';
                                            } else {
                                                $class = 'show';
                                            }
                                            ?>
                                            <?php /* ?> href="<?php echo site_url('newsletter/specific')."/".url_title($archive_newsletter[$d]['newsletter_name'],'dash',true)."/".$archive_newsletter[$d]['newsletter_id']?>"<?php */ ?>
                                            <div class="date_specific <?php echo $class; ?>"><a class="fancybox fancybox.iframe" href="<?php echo site_url('ajax_call/popups_ajax/archive_newsletter/' . $archive_newsletter[$d]['newsletter_id']) ?>"><?php echo $archive_newsletter[$d]['added_date']; ?></a></div>
                                        <?php }
                                        ?>
                                        <a class="datelink" onclick="show_div()" href="javascript:void(0)"><?php echo _clang(MORE_NEWSLETTER); ?>...<img src="<?php echo base_url(); ?>assets/img/more.png"></a>
                                        <a style="display: none;" class="less" onclick="hide_div()" href="javascript:void(0)"><?php echo _clang(LESS_NEWSLETTER); ?><img src="<?php echo base_url(); ?>assets/img/less.png"></a>
                                    </div>
                                    <div class="review_subscribe review_subscribe_<?php echo $newsletter[0]['newsletter_id']; ?>">
                                        <?php
                                        if (!empty($user_id)) {

                                            $where_Sfield = array();
                                            $where_Svalue = array();
                                            $where_Sfield = array('s_newsletter_id', 's_user_id');
                                            $where_Svalue = array($newsletter[0]['newsletter_id'], $user_id);
                                            $subscribe = $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_Sfield, $where_Svalue);
                                            if (count($subscribe) > 0) {
                                                ?>
                                                                                                                                                                                                                        <!-- <span style="float: right; margin-top: 20px; text-align: center; color:#808080; font-size: 11px;">You are already subscribed<br>Go to ”<u><span style="cursor:pointer;" onclick="display_tabs('tab_2')">My Newsletters</u>”<br>to manage<br>your subscriptions.</span>-->
                                            <?php } else { ?>
                                                <img alt="" style="cursor:pointer; margin-top:0;" onclick="popups_ajax('subscribe_1', '<?php echo $newsletter[0]['newsletter_id'] ?>', '<?php echo $user_id ?>')" src="<?php echo base_url(); ?>assets/img/subscribe_specificpage.png">
                                                <span onclick="popups_ajax('subscribe_1', '<?php echo $newsletter[0]['newsletter_id'] ?>', '<?php echo $user_id ?>')" style="position: absolute; color: rgb(154, 127, 130); font-weight: bold; font-size: 10px; margin-left: 55px; cursor: pointer;margin-top: 62px;"><?php echo _clang(SUBSCRIBE_BUTTON) ?></span> <?php
                                            }
                                        }
                                        ?>
                                        <?php /* ?><img style="cursor:pointer;" onclick="popups_ajax('subscribe_1','<?php echo $newsletter[0]['newsletter_id'] ?>','<?php echo $user_id?>')" src="<?php echo base_url(); ?>assets/img/subscribe_specificpage.png"><?php */ ?>


                                    </div>


                                <?php } else { ?>
                                    <h3 style="clear: both; color: black; text-align: center; margin-top: 20px; margin-bottom:20px;"><?php echo _clang(NO_ARCHIVE); ?></h3>
                                <?php }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div>

                        <div class="fullwidth_left details userrating">
                            <div class="title"><b><?php echo _clang(USER_RATING); ?>:</b></div>
                            <?php
                            /* $total_user_rate = count($get_rate);
                              $star_1 = array();
                              $star_2 = array();
                              $star_3 = array();
                              $star_4 = array();
                              $star_5 = array();
                              $avg_rate = array();
                              //echo '<pre>'; print_r($get_rate);
                              for($r=0;$r<count($get_rate);$r++){
                              $avg_rate[] = $get_rate[$r]['rate'];

                              if($get_rate[$r]['rate'] <= 1)
                              {
                              $star_1[] = $get_rate[$r]["rate"];
                              }
                              else if($get_rate[$r]['rate'] <= 2)
                              {
                              $star_2[] = $get_rate[$r]["rate"];
                              }
                              else if($get_rate[$r]['rate'] <= 3)
                              {
                              $star_3[] = $get_rate[$r]["rate"];
                              }
                              else if($get_rate[$r]['rate'] <= 4)
                              {
                              $star_4[] = $get_rate[$r]["rate"];
                              }
                              else if($get_rate[$r]['rate'] <= 5)
                              {
                              $star_5[] = $get_rate[$r]["rate"];
                              }
                              }
                              //echo '<pre>';print_r($avg_rate);
                              $s_star_1 = 	count($star_1);
                              @$s_star_1_per = (100 * $s_star_1)/$total_user_rate;
                              $s_star_1_per = !empty($s_star_1_per) ? $s_star_1_per : "0";

                              $s_star_2 = 	count($star_2);
                              @$s_star_2_per = (100 * $s_star_2)/$total_user_rate;
                              $s_star_2_per = !empty($s_star_2_per) ? $s_star_2_per : "0";

                              $s_star_3 = 	count($star_3);
                              @$s_star_3_per = (100 * $s_star_3)/$total_user_rate;
                              $s_star_3_per = !empty($s_star_3_per) ? $s_star_3_per : "0";

                              $s_star_4 = 	count($star_4);
                              @$s_star_4_per = (100 * $s_star_4)/$total_user_rate;
                              $s_star_4_per = !empty($s_star_4_per) ? $s_star_4_per : "0";

                              $s_star_5 = 	count($star_5);
                              @$s_star_5_per = (100 * $s_star_5)/$total_user_rate;
                              $s_star_5_per = !empty($s_star_5_per) ? $s_star_5_per : "0";

                              $s_star_1_per = round($s_star_1_per,2);
                              $s_star_2_per = round($s_star_2_per,2);
                              $s_star_3_per = round($s_star_3_per,2);
                              $s_star_4_per = round($s_star_4_per,2);
                              $s_star_5_per = round($s_star_5_per,2);
                              //echo '<pre>';print_r($avg_rate);
                              @$rate_sum = array_sum($avg_rate);
                              @$avg = (float)$rate_sum/(int)$total_user_rate;
                              @$avg_round = $avg;//round(2.8, 1); */
                            include("rating/rating_calculation.php");
                            $popupcss = "";
                            include("rating/rating_view.php");
                            ?>

                            <div class="starrating_detail">
                                <div class="reviewstar">
                                    <?php //echo $newsletter[0]['newsletter_id'];exit;         ?>
                                    <div title="<?php echo $avg_round; ?>" style="float:left;margin-top:2px;" data-productid="<?php echo $newsletter[0]['newsletter_id']; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $avg_round; ?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="true" class="rateit rateit9">
                                    </div>
                                    <a style="margin-left:3px;" href="<?php echo site_url("newsletter/display-rate" . "/" . $newsletter[0]['newsletter_id']); ?>">(<?php echo $total_user_rate; ?>)</a>
                                </div>
                                <div class="reviewstar">
                                    <div style="color:#808080; margin-top:5px;"><?php echo round($avg_round, 2) ?> <?php echo _clang(OUT_OF_NS); ?>
                                    </div>
                                </div>
                                <?php if (!empty($total_user_rate)) {
                                    ?>
                                    <div class="reviewstar">
                                        <div style="margin-top:5px;"><a href="<?php echo site_url("newsletter/display-rate") . "/" . $newsletter[0]["newsletter_id"]; ?>"><?php echo _clang(SEE_ALL_NS); ?> <?php echo $total_user_rate; ?> <?php echo _clang(CUSTOMER_REVIEW_NS); ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>


                                <div class="reviewstar">
                                    <div style="margin-top:5px;"><a href="<?php echo site_url("newsletter/display-rate") . "/" . $newsletter[0]["newsletter_id"]; ?>"> Be the first to rate this newsletter!</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>

            </div>
            <div>
                <?php if (!empty($newsletter_review)) { ?>
                    <div style="font-size:14px;" class="title"><b><?php echo _clang(MOST); ?>:</b></div>
                    <?php
                    if (count($newsletter_review) > 0) {
                        for ($n = 0; $n < count($newsletter_review); $n++) {
                            ?>
                            <div class="fullwidth_left details mostrecentreviews">
                                <div class="minititle">
                                    <div title="<?php echo $newsletter_review[$n]['rate']; ?>" style="float:left;" data-productid="<?php echo $newsletter_review[$n]['join_newsletter_id']; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $newsletter_review[$n]['rate']; ?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="true" class="rateit rateit9"></div>
                                    <label><?php echo $newsletter_review[$n]["title"] ?></label>
                                </div>
                                <div class="description"><?php echo $newsletter_review[$n]["message"] ?></div>
                                <span><?php echo _clang(PUBLISHED_ON); ?> <?php echo @date('j, F Y', strtotime($newsletter_review[$n]['date'])); ?> <?php echo _clang(BY); ?> <?php echo $newsletter_review[$n]["firstname"] ?></span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php /* ?><?php echo '<pre>'; print_r($newsletter_review);
                      echo '</pre>';?>
                      <div class="fullwidth_left details mostrecentreviews">
                      <div class="minititle">
                      <img src="<?php echo base_url(); ?>assets/img/yellowbgigstar.png"><img src="<?php echo base_url(); ?>assets/img/yellowbgigstar.png">
                      <img src="<?php echo base_url(); ?>assets/img/whitebigstar.png"><img src="<?php echo base_url(); ?>assets/img/whitebigstar.png"><img src="<?php echo base_url(); ?>assets/img/whitebigstar.png">
                      <label>Very weak science</label>
                      </div>
                      <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut<br/>
                      labore et dolore magna aliqua. Ut enim ad minim veniam...<a href="#">Read more</a></div>
                      <span>Published 1 month ago by Sergio A. Rosales</span>
                      </div><?php */ ?>
                <?php }
                ?>
            </div>
        </section>
        </div>

    </section>
    <script type="text/javascript">
        $(document).ready(
                function() {
                    $(".rating_hover").hover(function(e) {
                        if ($(this).children(".rating_popup").is(":visible") == true) {
                            $(this).children(".rating_popup").hide();
                        }
                        else {
                            $(this).children(".rating_popup").show();
                        }
                        //$(this).next().css("display","block");
                    }
                    );
                    $('.hide').hide();
                });
        function show_div() {
            $('.hide').show();
            $('.datelink').hide();
            $('.less').show();
        }
        function hide_div() {
            $('.hide').hide();
            $('.less').hide();
            $('.datelink').show();
        }
    </script>
    <?php include_once("includes/sidebars/newsletter_sidebar.php"); ?>
    <script src="<?php echo site_url('assets/js') ?>/jquery.rateit.js" type="text/javascript"></script>
</section>
</main>