<?php
/**
 * Plugin Name: My Starter Plugin
 * Plugin URI: https://github.com/tribalNerd/my-starter-plugin
 * Description: A clean plugin build to create plugins with.
 * Tags: technerdia, tribalnerd
 * Version: 1.0.0
 * License: GNU GPLv3
 * Copyright (c) 2017 Chris Winters
 * Author: tribalNerd, Chris Winters
 * Author URI: http://techNerdia.com/
 * Text Domain: my-starter-plugin
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Define Constants
 */
if( function_exists( 'MyStarterPluginConstants' ) )
{
    MyStarterPluginConstants( Array(
        'MY_STARTER_PLUGIN_BASE_URL'          => get_bloginfo( 'url' ),
        'MY_STARTER_PLUGIN_VERSION'           => '1.0.0',
        'MY_STARTER_PLUGIN_WP_MIN_VERSION'    => '3.8',

        'MY_STARTER_PLUGIN_PLUGIN_FILE'       => __FILE__,
        'MY_STARTER_PLUGIN_PLUGIN_DIR'        => dirname( __FILE__ ),
        'MY_STARTER_PLUGIN_PLUGIN_BASE'       => plugin_basename( __FILE__ ),

        'MY_STARTER_PLUGIN_MENU_NAME'         => __( 'My Starter Plugin', 'my-starter-plugin' ),
        'MY_STARTER_PLUGIN_PAGE_NAME'         => __( 'My Starter Plugin', 'my-starter-plugin' ),
        'MY_STARTER_PLUGIN_PAGE_DESC'         => __( 'A starter plugin for WordPress plugin development.', 'my-starter-plugin' ),
        'MY_STARTER_PLUGIN_OPTION_NAME'       => 'mystarterplugin_',
        'MY_STARTER_PLUGIN_PLUGIN_NAME'       => 'my-starter-plugin',

        'MY_STARTER_PLUGIN_CLASSES'           => dirname( __FILE__ ) .'/classes',
        'MY_STARTER_PLUGIN_TEMPLATES'         => dirname( __FILE__ ) .'/templates'
    ) );
}


/**
 * @about Loop Through Constants
 */
function MyStarterPluginConstants( $constants_array )
{
    foreach( $constants_array as $name => $value ) {
        define( $name, $value, true );
    }
}


/**
 * @about Register Classes & Include
 */
spl_autoload_register( function ( $class )
{
    if( strpos( $class, 'MyStarterPlugin_' ) !== false ) {
        $class_name = str_replace( 'MyStarterPlugin_', "", $class );

        // If the Class Exists, Include the Class
        if( file_exists( MY_STARTER_PLUGIN_CLASSES .'/class-'. strtolower( $class_name ) .'.php' ) ) {
            include_once( MY_STARTER_PLUGIN_CLASSES .'/class-'. strtolower( $class_name ) .'.php' );
        }
    }
} );


/**
 * @about Run Plugin
 */
if( ! class_exists( 'MyStarterPlugin' ) )
{
    class MyStarterPlugin
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Initiate Plugin
         */
        final public function init()
        {
            // Activate Plugin
            register_activation_hook( __FILE__, array( $this, 'activate' ) );

            // Inject Plugin Links
            add_filter( 'plugin_row_meta', array( $this, 'links' ), 10, 2 );

            // Load Admin Area
            MyStarterPlugin_AdminArea::instance();

            // Manage Settings
            MyStarterPlugin_Process::instance();

            // Display Font Awesome CSS
            MyStarterPlugin_Core::instance();
        }


        /**
         * @about Activate Plugin
         */
        final public function activate()
        {
            // Wordpress Version Check
            global $wp_version;

            // Version Check
            if( version_compare( $wp_version, MY_STARTER_PLUGIN_WP_MIN_VERSION, "<" ) ) {
                wp_die( __( '<b>Activation Failed</b>: The ' . MY_STARTER_PLUGIN_PAGE_NAME . ' plugin requires WordPress version ' . MY_STARTER_PLUGIN_WP_MIN_VERSION . ' or higher. Please Upgrade Wordpress, then try activating this plugin again.', 'my-starter-plugin' ) );
            }
        }


        /**
         * @about Inject Links Into Plugin Admin
         * @param array $links Default links for this plugin
         * @param string $file The name of the plugin being displayed
         * @return array $links The links to inject
         */
        final public function links( $links, $file )
        {
            // Get Current URL
            $request_uri = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL );

            // Links To Inject
            if ( $file == MY_STARTER_PLUGIN_PLUGIN_BASE && strpos( $request_uri, "plugins.php" ) !== false ) {
                $links[] = '<a href="options-general.php?page=' . MY_STARTER_PLUGIN_PLUGIN_NAME . '">'. __( 'Website Settings', 'my-starter-plugin' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/help/" target="_blank">'. __( 'Support', 'my-starter-plugin' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/feedback/" target="_blank">'. __( 'Feedback', 'my-starter-plugin' ) .'</a>';
            }

            return $links;
        }


        /**
        * @about Create Instance
        */
        final public static function instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self();
                self::$instance->init();
            }

            return self::$instance;
        }
    }
}

add_action( 'after_setup_theme', array( 'MyStarterPlugin', 'instance' ), 0 );
