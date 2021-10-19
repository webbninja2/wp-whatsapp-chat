<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://acewebx.com
 * @since      1.0.0
 *
 * @package    Whatsapp_Chat_Multi_Agent
 * @subpackage Whatsapp_Chat_Multi_Agent/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Whatsapp_Chat_Multi_Agent
 * @subpackage Whatsapp_Chat_Multi_Agent/admin
 * @author     Acewebx <webbninja01@gmail.com>
 */
class ace_social_chat_multi_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Whatsapp_Chat_Multi_Agent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Whatsapp_Chat_Multi_Agent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/whatsapp-chat-multi-agent-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'fontawesome-cdn', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function admin_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Whatsapp_Chat_Multi_Agent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Whatsapp_Chat_Multi_Agent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		admin_enqueue_script('jquery');
		admin_enqueue_script('jquery-ui-tabs');
		admin_enqueue_script('jquery-ui-sortable');

		admin_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/whatsapp-chat-multi-agent-admin.js', array( 'jquery' ), $this->version, true );

	}
    
    public function codexInit() {
		$labels = array(
		    'name' => _x('Ace Social Chat', 'post type general name'),
		    'all_items' => 'All Agents',
		    'singular_name' => _x('Agent', 'post type singular name'),
		    'add_new' => _x('Add Agent', 'Agent'),
		    'style' => _x('Style', 'Agent'),
		    'add_new_item' => __("Add Agent"),
		    'edit_item' => __("Edit Agent"),
		    'new_item' => __("New Agent"),
		    'view_item' => __("View Agent"),
		    'search_items' => __("Search Agent"),
		    'not_found' =>  __('No Agent found'),
		    'not_found_in_trash' => __('No Agent found in Trash')
	  	);

	  	$args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true, 
		    'query_var' => true,
		    'rewrite' => true,
		    'capability_type' => 'post',
		    'hierarchical' => false,
		    'menu_position' => null,
		    'supports' => array('title','thumbnail')
	    ); 
	    register_post_type('ace_whatsapp_agent',$args);
	}


	public function aceAddPages() {
		add_submenu_page(
    	    'edit.php?post_type=ace_whatsapp_agent',
    	    __( 'Setting', 'menu-test' ),
    	    __( 'Setting', 'menu-test' ),
    	    'manage_options',
    	    'ace_whatsapp_style',
    	    array( $this, 'aceWhatsappMenuCallback')
		);
	}

	public function aceAddCustomMetaBox() {
		add_meta_box('ace_member_detail', 'WhatsApp Agent Account', array( $this, 'aceShowCustomMetaBox'), 'ace_whatsapp_agent', 'normal', 'low'); 

		add_meta_box('ace_member_shortcode', 'Agent ShortCode', array( $this, 'aceShowSidebarMetaBox'), 'ace_whatsapp_agent', 'side', 'default'); 
	}

	public function aceShowSidebarMetaBox(){ 
		global $post_id; if( !empty( $post_id )): ?>
			<div class="ace_member_box_shortc">
				<div class="ace_member_box_shortc_title">
					Copy the Shortcode and paste on your page.
				</div>
				<div class="ace_member_box_shortc_content">
					<span><?php echo'[ace_wtsp_agent id='.$post_id.']'; ?></span>
				</div>
			</div>		
        <?php endif; 
	} 

	public function aceShowCustomMetaBox(){
		global $post; 
		$post_id = $post->ID;
		$data = get_post_meta( $post_id, '_ace_wtp_member_acc_', true );

		$wDays = ( isset( $data['ace_member_weekdays'] )) ? $data['ace_member_weekdays'] : '' ;

		if( !empty( $data['ace_member_all_days']) == 1 ): $always_online = 'checked="checked"'; endif; ?>

		<div class="ace-wtm-content">
			<div class="ace-wtm-container">
				<div class="ace-wtm-row ace-wtm-no-label">
					<label>Agent WhatApp No.</label>
				</div>
				<div class="ace-wtm-row ace-wtm-column ace-wtm-no-field">
					<input type="text" name="member_number" id="ace_member_number" value="<?php (isset( $data['ace_member_number'] )) ? _e($data['ace_member_number']): '' ; ?>" >
				</div>
			</div>
			<div class="ace-wtm-container">
				<div class="ace-wtm-row ace-wtm-position-label">
					<label>Agent Position</label>
				</div>
				<div class="ace-wtm-row ace-wtm-column ace-wtm-position-field">
					<input type="text" name="member_position" id="ace_member_position" value="<?php (isset( $data['ace_member_position'] )) ? _e($data['ace_member_position']): '' ; ?>">
				</div>
			</div>

			<div class="ace-wtm-container">
				<div class="ace-wtm-row ace-wtm-btntext-label">
					<label>Button Text</label>
				</div>
				<div class="ace-wtm-row ace-wtm-column ace-wtm-btntext-field">
					<input type="text" name="member_btntext" id="ace_member_btntext" value="<?php (isset( $data['ace_member_btntext'] )) ? _e($data['ace_member_btntext']): '' ; ?>">
				</div>
			</div>

			<div class="ace-wtm-container">
				<div class="ace-wtm-row ace-wtm-online-label">
					<label>Agent Always Online</label>
				</div>
				<div class="ace-wtm-row ace-wtm-column ace-wtm-online-field">
				 <label class="switch">
				  <input type="checkbox" name="member_all_days" id="ace_member_all_days" value="1" <?php (isset($always_online)) ? _e($always_online): '' ; ?>  >
				  <span class="slider"></span>
				</label>
			 	  </label>
				</div>
			</div>
			<div class="ace-wtm-container  ace-wtm-container-custom">
				<div class="ace-wtm-row ace-wtm-custon-label">
					<label>Custom Availability</label>
				</div>
				<div class="ace-wtm-row ace-wtm-column ace-wtm-custon-field">
					<ul>
						<?php 
						$daysArr = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

						foreach ($daysArr as $key => $sDay) { 

							$wDch = ( isset($wDays[$sDay]['ischecked']) ) ? 'checked' : '';
							$sTime = ( isset( $wDays[$sDay]['start_time'] )) ? $wDays[$sDay]['start_time']: '' ;
							$eTime = ( isset( $wDays[$sDay]['end_time'] )) ? $wDays[$sDay]['end_time']: '' ;

							?>
							<li>
							  	<!-- sunday time  -->
							  	<div class="ace-all-days-column">
							  		<div class="ace-day-fields ace-day-checkbox">
							  			<input type="checkbox" id="ace-sun" name="day[<?php echo $sDay; ?>][ischecked]" value="1" <?php _e($wDch) ;?> >		
							  		</div>
							  		<div class="ace-day-fields ace-day-label ace-sun-label">
							  			<label class="ace-label "><?php echo $sDay; ?></label>	
							  		</div>
							  		<div class="ace-day-fields ace-day-start-time" >
							  			<select name="day[<?php echo $sDay; ?>][start_time]" class="slct ace-selct-sun-start">
								    	<option value="" >Start Time</option>
								    	<?php for ($i=0; $i <= 23 ; $i++) { $t = $i.":00";
								    		?> 
								    				<option value="<?php echo $t; ?>" <?php if( !empty($sTime) && $sTime == $t ) echo 'selected';?> >
								    					<?php echo $t;?></option>
								    <?php 	} ?>
								    </select>		
							  		</div>
							  		<div class="ace-day-fields ace-day-end-time">
							  			<select name="day[<?php echo $sDay; ?>][end_time]" class="slct ace-slct-sun-end">
								    		<option value="" >End Time</option>
								    		<?php for ($i=0; $i <= 23 ; $i++) { $t = $i.':00';?> 
								    				<option value="<?php echo $t; ?>" <?php if( !empty($eTime) && $eTime == $t ) echo 'selected';?> >
								    					<?php echo $t;?></option>
								    		<?php 	} ?>
								    	</select>
							  		</div>
							  	</div>
							    <!-- <div class="check"><div class="inside"></div></div> -->
							  </li>

						<?php } ?>

					</ul>
				</div>
			</div>
		</div>
    <?php
    
    }


	public function aceSaveAgent( $post ){
		global $post_id;
		$member_number = ( isset( $_POST['member_number'] ))? sanitize_text_field($_POST['member_number']): ''; 
		$member_position = ( isset( $_POST['member_position'] ))? sanitize_text_field($_POST['member_position']): '';
		$member_all_days = ( isset( $_POST['member_all_days'] ))? sanitize_text_field($_POST['member_all_days']): '0';
		$member_btntext = ( isset( $_POST['member_btntext'] ))? sanitize_text_field($_POST['member_btntext']): 'Need help? Chat via WhatsApp' ;

		$data = array(
			'ace_member_number' 	=> $member_number,
			'ace_member_position' 	=> $member_position,
			'ace_member_all_days' 	=> $member_all_days,
			'ace_member_btntext'    => $member_btntext,
			'ace_member_weekdays'   => ( isset( $_POST['day'] ))? sanitize_text_field($_POST['day']): ''
			
		);

		$orderBy = get_option('awm_users_sortable_');
		if ( $orderBy ) {
			if ($post_id) {
			$new_post = array($post_id);
			if( empty($orderBy['awm_users_sortable_']) ) $orderBy['awm_users_sortable_'] = array();
			$merge = array_merge($orderBy['awm_users_sortable_'],$new_post);
			$update_sortable = update_option( 'awm_users_sortable_', $merge );		
			}
		}else{
			$new_post = array($post_id);
			$update_sortable = update_option( 'awm_users_sortable_',$new_post);	
		}
		update_post_meta( $post_id, '_ace_wtp_member_acc_' , $data);
	} 


	public function aceSetCustomEditAgentColumns($columns) {
	    $columns = array(
		'cb' => '&lt;input type="checkbox" />',
		'title' => __( 'Agent Name' ),
		'member_pic' => __( 'Picture' ),
		'position' => __( 'Position' ),
		'whatsapp_number' => __( 'WhatsApp Number'),
		'active_days' => __( 'Active Days' ),
		'shortcode_member' => __( 'ShortCode Agent' )
	);
	    return $columns;
	}

	public function aceCustomAgentColumn( $column, $post_id ) {
        $get_column = get_post_meta( $post_id, '_ace_wtp_member_acc_', true );
	    switch ( $column ) {

	    	case 'member_pic' :
	        	$args = array('post_type' => 'ace_whatsapp_agent');
				$img = query_posts( $args );
	            if ( has_post_thumbnail() ):
	            	the_post_thumbnail( 'shop_thumbnail', array('class' => 'wp_member_img' ) );
	            	else: echo "<span class='wp_member_img'>Image Not Set</span>";
	            endif;
	            break;

	        case 'position' :
	            if ( !empty( $get_column['ace_member_position'] ) ):
	            	echo "<h2>".ucfirst( $get_column['ace_member_position'])."</h2>";
	            	else: echo "Position Not Mentaion";
	            endif;
	            break;

			case 'whatsapp_number' :
	            if ( !empty( $get_column['ace_member_number'] ) ):
	            	echo $get_column['ace_member_number'];
	            	else: echo "Number Not Mentaion";
	            endif;
	            break;

			case 'active_days' :

				if ( $get_column['ace_member_weekdays'] ) {
					foreach ($get_column['ace_member_weekdays'] as $key => $sday) {
						if( isset($sday['ischecked']) ) $activeDays[] = $key;
					}

					if ( isset($activeDays) && !empty($activeDays) ) {
						echo implode(', ', $activeDays);
					}else{
						_e('Days Not Set');
					}	
				}else{
					echo 'Days Not Mentaion';
				}
				
	            break;	            

	        case 'shortcode_member' :
	            if ( !empty( $post_id ) ):
	            	echo '[ace_wtsp_agent id='.$post_id.']';
	            	else: echo "Empty shortcode";
	            endif;
	            break;


	    }
	}

	public function aceWhatsappMenuCallback() {
		if( isset( $_POST['ace_chat_setting_save'] ) ) {
			$whatsapp_start_chat     = (isset ( $_POST['whatsapp_start_chat']))? sanitize_text_field( $_POST['whatsapp_start_chat'] ):"";
			$whatsapp_content        = (isset ( $_POST['whatsapp_content']))? sanitize_text_field( $_POST['whatsapp_content'] ):"";
			$whatsapp_btn_color      = (isset ( $_POST['whatsapp_btn_color']))? sanitize_text_field( $_POST['whatsapp_btn_color'] ):"";
			$whatsapp_txtbtn_color   = (isset ( $_POST['whatsapp_txtbtn_color']))? sanitize_text_field( $_POST['whatsapp_txtbtn_color'] ):"";
			$whatsapp_hide_btn       = (isset ( $_POST['wp_hidden_button']))? sanitize_text_field( $_POST['wp_hidden_button'] ):"";
			$wp_display_home		 = (isset ( $_POST['wp_display_home']))? sanitize_text_field( $_POST['wp_display_home'] ):"";
			$wp_mobile_display		 = (isset ( $_POST['wp_mobile_display']))? sanitize_text_field( $_POST['wp_mobile_display'] ):"";
			$wp_woocom_button		 = (isset ( $_POST['wp_woocom_button']))? sanitize_text_field( $_POST['wp_woocom_button'] ):"";

			$error = array();
			if( $whatsapp_hide_btn == 1 ): $checked = 1; else: $checked = 0; endif;

			if( $wp_display_home == 1 ): $wp_display_home = 1; else: $wp_display_home = 0; endif;

			if( $wp_mobile_display == 1 ): $wp_mobile_display = 1; else: $wp_mobile_display = 0; endif;

			if( $wp_woocom_button == 1 ):	$wp_woocom_button = 1; else: $wp_woocom_button = 0; endif;

			if( empty( $error ) ):
				update_option( 'ace-whatsapp-setting-field-M', array( 
														'whatsapp_start_chat' => $whatsapp_start_chat, 
														'whatsapp_content' => $whatsapp_content,
														'ace_whatsapp_hiden_btn' => $checked,
														'ace_whatsapp_btn_color' => $whatsapp_btn_color,
														'ace_whatsapp_txtbtn_color' => $whatsapp_txtbtn_color,
														'ace_wp_display_home' => $wp_display_home,
														'ace_wp_mobile_display' => $wp_mobile_display,
														'ace_wp_woocom_button' => $wp_woocom_button 	 ) );
			endif;
		}

		$sortable_save = 0;
		if ( isset($_POST['sortable']) ) {
			if( empty( $error ) ){
					//$update_sortable = update_option( 'awm_users_sortable_', $_POST['sortable_column'] );

					$update_sortable = update_option(sanitize_text_field('awm_users_sortable_', $_POST['sortable_column']));

			}
		}
		$get_setting_value = get_option( 'ace-whatsapp-setting-field-M' );
 		if( !empty( $get_setting_value['ace_whatsapp_hiden_btn']) == 1 ): $hiden_btn_check = 'checked="checked"'; endif;

 		if( !empty( $get_setting_value['ace_wp_display_home']) == 1 ): $display_home = 'checked="checked"'; endif;

 		if( !empty( $get_setting_value['ace_wp_woocom_button']) == 1 ): $woocom_btn_check = 'checked="checked"'; endif;

 		if( !empty( $get_setting_value['ace_wp_mobile_display']) == 1 ): $mobile_display = 'checked="checked"'; endif;

 		if ( !empty( $error ) ) : ?>
			<div class="notice notice-error is-dismissible"><h1>
 		<?php foreach ($error as $value): ?>
		        <font size="2em"><?php echo "<font color='red'>*</font>"; print_r( $value ); ?></font>
 		<?php endforeach; ?>
 			</h1></div>	 			 	
        <?php else: if( isset( $_POST['ace_chat_setting_save'] ) || isset($_POST['sortable'] ) ): ?>
 				<br>
		        <div class="notice notice-success is-dismissible">
    				<font size="2em"><h4><?php _e( 'Successfully Done!', 'ace_whatsapp_chat_wp' ); ?></h4></font>
   			 </div>

 		<?php endif; endif;
	 	require( plugin_dir_path( __FILE__ ).'partials/whatsapp-chat-multi-agent-admin-settings.php' );
	 }

}
function wpdocs_enqueue_admin_print_style() {
       // wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
        //wp_enqueue_style( 'custom_wp_admin_css');
     

}
add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_admin_print_style' );