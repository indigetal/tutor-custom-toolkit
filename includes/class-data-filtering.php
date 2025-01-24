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
        error_log(print_r($screen, true)); // Log screen info for debugging
        if (!$screen || !current_user_can('manage_tutor')) {
            error_log('Invalid screen or insufficient permissions');
            return;
        }

        // Check for specific backend screens and apply filtering logic
        switch ($screen->id) {
            case 'tutor_withdraw_requests':
                error_log('Withdraw Requests screen detected');
                self::filter_withdraw_requests();
                break;
            case 'tutor_enrollment':
                error_log('Enrollment screen detected');
                self::override_enrollment_controller();
                break;
            case 'tutor_gradebook':
                error_log('Gradebook screen detected');
                self::filter_gradebook();
                break;
            case 'tutor_reports':
                error_log('Reports screen detected');
                self::override_reports_controller();
                break;
            default:
                error_log("Unrecognized screen ID: {$screen->id}");
                break;
        }
    }

    /**
     * Override the EnrollmentController.
     */
    public static function override_enrollment_controller() {
        require_once plugin_dir_path(__FILE__) . 'controllers/EnrollmentController.php';
        new \Custom_Tutor_Controllers\EnrollmentController();
        error_log('Custom EnrollmentController initialized.');
    }

    /**
     * Override the ReportsController.
     */
    public static function override_reports_controller() {
        require_once plugin_dir_path(__FILE__) . 'controllers/ReportsController.php';
        new \Custom_Tutor_Controllers\ReportsController();
        error_log('Custom ReportsController initialized.');
    }

    /**
     * Filter Withdraw Requests.
     */
    public static function filter_withdraw_requests() {
        $current_user_id = get_current_user_id();

        // Use utility function to validate instructor role
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            error_log('User is not an instructor for Withdraw Requests');
            return;
        }

        // Modify the Withdraw Requests query
        add_filter('tutor_withdraw_requests_query', function($query) use ($current_user_id) {
            error_log('Withdraw Requests query filter triggered');
            error_log(print_r($query, true));

            if (!isset($query['course_id']) || !tutor_utils()->is_instructor_of_this_course($current_user_id, $query['course_id'])) {
                error_log('User is not the instructor of this course in Withdraw Requests');
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
     * Filter Gradebook.
     */
    public static function filter_gradebook() {
        $current_user_id = get_current_user_id();

        // Use utility function to validate instructor role
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            error_log('User is not an instructor for Gradebook');
            return;
        }

        add_filter('tutor_gradebook_query', function($query) use ($current_user_id) {
            error_log('Gradebook query filter triggered');
            error_log(print_r($query, true));

            if (!isset($query['course_id']) || !tutor_utils()->is_instructor_of_this_course($current_user_id, $query['course_id'])) {
                error_log('User is not the instructor of this course in Gradebook');
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
}

// Initialize data filtering.
Data_Filtering::init();
