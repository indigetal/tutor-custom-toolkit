<?php
namespace Custom_Tutor_Controllers;

use TUTOR\Http\Controllers\EnrollmentController as BaseEnrollmentController;
use WP_Query;

class EnrollmentController extends BaseEnrollmentController {

    /**
     * Override the index method to filter enrollments by instructor.
     */
    public function index() {
        $current_user_id = get_current_user_id();

        // Ensure the current user is an instructor
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            wp_die(__('You do not have permission to access this page.', 'tutor'));
        }

        // Fetch enrollments only for courses created by the current instructor
        $query_args = [
            'post_type'      => 'tutor_enrollment',
            'posts_per_page' => -1,
            'meta_query'     => [
                [
                    'key'     => 'course_id',
                    'value'   => $this->get_instructor_course_ids($current_user_id),
                    'compare' => 'IN',
                ],
            ],
        ];

        $query = new WP_Query($query_args);

        $enrollments = [];
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $enrollments[] = [
                    'id'        => get_the_ID(),
                    'course_id' => get_post_meta(get_the_ID(), 'course_id', true),
                    'user_id'   => get_post_meta(get_the_ID(), 'user_id', true),
                    'status'    => get_post_meta(get_the_ID(), 'status', true),
                ];
            }
        }

        wp_reset_postdata();

        // Render view or return data
        return $this->render('enrollments.index', compact('enrollments'));
    }

    /**
     * Get all course IDs created by the instructor.
     *
     * @param int $instructor_id
     * @return array
     */
    private function get_instructor_course_ids($instructor_id) {
        $query = new WP_Query([
            'post_type'      => 'tutor_course',
            'posts_per_page' => -1,
            'author'         => $instructor_id,
            'fields'         => 'ids',
        ]);

        return $query->posts;
    }
}
