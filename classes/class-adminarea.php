<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Admin Area Display
 * @location my-starter-plugin.php
 * @call MyStarterPlugin_AdminArea::instance();
 * 
 * @method init()       Init Admin Actions
 * @method menu()       Load Admin Area Menu
 * @method enqueue()    Enqueue Stylesheet and jQuery
 * @method display()    Display Website Admin Templates
 * @method tabs()       Display Admin Area Tabs
 * @method links()      Display Sidebar Links
 * @method statement()  Display Footer Statement
 * @method instance()   Class Instance
 */
if ( ! class_exists( 'MyStarterPlugin_AdminArea' ) )
{
    class MyStarterPlugin_AdminArea extends MyStarterPlugin_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;

        // Tab Names
        private $tabs;


        /**
         * @about Init Admin Actions
         */
        final public function init()
        {
            // Website Menu Link
            add_action( 'admin_menu', array( $this, 'menu' ) );

            // Unqueue Scripts Within Plugin Admin Area
            if ( parent::qString( 'page' ) == $this->plugin_name ) {
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
            }

            // Tabs Names: &tab=home
            $this->tabs = array(
                'home' => __( 'Settings', 'my-starter-plugin' )
            );
        }


        /**
         * @about Admin Menus
         */
        final public function menu()
        {
            add_submenu_page(
                'options-general.php',
                $this->plugin_title,
                $this->menu_name,
                'manage_options',
                $this->plugin_name,
                array( $this, 'display' )
            );
        }


        /**
         * @about Enqueue Stylesheet & Javascript
         */
        final public function enqueue()
        {
            wp_enqueue_style( $this->plugin_name, plugin_dir_url( $this->plugin_file ) . 'assets/style.css', '', date( 'YmdHis', time() ), 'all' );
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( $this->plugin_file ) . 'assets/script.js', array( 'jquery' ), date( 'YmdHis', time() ), false );
        }


        /**
         * @about Display Website Admin Templates
         */
        final public function display()
        {
            // Admin Header
            require_once( $this->templates .'/header.php' );

            // Switch Between Tabs
            switch ( parent::qString( 'tab' ) ) {
                case 'home':
                default:
                    require_once( $this->templates .'/home.php' );
                break;

                // Example
                //case 'settings':
                //    require_once( $this->templates .'/settings.php' );
                //break;
            }

            // Admin Footer
            require_once( $this->templates .'/footer.php' );
        }


        /**
         * @about Display Admin Area Tabs
         * @location templates/header.php
         * @call <?php echo $this->tabs();?>
         * @return string $html Tab Display
         */
        final public function tabs()
        {
            $html = '<h2 class="nav-tab-wrapper">';

            // Set Current Tab
            $current = ( parent::qString( 'tab' ) ) ? parent::qString( 'tab' ) : key( $this->tabs );

            foreach( $this->tabs as $tab => $name ) {
                // Current Tab Class
                $class = ( $tab == $current ) ? ' nav-tab-active' : '';

                // Tab Links
                $html .= '<a href="?page='. parent::qString( 'page' ) .'&tab='. $tab .'" class="nav-tab'. $class .'">'. $name .'</a>';
            }

            $html .= '</h2><br />';

            return $html;
        }


        /**
         * @about Display Sidebar Links
         * @location templates/sidebar.php
         * @call <?php echo $this->sidebar();?>
         * @return string $html Sidebar Links
         */
        final public function links()
        {
            $html  = '<ul>';
            $html .= '<li>&bull; <a href="https://github.com/tribalNerd/my-starter-plugin" target="_blank">' . __( 'Plugin Home Page', 'my-starter-plugin' ) . '</a></li>';
            $html .= '<li>&bull; <a href="https://github.com/tribalNerd/my-starter-plugin/issues" target="_blank">' . __( 'Bugs & Feature Requests', 'my-starter-plugin' ) . '</a></li>';
            $html .= '<li>&bull; <a href="#" target="_blank">' . __( 'Contact Support', 'my-starter-plugin' ) . '</a></li>';
            $html .= '<li>&bull; <a href="#" target="_blank">' . __( 'Submit Feedback', 'my-starter-plugin' ) . '</a></li>';
            $html .= '<li>&bull; <a href="#" target="_blank">' . __( 'More Plugins!', 'my-starter-plugin' ) . '</a></li>';
            $html .= '</ul>';

            return $html;
        }


        /**
         * @about Display Footer Statement
         * @location templates/footer.php
         * @call <?php echo $this->footer();?>
         * @return string $html Footer Statement
         */
        final public function statement()
        {
            return __( 'Created by', 'my-starter-plugin' ) . '</b>: <a href="http://technerdia.com/" target="_blank">techNerdia</a>';
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
