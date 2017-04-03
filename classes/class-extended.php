<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * @about Manager Class
 * 
 * @method __construct()    Set Parent Variables
 * @method option()         Get Saved Option Data
 * @method qString()        Get Query String Item
 * @method validate()       Form Validation
 */
if( ! class_exists( 'MyStarterPlugin_Extended' ) )
{
    class MyStarterPlugin_Extended
    {
        // Website URL
        public $base_url;

        // The plugin-slug-name
        public $plugin_name;
        
        // Plugin Page Title
        public $plugin_title;
        
        // Plugin Page Description
        public $plugin_desc;
        
        // Plugin filename.php
        public $plugin_file;
        
        // Current Plugin Version
        public $plugin_version;
        
        // Plugin Menu Name
        public $menu_name;
        
        // Path To Plugin Templates
        public $templates;

        // Base Option Name
        public $option_name;


        /**
         * @about Set Class Vars
         */
        function __construct()
        {
            // Set Vars
            $this->base_url         = MY_STARTER_PLUGIN_BASE_URL;
            $this->plugin_name      = MY_STARTER_PLUGIN_PLUGIN_NAME;
            $this->plugin_title     = MY_STARTER_PLUGIN_PAGE_NAME;
            $this->plugin_desc      = MY_STARTER_PLUGIN_PAGE_DESC;
            $this->plugin_file      = MY_STARTER_PLUGIN_PLUGIN_FILE;
            $this->plugin_version   = MY_STARTER_PLUGIN_VERSION;
            $this->menu_name        = MY_STARTER_PLUGIN_MENU_NAME;
            $this->templates        = MY_STARTER_PLUGIN_TEMPLATES;
            $this->option_name      = MY_STARTER_PLUGIN_OPTION_NAME;
        }


        /**
         * @about Get Saved Settings
         * @call echo parent::option( 'frontend' );
         * @param mixed $option Option Setting
         */
        final public function option( $option = '' )
        {
            $data = get_option( $this->option_name . 'settings' );
            return ( isset( $data[$option] ) ) ? $data[$option] : '';
        }


        /**
         * @about Get Query String Item
         * @param string $get Query String Get Item
         * @return string Query String Item Sanitized
         */
        final public function qString( $get )
        {
            // Lowercase & Sanitize String
            $filter = strtolower( filter_input( INPUT_GET, $get, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK ) );

            // Return No Spaces/Tabs, Stripped/Cleaned String
            return sanitize_text_field( preg_replace( '/\s/', '', $filter ) );
        }


        /**
         * @about Form Validation
         */
        final public function validate()
        {
            // Plugin Admin Area Only
            if ( filter_input( INPUT_GET, 'page', FILTER_UNSAFE_RAW ) != $this->plugin_name ) {
                wp_die( __( 'You are not authorized to perform this action.', 'my-starter-plugin' ) );
            }

            // Validate Nonce Action
            if( ! check_admin_referer( $this->option_name . 'action', $this->option_name . 'nonce' ) ) {
                wp_die( __( 'You are not authorized to perform this action.', 'my-starter-plugin' ) );
            }
        }
    }
}
