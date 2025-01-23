<?php
/**
 * Handles Withdraw Requests backend page for Tutor LMS.
 */

defined( 'ABSPATH' ) || exit;

class Withdraw_Requests_Handler {

    /**
     * Initialize the Withdraw Requests handler.
     */
    public static function init() {
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
        add_action( 'admin_menu', [ __CLASS__, 'customize_withdraw_requests_page' ] );
    }

    /**
     * Enqueue admin scripts and styles for the Withdraw Requests page.
     */
    public static function enqueue_scripts() {
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'tutor_withdraw_requests' ) {
            wp_enqueue_style( 'withdraw-requests-admin-style', plugin_dir_url( __FILE__ ) . 'assets/css/withdraw-requests.css', [], '1.0.0' );
            wp_enqueue_script( 'withdraw-requests-admin-script', plugin_dir_url( __FILE__ ) . 'assets/js/withdraw-requests.js', [ 'jquery' ], '1.0.0', true );
        }
    }

    /**
     * Customize the Withdraw Requests page display.
     */
    public static function customize_withdraw_requests_page() {
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'tutor_withdraw_requests' ) {
            add_action( 'admin_notices', [ __CLASS__, 'add_withdraw_requests_notice' ] );
            add_filter( 'tutor_withdraw_requests_query_args', [ __CLASS__, 'filter_withdraw_requests_query' ] );
        }
    }

    /**
     * Display a notice for the Withdraw Requests page.
     */
    public static function add_withdraw_requests_notice() {
        if ( current_user_can( 'manage_tutor' ) ) {
            return; // Skip the notice for administrators.
        }
        echo '<div class="notice notice-info"><p>' . esc_html__( 'Displaying only your associated withdraw requests.', 'tutor' ) . '</p></div>';
    }

    /**
     * Filter the query for Withdraw Requests to display only instructor-specific data.
     *
     * @param array $query_args The query arguments for withdraw requests.
     * @return array The modified query arguments.
     */
    public static function filter_withdraw_requests_query( $query_args ) {
        if ( current_user_can( 'manage_tutor' ) ) {
            return $query_args; // Skip filtering for administrators.
        }

        if ( current_user_can( 'view_withdraw_requests' ) ) {
            $query_args['meta_query'] = [
                [
                    'key'     => 'instructor_id',
                    'value'   => get_current_user_id(),
                    'compare' => '=',
                ],
            ];
        }

        return $query_args;
    }
}

// Initialize the Withdraw Requests handler.
Withdraw_Requests_Handler::init();
