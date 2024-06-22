<header class="bg-black text-white p-4">
    <nav class="bg-black text-white py-4">
        <div class="container mx-auto px-4 flex justify-between items-center flex">
            <a href="<?php echo esc_url(home_url()); ?>" class="text-xl font-bold">
                <?php bloginfo('name'); ?>
                <p style="font-size: 16px;"><?php bloginfo('description'); ?></p>
            </a>
            <ul class="navbar-menu flex space-x-4 lg:space-x-4 lg:flex-row lg:items-center lg:justify-end lg:w-auto lg:static relative left-0 bg-black lg:bg-transparent z-10">
                <li class="relative dropdown">
                    <button id="navbar-menu" class="block lg:inline-block text-blue-300 hover:text-white py-2 px-4">Par Catégorie</button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo esc_url(home_url()); ?>" class="block lg:inline-block text-blue-300 hover:text-white py-2 px-4">Tous les films</a></li>
                        <?php
                        $categories = get_categories();
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                $category_link = get_category_link($category->term_id);
                                echo '<li><a href="' . esc_url($category_link) . '" class="block px-4 py-2 hover:bg-gray-700">';
                                echo esc_html($category->name);
                                echo '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>