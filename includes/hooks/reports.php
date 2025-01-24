<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Custom hooks for filtering and processing reports in Tutor LMS
 */

// Include shared utility functions
require_once plugin_dir_path(__FILE__) . '/../utils.php';

/**
 * Filter reports data to restrict results based on the instructor's courses.
 */
add_filter('tutor_reports_data', function ($reports_data, $course_id = null, $date = null) {
    global $wpdb;
    $current_user_id = get_current_user_id();

    // Exempt admins from filtering
    if (user_can($current_user_id, 'administrator')) {
        return $reports_data;
    }

    // Check if the current user is an instructor
    if (tutor_utils()->has_user_role('instructor', $current_user_id)) {
        $instructor_course_ids = get_courses_by_instructor($current_user_id);

        if (!empty($instructor_course_ids)) {
            // Build the SQL query to fetch filtered reports
            $placeholders = implode(',', array_fill(0, count($instructor_course_ids), '%d'));
            $sql = "SELECT * FROM {$wpdb->prefix}tutor_course_reports WHERE course_id IN ($placeholders)";

            // Add date filtering if provided
            if (!empty($date) && isset($date['start'], $date['end'])) {
                $sql .= " AND created_at BETWEEN %s AND %s";
                $query_args = array_merge($instructor_course_ids, [$date['start'], $date['end']]);
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
    return $reports_data;
}, 10, 3);
