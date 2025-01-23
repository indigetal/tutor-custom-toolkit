<?php
/**
 * Manages granular capabilities for Tutor LMS backend pages.
 */

defined( 'ABSPATH' ) || exit;

class Capabilities_Manager {

    /**
     * Initialize the capabilities manager.
     */
    public static function init() {
        // Add new capabilities during plugin activation.
        register_activation_hook( __FILE__, [ __CLASS__, 'add_capabilities' ] );

        // Remove capabilities on deactivation (optional).
        register_deactivation_hook( __FILE__, [ __CLASS__, 'remove_capabilities' ] );
    }

    /**
     * Adds granular capabilities to administrator and instructor roles.
     */
    public static function add_capabilities() {
        $roles = [ 'administrator', 'instructor' ];
        foreach ( $roles as $role ) {
            $role_obj = get_role( $role );
            if ( $role_obj ) {
                $role_obj->add_cap( 'view_withdraw_requests' );
                $role_obj->add_cap( 'manage_orders' );
                $role_obj->add_cap( 'view_subscriptions' );
            }
        }
    }

    /**
     * Removes granular capabilities (optional).
     */
    public static function remove_capabilities() {
        $roles = [ 'administrator', 'instructor' ];
        foreach ( $roles as $role ) {
            $role_obj = get_role( $role );
            if ( $role_obj ) {
                $role_obj->remove_cap( 'view_withdraw_requests' );
                $role_obj->remove_cap( 'manage_orders' );
                $role_obj->remove_cap( 'view_subscriptions' );
            }
        }
    }
}

// Initialize the capabilities manager.
Capabilities_Manager::init();
