<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Custom hooks for filtering and processing enrollments in Tutor LMS
 */

// Include shared utility functions
require_once plugin_dir_path(__FILE__) . '/../utils.php';

/**
 * Filter enrolled courses query to restrict data to the instructor's courses.
 */
add_filter('tutor_dashboard_enrolled_courses_query', function ($query_args) {
    $current_user_id = get_current_user_id();

    // Exempt admins from filtering
    if (user_can($current_user_id, 'administrator')) {
        return $query_args;
    }

    // Check if the current user is an instructor
    if (tutor_utils()->has_user_role('instructor', $current_user_id)) {
        // Get instructor's course IDs (including authored and co-authored)
        $instructor_course_ids = get_courses_by_instructor($current_user_id);

        if (!empty($instructor_course_ids)) {
            $query_args['post__in'] = $instructor_course_ids;
        } else {
            // Prevent showing enrollments if the instructor has no courses
            $query_args['post__in'] = [-1]; // No matching courses
        }
    }

    return $query_args;
});
