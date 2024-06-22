<?php
$categories = get_categories();
?>

<aside class="bg-black p-4 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Categories</h2>
    <ul class="list-none">
        <?php
        if (!empty($categories)) {
            // Button to display all articles
            echo '<li class="mb-2">';
            echo '<a href="' . esc_url(home_url()) . '" class="text-blue-500 hover:underline">Tous les films</a>';
            echo '</li>';
            foreach ($categories as $category) {
                $category_link = get_category_link($category->term_id);
                echo '<li class="mb-2">';
                echo '<a href="' . esc_url($category_link) . '" class="text-blue-500 hover:underline">';
                echo esc_html($category->name);
                echo '</a>';
                echo '</li>';
            }
        }
        ?>
    </ul>
</aside>