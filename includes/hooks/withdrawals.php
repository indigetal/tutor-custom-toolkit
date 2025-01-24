<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Custom hooks for filtering and processing withdrawal requests in Tutor LMS
 */

// Include shared utility functions
require_once plugin_dir_path(__FILE__) . '/../utils.php';

/**
 * Filter withdrawal requests query to restrict data to the instructor's courses.
 */
add_filter('tutor_withdrawal_requests_query_args', function ($query_args) {
    $current_user_id = get_current_user_id();

    // Exempt admins from filtering
    if (user_can($current_user_id, 'administrator')) {
        return $query_args;
    }

    // Check if the current user is an instructor
    if (tutor_utils()->has_user_role('instructor', $current_user_id)) {
        $instructor_course_ids = get_courses_by_instructor($current_user_id);

        if (!empty($instructor_course_ids)) {
            $query_args['meta_query'][] = [
                'key'     => 'course_id',
                'value'   => $instructor_course_ids,
                'compare' => 'IN',
            ];
        } else {
            // Prevent showing withdrawal requests if the instructor has no courses
            $query_args['meta_query'][] = [
                'key'     => 'course_id',
                'value'   => -1, // No matching courses
                'compare' => '=',
            ];
        }
    }

    return $query_args;
});
