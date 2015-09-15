<?php if (!empty($user_id)) { ?>
    <form method="post" action="<?php echo current_url(); ?>" name="mynewsletter_search" id="mynl_newsletter_search">
        <input type="hidden" name="form" value="section_2" />
        <div class="findnewsletter_form">

            <div>

                <div class="title">Advanced Search</div>

                <div class="fullwidth_input"><input value="<?php echo $mynl_search_string_selected ?>" name="mynl_search_string" type="text"placeholder="for ex.: keyword, title, author, text..."></div>
                <div class="<?php echo get_if_free_user('class_free_user') ?>" <?php echo get_if_free_user('advance_search_popup') ?>> 
                    <div class="selectgroup">
                        <div class="<?php echo get_if_free_user('class_free_user_overlay_1') ?>" <?php echo get_if_free_user('advance_search_popup') ?>></div>
                        <div class="select"><label>Language:</label>
                            <select name="mynl_language_id">
                                <option value="">(all)</option>
                                <?php for ($l = 0; $l < count($language); $l++) { ?>
                                    <option <?php echo ($mynl_selected_language_id == $language[$l]['language_id']) ? 'selected="selected"' : "" ?>  value="<?php echo $language[$l]['language_id']; ?>"><?php echo $language[$l]['language_longform']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="select"><label>Category:</label>
                            <?php //echo $selected_newsletter_category;?>
                            <select name="mynl_newsletter_category">
                                <option  value="">(ALL)</option>
                                <?php for ($c = 0; $c < count($category); $c++) { ?>
                                    <option  <?php echo ($mynl_selected_newsletter_category == $category[$c]['en']) ? 'selected="selected"' : '' ?> value="<?php echo $category[$c]['en']; ?>"><?php echo $category[$c]['en']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="select"><label>Rating:</label><select name="mynl_rating_id">
                                <option value="">(all)</option>
                                <option <?php echo ($mynl_selected_newsletter_rating_id == '1') ? 'selected="selected"' : '' ?> value="1">1</option>
                                <option <?php echo ($mynl_selected_newsletter_rating_id == '2') ? 'selected="selected"' : '' ?> value="2">2</option>
                                <option <?php echo ($mynl_selected_newsletter_rating_id == '3') ? 'selected="selected"' : '' ?> value="3">3</option>
                                <option <?php echo ($mynl_selected_newsletter_rating_id == '4') ? 'selected="selected"' : '' ?> value="4">4</option>
                                <option <?php echo ($mynl_selected_newsletter_rating_id == '5') ? 'selected="selected"' : '' ?> value="5">5</option>
                            </select></div>
                    </div>
                    <div class="selectgroup">
                        <div class="<?php echo get_if_free_user('class_free_user_overlay_2') ?>" <?php echo get_if_free_user('advance_search_popup') ?>></div>
                        <div class="select"><label>Location:</label>
                            <select name="mynl_author_country">
                                <option value="">(country)</option>
                                <?php for ($l = 0; $l < count($countries); $l++) { ?>
                                    <option <?php echo $mynl_selected_author_country == $countries[$l]['id'] ? 'selected="selected"' : '' ?>  value="<?php echo $countries[$l]['id'] ?>"><?php echo $countries[$l]['country_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="select"><label></label><input style="padding:2.5%" placeholder="Zip code" type="text" value="<?php echo $mynl_selected_author_zipcode; ?>" name="mynl_author_zipcode" /></div>
                        <div class="select cancel_button"><label></label>
                            <div style="float:right;" class="summary_cancel">
                                <a class="cancle" href="<?php echo site_url('newsletter') ?>">cancle</a>
                                <!--<input class="cancle" type="reset" value="cancle" />-->
                                <button class="btnsearch" name="" type="submit"><img src="<?php echo base_url(); ?>assets/img/search.png" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div>
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
                <div class="result"><?php echo "Result " . ($mynl_limit_end + 1) . "-" . ($mynl_result_show_count) . " out of " . $mynl_total_rows ?><!--Result 1-10 out of 986--></div>
                <div class="sortby">
                    <label>Sort by:</label>
                    <?php //echo $order; ?>
                    <select name="mynl_order">
                        <option <?php echo $mynl_order == 'newsletter_name' ? 'selected="selected"' : "" ?> value="newsletter_name">newsletter title</option>
                        <option <?php echo $mynl_order == 'author_name' ? 'selected="selected"' : "" ?> value="author_name">newsletter author</option>
                        <option <?php echo $mynl_order == 'newsletter_id' ? 'selected="selected"' : "" ?> value="newsletter_id">newest first</option>
                    </select>
                </div>
                <!--<div class="view"><label>View:</label><a href="#"><img src="<?php echo base_url(); ?>assets/img/view.png"></a></div>-->
            </div>
        </div>
    </form>
    <div style="clear:both;" class="reviewlist">
        <?php for ($i = 0; $i < count($mynl_newsletter); $i++) { ?>
            <div class="dashreview" id="unsubscribe_<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>">

                <?php if (!empty($mynl_newsletter[$i]['screenshot'])) { ?>
                    <div class="review_img">
                        <a href="<?php echo site_url('newsletter/specific') . "/" . url_title($mynl_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $mynl_newsletter[$i]['newsletter_id'] ?>">
                            <img style="width:79px;" src="<?php echo base_url(); ?>uploads/<?php echo $mynl_newsletter[$i]['screenshot']; ?>" alt="">
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="review_img">
                        <a href="<?php echo site_url('newsletter/specific') . "/" . url_title($mynl_newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $mynl_newsletter[$i]['newsletter_id'] ?>">
                            <img style="width:79px;" src="<?php echo base_url(); ?>assets/img/authornewsletter.png" alt="">
                        </a>
                    </div>
                <?php } ?>
                <div class="review_detail">
                    <a class="name" href="<?php echo site_url('newsletter/specific') . "/" . create_slug($mynl_newsletter[$i]['newsletter_name'], 100) . "/" . $mynl_newsletter[$i]['newsletter_id'] ?>"><?php echo $mynl_newsletter[$i]['newsletter_name'] ?></a><br/>
                    <label style="color:#808080; float:left;">Author: </label><span style="float: left; width: 315px;"><?php echo $mynl_newsletter[$i]['author_name'] ?></span>
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
                        <div style=" display: inline-block; vertical-align: text-bottom;" data-productid="<?php echo $mynl_newsletter[$i]['newsletter_id']; ?>" title="<?php echo $avg_round; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $avg_round; ?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="<?php echo $readonly ?>" class="rateit rateit9"></div>

                        <?php if (count($get_news_user_id) > 0) { ?>
                            <img style="margin-left: 5px; vertical-align: text-top; display: inline-block;" src="<?php echo base_url(); ?>assets/img/review_down.png" alt="">
                        <?php } ?>
                        <a style="text-decoration: none; margin-left: 3px; display: inline-block; vertical-align: top;" href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>">(<?php echo (!empty($total_user_rate)) ? $total_user_rate : "0"; ?>)</a>
                        <?php if (count($get_news_user_id) > 0) { ?>
                            <div style="left:0; top:20px;"  class="rating_popup">
                                <?php $popupcss = "style='float:none; width:100%;'"; ?>
                                <?php include("rating/rating_view.php"); ?>
                                <a href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>">See all <?php echo (!empty($total_user_rate)) ? $total_user_rate : "0"; ?> customer reviews</a>
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
                    <label style="color:#808080;"><?php echo $count_subscribed; ?> subscribers, language: <?php echo (!empty($mynl_newsletter[$i]['newsletter_language']) ? $mynl_newsletter[$i]['newsletter_language'] : "N/A") ?></label>
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
                            <a href="<?php echo site_url("newsletter/display-rate" . "/" . $mynl_newsletter[$i]['newsletter_id']); ?>"><img src="<?php echo base_url(); ?>assets/img/evaluate.png" class="evaluate" alt=""></a>

                                                                                <!--<span style="float: right; margin-top: 20px; text-align: center; color:#808080; font-size: 11px;">
                                                                                You are already subscribed<br>Go to ”<u>My Newsletters</u>”<br>to manage<br>your subscriptions.</span>-->
                        <?php } else { ?>
                            <img onclick="popups_ajax('subscribe_1', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $user_id ?>')" src="<?php echo base_url(); ?>assets/img/subscribe.png" alt="">
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
                    $every = ($get_schedule_by_id[0]['every']) ? "every " . $get_schedule_by_id[0]['every'] . " Week" : "";
                    $week0 = ($get_schedule_by_id[0]['weeks_on']) ? "on " . $get_schedule_by_id[0]['weeks_on'] : "";
                    ?>
                    <div class="sendingscheduale"><b>Sending Schedule:</b><label><?php echo $get_schedule_by_id[0]['sending'] . " " . $every . " " . $week0 . " at " . date("H.i", strtotime($get_schedule_by_id[0]['at'] . ":00:00")) ?></label></div>
                    <div class="sendingemail"><b>Sending to email:</b><label><?php echo $get_schedule_by_id[0]['sending_to_email'] ?></label><img style="cursor:pointer;" onclick="popups_ajax('subscribe_1_edit', '<?php echo $mynl_newsletter[$i]['newsletter_id'] ?>', '<?php echo $get_schedule_by_id[0]['schedule_id'] ?>')" src="<?php echo base_url(); ?>assets/img/edit.png" alt=""></div>
                    <!--onclick="popups_ajax_schedule('schedule','<?php //echo $get_schedule_by_id[0]['schedule_id']   ?>')"-->
                <?php } ?>

            </div>
        <?php } ?>   
    </div>
    <?php echo '<div class="pagination">' . $mynl_link . '</div>'; ?>
<?php } else { ?>
    <div class="findnewsletter_form">
        <h1 style="clear: both; color: black; text-align: center; margin-top: 64px;">Please <a style="cursor:pointer;" onclick="popup('signin')">Login</a> to view My newsletter!</h1>  
    </div>
    <?php
}?>