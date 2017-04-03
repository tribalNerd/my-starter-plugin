<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * @about Core - Things To Do, Display, Register, Shortcodes, etc..
 * @location classes/my-starter-plugin.php
 * @call MyStarterPlugin_Core::instance();
 * 
 * @method init()       Initialize
 * @method action()     Things To Do
 * @method instance()   Create Instance
 */
if( ! class_exists( 'MyStarterPlugin_Core' ) )
{
    class MyStarterPlugin_Core extends MyStarterPlugin_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Initialize
         */
        final public function init()
        {
            //add_action( 'init', array( $this, 'action' ) );
            //add_action( 'wp_loaded', array( $this, 'action' ) );
            add_action( 'wp', array( $this, 'action' ) );
        }


        /**
         * @about Things To Do
         */
        final public function action()
        {
            // Add Things To Do, Display, Register, Shortcodes, etc..
        }


        /**
         * @about Create Instance
         */
        public static function instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self();
                self::$instance->init();
            }

            return self::$instance;
        }
    }
}
