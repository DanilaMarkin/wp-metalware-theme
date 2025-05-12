<!DOCTYPE html>
<html <?= language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= wp_title(); ?></title>
    <?= wp_head(); ?>
</head>

<body <?= body_class(); ?> data-theme-url="<?php echo get_template_directory_uri(); ?>">
    <div id="overlay"></div>
    <header class="header__other-page">
        <div class="header__other-page-wrapper container">
            <div class="header__top">
                <!-- logo -->
                <div class="header__top-logo">
                    <?php the_custom_logo(); ?>
                    <!-- <span class="header__top-logo-sublogo">Крепим будующее вместе!</span> -->
                </div>
                <!-- logo -->

                <!-- center nav -->
                <div class="header__top-navigation">
                    <!-- button catalog -->
                    <button type="button" class="header__top-catalog">
                        <div class="header__top-catalog-lines">
                            <div class="header__top-catalog-line"></div>
                            <div class="header__top-catalog-line"></div>
                            <div class="header__top-catalog-line"></div>
                        </div>
                        Каталог
                    </button>
                    <!-- button catalog -->

                    <!-- search nav -->
                    <div class="header__top-search">
                        <!-- search input -->
                        <div class="header__top-search-input">
                            <input id="search" type="search" placeholder="Быстрый поиск">
                            <button class="header__top-search-btn">
                                <?= wp_get_attachment_image(8, 'full', false, [
                                    'alt' => get_post_meta(8, '_wp_attachment_image_alt', true),
                                    'title' => get_the_title(8),
                                    'class' => 'header__top-search-icon'
                                ]); ?>
                            </button>
                        </div>
                        <!-- search input -->

                        <!-- search result -->
                        <div class="header__top-search-result hidden">
                            <ul class="header__top-search-result-list">
                                <!-- result -->
                            </ul>
                            <a href="" class="header__top-search-result-link">
                                Все результаты
                                <?= wp_get_attachment_image(17, 'full', false, [
                                    'alt' => get_post_meta(17, '_wp_attachment_image_alt', true),
                                    'title' => get_the_title(17),
                                ]); ?>
                            </a>
                        </div>
                        <!-- search result -->
                    </div>
                    <!-- search nav -->
                </div>
                <!-- center nav -->

                <!-- right nav -->
                <div class="header__right">
                    <div class="header__right-contact">
                        <!-- tel -->
                        <a href="tel:<?= rawurldecode(get_theme_mod('phone')); ?>" class="header__right-tel" rel="noindex nofollow">
                            <?= rawurldecode(get_theme_mod('phone')); ?>
                        </a>
                        <!-- tel -->

                        <!-- mail -->
                        <a href="mailto:<?= rawurldecode(get_theme_mod('email')); ?>" class="header__right-mail" rel="noindex nofollow">
                            <?= rawurldecode(get_theme_mod('email')); ?>
                        </a>
                        <!-- mail -->
                    </div>

                    <!-- cart -->
                    <a href="/cart" class="header__right-cart">
                        <?=
                        wp_get_attachment_image(158, 'full', false, [
                            'alt' => get_post_meta(158, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(158),
                            'class' => 'header__right-cart-icons'
                        ]);
                        ?>
                        <span class="header__right-cart-count">0</span>
                    </a>
                    <!-- cart -->

                    <!-- favourites -->
                    <a href="<?= get_permalink(248); ?>" class="header__right-favourites">
                        <?=
                        wp_get_attachment_image(242, 'full', false, [
                            'alt' => get_post_meta(242, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(242),
                            'class' => 'header__right-favourite-icons'
                        ]);
                        ?>
                        <span class="header__right-favourite-count">0</span>
                    </a>
                    <!-- cafavouritesrt -->

                    <!-- search icon for mobile -->
                    <button class="search-mob">
                        <?= wp_get_attachment_image(159, 'full', false, [
                            'alt' => get_post_meta(159, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(159),
                            'class' => 'header__top-search-mobile'
                        ]); ?>
                    </button>

                    <!-- search icon for mobile -->

                    <!-- burger menu for mobile -->
                    <div class="burger-menu__content">
                        <button class="burger-menu">
                            <span class="burger-menu__line"></span>
                            <span class="burger-menu__line"></span>
                            <span class="burger-menu__line"></span>
                        </button>
                    </div>
                    <!-- burger menu for mobile -->
                </div>
            </div>
            <!-- nav -->
            <nav class="header__bottom">
                <!-- header__botton-mob -->
                <div class="header__botton-mob">
                    <div class="header__botton-mob-header">
                        <?php the_custom_logo(); ?>
                        <!-- <span class="footer__item-logo-subtext">Интернет - магазин крепежных изделий</span> -->
                    </div>
                </div>
                <!-- header__botton-mob -->
                <ul class="header__bottom-list">
                    <li class="header__bottom-item">
                        <a href="<?= get_term_link(20); ?>" title="">Каталог</a>
                    </li>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s', // Убираем <ul>, так как он уже есть в разметке
                        'depth'          => 1,
                        'fallback_cb'    => false,
                        'walker'         => new Custom_Walker_Nav_Menu(), // Используем кастомный Walker
                    ));
                    ?>
                </ul>
            </nav>
            <!-- nav -->
            <!-- popup catalog -->
            <div class="popup-catalog" aria-hidden="true">
                <div class="popup-catalog__header">
                    <span class="popup-catalog__title">Выберите необходимую категорию:</span>
                </div>
                <ul class="catalog__list">
                    <?php
                    // Получаем родительские категории первого уровня, отсортированные по меню
                    $args = [
                        'taxonomy'   => 'product_cat',
                        'parent'      => 0, // Родительский элемент первого уровня
                        'orderby'     => 'menu_order', // Сортировка по порядку в меню
                        'order'       => 'ASC', // Порядок сортировки
                        'hide_empty'  => false, // Показывать даже пустые категории
                    ];

                    $parent_categories = get_terms($args);

                    // Проходим по каждой родительской категории первого уровня
                    foreach ($parent_categories as $parent_category) {
                        // Получаем дочерние категории второго уровня, отсортированные по меню
                        $child_args = [
                            'taxonomy'   => 'product_cat',
                            'parent'     => $parent_category->term_id,
                            'orderby'    => 'menu_order', // Сортировка по порядку в меню
                            'order'      => 'ASC', // Порядок сортировки
                            'hide_empty' => false,
                        ];

                        $child_categories = get_terms($child_args);

                        // Выводим дочерние категории второго уровня
                        foreach ($child_categories as $child_category) {
                    ?>
                            <li class="catalog__item">
                                <?php
                                // Получаем изображение категории
                                $thumbnail_id = get_term_meta($child_category->term_id, 'thumbnail_id', true);
                                if ($thumbnail_id) {
                                    echo wp_get_attachment_image($thumbnail_id, 'full', false, [
                                        'alt'   => esc_attr($child_category->name),
                                        'title' => esc_attr($child_category->name),
                                        'class' => 'catalog__item-img'
                                    ]);
                                }
                                ?>
                                <a href="<?= get_term_link($child_category); ?>" class="catalog__item-title">
                                    <h3><?= esc_html($child_category->name); ?></h3>
                                </a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </header>
    <div class="header-placeholder"></div>