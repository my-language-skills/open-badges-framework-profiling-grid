<?php

/**
 * This file allow to create roles and capabilities.
 *
 * @author Nicolas TORION
 * @package badges-issuer-for-wp
 * @subpackage includes/initialisation
 * @since 1.0.0
*/

/*
Add capabilities to the existing roles.
*/

function add_portfolios_capabilities() {
    // ADMINISTRATOR ROLE
    $admin = get_role('administrator');

    $admin->add_cap('edit_student_portfolio');
    $admin->add_cap('edit_student_portfolios');
    $admin->add_cap('edit_other_student_portfolios');
    $admin->add_cap('edit_published_student_portfolios');
    $admin->add_cap('publish_student_portfolios');
    $admin->add_cap('read_student_portfolio');
    $admin->add_cap('read_student_portfolios');
    $admin->add_cap('read_private_student_portfolios');
    $admin->add_cap('delete_student_portfolio');

    $admin->add_cap('edit_teacher_portfolio');
    $admin->add_cap('edit_teacher_portfolios');
    $admin->add_cap('edit_other_teacher_portfolios');
    $admin->add_cap('edit_published_teacher_portfolios');
    $admin->add_cap('publish_teacher_portfolios');
    $admin->add_cap('read_teacher_portfolio');
    $admin->add_cap('read_teacher_portfolios');
    $admin->add_cap('read_private_teacher_portfolios');
    $admin->add_cap('delete_teacher_portfolio');
}

add_action( 'init', 'add_portfolios_capabilities');

?>
