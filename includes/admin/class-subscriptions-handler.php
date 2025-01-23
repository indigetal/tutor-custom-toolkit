<?php
/**
 * Handles Subscriptions backend page for Tutor LMS.
 */

defined( 'ABSPATH' ) || exit;

class Subscriptions_Handler {

    /**
     * Initialize the Subscriptions handler.
     */
    public static function init() {
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
        add_action( 'admin_menu', [ __CLASS__, 'customize_subscriptions_page' ] );
    }

    /**
     * Enqueue admin scripts and styles for the Subscriptions page.
     */
    public static function enqueue_scripts() {
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'tutor_subscriptions' ) {
            wp_enqueue_style( 'subscriptions-admin-style', plugin_dir_url( __FILE__ ) . 'assets/css/subscriptions.css', [], '1.0.0' );
            wp_enqueue_script( 'subscriptions-admin-script', plugin_dir_url( __FILE__ ) . 'assets/js/subscriptions.js', [ 'jquery' ], '1.0.0', true );
        }
    }

    /**
     * Customize the Subscriptions page display.
     */
    public static function customize_subscriptions_page() {
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'tutor_subscriptions' ) {
            add_action( 'admin_notices', [ __CLASS__, 'add_subscriptions_notice' ] );
            add_filter( 'tutor_subscriptions_query_args', [ __CLASS__, 'filter_subscriptions_query' ] );
        }
    }

    /**
     * Display a notice for the Subscriptions page.
     */
    public static function add_subscriptions_notice() {
        if ( current_user_can( 'manage_tutor' ) ) {
            return; // Skip the notice for administrators.
        }
        echo '<div class="notice notice-info"><p>' . esc_html__( 'Displaying only your associated subscriptions.', 'tutor' ) . '</p></div>';
    }

    /**
     * Filter the query for Subscriptions to display only user-specific data.
     *
     * @param array $query_args The query arguments for subscriptions.
     * @return array The modified query arguments.
     */
    public static function filter_subscriptions_query( $query_args ) {
        if ( current_user_can( 'manage_tutor' ) ) {
            return $query_args; // Skip filtering for administrators.
        }

        if ( current_user_can( 'view_subscriptions' ) ) {
            $query_args['meta_query'] = [
                [
                    'key'     => 'subscriber_id',
                    'value'   => get_current_user_id(),
                    'compare' => '=',
                ],
            ];
        }

        return $query_args;
    }
}

// Initialize the Subscriptions handler.
Subscriptions_Handler::init();
