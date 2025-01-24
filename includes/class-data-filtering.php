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
                self::override_withdraw_controller();
                break;
            case 'tutor_enrollment':
                error_log('Enrollment screen detected');
                self::override_enrollment_controller();
                break;
            case 'tutor_gradebook':
                error_log('Gradebook screen detected');
                self::override_gradebook_controller();
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
     * Override the WithdrawController.
     */
    public static function override_withdraw_controller() {
        require_once plugin_dir_path(__FILE__) . 'controllers/WithdrawController.php';
        new \Custom_Tutor_Controllers\WithdrawController();
        error_log('Custom WithdrawController initialized.');
    }

    /**
     * Override the GradebookController.
     */
    public static function override_gradebook_controller() {
        require_once plugin_dir_path(__FILE__) . 'controllers/GradebookController.php';
        new \Custom_Tutor_Controllers\GradebookController();
        error_log('Custom GradebookController initialized.');
    }

}

// Initialize data filtering.
Data_Filtering::init();
