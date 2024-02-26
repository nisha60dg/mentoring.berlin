<?php

/**
 * Manage All Action Hooks
 * 
 * 
 */

function mentoring_manage_pages_redirections()
{
    if (isset($post) && !empty($post)) {
        global $post;
        if ($post->ID == 1219) {
            if (!isset($_COOKIE['mentee_id']) || empty($_COOKIE['mentee_id'])) {
                wp_redirect(get_permalink(1207));
                exit();
            }
        }
    }
}
add_action('wp', 'mentoring_manage_pages_redirections');
