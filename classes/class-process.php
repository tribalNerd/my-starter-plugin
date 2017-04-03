<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * @about Process Form Updates / Add/Delete Options
 * @location classes/my-starter-plugin.php
 * @call MyStarterPlugin_Process::instance();
 * 
 * @method init()       Start Admin Bar Manager
 * @method message()    Display Messages To User
 * @method update()     Update Option
 * @method instance()   Create Instance
 */
if( ! class_exists( 'MyStarterPlugin_Process' ) )
{
    class MyStarterPlugin_Process extends MyStarterPlugin_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Start Admin Bar Manager
         */
        final public function init()
        {
            // Process Plugin Disable/Enable, Delete Settings
            if ( filter_input( INPUT_POST, 'type' ) && parent::qString( 'page' ) == $this->plugin_name ) {
                // Form Security Check
                parent::validate();

                add_action( 'admin_init', array( $this, 'update') );
            }
        }

        /**
         * @about Display Messages To User
         * @param string $slug Which switch to load
         * @param string $notice_type Either updated/error
         */
        final public function message( $slug, $notice_type = false )
        {
            // Clear Message
            $message = '';

            // Message Switch
            switch ( $slug ) {
                case 'settingsupdate':
                    $message = __( '<u>Success</u>: Settings have been updated.', 'my-starter-plugin' );
                break;

                case 'settingsfail':
                    $message = __( '<u>Notice</u>: No settings selected or updated.', 'my-starter-plugin' );
                break;

                case 'settingsdelete':
                    $message = __( '<u>Notice</u>: All settings have been deleted.', 'my-starter-plugin' );
                break;
            }

            // Throw Message
            if ( ! empty( $message ) ) {
                // Set Message Type, Default Error
                $type = ( $notice_type == "update" ) ? "updated" : "error";

                // Return Message
                add_settings_error( $slug, $slug, $message, $type );
            }
        }


        /**
         * @about Update Option
         */
        final public function update()
        {
            // Delete Settings
            if ( filter_input( INPUT_POST, 'type' ) == "delete" ) {
                delete_option( $this->option_name . 'settings' );

                // Display Message
                $this->message( 'settingsdelete', 'update' );
            }

            // Update Settings
            if ( filter_input( INPUT_POST, 'type' ) == "update" ) {
                // Get Post Data
                $settings = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

                // Remove Unused Items
                unset( $settings[$this->option_name . 'nonce'] );
                unset( $settings['_wp_http_referer'] );
                unset( $settings['submit'] );
                unset( $settings['type'] );

                // Unset Empty Text Inputs
                if ( empty( $settings['text_name'] ) ) { unset( $settings['text_name'] ); }

                // Settings Posted
                if ( ! empty( $settings ) ) {
                    // Update Settings
                    update_option( $this->option_name . 'settings', $settings, true );
     
                    // Display Message
                    $this->message( 'settingsupdate', 'update' );

                // No Settings Posted
                } else {
                    // Empty Post - Delete Settings Option
                    if ( get_option( $this->option_name . 'settings' ) ) {
                        delete_option( $this->option_name . 'settings' );
                    }

                    // Display Message
                    $this->message( 'settingsfail', 'update' );
                }
            }
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
