<footer class="bg-black text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="footer-section">
                <h2 class="text-2xl font-bold mb-4">Catégories</h2>
                <ul class="list-none">
                    <?php
                    $categories = get_categories();
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            $category_link = get_category_link($category->term_id);
                            echo '<li class="mb-2">';
                            echo '<a href="' . esc_url($category_link) . '" class="text-blue-400 hover:underline">';
                            echo esc_html($category->name);
                            echo '</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script>
    document.getElementById('navbar-menu').addEventListener('click', function() {
        event.preventDefault();
        event.stopPropagation();
        this.nextElementSibling.classList.toggle('active');
    });
</script>

<?php wp_footer(); ?>