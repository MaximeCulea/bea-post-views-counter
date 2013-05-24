<?php

class BEA_PVC_Admin_Settings {

	static $settings_api;
	static $id = 'bea-pvc-main';

	/**
	 * __construct
	 * 
	 * @access public
	 *
	 * @return mixed Value.
	 */
	public function __construct() {
		self::$settings_api = new WeDevs_Settings_API();

		add_action('admin_menu', array(__CLASS__, 'admin_menu'));
		add_action('admin_init', array(__CLASS__, 'admin_init'));
	}

	/**
	 * admin_menu
	 * 
	 * @param mixed $hook Description.
	 *
	 * @access public
	 * @static
	 *
	 * @return mixed Value.
	 */
	public static function admin_menu() {
		add_options_page(__('BEA Post Views Counter', 'bea-post-views-counter'), __('Post Views Counter', 'bea-post-views-counter'), 'manage_options', 'bea-pvc-settings', array(__CLASS__, 'render_page_settings'));
	}

	/**
	 * render_page_settings
	 * 
	 * @access public
	 * @static
	 *
	 * @return mixed Value.
	 */
	public static function render_page_settings() {
		include (BEA_PVC_DIR . 'views/admin/page-settings.php');
	}

	/**
	 * admin_init
	 * 
	 * @access public
	 * @static
	 *
	 * @return mixed Value.
	 */
	public static function admin_init() {
		//set the settings
		self::$settings_api->set_sections(self::get_settings_sections());
		self::$settings_api->set_fields(self::get_settings_fields());

		//initialize settings
		self::$settings_api->admin_init();
	}

	public static function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'bea-pvc-main',
				'tab_label' => __('General', 'bea-post-views-counter'),
				'title' => __('General', 'bea-post-views-counter'),
				'desc' => false,
			),
		);
		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	public static function get_settings_fields() {
		$settings_fields = array(
			'bea-pvc-main' => array(
				array(
					'name' => 'mode',
					'label' => __('Counter mode', 'bea-post-views-counter'),
					'type' => 'radio',
					'default' => 'js-wp',
					'options' => array(
						'inline' => __('Inline', 'bea-post-views-counter'),
						'js-wp' => __('JS call with WordPress (default, best compromise)', 'bea-post-views-counter'),
						'js-php' => __('JS call with pure PHP script (best performance)', 'bea-post-views-counter')
					),
					'desc' => __('Mode <strong>inline</strong> is the simplest, most reliable, but it is not compatible with plugins static cache.<br />The two modes "JS Call" add asynchronous JavaScript code in the footer of your site for compatibilizing the number of views. The difference between <strong>WordPress</strong> and <strong>PHP Pure</strong> is the mechanism used to update the counters in the database. The <strong>pure PHP</strong> mode is on average 10 times more efficient than the WP mode because it does not load WordPress!<br />However, the <strong>pure PHP</strong> mode sometimes have problems operating in some accommodation, this is the reason why this is not the default mode.', 'bea-post-views-counter'),
				),
				array(
					'name' => 'include',
					'label' => __('Include', 'bea-post-views-counter'),
					'type' => 'radio',
					'default' => 'all',
					'options' => array(
						'all' => __('Everyone', 'bea-post-views-counter'),
						'guests' => __('Guests only', 'bea-post-views-counter'),
						'registered' => __('Users logged only', 'bea-post-views-counter'),
					),
					'desc' => __('Note that this setting does not work with pure PHP mode, all visitors will be recorded.', 'bea-post-views-counter')
				),
				array(
					'name' => 'exclude',
					'label' => __('Exclude', 'bea-post-views-counter'),
					'options' => array(
						'robots' => __('Robots (search, etc)', 'bea-post-views-counter'),
						'administrator' => __('Administrators', 'bea-post-views-counter')
					),
					'type' => 'multicheck',
					'desc' => __('It is important to exclude robots counters views because they regularly browsing your site and they distort the statistics. Note that the exclusion of users logged in with the administrator role does not work with pure PHP mode.', 'bea-post-views-counter')
				),
				array(
					'name' => 'exclude_ips',
					'label' => __('Exclude IPs:', 'bea-post-views-counter'),
					'desc' => __('You can exclude IP addresses of your choice, separate them with commas.', 'bea-post-views-counter'),
					'type' => 'textarea',
					'default' => ''
				),
			),
		);

		return $settings_fields;
	}

}