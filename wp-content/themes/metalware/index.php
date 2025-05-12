<?= custom_header() ?>

<main>
    <!-- banner -->
    <section class="banner container">
        <div class="swiper banner-content">
            <?php if (have_rows("banners")) { ?>
                <ul class="swiper-wrapper banner__list">
                    <?php while (have_rows("banners")) : the_row(); ?>
                        <li class="swiper-slide banner__item">
                            <!-- banner image -->
                            <?=
                            wp_get_attachment_image(get_sub_field("banner_photo"), 'full', false, [
                                'alt' => get_post_meta(get_sub_field("banner_photo"), '_wp_attachment_image_alt', true),
                                'title' => get_the_title(get_sub_field("banner_photo")),
                                'class' => 'banner__item-image'
                            ]);
                            ?>
                            <!-- banner image -->

                            <!-- banner info -->
                            <div class="banner__item-info">
                                <div class="banner__item-info-header">
                                    <h1
                                        class="banner__item-info-title"
                                        style="color:<?= get_sub_field("banner_colors"); ?>"><?= get_sub_field("banner_header"); ?></h1>
                                    <!-- <p class="banner__item-info-subtitle">ИЗ ЕВРОПЫ И КИТАЯ</p> -->
                                </div>
                                <div class="banner__item-info-btns">
                                    <?php
                                    if (have_rows("banner_btns")) {
                                        while (have_rows("banner_btns")) : the_row();
                                        $link = get_sub_field("link_btn");
                                    ?>
                                        <a 
                                        style="color:<?= get_sub_field("color_btn"); ?>; background:<?= get_sub_field("bg_btn"); ?>"
                                        class="banner__item-info-btn"
                                        href="<?= $link["url"] ?>">
                                            <?= $link["title"] ?>
                                        </a>
                                        
                                    <?php
                                        endwhile;
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- banner info -->
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php } ?>

            <!-- arrow slider -->
            <button class="banner__slider-arrow banner__slider-arrow-left">
                <?=
                wp_get_attachment_image(11, 'full', false, [
                    'alt' => get_post_meta(11, '_wp_attachment_image_alt', true),
                    'title' => get_the_title(11),
                    'class' => 'banner__slider-arrow-img'
                ]);
                ?>
            </button>

            <button class="banner__slider-arrow banner__slider-arrow-right">
                <?=
                wp_get_attachment_image(11, 'full', false, [
                    'alt' => get_post_meta(11, '_wp_attachment_image_alt', true),
                    'title' => get_the_title(11),
                    'class' => 'banner__slider-arrow-img'
                ]);
                ?>
            </button>
            <!-- arrow slider -->
        </div>
    </section>
    <!-- banner -->

    <!-- category product -->
    <?php
    $chapters = [
        [
            'image_id' => 143,
            'title' => 'Нержавеющий крепеж'
        ],
        [
            'image_id' => 432,
            'title' => 'Латунный крепеж'
        ],
        [
            'image_id' => 363,
            'title' => 'Высокопрочный крепёж '
        ],
        [
            'image_id' => 365,
            'title' => 'Полиамидный крепеж'
        ],
        [
            'image_id' => 362,
            'title' => 'Микрокрепёж'
        ]
    ];
    ?>
    <section class="category">
        <div class="category__content container">
            <ul class="category__list">
                <?php foreach ($chapters as $chapter) { ?>
                    <li class="category__item">
                        <a href="#" class="category__item-link">
                            <p class="category__item-title"><?= $chapter['title']; ?></p>
                        </a>
                        <?=
                        wp_get_attachment_image($chapter['image_id'], 'full', false, [
                            'alt' => get_post_meta($chapter['image_id'], '_wp_attachment_image_alt', true),
                            'title' => get_the_title($chapter['image_id']),
                            'class' => 'category__item-img'
                        ]);
                        ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <!-- category product -->

    <!-- catalog -->
    <section class="catalog">
        <div class="catalog__content container">
            <h2 class="catalog__title">КАТАЛОГ</h2>
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
    </section>
    <!-- catalog -->

    <!-- services -->
    <section class="services">
        <div class="services__content container">
            <!-- services header -->
            <div class="services__header">
                <ul class="services__header-list">
                    <li class="services__header-item">
                        <?=
                        wp_get_attachment_image(151, 'full', false, [
                            'alt' => get_post_meta(151, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(151),
                            'class' => 'services__header-item-img'
                        ]);
                        ?>
                        <p class="services__header-item-title">Склад с товарами в наличии</p>
                    </li>
                    <li class="services__header-item">
                        <?=
                        wp_get_attachment_image(150, 'full', false, [
                            'alt' => get_post_meta(150, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(150),
                            'class' => 'services__header-item-img'
                        ]);
                        ?>
                        <p class="services__header-item-title">Прямые поставки из Европы и Китая</p>
                    </li>
                    <li class="services__header-item">
                        <?=
                        wp_get_attachment_image(149, 'full', false, [
                            'alt' => get_post_meta(149, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(149),
                            'class' => 'services__header-item-img'
                        ]);
                        ?>
                        <p class="services__header-item-title">Низкие цены на весь ассортимент</p>
                    </li>
                    <li class="services__header-item">
                        <?=
                        wp_get_attachment_image(148, 'full', false, [
                            'alt' => get_post_meta(148, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(148),
                            'class' => 'services__header-item-img'
                        ]);
                        ?>
                        <p class="services__header-item-title">Быстрая доставка по всей России</p>
                    </li>
                </ul>
            </div>
            <!-- services header -->

            <!-- services content cart -->
            <div class="services-cart">
                <h2 class="services-cart__title">Услуги</h2>
                <?php if (have_rows("stock_list")) { ?>
                    <ul class="servieces-cart__list">
                        <?php while (have_rows("stock_list")) : the_row(); ?>
                            <li class="services-cart__item">
                                <?=
                                wp_get_attachment_image(get_sub_field("image_services"), 'full', false, [
                                    'alt' => get_post_meta(get_sub_field("image_services"), '_wp_attachment_image_alt', true),
                                    'title' => get_the_title(get_sub_field("image_services")),
                                    'class' => 'services-cart__item-img'
                                ]);
                                ?>
                                <a href="
                                <?php
                                $anchor_link = get_sub_field("anchor_link_to_service");
                                if ($anchor_link) {
                                    echo get_permalink(226) . esc_url($anchor_link);
                                }
                                ?>
                                " class="services-cart__item-link">
                                    <h3 class="services-cart__item-title"><?= get_sub_field("service_name"); ?></h3>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php } ?>
                <a href="<?= get_permalink(226); ?>" class="services-cart__btn">Посмотреть все услуги</a>
            </div>
            <!-- services content cart -->
        </div>
    </section>
    <!-- services -->

    <?php
    $page_id = is_front_page() ? 22 : get_the_ID(); // Берем данные со страницы ID 22, если это главная

    if (have_rows("stock_list", $page_id)) : ?>
        <section class="container">
            <ul class="stock__list stock__list-main">
                <?php
                $rows = get_field("stock_list", $page_id); // Получаем все записи
                if (is_front_page()) {
                    $rows = array_slice($rows, -2, 2); // Оставляем только 2 последних
                }

                foreach ($rows as $row) : ?>
                    <li class="stock__item">
                        <div class="stock__item-preview">
                            <?= wp_get_attachment_image($row["stock_image"], 'full', false, [
                                'alt' => get_post_meta($row["stock_image"], '_wp_attachment_image_alt', true),
                                'title' => get_the_title($row["stock_image"]),
                                'class' => 'stock__item-image'
                            ]); ?>
                            <div class="stock__item-header">
                                <h2 class="stock__item-header-title"><?= $row["stock_title"]; ?></h2>
                            </div>
                        </div>
                        <span><?= $row["stock_sub_text"]; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= get_permalink(22); ?>" class="stock__content-btn-main">Посмотреть все акции</a>
        </section>
    <?php else : ?>
        <p>Здесь пока нет акций!</p>
    <?php endif; ?>

    <!-- articles -->
    <section class="articles">
        <div class="articles__content container">
            <h2 class="articles__title">СТАТЬИ</h2>
            <!-- arrow slider -->
            <div class="articles__slider">
                <!-- button arrow left -->
                <div class="block-arrow block-arrow-left">
                    <button class="articles-arrow articles-arrow-left">
                        <?=
                        wp_get_attachment_image(11, 'full', false, [
                            'alt' => get_post_meta(11, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(11),
                            'class' => 'articles-arrow-img'
                        ]);
                        ?>
                    </button>
                </div>
                <!-- button arrow left -->

                <div class="swiper articles__slider-content">
                    <ul class="swiper-wrapper articles__list">
                        <?php
                        $args = [
                            'post_type' => 'post',
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ];

                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post();
                                $post_id = get_the_ID();
                                // Получаем ID миниатюры
                                $image_id = get_post_thumbnail_id($post_id);
                        ?>
                                <li class="swiper-slide articles__item">
                                    <?=
                                    wp_get_attachment_image($image_id, 'full', false, [
                                        'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
                                        'title' => get_the_title($image_id),
                                        'class' => 'articles-arrow__slider'
                                    ]);
                                    ?>
                                    <a href="<?= the_permalink(); ?>" class="articles__item-link">
                                        <h3 class="articles__item-title"><?= the_title(); ?></h3>
                                    </a>
                                </li>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else : ?>
                            <p>Записей нет.</p>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- button arrow right -->
                <div class="block-arrow block-arrow-right">
                    <button class="articles-arrow articles-arrow-right">
                        <?=
                        wp_get_attachment_image(11, 'full', false, [
                            'alt' => get_post_meta(11, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(11),
                            'class' => 'articles-arrow-img'
                        ]);
                        ?>
                    </button>
                </div>
                <!-- button arrow right -->
                <!-- arrow slider -->
            </div>
        </div>
    </section>
    <!-- articles -->
</main>

<?= custom_footer() ?>