<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vge_disable_block_editor( $use_block_editor, $post_type ) {
    $enabled_post_types = get_option( 'vge_enabled_post_types', [] );

    if ( in_array( $post_type, $enabled_post_types ) ) {
        return true; // Gutenberg enabled for this post type.
    }
    return false; // Gutenberg disabled for other post types.
}
add_filter( 'use_block_editor_for_post_type', 'vge_disable_block_editor', 10, 2 );
