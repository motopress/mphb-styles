<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @return bool
 *
 * @global string $pagenow
 *
 * @since 0.0.1
 */
function mphbs_is_edit_post_page()
{
    global $pagenow;
    return is_admin() && in_array($pagenow, ['post.php', 'post-new.php']);
}
