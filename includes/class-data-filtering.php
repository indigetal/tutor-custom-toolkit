<?php
defined('ABSPATH') || exit;

class Data_Filtering {

    /**
     * Initialize data filtering hooks.
     */
    public static function init() {
        add_action('admin_menu', [__CLASS__, 'apply_custom_filters']);
    }

    /**
     * Apply filters to specific backend pages.
     */
    public static function apply_custom_filters() {
        $screen = get_current_screen();
        if (!$screen || !current_user_can('manage_tutor')) {
            return;
        }

        // Check for specific backend screens and apply filtering logic
        switch ($screen->id) {
            case 'tutor_withdraw_requests':
                self::filter_withdraw_requests();
                break;
            case 'tutor_enrollment':
                self::filter_enrollment();
                break;
            case 'tutor_gradebook':
                self::filter_gradebook();
                break;
            case 'tutor_reports':
                self::filter_reports();
                break;
        }
    }

    /**
     * Filter Withdraw Requests.
     */
    public static function filter_withdraw_requests() {
        $current_user_id = get_current_user_id();

        // Use utility function to validate instructor role
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            return;
        }

        // Modify the Withdraw Requests query
        add_filter('tutor_withdraw_requests_query', function($query) use ($current_user_id) {
            if (!tutor_utils()->is_instructor_of_this_course($current_user_id, $query['course_id'] ?? 0)) {
                return $query; // Skip if not the instructor of the course
            }

            $query['meta_query'][] = [
                'key' => 'instructor_id',
                'value' => $current_user_id,
                'compare' => '=',
            ];
            return $query;
        });
    }

    /**
     * Filter Enrollment.
     */
    public static function filter_enrollment() {
        $current_user_id = get_current_user_id();

        // Use utility function to validate instructor role
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            return;
        }

        add_filter('tutor_enrollment_query', function($query) use ($current_user_id) {
            if (!tutor_utils()->is_instructor_of_this_course($current_user_id, $query['course_id'] ?? 0)) {
                return $query; // Skip if not the instructor of the course
            }

            $query['author'] = $current_user_id;
            return $query;
        });
    }

    /**
     * Filter Gradebook.
     */
    public static function filter_gradebook() {
        $current_user_id = get_current_user_id();

        // Use utility function to validate instructor role
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            return;
        }

        add_filter('tutor_gradebook_query', function($query) use ($current_user_id) {
            if (!tutor_utils()->is_instructor_of_this_course($current_user_id, $query['course_id'] ?? 0)) {
                return $query; // Skip if not the instructor of the course
            }

            $query['meta_query'][] = [
                'key' => '_tutor_instructor_course_id',
                'value' => $current_user_id,
                'compare' => '=',
            ];
            return $query;
        });
    }

    /**
     * Filter Reports.
     */
    public static function filter_reports() {
        $current_user_id = get_current_user_id();

        // Use utility function to validate instructor role
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            return;
        }

        add_filter('tutor_reports_query', function($query) use ($current_user_id) {
            if (!tutor_utils()->is_instructor_of_this_course($current_user_id, $query['course_id'] ?? 0)) {
                return $query; // Skip if not the instructor of the course
            }

            $query['author'] = $current_user_id;
            return $query;
        });
    }
}

// Initialize data filtering.
Data_Filtering::init();
