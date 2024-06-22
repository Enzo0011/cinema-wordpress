<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <?php wp_head(); ?>
</head>

<body>
    <?php get_header(); ?>
    <main>
        <div class="container mx-auto px-4 py-8">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
            ?>
                    <div class="content mb-6 flex items-center">
                        <header class="mb-4">
                            <h1 class="text-4xl font-bold mb-2"><?php the_title(); ?></h1>
                            <div class="text-gray-600 mb-4">
                                <?php echo get_the_date(); ?> by <?php the_author(); ?>
                            </div>
                        </header>
                        <div class="mb-5">
                            <?php
                            if (has_post_thumbnail()) the_post_thumbnail('thumbnail');
                            ?>
                        </div>
                    </div>
                    <p><?php the_content(); ?></p>
                    <?php
                    $link = get_post_meta(get_the_ID(), '_link', true);
                    if (!empty($link)) {
                        echo '<div class="post-link text-center">';
                        echo '<div class="link-preview flex align-center justify-center">';
                        echo '<iframe src="' . esc_url($link) . '" width="600" height="400"></iframe>';
                        echo '</div>';

                        echo '</div>';
                    }
                    ?>

                    <div class="text-center mb-3">
                        <?php
                        $rating = get_post_meta(get_the_ID(), '_rating', true);
                        if (!empty($rating)) {
                            echo '<div class="post-rating">';
                            echo '˗ˏˋ ';
                            for ($i = 0; $i < $rating; $i++) {
                                echo '★';
                            }
                            echo ' ˎˊ˗';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <footer class="border-t pt-4">
                        <div class="tags mb-2">
                            <?php the_tags('<span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">', '</span><span class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">', '</span>'); ?>
                        </div>
                        <div class="categories text-gray-600">
                            <?php _e('Categories: ');
                            the_category(', '); ?>
                        </div>
                    </footer>
            <?php
                endwhile;
            else :
                echo '<p>No content found</p>';
            endif;
            ?>
        </div>
    </main>
    <?php get_footer(); ?>
</body>

</html>