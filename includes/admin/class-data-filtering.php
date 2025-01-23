<?php
/**
 * Implements dynamic data filtering for Tutor LMS backend pages based on user roles.
 */

defined( 'ABSPATH' ) || exit;

class Data_Filtering {

    /**
     * Initialize data filtering hooks.
     */
    public static function init() {
        add_action( 'pre_get_posts', [ __CLASS__, 'filter_withdraw_requests' ] );
        add_action( 'pre_get_posts', [ __CLASS__, 'filter_orders' ] );
        add_action( 'pre_get_posts', [ __CLASS__, 'filter_subscriptions' ] );
    }

    /**
     * Filter Withdraw Requests data for instructors.
     *
     * @param WP_Query $query The current query object.
     */
    public static function filter_withdraw_requests( $query ) {
        if ( is_admin() && $query->is_main_query() && isset( $_GET['page'] ) && $_GET['page'] === 'tutor_withdraw_requests' ) {
            if ( current_user_can( 'manage_tutor' ) ) {
                return; // Skip filtering for administrators.
            }

            if ( current_user_can( 'view_withdraw_requests' ) ) {
                $query->set( 'meta_key', 'instructor_id' );
                $query->set( 'meta_value', get_current_user_id() );
            }
        }
    }

    /**
     * Filter Orders data for instructors.
     *
     * @param WP_Query $query The current query object.
     */
    public static function filter_orders( $query ) {
        if ( is_admin() && $query->is_main_query() && isset( $_GET['page'] ) && $_GET['page'] === 'tutor_orders' ) {
            if ( current_user_can( 'manage_tutor' ) ) {
                return; // Skip filtering for administrators.
            }

            if ( current_user_can( 'manage_orders' ) ) {
                $query->set( 'meta_key', 'customer_id' );
                $query->set( 'meta_value', get_current_user_id() );
            }
        }
    }

    /**
     * Filter Subscriptions data for instructors.
     *
     * @param WP_Query $query The current query object.
     */
    public static function filter_subscriptions( $query ) {
        if ( is_admin() && $query->is_main_query() && isset( $_GET['page'] ) && $_GET['page'] === 'tutor_subscriptions' ) {
            if ( current_user_can( 'manage_tutor' ) ) {
                return; // Skip filtering for administrators.
            }

            if ( current_user_can( 'view_subscriptions' ) ) {
                $query->set( 'meta_key', 'subscriber_id' );
                $query->set( 'meta_value', get_current_user_id() );
            }
        }
    }
}

// Initialize data filtering.
Data_Filtering::init();
