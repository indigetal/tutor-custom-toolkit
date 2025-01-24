<?php
/*
Plugin Name: Tutor LMS Advanced Customization Toolkit
Description: A powerful integration tool for Tutor LMS, making it compatible with Blocksy's Content Blocks and advanced query systems like GreenShift. Features include dynamic template overrides, course metadata storage, and seamless Gutenberg-based customization.
Version: 1.2.3
Author: Brandon Meyer
*/

// Define plugin file constant.
if ( ! defined( 'TUTOR_CUSTOM_TOOLKIT_FILE' ) ) {
    define( 'TUTOR_CUSTOM_TOOLKIT_FILE', __FILE__ );
}

// Load dependencies.
require_once plugin_dir_path( __FILE__ ) . 'includes/class-template-loader.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-metadata-handler.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-data-filtering.php';

// Override the course archive template loader.
add_action( 'tutor_loaded', 'override_tutor_lms_template_loader', 20 );
function override_tutor_lms_template_loader() {
    if ( class_exists( 'TUTOR\\Template' ) ) {
        $template_class = new TUTOR\Template();
        remove_filter( 'template_include', array( $template_class, 'load_course_archive_template' ), 99 );
        Custom_Tutor_LMS_Template_Loader::init();
    }
}

// Initialize metadata handler after Tutor LMS is fully loaded.
add_action( 'tutor_loaded', function() {
    Tutor_LMS_Metadata_Handler::init();
});

// Initialize custom data filtering logic.
add_action( 'plugins_loaded', function() {
    Data_Filtering::init();
});

// Force WordPress default behavior for the course archive template.
add_filter( 'template_include', function( $template ) {
    if ( is_post_type_archive( 'courses' ) ) {
        return locate_template( 'archive-course.php' ) ?: locate_template( 'archive.php' );
    }
    return $template;
}, 100 );
