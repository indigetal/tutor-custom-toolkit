<?php
/**
 * Registers and handles backend menu items for Tutor LMS with granular capabilities.
 */

defined( 'ABSPATH' ) || exit;

class Menu_Handler {

    /**
     * Initialize the menu handler.
     */
    public static function init() {
        add_action( 'admin_menu', [ __CLASS__, 'register_menus' ], 100 );
    }

    /**
     * Register backend menu items based on user capabilities.
     */
    public static function register_menus() {
        // Withdraw Requests Menu
        if ( current_user_can( 'view_withdraw_requests' ) ) {
            add_submenu_page(
                'tutor',
                __( 'Withdraw Requests', 'tutor' ),
                __( 'Withdraw Requests', 'tutor' ),
                'view_withdraw_requests',
                'tutor_withdraw_requests',
                [ __CLASS__, 'withdraw_requests_page' ]
            );
        }

        // Orders Menu
        if ( current_user_can( 'manage_orders' ) ) {
            add_submenu_page(
                'tutor',
                __( 'Orders', 'tutor' ),
                __( 'Orders', 'tutor' ),
                'manage_orders',
                'tutor_orders',
                [ __CLASS__, 'orders_page' ]
            );
        }

        // Subscriptions Menu
        if ( current_user_can( 'view_subscriptions' ) ) {
            add_submenu_page(
                'tutor',
                __( 'Subscriptions', 'tutor' ),
                __( 'Subscriptions', 'tutor' ),
                'view_subscriptions',
                'tutor_subscriptions',
                [ __CLASS__, 'subscriptions_page' ]
            );
        }
    }

    /**
     * Render the Withdraw Requests page.
     */
    public static function withdraw_requests_page() {
        echo '<h1>' . esc_html__( 'Withdraw Requests', 'tutor' ) . '</h1>';
        // Add additional logic for displaying withdraw requests here.
    }

    /**
     * Render the Orders page.
     */
    public static function orders_page() {
        echo '<h1>' . esc_html__( 'Orders', 'tutor' ) . '</h1>';
        // Add additional logic for displaying orders here.
    }

    /**
     * Render the Subscriptions page.
     */
    public static function subscriptions_page() {
        echo '<h1>' . esc_html__( 'Subscriptions', 'tutor' ) . '</h1>';
        // Add additional logic for displaying subscriptions here.
    }
}

// Initialize the menu handler.
Menu_Handler::init();
