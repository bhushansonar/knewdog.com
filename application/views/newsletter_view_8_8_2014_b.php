<main>
    <link href="<?php echo site_url('assets/css') ?>/rateit.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <!--<link href="<?php echo base_url(); ?>assets/css/kd2a2a0u1g4/bootstrap.css" rel="stylesheet" type="text/css">-->
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <div class="set_errors">
        <?php
        $this->load->model('newsletter_model');

        $ci = & get_instance();
        $ci->load->model('subscribe_model');
        $ci->load->model('schedule_model');
        $user_id = $this->session->userdata("user_id");
        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {
            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        //echo '<pre>'; print_r($newsletter); die;
        ?>
    </div>
    <section class="knewdog findnewsletter" id="container">
        <section id="knewdog_leftbar">
            <div class="knewdog_leftbar_inner">
                <div id="tabsholder">
                    <ul class="tabs">
                        <li onclick="display_tabs(this.id)" id="tab_1" style=""><?php echo _clang(FIND_NEWSLETTER); ?></li>
                        <li onclick="display_tabs(this.id)" class="" id="tab_2"><?php echo _clang(MY_NEWSLETTERS); ?></li>
                    </ul>
                </div>
                <section class="section" style="display:none;" id="section_1">
                    <form method="post" action="<?php echo current_url(); ?>" name="newsletter_search" id="newsletter_search">
                        <input type="hidden" name="form" value="section_1" />
                        <div class="findnewsletter_form">

                            <article>

                                <div class="title"><?php echo _clang(ADVANCED_SEARCH); ?></div>
                                <div class="fullwidth_input"><input value="<?php echo $search_string_selected ?>" name="search_string" type="text"placeholder="<?php echo _clang(FOR_EX_HOLDER); ?>"></div>
                                <div class="<?php echo get_if_free_user('class_free_user') ?>"> 
                                    <div class="selectgroup">
                                        <div class="<?php echo get_if_free_user('class_free_user_overlay_1') ?>" <?php echo get_if_free_user('advance_search_popup') ?>></div>
                                        <div class="select"><label><?php echo _clang(LANGUAGE); ?></label>
                                            <select name="language_id">
                                                <option value=""><?php echo _clang(ALL_HOLDER); ?></option>
                                                <?php for ($l = 0; $l < count($language); $l++) { ?>
                                                    <option <?php echo ($selected_language_id == $language[$l]['language_id']) ? 'selected="selected"' : "" ?>  value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="select"><label><?php echo _clang(CATEGORY); ?></label>
                                            <?php //echo $selected_newsletter_category;?>
                                            <select name="newsletter_category">
                                                <option  value=""><?php echo _clang(ALL); ?></option>
                                                <?php for ($c = 0; $c < count($category); $c++) { ?>
                                                    <option  <?php echo ($selected_newsletter_category == $category[$c]['en']) ? 'selected="selected"' : '' ?> value="<?php echo $category[$c]['en']; ?>"><?php echo $category[$c]['en']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="select"><label><?php echo _clang(RATING); ?></label>
                                            <select name="rating_id">
                                                <option value=""><?php echo _clang(ALL_RATING); ?></option>
                                                <option <?php echo ($selected_newsletter_rating_id == '1') ? 'selected="selected"' : '' ?> value="1">1</option>
                                                <option <?php echo ($selected_newsletter_rating_id == '2') ? 'selected="selected"' : '' ?> value="2">2</option>
                                                <option <?php echo ($selected_newsletter_rating_id == '3') ? 'selected="selected"' : '' ?> value="3">3</option>
                                                <option <?php echo ($selected_newsletter_rating_id == '4') ? 'selected="selected"' : '' ?> value="4">4</option>
                                                <option <?php echo ($selected_newsletter_rating_id == '5') ? 'selected="selected"' : '' ?> value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="selectgroup">
                                        <?php // echo '<pre>';print_r($this->session->userdata); die;?>
                                        <div class="<?php echo get_if_free_user('class_free_user_overlay_2') ?>" <?php echo get_if_free_user('advance_search_popup') ?>></div>
                                        <div class="select"><label><?php echo _clang(LOCATION); ?></label>
                                            <select name="author_country">
                                                <option value=""><?php echo _clang(COUNTRY); ?></option>
                                                <?php for ($l = 0; $l < count($countries); $l++) { ?>
                                                    <option <?php echo $selected_author_country == $countries[$l]['id'] ? 'selected="selected"' : '' ?>  value="<?php echo $countries[$l]['id'] ?>"><?php echo $countries[$l]['country_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="select"><label></label><input style="padding:2.5%" placeholder="<?php echo _clang(ZIPCODE); ?>" type="text" value="<?php echo $selected_author_zipcode; ?>" name="author_zipcode" /></div>
                                        <div class="select cancel_button"><label></label>
                                            <div style="float:right;" class="summary_cancel">
                                                <a class="cancle" href="<?php echo site_url('newsletter') ?>"><?php echo _clang(CANCEL); ?></a>
                                                <!--<input class="cancle" type="reset" value="cancle" />-->
                                                <input  class="btn btn_main" name="" style="font-size: 14px; margin-top: 1px; padding: 3px 5px;"  value="<?php echo _clang(SEARCH_BUTTON) ?>" type="submit">
                                                    <!--<img src="<?php echo base_url(); ?>assets/img/search.png">-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <article>
                            <div class="pager">
                                <?php
                                if ($page == 0) {
                                    $page = 1;
                                } else {
                                    $page = $page;
                                }
                                //$total = count($newsletter);
                                //echo $result_show_count1 = ($limit_end  + $limit_start);
                                //echo ($page * $limit_start)."=".$total_rows;
                                if ($total_rows <= ($page * $limit_start)) {
                                    $result_show_count = $total_rows;
                                } else {
                                    $result_show_count = $page * $limit_start;
                                }
                                /* if($total > $total_rows){ $result_total = $total;}else{ $result_total = $total_rows;} */
                                ?>
                                <div class="result"><?php echo _clang(RESULT) . " " . ($limit_end + 1) . "-" . ($result_show_count) . " " . _clang(OUT_OF) . " " . $total_rows ?><!--Result 1-10 out of 986--></div>
                                <div class="sortby">
                                    <label><?php echo _clang(SORT_BY); ?></label>
                                    <?php //echo $order; ?>
                                    <select name="order">
                                        <option <?php echo $order == 'newsletter_name' ? 'selected="selected"' : "" ?> value="newsletter_name"><?php echo _clang(N_TITLE); ?></option>
                                        <option <?php echo $order == 'author_name' ? 'selected="selected"' : "" ?> value="author_name"><?php echo _clang(N_AUTHOR); ?></option>
                                        <option <?php echo $order == 'newsletter_id' ? 'selected="selected"' : "" ?> value="newsletter_id"><?php echo _clang(N_NEWEST); ?></option>
                                    </select>
                                </div>
                                <!--<div class="view"><label>View:</label><a href="#"><img src="<?php echo base_url(); ?>assets/img/view.png"></a></div>-->
                            </div>
                        </article>
                    </form>
                    <article style="clear:both;" class="reviewlist">
                        <?php
                        for ($i = 0; $i < count($newsletter); $i++) {
                            if (!$user_id) {
                                $newsletter_inner_url = 'javascript:void(0)';
                                $onclick = 'onclick="popup(\'notviewdetail\')"';
                            } else {
                                $newsletter_inner_url = site_url('newsletter/specific') . "/" . url_title($newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter[$i]['newsletter_id'];
                                $onclick = '';
                            }
                            ?>
                            <div class="dashreview">
                                <div class="review_img"><a <?php echo $onclick; ?>  href="<?php echo $newsletter_inner_url; ?>">
                                        <?php if (!empty($newsletter[$i]['screenshot'])) { ?>
                                            <img style="width:79px;" src="<?php echo base_url(); ?>uploads/<?php echo $newsletter[$i]['screenshot']; ?>" alt="">
                                        <?php } else { ?>
                                            <img style="width:79px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png" alt="">
                                        <?php } ?>
                                    </a></div>
                                <div class="review_detail">
                                    <a class="name" href="<?php echo $newsletter_inner_url ?>" <?php echo $onclick ?>><?php echo $newsletter[$i]['newsletter_name'] ?></a><br/>
                                    <label style="color:#808080; float:left;"><?php echo _clang(AUTHOR); ?> </label><span style="float: left; width: 315px;"><?php echo $newsletter[$i]['headline'] ?></span>
                                    <?php
                                    $get_rate = $this->newsletter_model->get_rate_by_user($newsletter[$i]['newsletter_id']);

                                    include("rating/rating_calculation.php");



                                    //echo "user_id->".$newsletter[$i]["user_id"];
                                    $wherefield = array("join_newsletter_id");
                                    $wherevalue = array($newsletter[$i]["newsletter_id"]);
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

                                    //$data['get_rate'] = $get_rate;	
                                    ?>
                                    <span style="float:left; position:relative" class="rating_hover">
                                        <div style=" display: inline-block; vertical-align: text-bottom;" data-productid="<?php echo $newsletter[$i]['newsletter_id']; ?>" title="<?php echo $avg_round; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $avg_round; ?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="<?php echo $readonly ?>" class="rateit" id="rateit9"></div>

                                        <?php if (count($get_news_user_id) > 0) { ?>
                                            <img style="margin-left: 5px; vertical-align: text-top; display: inline-block;" src="<?php echo base_url(); ?>assets/img/review_down.png" alt="">
                                        <?php } ?>
                                        <a style="text-decoration: none; margin-left: 3px; display: inline-block; vertical-align: top;" href="javascript:void(0);<?php //echo site_url("newsletter/display-rate"."/".$newsletter[$i]['newsletter_id']);   ?>">(<?php echo (!empty($total_user_rate)) ? $total_user_rate : "0"; ?>)</a>
                                        <?php if (count($get_news_user_id) > 0) { ?>
                                            <div style="left:0; top:20px;"  class="rating_popup">
                                                <?php $popupcss = "style='float:none; width:100%;'"; ?>
                                                <?php include("rating/rating_view.php"); ?>
                                                <a href="<?php echo site_url("newsletter/display-rate" . "/" . $newsletter[$i]['newsletter_id']); ?>"><?php echo _clang(SEE_ALL); ?> <?php echo (!empty($total_user_rate)) ? $total_user_rate : "0"; ?> <?php echo _clang(CUSTOMER_REVIEW); ?></a>
                                            </div>
                                        <?php } ?>
                                    </span>

                                    <br/>
                                    <div class="description">
                                        <?php echo substr(strip_tags($newsletter[$i]['description']), 0, 100); ?>
                                    </div>
                                    <?php
                                    $where_s_field_3 = array('s_newsletter_id');
                                    $where_s_value_3 = array($newsletter[$i]['newsletter_id']);
                                    $subscribed_3 = $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_s_field_3, $where_s_value_3);
                                    $count_subscribed_3 = count($subscribed_3);
                                    ?>
                                    <label style="color:#808080;"><?php echo $count_subscribed_3; ?> <?php echo _clang(SUB_LANGUAGE); ?> <?php echo (!empty($newsletter[$i]['newsletter_language']) ? $newsletter[$i]['newsletter_language'] : "N/A") ?></label>
                                    <!--<label style="color:#808080;">1.125 subscribers, 4 newsletters last month, language: English</label> -->
                                </div>
                                <div class="review_subscribe review_subscribe_<?php echo $newsletter[$i]['newsletter_id']; ?>">
                                    <?php
                                    if (!empty($user_id)) {


                                        $where_Sfield = array('s_newsletter_id', 's_user_id');
                                        $where_Svalue = array($newsletter[$i]['newsletter_id'], $user_id);
                                        $subscribe = $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_Sfield, $where_Svalue);
                                        if (count($subscribe) > 0) {
                                            ?>
                                            <span style="float: right; margin-top: 20px; text-align: center; color:#808080; font-size: 11px;"><?php echo _clang(YOU_ARE); ?><br><?php echo _clang(GO_TO); ?> <u><span style="cursor:pointer;" onclick="display_tabs('tab_2')"><?php echo _clang(MY_NEWSLETTERS_N); ?></u><br><?php echo _clang(TO_MANAGE); ?></span>
                                        <?php } else { ?>
                                            <img style="cursor:pointer;" onclick="popups_ajax('subscribe_1', '<?php echo $newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" src="<?php echo base_url(); ?>assets/img/subscribe.png" alt="">
                                            <label onclick="popups_ajax('subscribe_1', '<?php echo $newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" style=" cursor:pointer; float: right; margin: 38px -51px; color: #9A7F82;font-weight: bold; font-size: 11px;"><?php echo _clang(SUBSCRIBE_BUTTON) ?></label>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>




                            </div>
                        <?php } ?>   
                    </article>
                    <?php
                    //$this->pagination->create_links()
                    echo '<div class="pagination">' . $link . '</div>';
                    ?>
                </section>
                <!--------------------------------------------Section 2 --------------------------------------------------->

                <section class="section" style="display:none;" id="section_2">
                    <?php //include("includes/mynewsletter.php") ?>
                    <?php if (!empty($user_id)) { ?>
                        <form method="post" action="<?php echo current_url(); ?>" name="mynewsletter_search" id="mynl_newsletter_search">
                            <input type="hidden" name="form" value="section_2" />
                            <div class="findnewsletter_form">

                                <article>

                                    <div class="title"><?php echo _clang(ADVANCED_SEARCH); ?></div>

                                    <div class="fullwidth_input"><input value="<?php echo $mynl_search_string_selected ?>" name="mynl_search_string" type="text"placeholder="<?php echo _clang(FOR_EX_HOLDER); ?>"></div>
                                    <div class="<?php echo get_if_free_user('class_free_user') ?>" <?php echo get_if_free_user('advance_search_popup') ?>> 
                                        <div class="selectgroup">
                                            <div class="<?php echo get_if_free_user('class_free_user_overlay_1') ?>" <?php echo get_if_free_user('advance_search_popup') ?>></div>
                                            <div class="select"><label><?php echo _clang(LANGUAGE); ?></label>
                                                <select name="mynl_language_id">
                                                    <option value=""><?php echo _clang(ALL_HOLDER); ?></option>
                                                    <?php for ($l = 0; $l < count($language); $l++) { ?>
                                                        <option <?php echo ($mynl_selected_language_id == $language[$l]['language_id']) ? 'selected="selected"' : "" ?>  value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="select"><label><?php echo _clang(CATEGORY); ?></label>
                                                <?php //echo $selected_newsletter_category;  ?>
                                                <select name="mynl_newsletter_category">
                                                    <option  value=""><?php echo _clang(ALL); ?></option>
                                                    <?php for ($c = 0; $c < count($category); $c++) { ?>
                                                        <option  <?php echo ($mynl_selected_newsletter_category == $category[$c]['en']) ? 'selected="selected"' : '' ?> value="<?php echo $category[$c]['en']; ?>"><?php echo $category[$c]['en']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="select"><label><?php echo _clang(RATING); ?></label><select name="mynl_rating_id">
                                                    <option value=""><?php echo _clang(ALL_RATING); ?></option>
                                                    <option <?php echo ($mynl_selected_newsletter_rating_id == '1') ? 'selected="selected"' : '' ?> value="1">1</option>
                                                    <option <?php echo ($mynl_selected_newsletter_rating_id == '2') ? 'selected="selected"' : '' ?> value="2">2</option>
                                                    <option <?php echo ($mynl_selected_newsletter_rating_id == '3') ? 'selected="selected"' : '' ?> value="3">3</option>
                                                    <option <?php echo ($mynl_selected_newsletter_rating_id == '4') ? 'selected="selected"' : '' ?> value="4">4</option>
                                                    <option <?php echo ($mynl_selected_newsletter_rating_id == '5') ? 'selected="selected"' : '' ?> value="5">5</option>
                                                </select></div>
                                        </div>
                                        <div class="selectgroup">
                                            <div class="<?php echo get_if_free_user('class_free_user_overlay_2') ?>" <?php echo get_if_free_user('advance_search_popup') ?>></div>
                                            <div class="select"><label><?php echo _clang(LOCATION); ?></label>
                                                <select name="mynl_author_country">
                                                    <option value=""><?php echo _clang(COUNTRY); ?></option>
                                                    <?php for ($l = 0; $l < count($countries); $l++) { ?>
                                                        <option <?php echo $mynl_selected_author_country == $countries[$l]['id'] ? 'selected="selected"' : '' ?>  value="<?php echo $countries[$l]['id'] ?>"><?php echo $countries[$l]['country_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="select"><label></label><input style="padding:2.5%" placeholder="<?php echo _clang(ZIPCODE); ?>" type="text" value="<?php echo $mynl_selected_author_zipcode; ?>" name="mynl_author_zipcode" /></div>
                                            <div class="select cancel_button"><label></label>
                                                <div style="float:right;" class="summary_cancel">
                                                    <a class="cancle" href="<?php echo site_url('newsletter') ?>"><?php echo _clang(CANCEL); ?></a>
                                                    <!--<input class="cancle" type="reset" value="cancle" />-->
                                                    <input class="btn btn_main" style="font-size: 14px; margin-top: 1px; padding: 3px 5px;" value="<?php echo _clang(SEARCH_BUTTON) ?>"name="" type="submit">
                                                    <!--<img src="<?php echo base_url(); ?>assets/img/search.png"></button>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </article>
                            </div>
                            <article>
                                <div class="pager">
                                    <?php
                                    if ($mynl_page == 0) {
                                        $mynl_page = 1;
                                    } else {
                                        $mynl_page = $mynl_page;
                                    }
                                    //$total = count($newsletter);
                                    //echo $result_show_count1 = ($limit_end  + $limit_start);
                                    //echo ($page * $limit_start)."=".$total_rows;
                                    if ($mynl_total_rows <= ($mynl_page * $mynl_limit_start)) {
                                        $mynl_result_show_count = $mynl_total_rows;
                                    } else {
                                        $mynl_result_show_count = $mynl_page * $mynl_limit_start;
                                    }
                                    /* if($total > $total_rows){ $result_total = $total;}else{ $result_total = $total_rows;} */
                                    ?>
                                    <div class="result"><?php echo _clang(RESULT) . " " . ($mynl_limit_end + 1) . "-" . ($mynl_result_show_count) . " " . _clang(OUT_OF) . " " . $mynl_total_rows ?><!--Result 1-10 out of 986--></div>
                                    <div class="sortby">
                                        <label><?php echo _clang(SORT_BY); ?></label>
                                        <?php //echo $order; ?>
                                        <select name="mynl_order">
                                            <option <?php echo $mynl_order == 'newsletter_name' ? 'selected="selected"' : "" ?> value="newsletter_name"><?php echo _clang(N_TITLE); ?></option>
                                            <option <?php echo $mynl_order == 'author_name' ? 'selected="selected"' : "" ?> value="author_name"><?php echo _clang(N_AUTHOR); ?></option>
                                            <option <?php echo $mynl_order == 'newsletter_id' ? 'selected="selected"' : "" ?> value="newsletter_id"><?php echo _clang(N_NEWEST); ?></option>
                                        </select>
                                    </div>
                                    <!--<div class="view"><label>View:</label><a href="#"><img src="<?php echo base_url(); ?>assets/img/view.png"></a></div>-->
                                </div>
                            </article>
                        </form>
                        <article style="clear:both;" class="reviewlist">
                            <?php for ($i = 0; $i < count($mynl_newsletter); $i++) { ?>
                                <div class="dashreview" id="unsubscribe_<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>">
                                    <div class="review_img"><a href="<?php echo site_url('newsletter/specific') . "/" . url_title($mynl_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $mynl_newsletter[$i]['newsletter_id'] ?>">
                                            <?php if (!empty($mynl_newsletter[$i]['screenshot'])) { ?>
                                                <img style="width:79px;" src="<?php echo base_url(); ?>uploads/<?php echo $mynl_newsletter[$i]['screenshot']; ?>" alt=""></a></div>
                                    <?php } else { ?>
                                        <img style="width:79px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png" alt=""></a></div>
                                <?php } ?>
                                <div class="review_detail">
                                    <a class="name" href="<?php echo site_url('newsletter/specific') . "/" . create_slug($mynl_newsletter[$i]['newsletter_name'], 100) . "/" . $mynl_newsletter[$i]['newsletter_id'] ?>"><?php echo $mynl_newsletter[$i]['newsletter_name'] ?></a><br/>
                                    <label style="color:#808080; float:left;"><?php echo _clang(AUTHOR); ?> </label><span style="float: left; width: 315px;"><?php echo $mynl_newsletter[$i]['author_name'] ?></span>
                                    <?php
                                    $get_rate = $this->newsletter_model->get_rate_by_user($mynl_newsletter[$i]['newsletter_id']);

                                    include("rating/rating_calculation.php");


                                    $user_id = $this->session->userdata("user_id");
                                    //echo "user_id->".$newsletter[$i]["user_id"];
                                    $wherefield = array();
                                    $wherevalue = array();

                                    $wherefield = array("join_newsletter_id");
                                    $wherevalue = array($mynl_newsletter[$i]["newsletter_id"]);
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

                                    //$data['get_rate'] = $get_rate;	
                                    ?>
                                    <span  style="float:left; position:relative" class="rating_hover">
                                        <div style=" display: inline-block; vertical-align: text-bottom;" data-productid="<?php echo $mynl_newsletter[$i]['newsletter_id']; ?>" title="<?php echo $avg_round; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $avg_round; ?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="<?php echo $readonly ?>" class="rateit" id="rateit9"></div>

                                        <?php if (count($get_news_user_id) > 0) { ?>
                                            <img style="margin-left: 5px; vertical-align: text-top; display: inline-block;" src="<?php echo base_url(); ?>assets/img/review_down.png" alt="">
                                        <?php } ?>
                                        <a style="text-decoration: none; margin-left: 3px; display: inline-block; vertical-align: top;" href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>">(<?php echo (!empty($total_user_rate)) ? $total_user_rate : "0"; ?>)</a>
                                        <?php if (count($get_news_user_id) > 0) { ?>
                                            <div style="left:0; top:20px;"  class="rating_popup">
                                                <?php $popupcss = "style='float:none; width:100%;'"; ?>
                                                <?php include("rating/rating_view.php"); ?>
                                                <a href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>"><?php echo _clang(SEE_ALL); ?> <?php echo (!empty($total_user_rate)) ? $total_user_rate : "0"; ?> <?php echo _clang(CUSTOMER_REVIEW); ?></a>
                                            </div>
                                        <?php } ?>
                                    </span>

                                    <br/>
                                    <div class="description">
                                        <?php echo substr(strip_tags($mynl_newsletter[$i]['description']), 0, 100); ?>
                                    </div>
                                    <?php
                                    $where_s_field_2 = array('s_newsletter_id');
                                    $where_s_value_2 = array($mynl_newsletter[$i]['newsletter_id']);
                                    $subscribed_2 = $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_s_field_2, $where_s_value_2);
                                    $count_subscribed = count($subscribed_2);
                                    ?>
                                    <label style="color:#808080;"><?php echo $count_subscribed; ?> <?php echo _clang(SUB_LANGUAGE); ?> <?php echo (!empty($mynl_newsletter[$i]['newsletter_language']) ? $mynl_newsletter[$i]['newsletter_language'] : "N/A") ?></label>
                                    <!--<label style="color:#808080;">1.125 subscribers, 4 newsletters last month, language: English</label> -->
                                </div>
                                <div class="review_subscribe">
                                    <?php
                                    if (!empty($user_id)) {

                                        $where_Sfield = array();
                                        $where_Svalue = array();

                                        $where_Sfield = array('s_newsletter_id', 's_user_id');
                                        $where_Svalue = array($mynl_newsletter[$i]['newsletter_id'], $user_id);
                                        $subscribe = $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_Sfield, $where_Svalue);

                                        if (count($subscribe) > 0) {
                                            ?>
                                            <img style="cursor:pointer; float:none;" onclick="popups_ajax_unsubscribe('unsubscribe', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" src="<?php echo base_url(); ?>assets/img/unsubscribe.png" alt="">
                                            <label onclick="popups_ajax_unsubscribe('unsubscribe', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" style="color: #9a7f82; cursor:pointer; float: right;font-size: 11px;font-weight: bold;margin: -6px 84px;"><?php echo _clang(UNSUBSCRIBE_BUTTON) ?></label>
                                            <a href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>"><img src="<?php echo base_url(); ?>assets/img/evaluate.png" class="evaluate" alt="">

                                                <?php
                                                $user_id = $this->session->userdata("user_id");
                                                //echo "user_id->".$newsletter[$i]["user_id"];
                                                $wherefield = array("join_newsletter_id", "join_user_id");
                                                $wherevalue = array($mynl_newsletter[$i]["newsletter_id"], $user_id);
                                                $get_news_user_id = $this->newsletter_model->get_rate_by_field($wherefield, $wherevalue);
                                                if ($get_news_user_id == true) {
                                                    echo '<span style="float: right; color: rgb(128, 128, 128); font-size: 11px; margin-right: 40px;">Edit</span>';
                                                }
                                                ?>
                                                <label style="color: #9a7f82;float: right;font-size: 11px;font-weight: bold;margin: -8px 22px;"><?php echo _clang(EVALUATE_BUTTON) ?></label>
                                            </a>
                                            

                                                                <!--<span style="float: right; margin-top: 20px; text-align: center; color:#808080; font-size: 11px;">
                                                                You are already subscribed<br>Go to ”<u>My Newsletters</u>”<br>to manage<br>your subscriptions.</span>-->
                                        <?php } else { ?>
                                            <img onclick="popups_ajax('subscribe_1', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" src="<?php echo base_url(); ?>assets/img/subscribe.png" alt="">
                                            <label onclick="popups_ajax('subscribe_1', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" style="float: right; cursor:pointer; margin: 38px -51px; color: #9A7F82;font-weight: bold; font-size: 11px;"><?php echo _clang(SUBSCRIBE_BUTTON) ?></label>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <?php
                                //$this->load->model('subscribe_model');
                                $where_s_field = array('s_user_id', 's_newsletter_id');
                                $where_s_value = array($user_id, $mynl_newsletter[$i]['newsletter_id']);
                                $subscribed_1 = $ci->subscribe_model->get_subscribe('', '', '', '', '', $where_s_field, $where_s_value);

                                //echo "schedule_id->".$subscribed_1[0]['schedule_id'];
                                if ($subscribed_1[0]['schedule_id'] != 0) {
                                    $get_schedule_by_id = $ci->schedule_model->get_schedule_by_id($subscribed_1[0]['schedule_id']);

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
                                    //$every = ($get_schedule_by_id[0]['every']) ? "every ".$get_schedule_by_id[0]['every'] ." Week": "";	
                                    $week0 = ($get_schedule_by_id[0]['weeks_on']) ? "on " . $get_schedule_by_id[0]['weeks_on'] : "";
                                    ?>
                                    <div class="sendingscheduale"><b><?php echo _clang(SENDING_SCHEDULE); ?></b><label><?php echo $get_schedule_by_id[0]['sending'] . " " . $every . " " . $week0 . " at " . date("H.i", strtotime($get_schedule_by_id[0]['at'] . ":00:00")) ?></label></div><div class="sendingemail"><b><?php echo _clang(SENDING_MAIL); ?></b><label><?php echo $get_schedule_by_id[0]['sending_to_email'] ?></label><img style="cursor:pointer;" onclick="popups_ajax('subscribe_1_edit', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $get_schedule_by_id[0]['schedule_id'] ?>')" src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></div>
                                    <!--onclick="popups_ajax_schedule('schedule','<?php //echo $get_schedule_by_id[0]['schedule_id']    ?>')"-->
                                <?php } ?>

                                </div>
                            <?php } ?>   
                        </article>
                        <?php echo '<div class="pagination">' . $mynl_link . '</div>'; ?>
                    <?php } else { ?>
                        <div class="findnewsletter_form">
                            <h1 style="clear: both; color: black; text-align: center; margin-top: 64px;"><?php echo _clang(PLEASE_N); ?> <a style="cursor:pointer;" onclick="popup('signin')"><?php echo _clang(LOGIN_N); ?></a> <?php echo _clang(TO_VIEW); ?></h1>  
                        </div>
                    <?php } ?>
                </section>
            </div>

        </section>

        <?php include_once("includes/sidebars/newsletter_sidebar.php"); ?>
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
/* if(empty($mynl_tab)){
  $mynl_tab = 'tab_1';
  } */
?>
                            //var mynl_tab = '<?php //echo $mynl_table    ?>'; 
                            var mynl_tab = '<?php echo ($this->session->flashdata("flash_mynl_tab") ? $this->session->flashdata("flash_mynl_tab") : $mynl_tab); //echo $this->session->flashdata("flash_mynl_tab")    ?>';
                            //alert(mynl_tab);
                            //alert(mynl_tab);
                            if (mynl_tab == 'tab_2') {
                                display_tabs('tab_2');

                            } else if (mynl_tab == 'tab_1') {
                                display_tabs('tab_1');

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
                                        $(".site .everyweekson").find("input").attr('disabled', false);
                                        //$('.site input[name="weeks_on[]"]').attr('checked', false);
                                        $('.site input[name="every"]').attr('disabled', true);
                                        //$('input[name="weeks_on"]').attr('disabled', true);
                                    } else if (id == 'Monthly') {
                                        $(".site .everyweekson").find("input").attr('disabled', false);
                                        //$('.site input[name="weeks_on[]"]').attr('checked', false);
                                        //$('input[name="every"]').attr('disabled', true);
                                        //$('input[name="weeks_on"]').attr('disabled', true);
                                    } else if (id == 'Yearly') {
                                        $(".site .everyweekson").find("input").attr('disabled', false);
                                        //$('.site input[name="weeks_on[]"]').attr('checked', false);
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

                                        //$('input[name="weeks_on"]').attr('disabled', true);
                                    } else if (id == 'Monthly') {
                                        $(".popup_ajax .everyweekson").find("input").attr('disabled', false);
                                        //$('.popup_ajax input[name="weeks_on[]"]').attr('checked', false);
                                        //$('input[name="every"]').attr('disabled', true);
                                        //$('input[name="weeks_on"]').attr('disabled', true);
                                    } else if (id == 'Yearly') {
                                        $(".popup_ajax .everyweekson").find("input").attr('disabled', false);
                                        //$('.popup_ajax input[name="weeks_on[]"]').attr('checked', false);
                                        $('.popup_ajax input[name="every"]').attr('disabled', true);
                                        $('.popup_ajax input[name="every"]').val('');
                                        //$('.popup_ajax input[name="weeks_on[]"]').attr('checked', 'checked');
                                        $('.popup_ajax input[name="weeks_on[]"]').attr('disabled', true);
                                    }
                                }
                            }
    </script>

    <script src="<?php echo site_url('assets/js') ?>/jquery.rateit.js" type="text/javascript"></script>
</main>