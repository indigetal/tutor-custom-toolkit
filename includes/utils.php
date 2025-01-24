<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Utility functions for Tutor LMS Custom Toolkit.
 */

/**
 * Get all course IDs created by an instructor.
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
