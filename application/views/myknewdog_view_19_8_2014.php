<main>
    <link href="<?php echo site_url('assets/css') ?>/rateit.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script type="text/javascript">
        $(function() {
            $("#ends_on").datepicker();
            $("#ends_on").datepicker("option", "dateFormat", 'yy-mm-dd');
            var currentDate = new Date();
            $("#ends_on").datepicker("setDate", currentDate);
        });
    </script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/file_uploads.js') ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/vpb_script.js') ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/date.format.js') ?>"></script>
    <link href="<?php echo site_url('assets/css') ?>/main.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url('assets/css') ?>/jquery.Jcrop.css" rel="stylesheet" type="text/css" />

    <!-- add scripts -->
    <script src="<?php echo site_url('assets/js') ?>/jquery.Jcrop.js"></script>
    <script src="<?php echo site_url('assets/js') ?>/script.js"></script>

    <?php
    $this->load->model('newsletter_model');
    $this->load->model('user_model');
    $this->load->model('newsletter_language_model');
    $this->load->model('newsletter_keyword_model');
    $this->load->model('schedule_model');
    $ci =
            & get_instance();
    $ci->load->model('subscribe_model');
    $ci->load->model('time_zone_model');
    $user_id =
            $this->session->userdata("user_id");
    $user_all_data =
            $this->user_model->get_user_by_id($user_id);
//echo '<pre>'; print_r($user);
//echo '</pre>';
    $gopremium_p =
            get_type_of_membership_array($user[0]['type_of_membership']);
    $lang = $this->session->userdata('language_shortcode');
    ?>
    <div class="set_errors">
        <?php
        if ($this->session->flashdata('validation_error_messages')) {
            echo $this->session->flashdata('validation_error_messages');
        }
        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {
            //echo "->".$this->session->flashdata("flash_mynl_tab"); 
            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        //echo '<pre>'; print_r($user); die;
        ?>
    </div>
    <section class="knewdog findnewsletter" id="container">
        <section id="knewdog_leftbar">
            <div class="knewdog_leftbar_inner">
                <div id="tabsholder">
                    <ul class="tabs">
                        <li style="line-height:33px;" onclick="display_tabs(this.id)" id="tab_1" ><?php echo _clang(MY_PROFILE); ?></li>
                        <li onclick="display_tabs(this.id)" id="tab_2" ><?php echo _clang(MY_NEWSLETTERS_K); ?></li>
                        <?php
                        if (get_if_free_user('class_free_user') ==
                                'free_user') {
                            $popup =
                                    "popup('manage_schedule_popup_3')";
                        } else {
                            $popup =
                                    "";
                        }
                        ?>
                        <li onclick="display_tabs(this.id);
                            <?php echo $popup; ?>" id="tab_3"><?php echo _clang(MY_SCHEEDULES); ?></li>
                        <li onclick="display_tabs(this.id)" id="tab_4"><?php echo _clang(AC_SETTINGS); ?></li>
                    </ul>

                </div>
                <!--------------------------------------------Section 1 --------------------------------------------------->
                <section class="section" style="display:none;" id="section_1">
                    <?php /* ?> <?php if($user[0]['account_confirmed'] == 'NO'){?>
                      <div class="notes"><?php echo _clang(SYSTEM_MESSAGE); ?></div>
                      <?php }?><?php */ ?>
                    <div id="vasPhoto_uploads_Status" class="profilepicture" style="position:relative;">
                        <div id="view">
                            <?php
                            //echo $user[0]['avatar'];
                            //if(@getimagesize((site_url('uploads/avatar')."/".$user[0]['avatar']))){
                            $sTempFileName =
                                    FCPATH . "uploads/avatar/" . $user[0]['avatar'];
                            if (is_file($sTempFileName)) {
                                ?>
                                <div onclick="remove_avatar();" class="remove_icon"><img style="width:23px;" src="<?php echo site_url('assets/img/list-remove.png') ?>" alt="" /></div>
                                <img style="max-width:161px;" src="<?php echo site_url('uploads/avatar') . "/" . $user[0]['avatar']; ?>" alt="" >
                            <?php } else { ?>
                                <img src="<?php echo base_url(); ?>assets/img/avatarpic.png" alt="">
                            <?php } ?>
                        </div>  
                        <div style="position: absolute; bottom: 4px; text-align: center; left: 45px; color: black;" class="vasplusfile_adds"><span style="cursor:pointer;" onclick="popup('uploadavatar')"><?php echo _clang(CHANGE_PHOTO); ?></span></div>
                          <!--<form style="color: rgb(240, 240, 240); font-size: 13px; position: absolute; text-align: center; bottom: 4px; left: 44px; z-index: 10;" class="ajaxform" method="post" enctype="multipart/form-data" action="<?php //echo site_url('myknewdog/upload_avtar')       ?>" autocomplete="off">
  <div class="vasplusfile_adds"><span><?php //echo _clang(CHANGE_PHOTO);        ?></span><input type="file" name="imagefile" id="photo" style="opacity: 0; z-index: 9999; width: 90px; cursor:pointer; padding: 5px; position: absolute; left: -13px; bottom: 0px;" />
    <input type="hidden" name="do" value="upload"/>
  </div>
  </form>-->
                        <!--<div id='view'></div>-->
                    </div>
                    <div class="profile_detail">
                        <div class="username"><?php echo $user[0]['username']; ?></div>
                        <?php
                        $type_of_membership =
                                get_type_of_membership_txt($user[0]['type_of_membership']);
                        ?>
                        <span><?php echo _clang(LOGGED_AS); ?> <?php echo $type_of_membership; ?> 
                            <?php
//echo "show->".show_go_premium_link();
                            if (show_go_premium_link() ==
                                    true) {
                                ?>
                                <a href="<?php echo site_url('premium-account'); ?>">(<?php echo $gopremium_p['go_premium']; ?>)</a>
                            <?php } ?>
                        </span>
                        <form style="margin-top:10px;" id="profilepicture_detail" class="autosubmit" method="POST" action="./ajax-update.php">
                            <div class="firstname">
                                <label><?php echo _clang(FIRSTNAME); ?>&nbsp;</label> <div><label><?php
                                        echo (!empty($user[0]['firstname']) ? $user[0]['firstname'] . " " . $user[0]['lastname'] : "N/A");
                                        ?></label></div>
                                <span class="editbtn"><span style="cursor:pointer;" onclick="popups_ajax('profile', '1')" ><img src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></span></span>
                            </div>
                            <div class="firstname">
                                <label><?php echo _clang(GENDER_K); ?>&nbsp;</label> <div><label><?php
                                        echo (!empty($user[0]['gender']) ? $user[0]['gender'] : "N/A");
                                        ?></label></div>
                            </div>
                            <div><label><?php echo _clang(COMPANY); ?>&nbsp;</label><div><label><?php
                                        echo (!empty($user[0]['company_name'])) ? $user[0]['company_name'] : "N/A"
                                        ?></label></div></div>
                            <div><label><?php echo _clang(TOWN); ?>&nbsp;</label><div><label><?php
                                        echo (!empty($user[0]['town'])) ? $user[0]['town'] : "N/A";
                                        ?></label></div></div>

                            <div><label><?php echo _clang(ZIPCODE_K); ?>&nbsp;</label><div><label><?php
                                        echo (!empty($user[0]['zip_code'])) ? $user[0]['zip_code'] : "N/A";
                                        ?></label></div></div>
                            <?php
                            //country
                            $country_id =
                                    !empty($user[0]['country']) ? $user[0]['country'] : "";
                            if (!empty($country_id)) {
                                $country =
                                        $this->user_model->get_countries_by_id($country_id);
                                $country =
                                        $country[0]['country_name'];
                            } else {
                                $country =
                                        "N/A";
                            }
                            ?>
                            <div><label><?php echo _clang(COUNTRY_MK); ?>&nbsp;</label><div><label><?php echo $country; ?></label></div></div>

                            <div style="margin-top:15px;">
                                <label><?php echo _clang(EMAIL); ?></label><a href="mailto:<?php echo $user[0]['primary_email']; ?>" style="margin-left:5px;"><?php echo $user[0]['primary_email']; ?></a>
                                <span class="editbtn"><span onclick="popups_ajax('profile', '2')" style=" cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></span></span>
                            </div>
                            <div>

                                <label><?php echo _clang(ADDITIONAL_EMAIL); ?></label>
                                <?php
                                if (show_go_premium_link() ==
                                        true) {
                                    ?>
                                    <?php
                                    if ($user[0]['type_of_membership'] ==
                                            'FREE') {
                                        ?>
                                        <a href="<?php echo site_url('premium-account') ?>" style="margin-left:5px;"><?php echo _clang(GO_PREMIUM_MK); ?></a>
                                    <?php } ?>
                                <?php } ?>
                                <?php
                                if (show_additional_email_link() ==
                                        true) {
                                    $display_additional_email =
                                            $this->additional_email_model->get_additional_email_by_field(array(
                                        "user_id"), array(
                                        $user_id));
                                    //echo '<pre>'; print_r($display_additional_email);
                                    for ($e =
                                    0; $e <
                                            count($display_additional_email); $e++) {
                                        ?>

                                        <div class="additinal_list"><a href="mailto:<?php echo $display_additional_email[$e]['email'] ?>"><?php echo $display_additional_email[$e]['email']; ?></a></div>
                                    <?php } ?>
                                    <span class="editbtn"><span onclick="popups_ajax_additional_email('additional_email', '1')" style=" cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></span></span>
                                <?php } ?>
                            </div>
                            <div style="margin-top:15px;">
                                <label><?php echo _clang(TIME_ZONE); ?>:</label>
                                <?php
                                if (!empty($user_all_data[0]['time_zone'])) {
                                    $user_time_zone = $this->time_zone_model->get_time_zone_by_field(array("time_zone_id"), array($user_all_data[0]['time_zone']));
                                    ?>
                                    <span><?php echo _clang(YOUR_TIME_ZONE); ?> <?php echo $user_time_zone[0]['time_zone']; ?></span>
                                <?php } else { ?>
                                    <span><?php echo _clang(PLEASE_SET); ?></span>	
                                <?php } ?>
                                <span class="editbtn"><span onclick="popups_ajax('profile', '5')" style=" cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></span></span>
                            </div>
                            <div style="margin-top:15px;"><label style="margin-right:5px;"><?php echo _clang(LAST_LOGIN); ?></label><time><?php
//                            echo $a=date('j, F Y',strtotime($this->session->userdata('last_login')));
                                    echo ($this->session->userdata('last_login') != '0000-00-00 00:00:00') ? date('j, F Y', strtotime($this->session->userdata('last_login'))) : "You are logged in first time."
                                    ?></time></div>
                        </form>
                    </div>
                    <article id="knewdog_article">
                        <span style="margin-top:45px; font-size:13px; float:left;">
                            <b style="font-size:14px;"><?php echo _clang(TELL_US); ?></b> <?php echo _clang(RECOMMEND_YOU); ?></span>
                        <div class="laungages"><label><b><?php echo _clang(LANGUAGES_MK); ?></b></label>
                            <div class="laungages_con language_id">
                                <?php
                                if (!empty($user[0]['language_id'])) {
                                    $newsletter_language_ids =
                                            explode(",", $user[0]['language_id']);
                                    for ($i =
                                    0; $i <
                                            count($newsletter_language_ids); $i++) {
                                        $newsletter_language =
                                                $this->newsletter_language_model->get_language_by_id($newsletter_language_ids[$i]);
                                        ?>
                                        <span id="del_<?php echo $newsletter_language_ids[$i] ?>"><?php echo $newsletter_language[0]['language_longform'] ?><a onclick="profile_delete('language_id',<?php echo $newsletter_language_ids[$i] ?>, '<?php echo $user_id ?>')" style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/cancell.png" alt=""></a></span>
                                    <?php } ?>
                                <?php } ?>
                                <span onclick="popups_ajax('profile', '3')" style=" cursor:pointer; font-weight:bold;"><?php echo _clang(ADD_ONE); ?></span>
                            </div>
                        </div>
                        <div class="interests"><label><b><?php echo _clang(INTEREST); ?></b></label>
                            <div class="interests_con user_interests">
                                <?php
                                if (!empty($user[0]['user_interests'])) {
                                    $newsletter_keyword_ids =
                                            explode(",", $user[0]['user_interests']);
                                    //echo '<pre>'; print_r($newsletter_keyword_ids); 
                                    for ($i =
                                    0; $i <
                                            count($newsletter_keyword_ids); $i++) {
                                        $newsletter_keyword =
                                                $this->newsletter_keyword_model->get_keyword_by_id($newsletter_keyword_ids[$i]);
                                        //$this->session->userdata('language_shortcode')
                                        $word =
                                                !empty($newsletter_keyword[0][$this->session->userdata('language_shortcode')]) ? $newsletter_keyword[0][$this->session->userdata('language_shortcode')] : $newsletter_keyword[0]['en'];
                                        ?>
                                        <span id="del_<?php echo $newsletter_keyword_ids[$i] ?>"><?php echo $word ?><a onclick="profile_delete('user_interests',<?php echo $newsletter_keyword_ids[$i] ?>, '<?php echo $user_id ?>')" style="cursor:pointer;"><img src="<?php echo base_url(); ?>assets/img/cancell.png" alt=""></a></span>
                                    <?php } ?>
                                <?php } ?>
                                <span style="cursor:pointer;font-weight:bold;" onclick="popups_ajax('profile', '4')" ><?php echo _clang(ADD_ONE); ?></span>
                            </div>
                        </div>
                    </article>
                </section>
                <!--------------------------------------------Section 2 --------------------------------------------------->
                <section class="section" style="display:none;" id="section_2">
                    <?php if (!empty($user_id)) { ?>
                        <form method="post" action="<?php echo current_url(); ?>" name="mynewsletter_search" id="mynl_newsletter_search">
                            <input type="hidden" name="form" value="section_2" />
                            <div class="findnewsletter_form">

                                <article>
                                    <div class="title"><?php echo _clang(ADVANCED_SEARCH_MK); ?></div>
                                    <div class="fullwidth_input"><input value="<?php echo $mynl_search_string_selected ?>" name="mynl_search_string" type="text"placeholder="<?php echo _clang(FOR_EX_MK); ?>"></div>
                                    <div class="<?php echo get_if_free_user('class_free_user') ?>"> 
                                        <div class="selectgroup">
                                            <div class="<?php echo get_if_free_user('class_free_user_overlay_1') ?>" <?php echo get_if_free_user('advance_search_popup') ?>></div>
                                            <div class="select"><label><?php echo _clang(LANGUAGE_MK); ?></label>
                                                <select name="mynl_language_id">
                                                    <option value=""><?php echo _clang(ALL_MK); ?></option>
                                                    <?php
                                                    for ($l =
                                                    0; $l <
                                                            count($language); $l++) {
                                                        ?>
                                                        <option <?php
                                                        echo ($mynl_selected_language_id ==
                                                        $language[$l]['language_id']) ? 'selected="selected"' : ""
                                                        ?>  value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                            <div class="select"><label><?php echo _clang(CATEGORY_MK); ?></label>
                                                <?php //echo $selected_newsletter_category;     ?>
                                                <select name="mynl_newsletter_category">
                                                    <option  value=""><?php echo _clang(CAT_ALL_MK); ?></option>
                                                    <?php
                                                    for ($c =
                                                    0; $c <
                                                            count($category); $c++) {
                                                        ?>
                                                        <option  <?php
                                                        echo ($mynl_selected_newsletter_category ==
                                                        $category[$c]['en']) ? 'selected="selected"' : ''
                                                        ?> value="<?php echo $category[$c]['en']; ?>"><?php echo $category[$c]['en']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                            <div class="select"><label><?php echo _clang(RATING_MK); ?></label>
                                                <select name="mynl_rating_id">
                                                    <option value=""><?php echo _clang(ALL_MK); ?></option>
                                                    <option <?php
                                                    echo ($mynl_selected_newsletter_rating_id ==
                                                    '1') ? 'selected="selected"' : ''
                                                    ?> value="1">1</option>
                                                    <option <?php
                                                    echo ($mynl_selected_newsletter_rating_id ==
                                                    '2') ? 'selected="selected"' : ''
                                                    ?> value="2">2</option>
                                                    <option <?php
                                                    echo ($mynl_selected_newsletter_rating_id ==
                                                    '3') ? 'selected="selected"' : ''
                                                    ?> value="3">3</option>
                                                    <option <?php
                                                    echo ($mynl_selected_newsletter_rating_id ==
                                                    '4') ? 'selected="selected"' : ''
                                                    ?> value="4">4</option>
                                                    <option <?php
                                                    echo ($mynl_selected_newsletter_rating_id ==
                                                    '5') ? 'selected="selected"' : ''
                                                    ?> value="5">5</option>
                                                </select></div>
                                        </div>
                                        <div class="selectgroup">
                                            <div class="<?php echo get_if_free_user('class_free_user_overlay_2') ?>" <?php echo get_if_free_user('advance_search_popup') ?>></div>
                                            <div class="select"><label><?php echo _clang(LOCATION_MK); ?></label>
                                                <select name="mynl_author_country">
                                                    <option value=""><?php echo _clang(COUNTRY_HOLDER); ?></option>
                                                    <?php
                                                    for ($l =
                                                    0; $l <
                                                            count($countries); $l++) {
                                                        ?>
                                                        <option <?php
                                                        echo $mynl_selected_author_country ==
                                                        $countries[$l]['id'] ? 'selected="selected"' : ''
                                                        ?>  value="<?php echo $countries[$l]['id'] ?>"><?php echo $countries[$l]['country_name'] ?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                            <div class="select"><label></label><input style="padding:2.5%" placeholder="<?php echo _clang(ZIPCODE_MK); ?>" type="text" value="<?php echo $mynl_selected_author_zipcode; ?>" name="mynl_author_zipcode" /></div>
                                            <div class="select cancel_button"><label></label>
                                                <div style="float:right;" class="summary_cancel">
                                                    <a class="cancle" href="<?php echo site_url('myknewdog') ?>"><?php echo _clang(CANCEL_MK); ?></a>
                                                    <!--<input class="cancle" type="reset" value="cancle" />-->
                                                    <!--<button class="btnsearch" name="" type="submit"><img src="<?php echo base_url(); ?>assets/img/search.png"></button>-->
                                                    <input class="btn btn_main" style="font-size: 14px; margin-top: 1px; padding: 3px 5px;" value="<?php echo _clang(SEARCH_BUTTON) ?>"name="" type="submit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </article>
                            </div>
                            <article>
                                <div class="pager">
                                    <?php
                                    if ($mynl_page ==
                                            0) {
                                        $mynl_page =
                                                1;
                                    } else {
                                        $mynl_page =
                                                $mynl_page;
                                    }
                                    //$total = count($newsletter);
                                    //echo $result_show_count1 = ($limit_end  + $limit_start);
                                    //echo ($page * $limit_start)."=".$total_rows;
                                    if ($mynl_total_rows <=
                                            ($mynl_page *
                                            $mynl_limit_start)) {
                                        $mynl_result_show_count =
                                                $mynl_total_rows;
                                    } else {
                                        $mynl_result_show_count =
                                                $mynl_page *
                                                $mynl_limit_start;
                                    }
                                    /* if($total > $total_rows){ $result_total = $total;}else{ $result_total = $total_rows;} */
                                    ?>
                                    <div class="result"><?php
                                        echo _clang(RESULT_MK) . " " . ($mynl_limit_end +
                                        1) . "-" . ($mynl_result_show_count) . " " . _clang(OUT_OF_MK) . " " . $mynl_total_rows
                                        ?><!--Result 1-10 out of 986--></div>
                                    <div class="sortby">
                                        <label><?php echo _clang(SORT_BY_MK); ?></label>
                                        <?php //echo $order;  ?>
                                        <select name="mynl_order">
                                            <option <?php
                                            echo $mynl_order ==
                                            'newsletter_name' ? 'selected="selected"' : ""
                                            ?> value="newsletter_name"><?php echo _clang(N_TITLE_MK); ?></option>
                                            <option <?php
                                            echo $mynl_order ==
                                            'author_name' ? 'selected="selected"' : ""
                                            ?> value="author_name"><?php echo _clang(N_AUTHOR_MK); ?></option>
                                            <option <?php
                                            echo $mynl_order ==
                                            'newsletter_id' ? 'selected="selected"' : ""
                                            ?> value="newsletter_id"><?php echo _clang(N_NEWEST_MK); ?></option>
                                        </select>
                                    </div>
                                    <!--<div class="view"><label>View:</label><a href="#"><img src="<?php echo base_url(); ?>assets/img/view.png"></a></div>-->
                                </div>
                            </article>
                        </form>
                        <article style="clear:both;" class="reviewlist">
                            <?php
                            for ($i =
                            0; $i <
                                    count($mynl_newsletter); $i++) {
                                ?>
                                <div class="dashreview">
                                    <div class="review_img"><a href="<?php
                                        echo site_url('newsletter/specific') . "/" . url_title($mynl_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $mynl_newsletter[$i]['newsletter_id']
                                        ?>">
                                                                   <?php if (!empty($mynl_newsletter[$i]['screenshot'])) { ?>
                                                <img style="width:79px;" src="<?php echo base_url(); ?>uploads/<?php echo $mynl_newsletter[$i]['screenshot']; ?>" alt=""></a></div>
                                    <?php } else { ?>
                                        <img style="width:79px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png" alt=""></a></div>
                                <?php } ?>
                                <div class="review_detail">
                                    <a class="name" href="<?php
                                    echo site_url('newsletter/specific') . "/" . create_slug($mynl_newsletter[$i]['newsletter_name'], 100) . "/" . $mynl_newsletter[$i]['newsletter_id']
                                    ?>"><?php echo $mynl_newsletter[$i]['newsletter_name'] ?></a><br/>
                                    <label style="color:#808080; float:left;"><?php echo _clang(AUTHOR_MK); ?> </label><span style="float: left; width: 315px;"><?php echo $mynl_newsletter[$i]['author_name'] ?></span>
                                    <?php
                                    $get_rate =
                                            $this->newsletter_model->get_rate_by_user($mynl_newsletter[$i]['newsletter_id']);

                                    include("rating/rating_calculation.php");


                                    $user_id =
                                            $this->session->userdata("user_id");
                                    //echo "user_id->".$newsletter[$i]["user_id"];
                                    $wherefield =
                                            array();
                                    $wherevalue =
                                            array();

                                    $wherefield =
                                            array(
                                                "join_newsletter_id");
                                    $wherevalue =
                                            array(
                                                $mynl_newsletter[$i]["newsletter_id"]);
                                    $get_news_user_id =
                                            $this->newsletter_model->get_rate_by_field($wherefield, $wherevalue);
                                    /* if(!empty($user_id)){
                                      if(count($get_news_user_id) > 0){
                                      $readonly = "true";
                                      }else{
                                      $readonly = "false";
                                      }
                                      }else{
                                      $readonly = "true";
                                      } */
                                    $readonly =
                                            "true";

                                    //$data['get_rate'] = $get_rate;	
                                    ?>
                                    <span style="float:left; position:relative" class="rating_hover">
                                        <div style="display: inline-block; vertical-align: text-bottom;" data-productid="<?php echo $mynl_newsletter[$i]['newsletter_id']; ?>" title="<?php echo $avg_round; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $avg_round; ?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="<?php echo $readonly ?>" class="rateit" id="rateit9"></div>

                                        <?php
                                        if (count($get_news_user_id) >
                                                0) {
                                            ?>
                                            <img style="margin-left: 5px; vertical-align: text-top; display: inline-block;" src="<?php echo base_url(); ?>assets/img/review_down.png" alt="">
                                        <?php } ?>
                                        <a style="text-decoration: none; margin-left: 3px; display: inline-block; vertical-align: top;" href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>">(<?php
                                            echo (!empty($total_user_rate)) ? $total_user_rate : "0";
                                            ?>)</a>
                                        <?php
                                        if (count($get_news_user_id) >
                                                0) {
                                            ?>
                                            <div  style="left:0; top:20px;"   class="rating_popup">
                                                <?php
                                                $popupcss =
                                                        "style='float:none; width:100%;'";
                                                ?>
                                                <?php include("rating/rating_view.php"); ?>
                                                <a href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>"><?php echo _clang(SEE_ALL_MK); ?> <?php
                                                    echo (!empty($total_user_rate)) ? $total_user_rate : "0";
                                                    ?> <?php echo _clang(CUSTOMER_REVIEW_MK); ?></a>
                                            </div>
                                        <?php } ?>
                                    </span>

                                    <br/>
                                    <div class="description">
                                        <?php
                                        echo substr(strip_tags($mynl_newsletter[$i]['description']), 0, 100);
                                        ?>
                                    </div>
                                    <?php
                                    $where_s_field_2 =
                                            array(
                                                's_newsletter_id');
                                    $where_s_value_2 =
                                            array(
                                                $mynl_newsletter[$i]['newsletter_id']);
                                    $subscribed_2 =
                                            $this->subscribe_model->get_subscribe('', '', '', '', '', $where_s_field_2, $where_s_value_2);
                                    $count_subscribed =
                                            count($subscribed_2);
                                    ?>
                                    <label style="color:#808080;"><?php echo $count_subscribed; ?> <?php echo _clang(SUB_LANGUAGE_MK); ?> <?php
                                        echo (!empty($mynl_newsletter[$i]['newsletter_language']) ? $mynl_newsletter[$i]['newsletter_language'] : "N/A")
                                        ?></label> 
                                </div>

                                                                <!--<div class="review_subscribe"><img src="<?php echo base_url(); ?>assets/img/evaluate.png" class="evaluate"><img src="<?php echo base_url(); ?>assets/img/unsubscribe.png"></div>-->

                                <div class="review_subscribe">
                                    <?php
                                    if (!empty($user_id)) {

                                        $where_Sfield =
                                                array();
                                        $where_Svalue =
                                                array();

                                        $where_Sfield =
                                                array(
                                                    's_newsletter_id',
                                                    's_user_id');
                                        $where_Svalue =
                                                array(
                                                    $mynl_newsletter[$i]['newsletter_id'],
                                                    $user_id);
                                        $subscribe =
                                                $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_Sfield, $where_Svalue);

                                        if (count($subscribe) >
                                                0) {
                                            ?>
                                            <img style="cursor:pointer; float:none;" onclick="popups_ajax_unsubscribe('unsubscribe', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" src="<?php echo base_url(); ?>assets/img/unsubscribe.png" alt="">
                                            <label onclick="popups_ajax_unsubscribe('unsubscribe', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" style="color: #9a7f82; cursor:pointer; float: right;font-size: 11px;font-weight: bold;margin: -6px 84px;"><?php echo _clang(UNSUBSCRIBE_BUTTON) ?></label>
                                            <a href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>"><img src="<?php echo base_url(); ?>assets/img/evaluate.png" class="evaluate" alt="">
                                                <?php
                                                $user_id =
                                                        $this->session->userdata("user_id");
                                                //echo "user_id->".$newsletter[$i]["user_id"];
                                                $wherefield =
                                                        array(
                                                            "join_newsletter_id",
                                                            "join_user_id");
                                                $wherevalue =
                                                        array(
                                                            $mynl_newsletter[$i]["newsletter_id"],
                                                            $user_id);
                                                $get_news_user_id =
                                                        $this->newsletter_model->get_rate_by_field($wherefield, $wherevalue);
                                                if ($get_news_user_id ==
                                                        true) {
                                                    echo '<span style="float: right; color: rgb(128, 128, 128); font-size: 11px; margin-top: -6px; margin-right: 42px;">Edit</span>';
                                                }
                                                ?>
                                                <label style="color: rgb(154, 127, 130); float: right; font-size: 11px; font-weight: bold; margin: -2px 26px;"><?php echo _clang(EVALUATE_BUTTON) ?></label>
                                            </a>
                                            <!--<span style="float: right; margin-top: 20px; text-align: center; color:#808080; font-size: 11px;">
                                        You are already subscribed<br>Go to â€?<u>My Newsletters</u>â€?<br>to manage<br>your subscriptions.</span>-->
                                        <?php } else { ?>
                                            <img onclick="popups_ajax('subscribe_1', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" src="<?php echo base_url(); ?>assets/img/subscribe.png" alt="">
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- Schedule for newsletters-->
                                <?php
                                //$this->load->model('subscribe_model');
                                $where_s_field =
                                        array(
                                            's_user_id',
                                            's_newsletter_id');
                                $where_s_value =
                                        array(
                                            $user_id,
                                            $mynl_newsletter[$i]['newsletter_id']);
                                $subscribed_1 =
                                        $this->subscribe_model->get_subscribe('', '', '', '', '', $where_s_field, $where_s_value);
                                //echo "schedule_id->".$subscribed_1[0]['schedule_id'];
                                if ($subscribed_1[0]['schedule_id'] !=
                                        0) {

                                    $get_schedule_by_id =
                                            $this->schedule_model->get_schedule_by_id($subscribed_1[0]['schedule_id']);
                                    //echo '<pre>'; print_r($get_schedule_by_id);
                                    //echo '</pre>';
                                    if ($get_schedule_by_id[0]['sending'] == 'Daily') {
                                        $senddata = "day(s)";
                                    } else if ($get_schedule_by_id[0]['sending'] == "Weekly") {
                                        $senddata = "week(s)";
                                    } else if ($get_schedule_by_id[0]['sending'] == "Monthly") {
                                        $senddata = "month(s)";
                                    }
                                    //if(every){
                                    if ($get_schedule_by_id[0]['every'] == 'last_day') {
                                        $every_temp = "last month";
                                    } else {
                                        $every_temp = $get_schedule_by_id[0]['every'];
                                    }
                                    $every = "every " . $every_temp . " " . $senddata;
                                    // $every =
                                    //($get_schedule_by_id[0]['every'])
                                    // ? "every " . $get_schedule_by_id[0]['every'] . " Week"
                                    // : "";
                                    $week0 =
                                            ($get_schedule_by_id[0]['weeks_on']) ? "on " . $get_schedule_by_id[0]['weeks_on'] : "";
                                    ?>
                                    <div class="sendingscheduale"><b><?php echo _clang(SENDING_SCHEDULE_MK); ?></b><label><?php
                                            echo $get_schedule_by_id[0]['sending'] . " " . $every . " " . $week0 . " at " . date("H.i", strtotime($get_schedule_by_id[0]['at'] . ":00:00"))
                                            ?></label></div><div class="sendingemail"><b><?php echo _clang(SENDING_MAIL_MK); ?></b><label><?php echo $get_schedule_by_id[0]['sending_to_email'] ?></label><img style="cursor:pointer;" onclick="popups_ajax_schedule('schedule', '<?php echo $get_schedule_by_id[0]['schedule_id'] ?>')" src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></div>
                                            <?php } ?>



                                </div>
                            <?php } ?>   
                        </article>
                        <?php echo '<div class="pagination">' . $mynl_link . '</div>'; ?>
                    <?php } else { ?>
                        <div class="findnewsletter_form">
                            <h1 style="clear: both; color: black; text-align: center; margin-top: 64px;"><?php echo _clang(PLEASE); ?> <a style="cursor:pointer;" onclick="popup('signin')"><?php echo _clang(LOGIN_MK); ?></a> <?php echo _clang(MY_NEWSLETTERS_MK); ?></h1>  
                        </div>
                    <?php } ?>

                </section>
                <!--------------------------------------------Section 3 --------------------------------------------------->           
                <section class="section" style="display:none;" id="section_3">
                    <div class="myscheduale_form site" style="height: auto">
                        <div class="<?php echo get_if_free_user('class_free_user') ?>">
                            <div class="<?php echo get_if_free_user('class_free_user_overlay_5') ?>" <?php echo get_if_free_user('manage_schedule_popup_3') ?>></div>
                            <form id="schedule_form" name="schedule_form" method="post" action="<?php echo site_url('myknewdog/schedule') ?>">
                                  <!--<input type="hidden" value="schedule" name="schedule" />-->
                                <input type="hidden" name="form" value="section_3" />
                                <div style="width:98%" class="setnewscheduale_title"><?php echo _clang(NEW_SCHEDULE); ?></div>
                                <?php
                                if (!empty($user_all_data[0]['time_zone'])) {
                                    $user_time_zone = $this->time_zone_model->get_time_zone_by_field(array("time_zone_id"), array($user_all_data[0]['time_zone']));
                                    ?>
                                    <div style="width: 98%; font-size: 13px; margin-top: 2px;" class="setnewscheduale_title"><?php echo _clang(YOUR_TIME_ZONE); ?> <?php echo $user_time_zone[0]['time_zone'] ?>.</div>
                                <?php } else { ?>
                                    <div style="width: 98%; font-size: 13px; margin-top: 2px;" class="setnewscheduale_title"><?php echo _clang(PLEASE_SET_YOUR); ?> <a onclick="display_tabs('tab_1')" href="javascript:void(0)"><?php echo _clang(MY_PROFILE); ?></a>.</div>
                                <?php } ?>
                                <?php /* ?> <div class="sendingtoemail">
                                  <label>Set Time Zone:</label>
                                  <select onchange="schedule_summary('site')" style="float:left;" name="time_zone">
                                  <option>Select Time zone</option>
                                  <?php
                                  for ($t =
                                  0;
                                  $t <
                                  count($time_zone);
                                  $t++) {
                                  ?>
                                  <option <?php
                                  echo ($user_all_data[0]['time_zone'] ==
                                  $time_zone[$t]['time_zone_id'])
                                  ? "selected='selected'"
                                  : "";
                                  ?> value="<?php echo $time_zone[$t]['time_zone_id'] ?>">(UTC <?php echo $time_zone[$t]['time_zone_time']?>) <?php echo $time_zone[$t]['time_zone'] ?></option>
                                  <?php } ?>
                                  </select>
                                  </div><?php */ ?>
                                <div class="sendingtoemail">
                                    <label><?php echo _clang(EMAIL_MK); ?></label>

                                    <input type="hidden" name="sd_user_id" value="<?php echo $user_id ?>" />
                                    <select onchange="schedule_summary('site')" style="float:left;" name="sending_to_email">
                                        <option><?php echo _clang(CHOSE_MAIL); ?></option>
                                        <option value="<?php echo $user[0]['primary_email'] ?>"><?php echo $user[0]['primary_email'] ?></option>
                                        <?php
                                        for ($e = 0; $e < count($additional_email); $e++) {
                                            ?>
                                            <option value="<?php echo $additional_email[$e]['email'] ?>"><?php echo $additional_email[$e]['email'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                    if (show_go_premium_link() ==
                                            true) {
                                        ?>
                                        <?php
                                        if ($user[0]['type_of_membership'] ==
                                                'FREE') {
                                            ?>
                                            <a href="<?php echo site_url('premium-account'); ?>"><?php echo _clang(GO_MK); ?></a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <section id="sendingtoemail_type">
                                    <div class="sending row site">
                                        <div class="heading"><?php echo _clang(SENDING_MK); ?>:</div>
                                        <p>
                                            <label>
                                                <input onclick="schedule_set(this.id, 'site');
            schedule_summary('site');" type="radio" id="Daily"  value="Daily" name="sending"><?php echo _clang(DAILY); ?></label>
                                            <br>
                                            <label>
                                                <input onclick="schedule_set(this.id, 'site');
            schedule_summary('site');" type="radio" id="Weekly"  value="Weekly" name="sending"><?php echo _clang(WEEKLY); ?></label>
                                            <br>
                                            <label>
                                                <input onclick="schedule_set(this.id, 'site');
            schedule_summary('site');" type="radio" id="Monthly" value="Monthly" name="sending"><?php echo _clang(MONTHLY); ?></label>
                                            <br>
                                            <?php /* ?><label>
                                              <input onclick="schedule_set(this.id, 'site');
                                              schedule_summary('site');" type="radio" id="Yearly"  value="Yearly" name="sending"><?php echo _clang(YEARLY); ?></label><?php */ ?>
                                            <br>
                                        </p>

                                    </div>
                                    <div class="everyweekson row">
                                        <div style="" class="heading"><label style="display:none;" class="head_lable"><?php echo _clang(EVERY); ?></label>
                                            <span class="every_fields" id="every_field"></span>
                                            <!--<span style="display:none" class="every_fields" id="every_field_Weekly">
                                            <select disabled="disabled"onchange="schedule_summary('site');" style="width:90px;" id="every" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select> Week(s)
                                            </span>
                                            <span style="display:none" class="every_fields" id="every_field_Monthly">
                                            <select disabled="disabled" onchange="schedule_summary('site');" style="width:90px;" id="every" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select> Months(s)
                                            </span>-->

                                        </div>
                                        <div class="weeks_on"> 
                                            <div style="float:left;">
                                                <div><input type="checkbox" onclick="schedule_summary('site');" value="Monday" name="weeks_on[]"><label><?php echo _clang(MONDAY); ?></label></div>
                                                <div><input type="checkbox" onclick="schedule_summary('site');" value="Tuesday" name="weeks_on[]"><label><?php echo _clang(TUESDAY); ?></label></div>
                                                <div><input type="checkbox" onclick="schedule_summary('site');" value="Wednesday" name="weeks_on[]"><label><?php echo _clang(WEDNESDAY); ?></label></div>
                                                <div><input type="checkbox" onclick="schedule_summary('site');" value="Thursday" name="weeks_on[]"><label><?php echo _clang(THURSDAY); ?></label></div>
                                            </div>
                                            <div style="float:right;">
                                                <div><input type="checkbox" onclick="schedule_summary('site');" value="Friday" name="weeks_on[]"><label><?php echo _clang(FRIDAY); ?></label></div>
                                                <div><input type="checkbox" onclick="schedule_summary('site');" value="Saturday" name="weeks_on[]"><label><?php echo _clang(SATURDAY); ?></label></div>
                                                <div><input type="checkbox" onclick="schedule_summary('site');" value="Sunday" name="weeks_on[]"><label><?php echo _clang(SUNDAY); ?></label></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time row">
                                        <div class="heading"><label><?php echo " " . _clang(AT); ?></label>

                                            <select onchange="schedule_summary('site');" name="at">
                                                <!--<option>12:00</option>
                                                <option>11:00</option>
                                                <option>10:00</option>-->
                                                <?php
                                                for ($i = 0; $i < 24; $i++) {
                                                    echo '<option value="' . $i . '">' . date("H.i", strtotime($i . ":00:00")) . '</option>';
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <label><?php echo _clang(ENDS); ?></label>

                                        <p style="margin-left:63px;">
                                            <label style="width:185px;">
                                                <input checked="checked" onclick="schedule_summary('site');" type="radio" id="" value="Never" name="ends">
                                                <label><?php echo _clang(NEVER); ?></label>
                                            </label>
                                            <br>
                                            <label style="width:185px;">
                                                <label for="ends_after">
                                                    <input onclick="schedule_summary('site');" type="radio" id="" value="after" name="ends" id="ends">
                                                </label>
                                                <label><?php echo _clang(AFTER); ?></label>
                                                <label for="ends"><input onkeyup="schedule_summary('site');" onblur="schedule_summary('site');" type="text" placeholder="12" name="ends_after" id="ends_after" class="occuranes"></label>
                                                <label><?php echo _clang(OCCURRENCES); ?></label>
                                            </label>
                                            <br>
                                            <label style="width:185px;">
                                                <label for="ends_on"><input onclick="schedule_summary('site');" type="radio" id="on" value="on" name="ends"></label>
                                                <label><?php echo _clang(ON); ?></label>
                                                <label for="on"><input style="padding-left:3px;" onchange="schedule_summary('site');" id="ends_on" type="text" value="<?php //echo date('Y-m-d');                           ?>" placeholder="2014-05-16"  name="ends_on" class="occuranes_12172014"></label>
                                            </label>
                                            <br>
                                        </p>

                                    </div>
                                </section>
                                <section id="summary">
                                    <div class="summary_title"><?php echo _clang(SUMMARY); ?></div>
                                    <div class="summary_emailid" style="width: 449px; float: left;"><b id="schedule_summary"><!--Weekly on Wednesday at 20:00 to username@dmail.com-->&nbsp;</b></div>
                                    <div class="summary_cancel">
                                        <input class="btn btn_main" style="font-size: 14px; float: right; margin-right: 30px; padding: 3px 20px;" value="<?php echo _clang(OK_BUTTON) ?>" type="submit">
                                        <!--<img src="<?php echo base_url(); ?>assets/img/summary_ok.png">-->
                                        <a onclick="submitform('gotoschedule')" href="javascript:void(0)"><?php echo _clang(CANCEL_MK); ?></a></div>

                                </section>
                            </form>

                            <form id="gotoschedule" action="<?php echo site_url('myknewdog'); ?>" method="post">
                                <input type="hidden" name="form" value="section_3" /> 
                            </form>
                        </div>
                    </div>
                    <section id="yourscheduales">
                        <div class="yourscheduales_title"><?php echo _clang(SCHEDULES); ?></div>
                        <div class="yourscheduales_list">
                            <?php
                            if (get_if_free_user('class_free_user') !=
                                    'free_user') {
                                for ($i = 0; $i < count($schedule); $i++) {
                                    $sending_value = $schedule[$i]['sending'];
                                    $ending = $schedule[$i]['ends'];

                                    $sending_content = $this->user_model->get_translate_languages('en', array("'$sending_value'"));
                                    $ending_content = $this->user_model->get_translate_languages('en', array("'$ending'"));

                                    if (!empty($schedule[$i]['weeks_on'])) {
                                        $weeks_on_d_remove_comma = str_replace(',', ' ', $schedule[$i]['weeks_on']);
                                        $weeks_on_d_t = explode(" ", $weeks_on_d_remove_comma);
                                        $main_weeks_on_d_t = "'" . implode("','", $weeks_on_d_t) . "'";
                                        $weeks_on_d_t_one = $this->user_model->get_translate_languages('en', array("$main_weeks_on_d_t"));
                                        $days_value = "";

                                        $weeks_on_d_t1 = array();
                                        for ($w = 0; $w < count($weeks_on_d_t_one); $w++) {
                                            if ($lang == 'de') {
                                                $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['de'];
                                            } elseif ($lang == 'fr') {
                                                $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['fr'];
                                            } else {
                                                $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['en'];
                                            }
                                        }
                                        $days_value = implode(", ", $weeks_on_d_t1);
                                    }



                                    if ($lang == 'de') {
                                        $final_sending_content = $sending_content[0]['de'];
                                        $after_keyword_content = $ending_content[0]['de'];
                                    } elseif ($lang == 'fr') {
                                        $final_sending_content = $sending_content[0]['fr'];
                                        $after_keyword_content = $ending_content[0]['fr'];
                                    } else {
                                        $final_sending_content = $sending_content[0]['en'];
                                        $after_keyword_content = $ending_content[0]['en'];
                                    }
                                    ?>
                                    <div id="delete_<?php echo $schedule[$i]['schedule_id'] ?>">
                                        <label><span><?php
                                                echo ($i + 1);
                                                ?>)</span><div style="display: inline-block; width: 510px;"> <?php echo $final_sending_content; ?> <?php
                                                if ($schedule[$i]['sending'] == 'Daily') {
                                                    $senddata = _clang(DAYS_ON);
                                                } else if ($schedule[$i]['sending'] == "Weekly") {
                                                    $senddata = _clang(WEEK_ON);
                                                } else if ($schedule[$i]['sending'] == "Monthly") {

                                                    $senddata = _clang(MONTH_ON);
                                                }

                                                if ($schedule[$i]['every'] == 'last_day') {
                                                    $every_temp = "last month";
                                                } else {
                                                    $every_temp = $schedule[$i]['every'];
                                                }
                                                echo $every_d = _clang(EVERY) . " " . $every_temp . " " . $senddata;
                                                ?> 
                                                <?php
                                                echo ($schedule[$i]['weeks_on']) ? _clang(ON) . " " . $days_value : " "
                                                ?> <?php echo _clang(AT) ?><?php
                                                echo " " . date("H.i", strtotime($schedule[$i]['at'] . ":00:00"))
                                                ?> to <?php echo $schedule[$i]['sending_to_email'] ?>
                                                    <?php
                                                    if ($schedule[$i]['ends'] == "Never") {
                                                        $ends_in = _clang(ENDS) . " " . $after_keyword_content;
                                                    } else if ($schedule[$i]['ends'] == "after") {
                                                        $ends_in = _clang(ENDS) . " " . $after_keyword_content . " " . $schedule[$i]['ends_after'] . " " . _clang(OCCURRENCES);
                                                    } else if ($schedule[$i]['ends'] == "on") {
                                                        $ends_in = _clang(ENDS) . " " . $after_keyword_content . " " . $schedule[$i]['ends_on'];
                                                    }
                                                    echo $ends_in;
                                                    ?>   
                                            </div></label>
                                        <span class="editbtn" style="width:50px;"><a title="Edit schedule" style="margin-right:8px;" onclick="popups_ajax_schedule('schedule', '<?php echo $schedule[$i]['schedule_id'] ?>')" href="javascript:void(0)"><img src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></a><a title="Delete schedule" onclick="popups_ajax_schedule_delete('delete_schedule', '<?php echo $schedule[$i]['schedule_id'] ?>')" href="javascript:void(0)"><img src="<?php echo base_url(); ?>assets/img/wrong.png" alt=""></a></span>
                                        <?php /* ?> <form id="gotoschedule_<?php echo $i?>" action="<?php echo site_url('myknewdog');?>" method="post">
                                          <input type="hidden" name="form" value="section_3" />
                                          <input type="hidden" name="schedule_id" value="<?php echo $schedule[$i]['schedule_id']?>" />
                                          </form><?php */ ?>

                                    </div>
                                    <?php
                                }
                                if (show_go_premium_link() ==
                                        true) {
                                    ?>
                                    <div style="margin-top:15px;"><label><?php echo _clang(SET_UP_SCHEDULE); ?><a style="text-align:center;" href="<?php echo site_url('premium-account'); ?>"><?php echo _clang(GO_XXL); ?></a></label></div>
                                <?php } ?>
                                <?php
                            } else {
                                if (show_go_premium_link() ==
                                        true) {
                                    ?>
                                    <a style="text-align:center;" href="<?php echo site_url('premium-account'); ?>"><?php echo _clang(RECIEVE); ?></a>
                                    <?php
                                }
                            }
                            ?>
                            <!-- <div class="addmorecheduales"><a href="#">Add more Schedules!</a></div>-->
                        </div>
                    </section>
                </section>
                <!--------------------------------------------Section 4 --------------------------------------------------->           
                <section class="section" style="display:none;" id="section_4">
                    <div class="accountsetting">

                        <div style="margin-top:15px;" class="login_profile">
                            <div class="accountsetting_title"><?php echo _clang(LOGIN_DATE); ?></div>
                            <div><label><?php echo _clang(USER_MK); ?></label><?php echo $user[0]['username'] ?><span style="color:#808080;"> <?php echo _clang(CANT_CHANGE); ?></span></div>
                            <div><label><?php echo _clang(PASSWORD); ?></label>********<span style="float:right;"><a onclick="popups_ajax('account_settings', '1')" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></a></span></div>
                            <div><label style="height:45px;"><?php echo _clang(SYSTEM_LANGUAGE); ?></label><?php echo _clang(IN_WHICH); ?><span style="float:right;"><a onclick="popups_ajax('account_settings', '2')" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></a></span>
                                <br><label><?php echo $user[0]['language_longform']; ?></label></div>
                        </div>

                        <div class="login_profile">
                            <div class="accountsetting_title"><?php echo _clang(PRIVACY); ?></div>
                            <div>
                                <?php
                                if ($this->session->userdata("type_of_membership") ==
                                        "FREE") {
                                    $onclick_username_only =
                                            "popup('for_premium_memebers_only')";
                                    $onclick_privacy =
                                            "popup('for_premium_memebers_only')";
                                    $onclick_add =
                                            "popup('for_premium_memebers_only')";
                                    $onclick_adult =
                                            "popup('for_premium_memebers_only')";
                                } else {
                                    $onclick_username_only =
                                            "update_user('" . $user_id . "','username_only',this.id)";
                                    $onclick_privacy =
                                            "update_user('" . $user_id . "','privacy_settings',this.id)";
                                    $onclick_add =
                                            "update_user('" . $user_id . "','no_ads',this.id)";
                                    $onclick_adult =
                                            "update_user('" . $user_id . "','adult_content',this.id)";
                                }
                                ?>
                                <label style="min-height:70px;"><?php echo _clang(SHOW_MY); ?></label><a id="username_only" onclick="<?php echo $onclick_username_only ?>" href="javascript:void(0)"><img src="<?php echo base_url(); ?>assets/img/true.png" alt=""></a><?php echo _clang(USERNAME_ONLY); ?><br>

  <!--<a href="#"><img src="<?php echo base_url(); ?>assets/img/wrong.png"></a>my real name,address and profile photo<br>-->

                                <a id="privacy_settings" onclick="<?php echo $onclick_privacy ?>" href="javascript:void(0)" style="text-decoration:none">
                                    <?php
                                    if ($user[0]['privacy_settings'] ==
                                            "YES") {
                                        ?>
                                        <img src="<?php echo base_url(); ?>assets/img/true.png" alt="">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url(); ?>assets/img/wrong.png" alt="">
                                    <?php } ?></a><?php echo _clang(MY_REAL); ?>
                                <?php
                                if (show_go_premium_link() ==
                                        true) {
                                    ?>
                                    <?php
                                    if ($user[0]['type_of_membership'] ==
                                            'FREE') {
                                        ?>
                                        <span style="color:#808080;"> <?php echo _clang(FOR_PREMIUM); ?> <a href="<?php echo site_url('premium-account') ?>"><?php echo _clang(GO_PRE_MK); ?></a>)</span><br>
                                    <?php } ?>
                                <?php } ?>

<!-- <a href="#"><img src="<?php echo base_url(); ?>assets/img/true.png"></a>I'd like to receive HTML e-mails.-->
                            </div>
                            <div>
                                <label><?php echo _clang(ADVERTISEMENT); ?></label>

                                <a id="no_ads" onclick="<?php echo $onclick_add ?>" href="javascript:void(0)" style="text-decoration:none">
                                    <?php
                                    if ($user[0]['no_ads'] ==
                                            "YES") {
                                        ?>
                                        <img src="<?php echo base_url(); ?>assets/img/true.png" alt="">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url(); ?>assets/img/wrong.png" alt="">
                                    <?php } ?></a><?php echo _clang(DONT_SEND); ?>
                                <?php
                                if (show_go_premium_link() ==
                                        true) {
                                    ?>
                                    <?php
                                    if ($user[0]['type_of_membership'] ==
                                            'FREE') {
                                        ?>
                                        <span style="color:#808080;"> <?php echo _clang(FOR_PREMIUM); ?> <a href="<?php echo site_url('premium-account') ?>"><?php echo _clang(GO_PRE_MK); ?></a>)</span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div><label><?php echo _clang(ADULT_CONTENT); ?>:</label>

                                <a id="adult_content"  onclick="<?php echo $onclick_adult ?>" style="text-decoration:none;" href="javascript:void(0)">		
                                    <?php
                                    if ($user[0]['adult_content'] ==
                                            "NO") {
                                        ?> 
                                        <img src="<?php echo base_url(); ?>assets/img/wrong.png" alt="">
                                    <?php } else { ?>
                                        <img  src="<?php echo base_url(); ?>assets/img/true.png" alt="">
                                    <?php } ?>
                                </a><?php echo _clang(LIKE_TO); ?>
                                <?php
                                if (show_go_premium_link() ==
                                        true) {
                                    ?>
                                    <?php
                                    if ($user[0]['type_of_membership'] ==
                                            'FREE') {
                                        ?>
                                        <span style="color:#808080;"> <?php echo _clang(FOR_PREMIUM); ?> <a href="<?php echo site_url('premium-account') ?>"><?php echo _clang(GO_PRE_MK); ?></a>)</span>
                                    <?php } ?>
                                <?php } ?> 

                            </div>

                        </div>

                        <div class="login_profile">
                            <div class="accountsetting_title"><?php echo _clang(INVOICES); ?></div>
                            <div>
                                <label style="min-height:129px;"><?php echo _clang(INVOICE_ADDRESS); ?>:</label>
                                <?php
                                if ($this->session->userdata("type_of_membership") ==
                                        'FREE' ||
                                        $this->session->userdata("type_of_membership") ==
                                        'PRE1') {
                                    $firstname =
                                            $user[0]['firstname'];
                                    $lastname =
                                            $user[0]['lastname'];
                                    $company_name =
                                            $user[0]['company_name'];
                                    $town =
                                            $user[0]['town'];
                                    $zip_code =
                                            $user[0]['zip_code'];
                                    //country
                                    $country_id =
                                            !empty($user[0]['country']) ? $user[0]['country'] : "";
                                    if (!empty($country_id)) {
                                        $country =
                                                $this->user_model->get_countries_by_id($country_id);
                                        $country =
                                                $country[0]['country_name'];
                                    } else {
                                        $country =
                                                "N/A";
                                    }
                                    $onclick =
                                            "popups_ajax('account_settings','4')";
                                } else {
                                    $firstname =
                                            $user[0]['i_firstname'];
                                    $lastname =
                                            $user[0]['i_lastname'];
                                    $company_name =
                                            $user[0]['i_company_name'];
                                    $town =
                                            $user[0]['i_town'];
                                    $zip_code =
                                            $user[0]['i_zip_code'];
                                    //country
                                    $country_id =
                                            !empty($user[0]['i_country']) ? $user[0]['i_country'] : "";
                                    if (!empty($country_id)) {
                                        $country =
                                                $this->user_model->get_countries_by_id($country_id);
                                        $country =
                                                $country[0]['country_name'];
                                    } else {
                                        $country =
                                                "N/A";
                                    }
                                    $onclick =
                                            "popups_ajax('account_settings','3')";
                                }
                                ?>
                                <?php echo _clang(FIRSTNAME); ?>&nbsp;<?php
                                echo (!empty($firstname) ? $firstname : "N/A");
                                ?><span style="float:right;"><a href="<?php echo site_url('myknewdog/invoicelist') ?>"><?php echo _clang(LIST_OF); ?></a></span><br>
                                <?php echo _clang(COMPANY_NAME); ?>&nbsp;<?php
                                echo (!empty($company_name)) ? $company_name : "N/A"
                                ?><br>
                                <?php echo _clang(TOWN); ?>&nbsp;<?php
                                echo (!empty($town)) ? $town : "N/A";
                                ?><br>
                                <?php echo _clang(ZIPCODE_K); ?>&nbsp;<?php
                                echo (!empty($zip_code)) ? $zip_code : "N/A";
                                ?><br><span style="float:right;"><a style="cursor:pointer;" onclick="<?php echo $onclick; ?>" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></a></span>

                                <?php echo _clang(COUNTRY_MK); ?>&nbsp;<?php echo $country; ?>
                            </div>
                        </div> 

                        <div class="login_profile">
                            <div class="accountsetting_title"><?php echo _clang(YOUR_ACC); ?></div>
                            <div><label><?php echo _clang(YOUR_STATUS); ?></label><?php echo $type_of_membership; ?> 
                                <?php
                                if (show_go_premium_link() ==
                                        true) {
                                    ?>
                                    <a href="<?php echo site_url('premium-account'); ?>">(<?php echo $gopremium_p['go_premium']//echo _clang(GO_PREMIUM_K);        ?>)</a>
                                <?php } ?>
                            </div>
                            <div><label><?php echo _clang(DATE_OF_REGI); ?></label><?php
                                echo date('j, F Y', strtotime($user[0]['date_of_registration']))
                                ?></div>
                            <div><label><?php echo _clang(END_OF); ?>:</label>
                                <?php
                                //echo _clang(YOUR_ACCOUNT);
                                if ($this->session->userdata('type_of_membership') == "FREE") {
                                    
                                } else {
                                    $end_term = "";
                                    $year_data = "No date availabel";
                                    if ($user[0]['type_of_membership'] == 'FREE') {
                                        
                                        echo $end_term = _clang(YOUR_ACCOUNT);
                                    } else {
                                        $start = $user[0]['date_from'];
                                        $end = $user[0]['date_to'];
                                        $diff = abs(strtotime($end) - strtotime($start));
                                        if (!empty($diff)) {
                                            $years = floor($diff / (365 * 60 * 60 * 24));
                                            $year_data = " + " . $years . " years = ";
                                        }
                                        echo $end_term = $start . $year_data . $end;
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            if (in_array($this->session->userdata('type_of_membership'), array(
                                        'FREE',
                                        'PRE1',
                                        'PRE2'))) {
                                ?>
                                <div><label><?php echo _clang(CANCEL_ACCOUNT); ?>:</label><a onclick="popups_ajax('cancle_account', '<?php echo $this->session->userdata('type_of_membership'); ?>')" href="javascript:void(0);"><?php echo _clang(PLS_CLICK); ?></a></div>
<?php } ?>
                        </div> 
                    </div>
                </section>
            </div>

        </section>

<?php include_once("includes/sidebars/myknewdog_sidebar.php"); ?>
    </section>
    <script type ="text/javascript">
        //we bind only to the rateit controls within the products div
        $('.dashreview .rateit').bind('rated reset', function(e) {
            var ri = $(this);

            //if the use pressed reset, it will get value: 0 (to be compatible with the HTML range control), we could check if e.type == 'reset', and then set the value to  null .
            var value = ri.rateit('value');
            //alert(value);
            var productID = ri.data('productid');
            //var starheight = ri.rateit('starheight'); 
            // if the product id was in some hidden field: ri.closest('li').find('input[name="productid"]').val()
            //alert(productID);
            //alert(starheight)
            //maybe we want to disable voting?
            ri.rateit('readonly', true);

            $.ajax({
                url: '<?php echo site_url('newsletter/rateit'); ?>', //your server side script
                data: {action: 'rate', id: productID, value: value}, //our data
                type: 'POST',
                success: function(data) {
                    $('#response').append('<li>' + data + '</li>');
                    $("#result_star").rateit('value', data);
                },
                error: function(jxhr, msg, err) {
                    $('#response').append('<li style="color:red">' + msg + '</li>');
                }
            });
        });
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
                });
        function display_tabs(id) {
            var num = id.split("_");
            $(".tabs li").removeClass("current");
            $(".section").css("display", "none");
            $("#" + id).addClass("current");
            $("#section_" + num[1]).css("display", "block");
        }
<?php
if (empty($mynl_tab)) {
    $mynl_tab =
            'tab_1';
}
?>
        var mynl_tab = '<?php
echo ($this->session->flashdata("flash_mynl_tab") ? $this->session->flashdata("flash_mynl_tab") : $mynl_tab); //echo $this->session->flashdata("flash_mynl_tab") 
?>';
        //alert(mynl_tab);
        if (mynl_tab == 'tab_2') {

            display_tabs('tab_2');
        } else if (mynl_tab == 'tab_1') {
            display_tabs('tab_1');
        } else if (mynl_tab == 'tab_3') {
            display_tabs('tab_3');
        } else if (mynl_tab == 'tab_4') {
            display_tabs('tab_4');
        } else {
            display_tabs('tab_1');
        }
        function schedule_set(id, loc) {
            if (loc == 'site') {

                if (id == 'Daily') {
                    $(".site .everyweekson").find("input").attr('disabled', false);
                    $('.site input[name="weeks_on[]"]').attr('checked', false);
                    $('.site input[name="every"]').attr('disabled', true);
                    $('.site input[name="every"]').val('');
                    //$('.site input[name="weeks_on[]"]').attr('checked', 'checked');
                    $('.site input[name="weeks_on[]"]').attr('disabled', true);


                } else if (id == 'Weekly') {
                    //alert(id);
                    $(".site .everyweekson").find("input").attr('disabled', false);
                    //$('.site input[name="weeks_on[]"]').attr('checked', false);
                    $('.site input[name="every"]').attr('disabled', true);
                    $('.site input[name="every"]').val('');
                    //$('input[name="weeks_on"]').attr('disabled', true);
                } else if (id == 'Monthly') {
                    $(".site .everyweekson").find("input").attr('disabled', false);
                    //$('.site input[name="weeks_on[]"]').attr('checked', false);
                    //$('input[name="every"]').attr('disabled', true);
                    //$('.site input[name="weeks_on[]"]').attr('disabled', true);
                } else if (id == 'Yearly') {
                    $(".site .everyweekson").find("input").attr('disabled', false);
                    $('.site input[name="weeks_on[]"]').attr('checked', false);
                    $('.site input[name="every"]').attr('disabled', true);
                    $('.site input[name="every"]').val('');
                    //$('.site input[name="weeks_on[]"]').attr('checked', 'checked');
                    $('.site input[name="weeks_on[]"]').attr('disabled', true);
                }
            }
            if (loc == 'popup') {

                if (id == 'Daily') {
                    $(".popup_ajax .everyweekson").find("input").attr('disabled', false);
                    $('.popup_ajax input[name="weeks_on[]"]').attr('checked', false);
                    $('.popup_ajax input[name="every"]').attr('disabled', true);
                    $('.popup_ajax input[name="every"]').val('');
                    //$('.popup_ajax input[name="weeks_on[]"]').attr('checked', 'checked');
                    $('.popup_ajax input[name="weeks_on[]"]').attr('disabled', true);


                } else if (id == 'Weekly') {
                    $(".popup_ajax .everyweekson").find("input").attr('disabled', false);
                    //$('.popup_ajax input[name="weeks_on[]"]').attr('checked', false);
                    $('.popup_ajax input[name="every"]').attr('disabled', true);
                    $('.popup_ajax input[name="every"]').val('');
                    //$('input[name="weeks_on"]').attr('disabled', true);
                } else if (id == 'Monthly') {
                    $(".popup_ajax .everyweekson").find("input").attr('disabled', false);
                    //$('.popup_ajax input[name="weeks_on[]"]').attr('checked', false);
                    //$('input[name="every"]').attr('disabled', true);
                    //$('.popup_ajax input[name="weeks_on[]"]').attr('disabled', true);
                } else if (id == 'Yearly') {
                    /*$(".popup_ajax .everyweekson").find("input").attr('disabled',false);
                     //$('.popup_ajax input[name="weeks_on[]"]').attr('checked', false);
                     $('.popup_ajax input[name="every"]').attr('disabled', true);
                     $('.popup_ajax input[name="every"]').val('');
                     //$('.popup_ajax input[name="weeks_on[]"]').attr('checked', 'checked');
                     $('.popup_ajax input[name="weeks_on[]"]').attr('disabled', true);*/
                    $(".popup_ajax .everyweekson").find("input").attr('disabled', false);
                    $('.popup_ajax input[name="weeks_on[]"]').attr('checked', false);
                    $('.popup_ajax input[name="every"]').attr('disabled', true);
                    $('.popup_ajax input[name="every"]').val('');
                    //$('.site input[name="weeks_on[]"]').attr('checked', 'checked');
                    $('.popup_ajax input[name="weeks_on[]"]').attr('disabled', true);
                }
            }
        }

    </script>

    <script src="<?php echo site_url('assets/js') ?>/jquery.rateit.js" type="text/javascript"></script>
</main>