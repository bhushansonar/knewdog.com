<aside id="sidebar">
                <div id="sidebar_right">
                    <aside class="widget"><h3 class="widget-title" style="font-size:20px; margin-bottom:1.5em;"><?php echo _clang(HOW_CAN);?></h3>			
                        <div class="widget_content">
							<p><img height="150" width="150" src="<?php echo base_url(); ?>assets/img/pictogram4-150x150.png" alt="" class="alignnone size-thumbnail wp-image-260"></p> 
                        </div>
                    </aside>
                    
                    <aside class="widget">
                    <h3 class="widget-title"><?php echo _clang(HELP_CENTRE);?></h3>			
                        <div class="widget_content">
                            <ul>
                            	<?php $cms_help_list = cms_help_list();
								//echo '<pre>'; print_r($cms_help_list);
						for($i=0;$i<count($cms_help_list);$i++){
							$display_name = ($cms_help_list[$i]['display_name_'.$this->session->userdata('language_shortcode')] != "") ? $cms_help_list[$i]['display_name_'.$this->session->userdata('language_shortcode')] : $cms_help_list[$i]['display_name_en']; 
							$block_url = ($cms_help_list[$i]['block_name'] == 'HELP_PAGE') ? "" : $cms_help_list[$i]['block_name'];
							?>
                    	<li><a href="<?php echo site_url('help')."/".$block_url?>"><?php echo $display_name?></a></li>
                        <?php }?>
                            <li><a href="<?php echo site_url('contactus')?>"><?php echo _clang(CONTACT_US_HS);?></a></li>
                            </ul>
                        </div>
                    </aside>
                 </div>
            </aside>