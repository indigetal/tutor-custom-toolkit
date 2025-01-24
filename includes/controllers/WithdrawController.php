<?php
namespace Custom_Tutor_Controllers;

use Tutor\Http\Controllers\WithdrawController as BaseWithdrawController;
use WP_Query;

class WithdrawController extends BaseWithdrawController {

    /**
     * Override the index method to filter withdraw requests by instructor.
     */
    public function index() {
        // Ensure the base class exists
        if (!class_exists('Tutor\Http\Controllers\WithdrawController')) {
            error_log('Base WithdrawController class not found!');
            wp_die(__('Base WithdrawController class not found.', 'tutor'));
        }

        $current_user_id = get_current_user_id();

        // Ensure the current user is an instructor
        if (!tutor_utils()->has_user_role('instructor', $current_user_id)) {
            wp_die(__('You do not have permission to access this page.', 'tutor'));
        }

        // Fetch withdraw requests only for courses created by the current instructor
        $query_args = [
            'post_type'      => 'tutor_withdraw',
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

        $withdraw_requests = [];
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $withdraw_requests[] = [
                    'id'         => get_the_ID(),
                    'course_id'  => get_post_meta(get_the_ID(), 'course_id', true),
                    'amount'     => get_post_meta(get_the_ID(), 'amount', true),
                    'status'     => get_post_meta(get_the_ID(), 'status', true),
                    'created_at' => get_the_date(),
                ];
            }
        }

        wp_reset_postdata();

        // Render view or return data
        return $this->render('withdraw.index', compact('withdraw_requests'));
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
