<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Custom hooks for filtering and processing gradebook data in Tutor LMS
 */

/**
 * Filter gradebook data to restrict entries to the instructor's courses.
 */
add_filter('tutor_gradebook_data', function ($gradebook_data) {
    $current_user_id = get_current_user_id();

    // Check if the current user is an instructor
    if (tutor_utils()->has_user_role('instructor', $current_user_id)) {
        $instructor_course_ids = get_courses_by_instructor($current_user_id);

        // Filter gradebook entries to include only data for the instructor's courses
        $filtered_gradebook = array_filter($gradebook_data, function ($entry) use ($instructor_course_ids) {
            return in_array($entry['course_id'], $instructor_course_ids);
        });

        return $filtered_gradebook;
    }

    return $gradebook_data; // Return unfiltered data for non-instructors
});

/**
 * Helper function to get all course IDs created by an instructor.
 *
 * @param int $instructor_id The ID of the instructor.
 * @return array An array of course IDs.
 */
function get_courses_by_instructor($instructor_id) {
    $query = new WP_Query([
        'post_type'      => 'tutor_course',
        'posts_per_page' => -1,
        'author'         => $instructor_id,
        'fields'         => 'ids',
    ]);

    return $query->posts;
}
