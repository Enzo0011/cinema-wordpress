<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php get_header(); ?>

    <?php
    if (is_category()) {
        $category = get_queried_object();
        $image_url = get_term_meta($category->term_id, 'category-image', true);

        if ($image_url) {
            echo '<div class="mx-auto px-4 py-8 headerImage" style="background-image: url(' . esc_url($image_url) . '"></div>';
        }
    }
    ?>

    <div class="container mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
        ?>
                <article class="bg-white p-6 rounded-lg flex flex-col items-center transform transition-transform duration-300">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('medium', ['class' => 'mb-4 rounded-lg post-thumbnail']);
                    }
                    ?>
                    <h2 class="text-2xl font-semibold mb-2 text-center">
                        <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline"><?php the_title(); ?></a>
                    </h2>
                    <?php
                    $rating = get_post_meta(get_the_ID(), '_rating', true);
                    if (!empty($rating)) {
                        echo '<div class="post-rating mb-4">';
                        for ($i = 0; $i < 5; $i++) {
                            if ($i < $rating) {
                                echo '<span class="text-yellow-500">★</span>';
                            } else {
                                echo '<span class="text-gray-400">★</span>';
                            }
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="text-gray-700 text-center">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors duration-300">Voir le film</a>
                </article>
        <?php
            endwhile;
        else :
            echo '<p class="text-center col-span-full text-gray-500">No content found</p>';
        endif;
        ?>
    </div>

    <?php if (have_posts()) {
        echo '<div class="pagination flex justify-center py-4">';
        echo paginate_links();
        echo '</div>';
    } ?>

    <?php get_footer(); ?>
</body>

</html>