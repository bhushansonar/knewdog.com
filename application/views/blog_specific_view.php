<main>
<!--    <style>body{ overflow-x:hidden}</style>-->
    <div class="set_errors">
        <?php
        $user_id = $this->session->userdata("user_id");
        $username = $this->session->userdata("username");
        if ($user_id) {
            $this->load->model('user_model');
            $get_user_data = $this->user_model->get_user_by_id($user_id);
        }
        $blog_id = $this->uri->segment(4);
        //$user_id = $this->session->userdata("username");  
        if ($this->session->flashdata('validation_error_messages')) {
            echo $this->session->flashdata('validation_error_messages');
        }
        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {
            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        ?>
    </div>
    <section class="blog" id="container">
        <section id="blog_leftbar">
            <div class="blog_leftbar_inner">
                <div class="page_blogtitle">
                    <h2><?php echo _clang(KNEWDOG); ?></h2>
                    <hr>
                </div>
                <?php
                $language_shortcode = $this->session->userdata('language_shortcode');
                if (!empty($blog[0]['title_' . $language_shortcode])) {
                    $blog_title = $blog[0]['title_' . $language_shortcode];
                } else {
                    $blog_title = $blog[0]['title_en'];
                }
                if (!empty($blog[0]['description_' . $language_shortcode])) {
                    $blog_description = $blog[0]['description_' . $language_shortcode];
                } else {
                    $blog_description = $blog[0]['description_en'];
                }
//$blog_title = $blog[0]['title_'.$language_shortcode];
//$blog_description = $blog[0]['description_'.$language_shortcode];
                ?>
                <div id="blog_article" style="margin-bottom:20px;">
                    <div class="header_blogtitle">
                        <div class="blogtitle">
                            <h2 style="color:#E46C0A;"><?php echo $blog_title ?></h2>

                            <div class="date_time"><span><?php echo _clang(PUBLISHED_ON_B); ?></span> <?php echo date('j, F Y', strtotime($blog[0]['published_date'])) ?></div>
                        </div>
                    </div>
                    <div class="blog_content"><?php if (@getimagesize((site_url('uploads') . "/" . $blog[0]['featured_image']))) { ?>
                            <img alt="Feature Image" class="feature_img_blog_second" src="<?php echo site_url('uploads') . "/" . $blog[0]['featured_image'] ?>"  />
                        <?php } ?>
                        <?php echo $blog_description; ?>
                    </div>

                </div>
                <!-- AddThis Button BEGIN -->
                <div style="margin-top:10px; margin-bottom:10px;" class="addthis_toolbox addthis_default_style ">
                    <a href="#" class="addthis_button_facebook"></a>
                    <a href="#" class="addthis_button_google_plusone_share"></a>
                    <a href="#" class="addthis_button_linkedin"></a>
                    <a href="#" class="addthis_button_twitter"></a>
                    <a href="#" class="addthis_button_xing"></a>
                    <a href="#" class="addthis_button_email"></a>
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <!--<a class="addthis_button_tweet"></a>
                    <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
                    --><a class="addthis_counter addthis_pill_style"></a>
                </div>
                <script type="text/javascript">var addthis_config = {"data_track_addressbar": true};</script>
                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-537da6011b1baf6f"></script>
                <!-- AddThis Button END -->
                <hr />
                <div id="comments">
                    <header id="comments-title">
                        <h3><?php echo _clang(COMMENT); ?></h3>
                        <h4><em><?php echo $blog_title ?></em> — <?php echo (!empty($comment_count)) ? $comment_count : "0"; ?> <?php echo _clang(COMMENT); ?></h4>
                        <?php
                        //echo '<pre>'; print_r($all_comment);
                        $ci = & get_instance();
                        $ci->load->model('comment_model');
                        $ci->load->model('user_model');
                        ?>
                        <div class="comments_list">
                            <ul>
                                <?php
                                echo $all_com = getParentCommentList(0, '', '', 1, '', false, $blog_id);
                                ?> 
                            </ul>
                            <?php
//                            if ($link) {
//                                echo '<div class="pagination">' . $link . '</div>';
//                            }
//                            
                            ?>
                        </div>
                        <div class="comment_form">
                            <h1><?php echo _clang(LEAVE_COMMENT); ?></h1>
                            <?php if (!empty($user_id)) { ?>
                                <div class="logged_in_as"><?php echo _clang(LOGGED_AS_BS); ?> <a href="<?php echo site_url('myknewdog') ?>"><em><?php echo $username ?></em></a> 
                                    <a href="<?php echo site_url('home/logout') ?>"><em><?php echo _clang(LOGOUT_BS); ?></em></a></div>
                            <?php } else { ?>
                                <div class="logged_in_as"><?php echo _clang(LOGIN_TO); ?> <a href=""><em><?php echo $username ?></em></a> 
                                    <a href="javascript:void(0)" onclick=" popup('signin')"><em><?php echo _clang(LOGIN_BS); ?></em></a> </div>
                            <?php } ?>
                            <div class="form comment_form1">
                                <form action="<?php echo site_url("blog/comment") ?>" name="comment" method="post">
                                    <input type="hidden" id="cmt" value="0" name="parent_id">
                                    <input type="hidden" name="blog_id" value="<?php echo $blog_id ?>" />
                                    <?php if ($user_id) { ?>
                                        <input type="hidden" name="name" value="<?php echo $username ?>" />
                                        <input type="hidden" name="email" value="<?php echo $get_user_data[0]['primary_email'] ?>" />
                                    <?php } else { ?>
                                        <ul style="clear:both;">
                                            <li><?php echo _clang(NAME); ?></li>
                                            <li class="textbox_li"><input type="text" size="30" name="name"></li>
                                        </ul>
                                        <ul style="clear:both;">
                                            <li><?php echo _clang(EMAIL_BS); ?></li>
                                            <li class="textbox_li">
                                                <input type="text" size="30" name="email">
                                            </li>
                                            <li style="color: #808080;font-size: 11px;font-style: italic;width: 232px;">(Your e-mail address will NOT be published)</li>
                                        </ul>

                                    <?php } ?>
                                    <div id="reply_content">
                                        <div class="reply_to_content commnet_label" style="display: inline-block;width: 500px;">

                                        </div>
                                        <div id="close_btn" style="display: inline-block;">
                                            <a id="close_content" href="javascript:void(0)"></a>
                                        </div>
                                    </div>
                                    <p style="clear:both;">
                                        <label class="commnet_label"><?php echo _clang(COMMENT_BS); ?>:</label>
                                        <textarea class="comment_textarea" style="" name="comment"></textarea>
                                    </p>
                                    <div class="comment_recaptcha"><?php echo $recaptcha_html; ?></div>
                                    <p><input type="submit" name="submit" value="<?php echo _clang(SUBMIT_BUTTON) ?>" class="btn btn_main commnet_submit" /></p>
                                </form>
                            </div>
                        </div>
                    </header>
                </div>
            </div>
        </section>
        <?php include_once("includes/sidebars/blog_sidebar.php"); ?>
    </section>
</main>
<script type="text/javascript">
                    function reply_comment(obj, comment_id) {
                        $("#cmt").val(comment_id);
                        reply_to = $(obj).parent().siblings('.comment-body').html();
                        username = $(obj).parent().siblings().siblings('.aut').html();
                        if (reply_to.length > 10)
                            reply = reply_to.substring(0, 10);
                        str1 = "You replying to <u>" + username + "</u> on ";
                        str2 = "Cancle";
                        str3 = "...";

                        res = str1.concat(reply).concat(str3);

                        $('.reply_to_content').html("<h4>" + res + "</h4>");
                        $('#close_btn a').html(str2);


                        $("#close_content").click(function() {
                            $("#cmt").val(0);
                            $('.reply_to_content').html("");
                            $('#close_btn a').html("");
                        });

                        $('html, body').animate({
                            scrollTop: $('.comment_form').offset().top
                        }, 'slow');

                    }
</script>
