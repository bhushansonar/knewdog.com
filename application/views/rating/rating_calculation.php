<?php $total_user_rate = count($get_rate);
									$star_1 = array();
									$star_2 = array();
									$star_3 = array();
									$star_4 = array();
									$star_5 = array();
									$avg_rate = array();
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
											}										}
										//print_r($avg_rate);
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
										
										$rate_sum = array_sum($avg_rate);
										@$avg = (float)$rate_sum/(int)$total_user_rate;
										$avg_round = $avg;//round(2.8, 1);
?>