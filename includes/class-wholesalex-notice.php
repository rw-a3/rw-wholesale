<?php
/**
 * Admin Action.
 *
 * @package WHOLESALEX
 * @since 1.0.0
 */

namespace WHOLESALEX;

/**
 * WholesaleX Notice Class
 */
class WHOLESALEX_Notice {

	/**
	 * Contains Notice Version
	 *
	 * @var string
	 */
	private $notice_version = 'v9';

	/**
	 * Contains Notice type
	 *
	 * @var string
	 */
	private $type = '';
	/**
	 * Contains notice is force or not
	 *
	 * @var string
	 */
	private $force = '';
	/**
	 * Contain Notice content.
	 *
	 * @var string
	 */
	private $content = '';

	private $heading = '';

	private $subheading = '';

	private $days_remaining = '';

	private $available_notice = array();

	private $price_id = false;

	/**
	 * Admin WooCommerce Installation Notice Action
	 *
	 * @since 1.0.0
	 */
	public function install_notice() {
		add_action( 'wp_ajax_wc_install', array( $this, 'wc_install_callback' ) );
		add_action( 'admin_notices', array( $this, 'wc_installation_notice_callback' ) );
	}


	/**
	 * Admin WooCommerce Activation Notice Action
	 *
	 * @since 1.0.0
	 */
	public function active_notice() {
		add_action( 'admin_notices', array( $this, 'wc_activation_notice_callback' ) );
		add_action( 'admin_action_wc_activate', array( $this, 'wc_activate_action' ) );
	}

	/**
	 * Promotional Notice Callback
	 *
	 * @since 1.0.0
	 */
	public function promotion() {

		// $price_id =get_option('__wholesalex_price_id','');
		// $default_notice = array(
		// array(
		// 'start'   => '26-11-2023', // Date format "d-m-Y" [08-02-2019]
		// 'end'     => '07-12-2023',
		// 'type'    => 'content',
		// 'content' => array('heading'=>'🎉 Your Cyber Monday Gift! 🎉','subheading'=>'Start selling in bulk and Skyrocket your sales. Get Your Cyber Monday gift <span class="wholesalex-notice-content-upto">Up to 65% off</span>. <strong>WholesaleX</strong> is the complete solution for B2B WooCommerce.','countdown_start'=>'04-12-2023'),
		// 'force'   => true,
		// 'key'     => 'cyber_monday_free_1',
		// 'is_show'     => !wholesalex()->is_pro_active(),
		// ),
		// array(
		// 'start'   => '26-11-2023', // Date format "d-m-Y" [08-02-2019]
		// 'end'     => '07-12-2023',
		// 'type'    => 'content',
		// 'content' => array('heading'=>'Your Cyber Monday Gift! ','subheading'=>'Upgrade to a lifetime plan now and keep using WholesaleX forever. <strong> Skip Renewal Hassle! </strong>','countdown_start'=>'04-12-2023'),
		// 'force'   => true,
		// 'key'     => 'cyber_monday_pro_1',
		// 'is_show'     => wholesalex()->is_pro_active() && ('6'!=$price_id && '7'!=$price_id),
		// )

		// );
		// if ( count( $default_notice ) > 0 ) {
		// foreach ( $default_notice as $key => $notice ) {
		// $current_time = date('U');
		// if ( $current_time > strtotime( $notice['start'] ) && $current_time < strtotime( $notice['end'] ) && $notice['is_show'] ) {
		// $this->type    = $notice['type'];
		// $this->content = $notice['content'];
		// $this->force   = $notice['force'];
		// $this->notice_version = $notice['key'];
		// $this->heading = isset($notice['content']['heading'])? $notice['content']['heading']:'';
		// $this->subheading = isset($notice['content']['subheading'])? $notice['content']['subheading']:'';
		// if(isset($notice['content']['countdown_start']) && $current_time>=strtotime($notice['content']['countdown_start'])) {
		// $your_date = strtotime($notice['end']);
		// $datediff = $your_date -  $current_time;
		// $this->days_remaining = round($datediff / (60 * 60 * 24)) - 1;
		// }
		// add_action( 'admin_notices', array( $this, 'promotional_notice_callback' ) );
		// }
		// }
		// }
		add_action( 'admin_init', array( $this, 'notice_callback' ) );
		add_action( 'admin_notices', array( $this, 'display_notices' ) );

	}

	public function notice_content( $heading = '', $subheading = '', $key = '' ) {
		wp_enqueue_style( 'dashicons' );
		$submit_text = 'Grab The Deal';
		$skip_text   = 'Skip Renewal Hassle!';
		$logo        = WHOLESALEX_URL . 'assets/img/icon.svg';
		$deal_link   = 'https://getwholesalex.com/pricing/?utm_source=wholesalex-ad&utm_medium=DB-banner&utm_campaign=wholesalex-DB';

		?>
		<style>
			.wholesalex-notice-content-upto{
				color: #f2704e;
				font-weight: bold;
			}
			.wholesalex-content-notice {
				background: #fff;
				border: 1px solid #c3c4c7;
				border-left-color: #6C6CFF  !important;
				border-left-width: 4px;
				border-radius: 4px 0px 0px 4px;
				box-shadow: 0 1px 1px rgba(0,0,0,.04);
				padding: 0px !important;
				margin: 40px 0px !important;
			}
			.wholesalex-content-notice .wholesalex-content-notice-container {
				display: flex;
			}

			.wholesalex-content-notice .wholesalex-content-notice-container a{
				text-decoration: none;
			}

			.wholesalex-content-notice .wholesalex-content-notice-container a:visited{
				color: white;
			}
			.wholesalex-content-notice .wholesalex-content-notice-container img {
				height: 100%; 
				width: 100%;
				max-width: 30px !important;
				padding: 12px;
			}

			.wholesalex-content-notice .wholesalex-content-notice-image {
				display: flex;
				align-items: center;
				flex-direction: column;
				justify-content: center;
				background-color: #f4f4ff;
			}
			.wholesalex-content-notice .wholesalex-content-notice-image img{
				max-width: 100%;
				/* height: 300px; */
			}

			.wholesalex-content-notice .wholesalex-content-notice-content {
				width: 100%;
				margin: 5px !important;
				padding: 8px !important;
				display: flex;
				flex-direction: column;
				gap: 0px;
			}

			.wholesalex-content-notice .wholesalex-content-notice-wholesalex-content-button {
				max-width: fit-content;
				text-decoration: none;
				padding: 7px 12px;
				font-size: 12px;
				color: white;
				border: none;
				border-radius: 2px;
				cursor: pointer;
				margin-top: 6px;
				background-color: #6C6CFF ;
			}

			.wholesalex-content-notice-heading {
				font-size: 18px;
				font-weight: 500;
				color: #1b2023;
			}

			.wholesalex-content-notice-content-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
			}

			.wholesalex-content-notice-close .dashicons-no-alt {
				font-size: 25px;
				height: 26px;
				width: 25px;
				cursor: pointer;
				color: #585858;
			}

			.wholesalex-content-notice-close .dashicons-no-alt:hover {
				color: red;
			}

			.wholesalex-content-notice-content-body {
				font-size: 12px;
				color: #343b40;
			}
			.wholesalex-content-bold {
				font-weight: bold;
			}
			a.wholesalex-content-pro-dismiss:focus {
				outline: none;
				box-shadow: unset;
			}
			.wholesalex-content-free-notice .loading, .wholesalex-content-notice .loading {
				width: 16px;
				height: 16px;
				border: 3px solid #FFF;
				border-bottom-color: transparent;
				border-radius: 50%;
				display: inline-block;
				box-sizing: border-box;
				animation: rotation 1s linear infinite;
				margin-left: 10px;
			}
			a.wholesalex-content-notice-wholesalex-content-button:hover {
				color: #fff !important;
			}
			.wholesalex-content-notice .wholesalex-content-link-wrap  {
				margin-top: 10px;
			}
			.wholesalex-content-notice .wholesalex-content-link-wrap a {
				margin-right: 4px;
			}
			.wholesalex-content-notice .wholesalex-content-link-wrap a:hover {
				background-color: #004fd0;
			}
			body .wholesalex-content-notice .wholesalex-content-link-wrap > a.wholesalex-content-notice-skip {
				background: none !important;
				border: 1px solid #6C6CFF ;
				color: #6C6CFF ;
				padding: 6px 15px !important;
			}
			body .wholesalex-content-notice .wholesalex-content-link-wrap > a.wholesalex-content-notice-skip:hover {
				background: #6C6CFF  !important;
			}
			@keyframes rotation {
				0% {
					transform: rotate(0deg);
				}

				100% {
					transform: rotate(360deg);
				}
			}

		</style>
		<div class="wholesalex-content-notice">
			<div class="wholesalex-content-notice-container">
				<div class="wholesalex-content-notice-image"><img src="<?php echo esc_url( $logo ); ?>"/></div>
				<div class="wholesalex-content-notice-content">
					<div class="wholesalex-content-notice-content-header">
						<div class="wholesalex-content-notice-heading">
							<?php echo esc_html( $heading ); ?>
							<?php
							if ( $this->days_remaining ) {
								echo '(' . $this->days_remaining . ' Days Left!)';
							}
							?>
						</div>
						<div class="wholesalex-content-notice-close">
							<a class="wholesalex-content-wholesalex-content-pro-dismiss" href="<?php echo esc_url( add_query_arg( 'disable_wholesalex_notice_' . $this->notice_version, 'yes' ) ); ?>"><span class="dashicons dashicons-no-alt"></span></a>
						</div>
					</div>
					<div class="wholesalex-content-notice-content-body">
						<?php echo $subheading; ?>
					</div>
					<div class="wholesalex-content-link-wrap">
						<a id="wholesalex-content_install_wholesalex-content" href="<?php echo esc_url( $deal_link ); ?>" target="_blank" class="wholesalex-content-notice-wholesalex-content-button" ><?php echo esc_html( $submit_text ); ?></a>
						<a id="wholesalex-content_install_wholesalex-content" href="<?php echo esc_url( add_query_arg( 'disable_wholesalex_notice_' . $this->notice_version, 'yes' ) ); ?>" class="wholesalex-content-notice-wholesalex-content-button wholesalex-content-notice-skip" ><?php echo esc_html( $skip_text ); ?></a>
					</div>
				</div>
			</div>
		</div>
		<?php

	}

	private function get_notice_by_id( $id ) {
		if ( isset( $this->available_notice[ $id ] ) ) {
			return $this->available_notice[ $id ];
		}
	}

	/**
	 * Promotional Dismiss Notice Option Data
	 *
	 * @since 1.0.0
	 * @return NULL
	 */
	public function notice_callback() {
		$this->price_id         = $this->get_price_id();
		$activate_date          = get_option( 'wholesalex_installation_date', false );
		$this->available_notice = array(
			// Free to Pro
			'wsx_free_promo_1'        => $this->set_new_notice( 'wsx_free_promo_1', 'promotion', 'pro_1', '1-2-2024', '10-2-2024', false, 10, ! wholesalex()->is_pro_active() ),
			'wsx_free_promo_2'        => $this->set_new_notice( 'wsx_free_promo_2', 'promotion', 'pro_2', '15-2-2024', '25-2-2024', false, 10, ! wholesalex()->is_pro_active() ),
			'wsx_free_promo_3'        => $this->set_new_notice( 'wsx_free_promo_3', 'promotion', 'pro_3', '1-3-2024', '10-3-2024', false, 10, ! wholesalex()->is_pro_active() ),
			'wsx_free_promo_4'        => $this->set_new_notice( 'wsx_free_promo_4', 'promotion', 'pro_4', '15-3-2024', '25-3-2024', false, 10, ! wholesalex()->is_pro_active() ),

			// Pro Tier 3 -> Unlimited Sites to Lifetime or others
			'wsx_pro_lifetime_unli_1' => $this->set_new_notice( 'wsx_pro_lifetime_unli_1', 'promotion', 'lifetime_n_unlimited_1', '1-2-2024', '20-2-2024', false, 10, in_array( $this->price_id, array( 3 ) ) ),
			'wsx_pro_lifetime_unli_2' => $this->set_new_notice( 'wsx_pro_lifetime_unli_2', 'promotion', 'lifetime_n_unlimited_1', '10-3-2024', '30-3-2024', false, 10, in_array( $this->price_id, array( 3 ) ) ),

			// Pro Tier 1 -> Single Site to Lifetime or Others
			'wsx_lifetime_1'          => $this->set_new_notice( 'wsx_lifetime_1', 'promotion', 'lifetime_1', '1-2-2024', '20-2-2024', false, 10, in_array( $this->price_id, array( 1 ) ) ),
			'wsx_lifetime_2'          => $this->set_new_notice( 'wsx_lifetime_2', 'promotion', 'lifetime_2', '10-3-2024', '30-3-2024', false, 10, in_array( $this->price_id, array( 1 ) ) ),

			// Welcome
			'welcome_notice'          => array(
				'id'                        => 'welcome_notice',
				'type'                      => 'promotion',
				'start'                     => $activate_date, // Start Date
				'end'                       => strtotime( '+7 day', $activate_date ), // End Date date('d-m-Y',strtotime($activate_date,strtotime('+7 day',$activate_date)))
				'design_type'               => 'welcome',
				'repeat_notice_after'       => false, // Repeat after how many days
				'priority'                  => 30, // Notice Priority
				'display_with_other_notice' => false, // Display With Other Notice
				'show_if'                   => ! wholesalex()->is_pro_active() && $activate_date, // Notice Showing Conditions
				'capability'                => 'manage_options', // Capability of users, who can see the notice
			),

			// Data Collection
			'data_collection_notice'  => array(
				'id'                        => 'data_collection_notice',
				'type'                      => 'data_collect',
				'design_type'               => 'data_collection',
				'start'                     => '15-2-2024', // Start Date
				'end'                       => '1-1-2030', // End Date
				'repeat_notice_after'       => 60, // Repeat after how many days
				'if_allow_repeat_days'      => 2000,
				'priority'                  => 30, // Notice Priority
				'display_with_other_notice' => false, // Display With Other Notice
				'show_if'                   => true, // Notice Showing Conditions
				'capability'                => 'manage_options', // Capability of users, who can see the notice
			),

		);


		if ( isset( $_GET['wsx-data-collect'] ) ) {
			$notice_key = sanitize_text_field( $_GET['wsx-data-collect'] );
			$notice     = $this->get_notice_by_id( $notice_key );
			if ( 'data_collect' == $notice['type'] ) {
				if ( isset( $notice['if_allow_repeat_days'] ) && $notice['if_allow_repeat_days'] ) {
					$repeat_timestamp = ( DAY_IN_SECONDS * intval( $notice['if_allow_repeat_days'] ) );
					$this->set_notice( $notice_key, 'off', $repeat_timestamp );
					// Collect Data
					// Will Send to WPXPO Inside
					WHOLESALEX_Setup_Wizard::send_plugin_data( 'allow' );
				}
			}
		}
		if ( isset( $_GET['wsx-notice-disable'] ) ) {
			$notice_key = sanitize_text_field( $_GET['wsx-notice-disable'] );
			$notice     = $this->get_notice_by_id( $notice_key );
			if ( 'data_collect' == $notice['type'] ) {
				if ( isset( $notice['repeat_notice_after'] ) && $notice['repeat_notice_after'] ) {
					$repeat_timestamp = ( DAY_IN_SECONDS * intval( $notice['repeat_notice_after'] ) );
					$this->set_notice( $notice_key, 'off', $repeat_timestamp );
				}
			} else {
				if ( isset( $notice['repeat_notice_after'] ) && $notice['repeat_notice_after'] ) {
					$repeat_timestamp = time() + ( DAY_IN_SECONDS * intval( $notice['repeat_notice_after'] ) );
					$this->set_user_notice_meta( $notice_key, 'off', $repeat_timestamp );
				} else {
					$this->set_user_notice_meta( $notice_key, 'off', false );
				}
			}
		}
	}


	/**
	 * Promotional Banner Notice
	 */
	public function promotional_notice_callback() {
		if ( $this->get_notice( 'wholesalex_get_pro_notice_' . $this->notice_version ) != 'off' ) {
			if ( ( $this->force || ( date( 'U' ) > get_option( 'wholesalex_installation_date' ) ) ) ) {
				if ( ! isset( $_GET[ 'disable_wholesalex_notice_' . $this->notice_version ] ) ) {
					$this->wc_notice_css();
					?>
						<?php
						switch ( $this->type ) {
							case 'banner':
								?>
								<div class="wholesalex-wc-install wholesalex-pro-notice-v2">
									<div class="wholesalex-wc-install-body wholesalex-image-banner-v2">
										<a class="wc-dismiss-notice" href="<?php echo esc_url( add_query_arg( 'disable_wholesalex_notice_' . $this->notice_version, 'yes' ) ); ?>">
											<?php echo esc_html__( 'Dismiss', 'wholesalex' ); ?>
										</a>
										<a class="wholesalex-btn-image" target="_blank" href="<?php echo esc_url( 'https://getwholesalex.com/pricing/?utm_source=wholesalex-ad&utm_medium=DB-banner&utm_campaign=wholesalex-DB' ); ?>">
											<img loading="lazy" src="<?php echo esc_url( $this->content ); ?>" alt="Discount Banner"/>
										</a>
									</div>
									</div>

								<?php
								break;
							case 'content':
								$this->notice_content( $this->heading, $this->subheading, $this->notice_version );
								break;
						}
						?>
					<?php
				}
			}
		}
	}


	/**
	 * WooCommerce Installation Notice
	 *
	 * @since 1.0.0
	 */
	public function wc_installation_notice_callback() {
		if ( ! get_option( 'wholesalex_dismiss_notice' ) ) {
			$this->wc_notice_css();
			?>
			<div class="wholesalex-wc-install">
				<img loading="lazy" width="200" src="<?php echo esc_url( WHOLESALEX_URL . 'assets/img/woocommerce.png' ); ?>" alt="logo" />
				<div class="wholesalex-wc-install-body">
					<h3><?php /* translators: %s: Plugin Name */ echo sprintf( esc_html__( 'Welcome to %s.', 'wholesalex' ), esc_html( wholesalex()->get_plugin_name() ) ); ?></h3>
					<p><?php /* translators: %s: Plugin Name */ echo sprintf( esc_html__( 'WooCommerce %s is a WooCommerce plugin. To use this plugins you have to install and activate WooCommerce.', 'wholesalex' ), esc_html( wholesalex()->get_plugin_name() ) ); ?></p>
					<a class="wholesalex-wc-install-btn button button-primary button-hero" href="<?php echo esc_url( add_query_arg( array( 'action' => 'wc_install' ), admin_url( 'admin-ajax.php' ) ) ); ?>"><span class="dashicons dashicons-image-rotate"></span><?php esc_html_e( 'Install WooCommerce', 'wholesalex' ); ?></a>
					<div id="installation-msg"></div>
				</div>
			</div>
			<?php
		}
	}


	/**
	 * WooCommerce Activation Notice
	 *
	 * @since 1.0.0
	 */
	public function wc_activation_notice_callback() {
		if ( ! get_option( 'wholesalex_dismiss_notice' ) ) {
			$this->wc_notice_css();
			?>
			<div class="wholesalex-wc-install">
				<img loading="lazy" width="200" src="<?php echo esc_url( WHOLESALEX_URL . 'assets/img/woocommerce.png' ); ?>" alt="logo" />
				<div class="wholesalex-wc-install-body">
				<h3><?php /* translators: %s: Plugin Name */ echo sprintf( esc_html__( 'Welcome to %s.', 'wholesalex' ), esc_html( wholesalex()->get_plugin_name() ) ); ?></h3>
				<p><?php /* translators: %s: Plugin Name */ echo sprintf( esc_html__( 'WooCommerce %s is a WooCommerce plugin. To use this plugins you have to install and activate WooCommerce.', 'wholesalex' ), esc_html( wholesalex()->get_plugin_name() ) ); ?></p>
					<a class="button button-primary button-hero" href="<?php echo esc_url( add_query_arg( array( 'action' => 'wc_activate' ), admin_url() ) ); ?>"><?php esc_html_e( 'Activate WooCommerce', 'wholesalex' ); ?></a>
				</div>
			</div>
			<?php
		}
	}


	/**
	 * WooCommerce Notice Styles
	 *
	 * @since 1.0.0
	 */
	public function wc_notice_css() {
		?>
		<style type="text/css">

			/* .wholesalex-wc-install.wholesalex-pro-notice-v2 {
				padding-bottom: 0px;
			} */
			.wholesalex-content-notice {
				color: white;
				background-color: #6C6CFF;
				position: relative;
				font-size: 16px;
				padding-left: 10px;
				line-height: 23px;
			}

			.wholesalex-notice-content-wrapper {
				margin-bottom: 0px !important;
				padding: 10px 5px;
			}

			.wholesalex-wc-install .wholesalex-content-notice .wholesalex-btn-notice-pro {
				margin-left: 5px;
				background-color: #3c3cb7 !important;
				border-radius: 4px;
				max-height: 30px !important;
				padding: 8px 12px !important;
				font-size: 14px;
				position: relative;
				top: -4px;
			}
			.wholesalex-wc-install .wholesalex-content-notice .wholesalex-btn-notice-pro:hover {
				background-color: #29298c !important;
			}

			/* .wholesalex-content-notice .content-notice-dissmiss {
				position: absolute;
				top: 0;
				right: 0;
				color: white;
				background-color: black;
				padding: 5px;
				font-size: 12px;
				line-height: 1;
				border-bottom-left-radius: 5px;
			} */

			/* .whx-new-dismiss{
				position: absolute;
				top: 0;
				right: 0;
				color: white;
				background-color: black;
				padding: 4px 5px 5px;
				font-size: 12px;
				line-height: 1;
				border-bottom-left-radius: 3px;
				text-decoration: none;
			} */

			.wholesalex-content-notice .content-notice-dissmiss {
				position: absolute;
				top: 0;
				right: 0;
				color: white;
				background-color: #3f3fa6;
				padding: 4px 5px 5px;
				font-size: 12px;
				line-height: 1;
				border-bottom-left-radius: 3px;
				text-decoration: none;
			}
			.wholesalex-image-banner-v2{
				padding:0;
			}
			.wholesalex-wc-install {
				display: -ms-flexbox;
				display: flex;
				align-items: center;
				background: #fff;
				margin-top: 40px;
				width: calc(100% - 20px);
				border: 1px solid #ccd0d4;
				padding: 4px;
				border-radius: 4px;
				gap:40px;
			}   
			.wholesalex-wc-install img {
				margin-right: 0;
				max-width: 100%; 
			}
			.wholesalex-image-banner-v2.wholesalex-wc-install-body{
				position: relative;
			}
			.wholesalex-wc-install-body {
				-ms-flex: 1;
				flex: 1;
			}
			.wholesalex-wc-install-body > div {
				max-width: 450px;
				margin-bottom: 20px;
			}
			.wholesalex-wc-install-body h3 {
				margin-top: 0;
				font-size: 24px;
				margin-bottom: 15px;
			}
			.wholesalex-install-btn {
				margin-top: 15px;
				display: inline-block;
			}
			.wholesalex-wc-install .dashicons{
				display: none;
				animation: dashicons-spin 1s infinite;
				animation-timing-function: linear;
			}
			.wholesalex-wc-install.loading .dashicons {
				display: inline-block;
				margin-top: 12px;
				margin-right: 5px;
			}
			@keyframes dashicons-spin {
				0% {
					transform: rotate( 0deg );
				}
				100% {
					transform: rotate( 360deg );
				}
			}
			.wholesalex-image-banner-v2 .wc-dismiss-notice {
				color: #fff;
				background-color: #000000;
				padding-top: 0px;
				position: absolute;
				right: 0;
				top: 0px;
				padding:5px;
				/* padding: 10px 10px 14px; */
				border-radius: 0 0 0 4px;
				display: inline-block;
				transition: 400ms;
				font-size: 12px;
			}
			.wholesalex-image-banner-v2 .wc-dismiss-notice:focus{
				outline: none;
				box-shadow: unset;
			}
			.wholesalex-btn-image:focus{
				outline: none;
				box-shadow: unset;
			}
			.wc-dismiss-notice {
				position: relative;
				text-decoration: none;
				float: right;
				right: 26px;
			}
			.wc-dismiss-notice .dashicons{
				display: inline-block;
				text-decoration: none;
				animation: none;
			}

			.wholesalex-pro-notice-v2 .wholesalex-wc-install-body h3 {
				font-size: 20px;
				margin-bottom: 5px;
			}
			.wholesalex-pro-notice-v2 .wholesalex-wc-install-body > div {
				max-width: 100%;
				margin-bottom: 10px;
			}
			.wholesalex-pro-notice-v2 .button-hero {
				padding: 8px 14px !important;
				min-height: inherit !important;
				line-height: 1 !important;
				box-shadow: none;
				border: none;
				transition: 400ms;
			}
			.wholesalex-pro-notice-v2 .wholesalex-btn-notice-pro {
				background: #2271b1;
				color: #fff;
			}
			.wholesalex-pro-notice-v2 .wholesalex-btn-notice-pro:hover,
			.wholesalex-pro-notice-v2 .wholesalex-btn-notice-pro:focus {
				background: #185a8f;
			}
			.wholesalex-pro-notice-v2 .button-hero:hover,
			.wholesalex-pro-notice-v2 .button-hero:focus {
				border: none;
				box-shadow: none;
			}
			.wc-dismiss-notice:hover {
				color:red;
			}
			.wc-dismiss-notice .dashicons{
				display: inline-block;
				text-decoration: none;
				animation: none;
				font-size: 16px;
			}
		</style>
		<?php
	}

	/**
	 * WooCommerce Force Install Action
	 *
	 * @since 1.0.0
	 */
	public function wc_install_callback() {
        if(! current_user_can( 'manage_options' )) {
            die();
        }
		include ABSPATH . 'wp-admin/includes/plugin-install.php';
		include ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

		if ( ! class_exists( 'Plugin_Upgrader' ) ) {
			include ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';
		}
		if ( ! class_exists( 'Plugin_Installer_Skin' ) ) {
			include ABSPATH . 'wp-admin/includes/class-plugin-installer-skin.php';
		}

		$plugin = 'woocommerce';

		$api = plugins_api(
			'plugin_information',
			array(
				'slug'   => $plugin,
				'fields' => array(
					'short_description' => false,
					'sections'          => false,
					'requires'          => false,
					'rating'            => false,
					'ratings'           => false,
					'downloaded'        => false,
					'last_updated'      => false,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
				),
			)
		);

		if ( is_wp_error( $api ) ) {
			wp_die( esc_html__( 'Error!', 'wholesalex' ) );
		}
		/* translators: %s: API Name and Version */
		$title = sprintf( __( 'Installing Plugin: %s', 'wholesalex' ), $api->name . ' ' . $api->version );
		$nonce = 'install-plugin_' . $plugin;
		$url   = 'update.php?action=install-plugin&plugin=' . rawurlencode( $plugin );

		$upgrader = new \Plugin_Upgrader( new \Plugin_Installer_Skin( compact( 'title', 'url', 'nonce', 'plugin', 'api' ) ) );
		$upgrader->install( $api->download_link );
		die();
	}

	/**
	 * WooCommerce Redirect After Active Action
	 *
	 * @since 1.0.0
	 */
	public function wc_activate_action() {
		activate_plugin( 'woocommerce/woocommerce.php' );
		wp_safe_redirect( admin_url( 'plugins.php' ) );
		exit();
	}

	public function set_notice( $key = '', $value = '', $expiration = '' ) {
		if ( $key ) {
			$option_name = 'wholesalex_notice';
			$notice_data = wholesalex()->get_option_without_cache( $option_name, array() );
			if ( ! isset( $notice_data ) || ! is_array( $notice_data ) ) {
				$notice_data = array();
			}

			$notice_data[ $key ] = $value;

			if ( $expiration ) {
				$expire_notice_key                 = 'timeout_' . $key;
				$notice_data[ $expire_notice_key ] = time() + $expiration;
			}
			update_option( $option_name, $notice_data );
		}
	}

	public function get_notice( $key = '' ) {
		if ( $key ) {
			$option_name = 'wholesalex_notice';
			$notice_data = wholesalex()->get_option_without_cache( $option_name, array() );
			if ( ! isset( $notice_data ) || ! is_array( $notice_data ) ) {
				return false;
			}

			if ( isset( $notice_data[ $key ] ) ) {
				$expire_notice_key = 'timeout_' . $key;
				if ( isset( $notice_data[ $expire_notice_key ] ) && $notice_data[ $expire_notice_key ] < time() ) {
					unset( $notice_data[ $key ] );
					unset( $notice_data[ $expire_notice_key ] );
					update_option( $option_name, $notice_data );
					return false;
				}
				return $notice_data[ $key ];
			}
		}
		return false;
	}

	/**
	 * Sort the notices based on the given priority of the notice.
	 *
	 * @since 1.5.2
	 * @param array $notice_1 First notice.
	 * @param array $notice_2 Second Notice.
	 * @return array
	 */
	public function sort_notices( $notice_1, $notice_2 ) {
		if ( ! isset( $notice_1['priority'] ) ) {
			$notice_1['priority'] = 10;
		}
		if ( ! isset( $notice_2['priority'] ) ) {
			$notice_2['priority'] = 10;
		}

		return $notice_1['priority'] - $notice_2['priority'];
	}

	private function set_new_notice( $id = '', $type = '', $design_type = '', $start = '', $end = '', $repeat = false, $priority = 10, $show_if = false ) {

		return array(
			'id'                        => $id,
			'type'                      => $type,
			'design_type'               => $design_type,
			'start'                     => $start, // Start Date
			'end'                       => $end, // End Date
			'repeat_notice_after'       => $repeat, // Repeat after how many days
			'priority'                  => $priority, // Notice Priority
			'display_with_other_notice' => false, // Display With Other Notice
			'show_if'                   => $show_if, // Notice Showing Conditions
			'capability'                => 'manage_options', // Capability of users, who can see the notice
		);
	}

	public function get_notice_content( $key, $design_type ) {

		$close_url = add_query_arg( 'wsx-notice-disable', $key );

		switch ( $design_type ) {
			case 'pro_4':
				//
				// Will Get Free User
				$icon        = WHOLESALEX_URL . 'assets/img/icon.svg';
				$url         = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=special_discount_pro&utm_campaign=wholesalex-DB';
				$full_access = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=special_discount_access&utm_campaign=wholesalex-DB';

				ob_start();
				?>
				
				<div class="wsx-notice-wrapper wsx-notice-type-1"> 
					<div class="wsx-notice-icon"> <img src="<?php echo esc_url( $icon ); ?>"/>  </div>
					<div class="wsx-notice-content-wrapper">
					<div class="wsx-notice-content"> Claim your <strong>special discount</strong> by upgrading to WholesaleX Pro and unlock all pro features!</div>
					<div class="wsx-notice-buttons"> 
						<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $url ); ?>" target="_blank"> Upgrade to Pro   </a>
						<a class="wsx-notice-btn button" href="<?php echo esc_url( $full_access ); ?>" target="_blank">  Give Me Pro Access  </a>
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money">   I Don’t Want Full Access </a>
					</div>
					</div>
					<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
				</div>

				<?php

				return ob_get_clean();

				break;
			case 'pro_2':
				// User Get Free User
				$icon     = WHOLESALEX_URL . 'assets/img/icon.svg';
				$url      = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=massive_discount_pro&utm_campaign=wholesalex-DB';
				$discount = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=massive_discount_access&utm_campaign=wholesalex-DB';

				ob_start();
				?>
				
				<div class="wsx-notice-wrapper wsx-notice-type-2"> 
					<div class="wsx-notice-content-wrapper">
					<div class="wsx-notice-content"> Enjoy Massive Discount: Get lifetime access to WholesaleX Pro and keep managing your B2B stores forever.</div>
					<div class="wsx-notice-buttons"> 
						<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $url ); ?>" target="_blank"> Upgrade to Pro  </a>
						<a class="wsx-notice-btn button" href="<?php echo esc_url( $discount ); ?>" target="_blank">   Give Me Lifetime Access </a>
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money"> I don’t Want </a>
					</div>
					</div>
					<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
					</div>

				<?php

				return ob_get_clean();
				break;
			case 'pro_3':
				// Will Get single
				$url = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=dynamuc_rule_access&utm_campaign=wholesalex-DB';
				ob_start();
				?>
				
				<div class="wsx-notice-wrapper wsx-notice-type-5"> 
					<div class="wsx-notice-content-wrapper">
					<div class="wsx-notice-content"><strong>Surprise from WholesaleX:</strong> Unlock all Dynamic Pricing & Discount and enjoy special discount!</div>
					<div class="wsx-notice-buttons"> 
						<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $url ); ?>" target="_blank"> Give me Dynamic Rules Access   </a>
						<!-- <a class="wsx-notice-btn button" href=""> Give Me LIFETIME Access</a> -->
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money" > I Don’t Want Access </a>
					</div>
					</div>
					<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
					</div>

				<?php
				return ob_get_clean();

			case 'pro_1':
				// Will Get single
				// Lifetime and Ultimited
				$icon = WHOLESALEX_URL . 'assets/img/icon.svg';
				$url  = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=limited_offer_pro&utm_campaign=wholesalex-DB';

				$access_url = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=limited_offer_access&utm_campaign=wholesalex-DB';
				ob_start();
				?>
					
					<div class="wsx-notice-wrapper wsx-notice-type-1"> 
						<div class="wsx-notice-icon"> <img src="<?php echo esc_url( $icon ); ?>"/>  </div>
						<div class="wsx-notice-content-wrapper">
						<div class="wsx-notice-content"> Limited Time Offer: Unlock all Wholesale features and enjoy a special discount!</div>
						<div class="wsx-notice-buttons"> 
							<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $url ); ?>" target="_blank"> Upgrade to Pro  </a>
							<a class="wsx-notice-btn button" href="<?php echo esc_url( $access_url ); ?>" target="_blank">Give Me Lifetime Access</a>
							<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money"> I Don’t Want to Save Money </a>
						</div>
						</div>
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
					</div>
	
					<?php

				return ob_get_clean();
			case 'lifetime_n_unlimited_1':
				// Will Get single
				// Lifetime and Ultimited
				$icon = WHOLESALEX_URL . 'assets/img/icon.svg';
				$url  = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=unlimited_sites_to_lifetime_unlimited_pro&utm_campaign=wholesalex-DB';

				$lifetime_url = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=unlimited_sites_to_lifetime_unlimited_access&utm_campaign=wholesalex-DB';
				ob_start();
				?>
				
				<div class="wsx-notice-wrapper wsx-notice-type-1"> 
					<div class="wsx-notice-icon"> <img src="<?php echo esc_url( $icon ); ?>"/>  </div>
					<div class="wsx-notice-content-wrapper">
					<div class="wsx-notice-content">Upgrade to lifetime access and keep using WholesaleX forever with a single price!</div>
					<div class="wsx-notice-buttons"> 
						<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $url ); ?>" target="_blank">Upgrade Now </a>
						<a class="wsx-notice-btn button" href="<?php echo esc_url( $lifetime_url ); ?>" target="_blank">  Give me Lifetime Access </a>
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money">  I don’t want to Save Money  </a>
					</div>
					</div>
					<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
				</div>

				<?php

				return ob_get_clean();
			case 'lifetime_1':
				// Lifetime 1
				$icon    = WHOLESALEX_URL . 'assets/img/icon.svg';
				$url     = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=single_yearly_to_single_lifetime_pro&utm_campaign=wholesalex-DB';
				$pro_url = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=single_yearly_to_single_lifetime_access&utm_campaign=wholesalex-DB';

				ob_start();
				?>
				
				<div class="wsx-notice-wrapper wsx-notice-type-3"> 
					<div class="wsx-notice-content-wrapper">
					<div class="wsx-notice-content"> Use WholesaleX forever without renewal hassle by upgrading to lifetime access!</div>
					<div class="wsx-notice-buttons"> 
						<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $url ); ?>" target="_blank">Upgrade Now</a>
						<a class="wsx-notice-btn button" href="<?php echo esc_url( $pro_url ); ?>" target="_blank"> Give me Lifetime Access</a>
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money"> I don’t want to Save Money  </a>
					</div>
					</div>
					<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
					</div>

				<?php

				return ob_get_clean();
			case 'lifetime_2':
				// Lifetime 2

				$icon                  = WHOLESALEX_URL . 'assets/img/icon.svg';
				$url                   = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=single_yearly_to_unlimited_yearly_pro&utm_campaign=wholesalex-DB';
				$unlimited_site_access = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=single_yearly_to_unlimited_yearly_access&utm_campaign=wholesalex-DB';

				ob_start();
				?>
				
				<div class="wsx-notice-wrapper wsx-notice-type-4"> 
					<div class="wsx-notice-icon"> <img class="wsx-notice-icon-img" src="<?php echo esc_url( $icon ); ?>"/> </div>
					<div class="wsx-notice-content-wrapper">
					<div class="wsx-notice-content"> Upgrade WholesaleX and manage up to 20 sites without any extra charges!</div>
					<div class="wsx-notice-buttons"> 
						<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $url ); ?>" target="_blank">Upgrade Now</a>
						<a class="wsx-notice-btn button" href="<?php echo esc_url( $unlimited_site_access ); ?>" target="_blank">Give Me Access</a>
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money"> I don’t want to Save Money </a>
					</div>
					</div>
					<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
					</div>

				<?php

				return ob_get_clean();
			case 'welcome':
				$url = 'https://getwholesalex.com/pricing/?utm_source=wholesalex_topbar&utm_medium=welcome_offer&utm_campaign=wholesalex-DB';
				ob_start();
				?>
				
				<div class="wsx-notice-wrapper wsx-notice-type-5"> 
					<div class="wsx-notice-content-wrapper">
					<div class="wsx-notice-content">Thank you for joining <strong>WholesaleX Family.</strong> We have a welcome gift for you! </div>
					<div class="wsx-notice-buttons"> 
						<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $url ); ?>" target="_blank"> Claim Welcome Offer</a>
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money"> I Don’t Want to Save Money </a>
					</div>
					</div>
					<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
					</div>

				<?php

				return ob_get_clean();
				// code...
				break;
			case 'data_collection':
				$icon             = WHOLESALEX_URL . 'assets/img/icon.svg';
				$data_collect_url = add_query_arg( 'wsx-data-collect', $key );

				ob_start();
				?>
				<div class="wsx-notice-wrapper data_collection_notice"> 
					<?php
					if ( isset( $icon ) ) {
						?>
							<div class="wsx-notice-icon"> <img src="<?php echo esc_url( $icon ); ?>"/>  </div>
							<?php
					}
					?>
					
					<div class="wsx-notice-content-wrapper">
					<div class="wsx-notice-content">Help us to send important updates and special discount news by allowing us to collect non-sensitive usage data. <a class="wsx-notice-dc-learn-more" href="https://www.wpxpo.com/privacy-policy/" target="_blank">Learn more.</a></div>
					<div class="wsx-notice-buttons"> 
						<a class="wsx-notice-btn button button-primary" href="<?php echo esc_url( $data_collect_url ); ?>">Sure I’d love to help</a>
						<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-dont-save-money"> No Thanks</a>
					</div>
					</div>
					<a href="<?php echo esc_url( $close_url ); ?>" class="wsx-notice-close"><span class="wsx-notice-close-icon dashicons dashicons-dismiss"> </span></a>
					</div>

				<?php

				return ob_get_clean();
				// code...
				break;

			default:
				// code...
				break;
		}
		return '';

	}

	private function get_price_id() {
		if ( wholesalex()->is_pro_active() ) {
			$license_data = get_option( 'edd_wholesalex_license_data', false );
			$license_data = (array) $license_data;
			if ( is_array( $license_data ) && isset( $license_data['price_id'] ) ) {
				return $license_data['price_id'];
			} else {
				return false;
			}
		}
		return false;
	}

	public function is_valid_notice( $notice ) {
		$is_data_collect = isset( $notice['type'] ) && 'data_collect' == $notice['type'];
		$notice_status   = $is_data_collect ? $this->get_notice( $notice['id'] ) : $this->get_user_notice( $notice['id'] );

		if ( ! current_user_can( $notice['capability'] ) || 'off' === $notice_status ) {
			return false;
		}

		$current_time = date( 'U' ); // Todays Data
		// $current_time = 1710493466;
		if ( $current_time > strtotime( $notice['start'] ) && $current_time < strtotime( $notice['end'] ) && isset( $notice['show_if'] ) && true === $notice['show_if'] ) { // Has Duration
			// Now Check Max Duration
			return true;
		}
	}

	public function display_notices() {

		usort( $this->available_notice, array( $this, 'sort_notices' ) );

		$displayed_notice_count = 0;

		foreach ( $this->available_notice as $notice ) {
			if ( $this->is_valid_notice( $notice ) ) {

				if ( isset( $notice['show_if'] ) && true === $notice['show_if'] ) {
					if ( 0 !== $displayed_notice_count && false === $notice['display_with_other_notice'] ) {
						continue;
					}

					if ( isset( $notice['id'], $notice['design_type'] ) ) {
						echo $this->get_notice_content( $notice['id'], $notice['design_type'] );

						++$displayed_notice_count;
					}
				}
			}
		}
	}

	public function set_user_notice_meta( $key = '', $value = '', $expiration = '' ) {
		if ( $key ) {
			$user_id     = get_current_user_id();
			$meta_key    = 'wholesalex_notice';
			$notice_data = get_user_meta( $user_id, $meta_key, true );
			if ( ! isset( $notice_data ) || ! is_array( $notice_data ) ) {
				$notice_data = array();
			}

			$notice_data[ $key ] = $value;

			if ( $expiration ) {
				$expire_notice_key                 = 'timeout_' . $key;
				$notice_data[ $expire_notice_key ] = $expiration;
			}

			update_user_meta( $user_id, $meta_key, $notice_data );

		}
	}

	public function get_user_notice( $key = '' ) {
		if ( $key ) {
			$user_id     = get_current_user_id();
			$meta_key    = 'wholesalex_notice';
			$notice_data = get_user_meta( $user_id, $meta_key, true );
			if ( ! isset( $notice_data ) || ! is_array( $notice_data ) ) {
				return false;
			}

			if ( isset( $notice_data[ $key ] ) ) {
				$expire_notice_key = 'timeout_' . $key;
				$current_time      = time();
				if ( isset( $notice_data[ $expire_notice_key ] ) && $notice_data[ $expire_notice_key ] < $current_time ) {
					unset( $notice_data[ $key ] );
					unset( $notice_data[ $expire_notice_key ] );
					update_user_meta( $user_id, $meta_key, $notice_data );
					return false;
				}
				return $notice_data[ $key ];
			}
		}
		return false;
	}
}
