<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://firstpartyhq.com
 * @since      1.0.0
 *
 * @package    Firstparty
 * @subpackage Firstparty/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Firstparty
 * @subpackage Firstparty/admin
 * @author     Firstparty <support@firstpartyhq.com>
 */
class Firstparty_Admin {

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

    function options_page() {
        add_options_page( 'firstparty', 'Firstparty', 'manage_options', 'firstparty', array( $this, 'fp_options_page') );
    }

    function fp_options_page(  ) {

        ?>
        <h1>Firstparty for WordPress</h1>
        <p>Enter a Source Write Key below and Firstparty will automatically collect Page Viewed Events for all of your theme pages. WP Admin pageviews
            will not be collected. </p>

        <form action='options.php' method='post'>


            <?php
            settings_fields( 'firstparty' );
            do_settings_sections( 'firstparty' );
            submit_button();
            ?>

        </form>

        <p>After installing, you may also access the <code>window.firstparty</code> object in your frontend javascript,
            which allows you to collect custom Events like form completions and button clicks.</p>
        <?php

    }

    public function settings_init() {

        add_settings_section(
            'firstparty_event_collection_section',
            'Source Configuration',
            array( $this, 'settings_section_callback' ),
            'firstparty'
        );

        add_settings_field(
            'firstparty_source_key',
            'Write Key',
            array($this, 'firstparty_source_key_callback'),
            'firstparty',
            'firstparty_event_collection_section'
        );

        register_setting(
            'firstparty',
            'firstparty_source_key',
            array(
                'string',
                'The write key for the Firstparty Source you want to send Events to'
            )
        );

        add_settings_field(
            'firstparty_domain',
            'Domain',
            array($this, 'firstparty_domain_callback'),
            'firstparty',
            'firstparty_event_collection_section'
        );

        register_setting(
            'firstparty',
            'firstparty_domain',
            array(
                'string',
                'The configured custom Domain you want to send Events through'
            )
        );

    }

    public function firstparty_source_key_callback() {
        // get the value of the setting we've registered with register_setting()
        $setting = get_option('firstparty_source_key');
        // output the field
        echo '<input type="text" name="firstparty_source_key" value="'.$setting.'">';
    }

    public function firstparty_domain_callback() {
        // get the value of the setting we've registered with register_setting()
        $setting = get_option('firstparty_domain');
        // output the field
        echo '<input type="text" name="firstparty_domain" value="'.$setting.'">';
    }

    public function settings_section_callback() {
        echo "Create a new Javascript Source in your Firstparty Workspace, then enter the Source's Write Key below.";
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
		 * defined in Firstparty_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Firstparty_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/firstparty-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Firstparty_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Firstparty_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/firstparty-admin.js', array( 'jquery' ), $this->version, false );

	}

}
