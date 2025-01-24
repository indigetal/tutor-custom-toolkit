<?php
namespace Custom_Tutor_Controllers;

use TUTOR\Http\Controllers\GradebookController as BaseGradebookController;
use WP_Query;

class GradebookController extends BaseGradebookController {

    /**
     * Override the index method to filter gradebook data by instructor.
     */
    public function index() {
        $current_user_id = get_current_user_id();

        // Ensure the current user is an instructor
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            wp_die(__('You do not have permission to access this page.', 'tutor'));
        }

        // Fetch gradebook data only for courses created by the current instructor
        $query_args = [
            'post_type'      => 'tutor_gradebook',
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

        $gradebook_entries = [];
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $gradebook_entries[] = [
                    'id'         => get_the_ID(),
                    'course_id'  => get_post_meta(get_the_ID(), 'course_id', true),
                    'student_id' => get_post_meta(get_the_ID(), 'student_id', true),
                    'grade'      => get_post_meta(get_the_ID(), 'grade', true),
                    'updated_at' => get_the_modified_date(),
                ];
            }
        }

        wp_reset_postdata();

        // Render view or return data
        return $this->render('gradebook.index', compact('gradebook_entries'));
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
