<?php

function cinema_theme_styles()
{
    $theme_version = wp_get_theme()->get('Version');

    $version_string = is_string($theme_version) ? $theme_version : false;
    wp_register_style(
        'cinema_theme-style',
        get_template_directory_uri() . '/style.css',
        array(),
        $version_string
    );

    wp_enqueue_style('cinema_theme-style');
}

function add_tailwind_cdn()
{
    wp_enqueue_style('tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css');
}

function add_rating_meta_box()
{
    add_meta_box(
        'rating_meta_box',
        'Notes',
        'display_rating_meta_box',
        'post',
        'normal',
        'high'
    );
}

function display_rating_meta_box($post)
{
    $rating = get_post_meta($post->ID, '_rating', true);
    wp_nonce_field(basename(__FILE__), 'rating_nonce');
?>
    <label for="rating">Notes:</label>
    <select id="rating" name="rating">
        <option value="1" <?php selected($rating, '1'); ?>>nul</option>
        <option value="2" <?php selected($rating, '2'); ?>>bof</option>
        <option value="3" <?php selected($rating, '3'); ?>>moyen</option>
        <option value="4" <?php selected($rating, '4'); ?>>bon</option>
        <option value="5" <?php selected($rating, '5'); ?>>excellent</option>
    </select>
<?php
}

function save_rating_meta_box_data($post_id)
{
    if (!isset($_POST['rating_nonce']) || !wp_verify_nonce($_POST['rating_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['rating'])) {
        update_post_meta($post_id, '_rating', intval($_POST['rating']));
    } else {
        delete_post_meta($post_id, '_rating');
    }
}

function add_link_meta_box()
{
    add_meta_box(
        'link_meta_box',
        'Lien',
        'display_link_meta_box',
        'post',
        'normal',
        'high'
    );
}

function display_link_meta_box($post)
{
    $link = get_post_meta($post->ID, '_link', true);
    wp_nonce_field(basename(__FILE__), 'link_nonce');
?>
    <label for="link">Lien:</label>
    <input type="url" id="link" name="link" value="<?php echo esc_url($link); ?>" size="30" />
<?php
}

function save_link_meta_box_data($post_id)
{
    if (!isset($_POST['link_nonce']) || !wp_verify_nonce($_POST['link_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['link'])) {
        update_post_meta($post_id, '_link', esc_url_raw($_POST['link']));
    } else {
        delete_post_meta($post_id, '_link');
    }
}

function enqueue_media_uploader()
{
    if (is_admin()) {
        wp_enqueue_media();
        wp_enqueue_script('category-image-upload', get_template_directory_uri() . '/js/category-image-upload.js', array('jquery'), null, true);
    }
}

function add_category_image_field($taxonomy)
{
?>
    <div class="form-field term-group">
        <label for="category-image"><?php _e('Category Image', 'textdomain'); ?></label>
        <input type="text" id="category-image" name="category-image" value="" class="category-image-field">
        <button id="upload_image_button" class="button"><?php _e('Upload/Add image', 'textdomain'); ?></button>
        <img id="category-image-preview" src="" style="max-width: 100%; display: block; margin-top: 10px;">
    </div>
<?php
}

function edit_category_image_field($term, $taxonomy)
{
    $image_url = get_term_meta($term->term_id, 'category-image', true);
?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="category-image"><?php _e('Category Image', 'textdomain'); ?></label></th>
        <td>
            <input type="text" id="category-image" name="category-image" value="<?php echo esc_attr($image_url); ?>" class="category-image-field">
            <button id="upload_image_button" class="button"><?php _e('Upload/Add image', 'textdomain'); ?></button>
            <img id="category-image-preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 100%; display: block; margin-top: 10px;">
        </td>
    </tr>
<?php
}

function save_category_image($term_id)
{
    if (isset($_POST['category-image']) && '' !== $_POST['category-image']) {
        $image = esc_url_raw($_POST['category-image']);
        update_term_meta($term_id, 'category-image', $image);
    } else {
        delete_term_meta($term_id, 'category-image');
    }
}

add_theme_support('post-thumbnails');

add_action('created_category', 'save_category_image', 10, 2);
add_action('edited_category', 'save_category_image', 10, 2);
add_action('category_edit_form_fields', 'edit_category_image_field', 10, 2);
add_action('category_add_form_fields', 'add_category_image_field', 10, 2);
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');
add_action('add_meta_boxes', 'add_rating_meta_box');
add_action('add_meta_boxes', 'add_link_meta_box');
add_action('save_post', 'save_link_meta_box_data');
add_action('save_post', 'save_rating_meta_box_data');
add_action('wp_enqueue_scripts', 'cinema_theme_styles');
add_action('wp_enqueue_scripts', 'add_tailwind_cdn');
