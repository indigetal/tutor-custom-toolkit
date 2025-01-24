<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Custom hooks for filtering and processing gradebook data in Tutor LMS
 */

// Include shared utility functions
require_once plugin_dir_path(__FILE__) . '/../utils.php';

/**
 * Filter gradebook data to restrict entries to the instructor's courses.
 */
add_filter('tutor_gradebook_data', function ($gradebook_data, $course_id = null) {
    global $wpdb;
    $current_user_id = get_current_user_id();

    // Exempt admins from filtering
    if (user_can($current_user_id, 'administrator')) {
        return $gradebook_data;
    }

    // Check if the current user is an instructor
    if (tutor_utils()->has_user_role('instructor', $current_user_id)) {
        $instructor_course_ids = get_courses_by_instructor($current_user_id);

        if (!empty($instructor_course_ids)) {
            // Build the SQL query to fetch filtered gradebook entries
            $placeholders = implode(',', array_fill(0, count($instructor_course_ids), '%d'));
            $sql = "SELECT * FROM {$wpdb->prefix}tutor_gradebook WHERE course_id IN ($placeholders)";

            // Add course-specific filtering if a course_id is provided
            if ($course_id && in_array($course_id, $instructor_course_ids)) {
                $sql .= " AND course_id = %d";
                $query_args = array_merge($instructor_course_ids, [$course_id]);
            } else {
                $query_args = $instructor_course_ids;
            }

            $prepared_sql = $wpdb->prepare($sql, $query_args);
            return $wpdb->get_results($prepared_sql, ARRAY_A);
        } else {
            return []; // No courses for this instructor
        }
    }

    // Default behavior for non-instructors
    return $gradebook_data;
}, 10, 2);
