<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vge_render_settings_page() {
    $post_types = [
        'post' => get_post_type_object( 'post' ),
        'page' => get_post_type_object( 'page' ),
    ];

    $enabled_post_types = get_option( 'vge_enabled_post_types', [] );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Vaibhaw Gutenberg Editor Settings', 'vaibhaw-gutenberg-editor' ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'vge_settings_group' );
            do_settings_sections( 'vge_settings_group' );
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Enable Gutenberg for Post Types', 'vaibhaw-gutenberg-editor' ); ?></th>
                    <td>
                        <?php foreach ( $post_types as $post_type ): ?>
                            <label>
                                <input type="checkbox" name="vge_enabled_post_types[]" value="<?php echo esc_attr( $post_type->name ); ?>" <?php checked( in_array( $post_type->name, $enabled_post_types ), true ); ?>>
                                <?php echo esc_html( $post_type->label ); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
            <?php submit_button( __( 'Save Changes', 'vaibhaw-gutenberg-editor' ) ); ?>
        </form>
    </div>
    <?php
}
