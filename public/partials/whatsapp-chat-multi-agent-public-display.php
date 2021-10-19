<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    Whatsapp_Chat_Multi_Agent
 * @subpackage Whatsapp_Chat_Multi_Agent/public/partials
 */

global $product;
$gSetting = get_option( 'ace-whatsapp-setting-field-M' );
( $gSetting['whatsapp_content'] ) ? $wTitle = $gSetting['whatsapp_content']: '';
( $gSetting['ace_whatsapp_btn_color'] ) ? $bgcolor = $gSetting['ace_whatsapp_btn_color']: '';
( $gSetting['ace_whatsapp_txtbtn_color'] ) ? $color = $gSetting['ace_whatsapp_txtbtn_color']: '' ;

?>

<style type="text/css"> 
.awc_mBox, 
.chat_box_header { background:<?php echo $bgcolor;  ?>; color:<?php echo $color; ?>; }
.chat_box { background-image: url(<?php echo plugin_dir_url(__DIR__).'/images/whatsapp-bkg.png';;  ?>); }
#chatPage .chat_button{ color:<?php echo $bgcolor; ?>; }
#chatPage .chat_button:hover{ background:<?php echo $bgcolor;  ?>; }
</style>
<!--<link href="https://fonts.googleapis.com/css?family=Poppins:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">-->
<div id="chatPage" class="chat_page">
  <button onclick="openChatBox()" class="chat_button">
  <i id="chatOpen" class="fab fa-whatsapp"></i>
</button>
<div id="chatbar" class="chat_box animated fadeInUp">
	<div class="chat_box_header">
		<?php echo $wTitle; ?>
	</div>
	<div id="chatBody" class="chat_box_body">
  		<div class="awc_mContent" id="ace_style-16" >
<?php

    		$orderBy = get_option('awm_users_sortable_');
			$preTimeZ = get_option('gmt_offset');
		    $hours = ceil($preTimeZ);
			$newCTime = gmdate("H", strtotime('+'.$hours.' hours'));
			$cDay = gmdate("l", strtotime('+'.$hours.' hours'));

// 			$args = ( isset($orderBy)  ) ? 
// 							array( 'post_type' => 'ace_whatsapp_agent', 'pst_per_page' => -1,
// 							'orderby' => 'post__in', 
//     						'post__in' => $orderBy ): 
//     						array( 'post_type' => 'ace_whatsapp_agent', 'pst_per_page' => -1 );
	        
	        $args = array( 'post_type' => 'ace_whatsapp_agent', 'posts_per_page' => -1);
			
			$member_query = new WP_Query($args);
			if( $member_query->have_posts() ) {
				while ($member_query->have_posts()) : $member_query->the_post();
				 
				$get_cust_id = get_the_ID();
				$member_custom_field = get_post_meta( $get_cust_id, '_ace_wtp_member_acc_', true ); 

				$allDay = $member_custom_field['ace_member_all_days'];
				if ($allDay) {
					$mClass = ( $allDay ) ? 'awc_online' : 'awc_offline';
				}else{
					$wDays = $member_custom_field['ace_member_weekdays'];

					if (isset( $wDays[$cDay]['ischecked'] )) {

						$st = ($wDays[$cDay]['start_time']) ? $wDays[$cDay]['start_time'] : '0:00';
						$et = ($wDays[$cDay]['end_time']) ? $wDays[$cDay]['end_time'] : '23:00';
						
						$sT = explode(':', $st)[0];
						$eT = explode(':', $et)[0];

						if ($newCTime >= $sT && $newCTime <= $eT) {  
							
							$mClass = 'awc_online';
						
						}else{

							$mClass = 'awc_offline';
							$offMsg =  'Online from '.$st.' - '.$et.' UTC';
						}

					}else{
						$mClass = 'awc_offline';
						$offMsg =  'Agent is offline.';
					}

				}

			    if($mClass == 'awc_online') {
			    	$mUrl = 'https://';
			    	$mUrl .= ( wp_is_mobile() ) ? "api" : "web"; 
					$mUrl .= '.whatsapp.com/send?phone='.$member_custom_field['ace_member_number'].'&text='.$text;
					$target = 'target="_blank"';



			    }else{
			    	$mUrl = 'javascript:;';
					$target = '';
				}
				
				if (has_post_thumbnail( isset( $post->ID ) ) ){
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ) );
					$image = $image[0];
				}else{
					$image = plugin_dir_url(__DIR__).'/images/profile.jpg';
				}


			?>
	        <div class="awc_sMember <?php echo $mClass; ?> ">
		            <a href="<?php echo $mUrl; ?>" <?php echo $target; ?> onclick="gtag('event', 'WhatsApp', {'event_action': 'whatsapp_chat', 'event_category': 'Chat', 'event_label': 'Chat_WhatsApp'});">
		                <div class="awc_mImg">
		                	<img class="awcImg" src="<?php echo $image; ?>">
		                </div>
		                <div class="awc_mData tt">
		                    <p class="awc_mTitle"><?php the_title(); ?></p>
		                    <p class="awc_mStatus"><?php echo $member_custom_field['ace_member_position'];?></p>
		                    <p class="awc_wIco"><i class="fab fa-whatsapp" aria-hidden="true"></i></p>
		                    <?php if($mClass == 'awc_offline'){
		                    	echo '<a href ="#"><p class="awc_mOnlinetime">'.$offMsg.'</a> </p>';
		                    } else { echo $member_custom_field['ace_member_btntext'];  }?>
		                </div>
		                <div class="awc_clear"></div>
		            </a>
	        </div>
			  <?php endwhile;
			}else{ ?>
				<div class="awc_sMember ">
		            <p style="text-align: center;">No Agent Found</p>
	        </div>
			<?php } wp_reset_query(); ?>


    	</div>
	</div>
</div>
</div>

<script type="text/javascript">

    var ischatopen = false;
	var ele = document.getElementById("chatbar");

	function openChatBox()
	{
		if(ischatopen == false)
	    {
	       ele.classList.add("newToggle");
	       ischatopen = true;
	       document.getElementById("chatOpen").classList.remove("fa-whatsapp");
	       document.getElementById("chatOpen").classList.remove("fab");
	       document.getElementById("chatOpen").classList.add("fas");
			document.getElementById("chatOpen").classList.add("fa-times");
	      
	    }else {
			ele.classList.remove("newToggle");
			ischatopen = false;
			document.getElementById("chatOpen").classList.add("fa-whatsapp");
			document.getElementById("chatOpen").classList.add("fab");
			document.getElementById("chatOpen").classList.remove("fas");
			document.getElementById("chatOpen").classList.remove("fa-times");
	  	}
	}

</script>