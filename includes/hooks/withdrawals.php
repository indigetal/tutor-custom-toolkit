<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Custom hooks for filtering and processing withdrawal requests in Tutor LMS
 */

/**
 * Filter withdrawal requests to restrict data to the instructor's courses.
 */
add_filter('tutor_withdrawal_requests_query', function ($query_args) {
    $current_user_id = get_current_user_id();

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
