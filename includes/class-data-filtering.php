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
        add_action( 'pre_get_posts', [ __CLASS__, 'filter_enrollment' ] );
        add_action( 'pre_get_posts', [ __CLASS__, 'filter_gradebook' ] );
        add_action( 'pre_get_posts', [ __CLASS__, 'filter_reports' ] );
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

            if ( current_user_can( 'manage_tutor' ) ) {
                $query->set( 'meta_key', 'instructor_id' );
                $query->set( 'meta_value', get_current_user_id() );
            }
        }
    }

    /**
     * Filter Enrollment data for instructors.
     *
     * @param WP_Query $query The current query object.
     */
    public static function filter_enrollment( $query ) {
        if ( is_admin() && $query->is_main_query() && isset( $_GET['page'] ) && $_GET['page'] === 'tutor_enrollment' ) {
            if ( current_user_can( 'manage_tutor' ) ) {
                return; // Skip filtering for administrators.
            }

            if ( current_user_can( 'manage_tutor' ) ) {
                $query->set( 'meta_query', [
                    [
                        'key'     => 'course_author',
                        'value'   => get_current_user_id(),
                        'compare' => '=',
                    ],
                ] );
            }
        }
    }

    /**
     * Filter Gradebook data for instructors.
     *
     * @param WP_Query $query The current query object.
     */
    public static function filter_gradebook( $query ) {
        if ( is_admin() && $query->is_main_query() && isset( $_GET['page'] ) && $_GET['page'] === 'tutor_gradebook' ) {
            if ( current_user_can( 'manage_tutor' ) ) {
                return; // Skip filtering for administrators.
            }

            if ( current_user_can( 'manage_tutor' ) ) {
                $query->set( 'meta_query', [
                    [
                        'key'     => 'course_author',
                        'value'   => get_current_user_id(),
                        'compare' => '=',
                    ],
                ] );
            }
        }
    }

    /**
     * Filter Reports data for instructors.
     *
     * @param WP_Query $query The current query object.
     */
    public static function filter_reports( $query ) {
        if ( is_admin() && $query->is_main_query() && isset( $_GET['page'] ) && $_GET['page'] === 'tutor_reports' ) {
            if ( current_user_can( 'manage_tutor' ) ) {
                return; // Skip filtering for administrators.
            }

            if ( current_user_can( 'manage_tutor' ) ) {
                $query->set( 'meta_query', [
                    [
                        'key'     => 'course_author',
                        'value'   => get_current_user_id(),
                        'compare' => '=',
                    ],
                ] );
            }
        }
    }
}

// Initialize data filtering.
Data_Filtering::init();
