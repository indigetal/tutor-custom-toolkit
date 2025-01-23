<?php
/**
 * Handles Orders backend page for Tutor LMS.
 */

defined( 'ABSPATH' ) || exit;

class Orders_Handler {

    /**
     * Initialize the Orders handler.
     */
    public static function init() {
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
        add_action( 'admin_menu', [ __CLASS__, 'customize_orders_page' ] );
    }

    /**
     * Enqueue admin scripts and styles for the Orders page.
     */
    public static function enqueue_scripts() {
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'tutor_orders' ) {
            wp_enqueue_style( 'orders-admin-style', plugin_dir_url( __FILE__ ) . 'assets/css/orders.css', [], '1.0.0' );
            wp_enqueue_script( 'orders-admin-script', plugin_dir_url( __FILE__ ) . 'assets/js/orders.js', [ 'jquery' ], '1.0.0', true );
        }
    }

    /**
     * Customize the Orders page display.
     */
    public static function customize_orders_page() {
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'tutor_orders' ) {
            add_action( 'admin_notices', [ __CLASS__, 'add_orders_notice' ] );
            add_filter( 'tutor_orders_query_args', [ __CLASS__, 'filter_orders_query' ] );
        }
    }

    /**
     * Display a notice for the Orders page.
     */
    public static function add_orders_notice() {
        echo '<div class="notice notice-info"><p>' . esc_html__( 'Displaying only your associated orders.', 'tutor' ) . '</p></div>';
    }

    /**
     * Filter the query for Orders to display only user-specific data.
     *
     * @param array $query_args The query arguments for orders.
     * @return array The modified query arguments.
     */
    public static function filter_orders_query( $query_args ) {
        if ( current_user_can( 'manage_orders' ) && ! current_user_can( 'manage_tutor' ) ) {
            $query_args['meta_query'] = [
                [
                    'key'     => 'customer_id',
                    'value'   => get_current_user_id(),
                    'compare' => '=',
                ],
            ];
        }

        return $query_args;
    }
}

// Initialize the Orders handler.
Orders_Handler::init();
