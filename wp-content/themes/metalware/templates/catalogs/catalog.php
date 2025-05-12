<?php
$chapters = [
    [
        'image_id' => 364,
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

<main class="catalog container">
    <!-- catalog title -->
    <h1 class="catalog-category__title"><?= single_cat_title(); ?></h1>
    <!-- catalog title -->
    <?php
    // Получим текущую выбранную категорию (если есть)
    $current_cat = get_queried_object_id();

    // Получаем дочерние категории от родительской
    $parent_cat_id = 20;

    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => $parent_cat_id,
    ]);
    ?>
    <!-- catalog category -->
    <section class="swiper catalog-category">
        <!-- list category -->
        <ul class="swiper-wrapper catalog-category__list">
            <li class="swiper-slide catalog-category__item all-product <?= $current_cat === 20 ? 'open' : '' ?>">
                <a href="<?= get_term_link(20); ?>"
                    class="catalog-category__item-link">
                    Все товары
                </a>
            </li>
            <?php foreach ($categories as $category) {
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                // Проверим, если текущая категория совпадает с категорией в цикле
                $is_active = ($current_cat == $category->term_id) ? 'open' : '';
            ?>
                <li class="swiper-slide catalog-category__item <?= $is_active ?>">
                    <?=
                    wp_get_attachment_image($thumbnail_id, 'full', false, [
                        'alt' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true),
                        'title' => get_the_title($thumbnail_id),
                        'class' => 'catalog-category__item-image'
                    ]);
                    ?>
                    <a href="<?= get_term_link($category); ?>"
                        class="catalog-category__item-link">
                        <?= $category->name ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <!-- list category -->
    </section>
    <!-- catalog category -->
    <!-- сatalog content -->
    <section class="catalog__wrapper">
        <!-- filter -->
        <aside class="filter">
            <!-- filter mobile button close -->
            <button class="filter-mob__btn-close">
                <?=
                wp_get_attachment_image(251, 'full', false, [
                    'alt' => get_post_meta(251, '_wp_attachment_image_alt', true),
                    'title' => get_the_title(251),
                    'class' => 'filter-mob__btn-close-icon'
                ]);
                ?>
            </button>
            <!-- filter mobile button close -->
            <!-- chapter list -->
            <div class="filter-chapter">
                <p class="filter-chapter__title">РАЗДЕЛЫ</p>
                <ul class="filter-chapter__list">
                    <li class="filter-chapter__item active">
                        <a href="#">Нержавеющий крепеж</a>
                    </li>
                    <?php foreach ($chapters as $chapter) { ?>
                        <li class="filter-chapter__item">
                            <a href="#"><?= $chapter['title']; ?></a>
                        </li>
                    <?php } ?>
                </ul>
                <a href="#" class="filter-chapter__all">Все виды</a>
            </div>
            <!-- chapter list -->
            <form action="#" class="filter__form">
                <!-- filter list -->
                <ul class="filter__list">
                    <li class="filer__item">
                        <div class="filter__item-main">
                            <p class="filter__item-main-title">Категория товара</p>
                            <button
                                class="filter__arrow-btn active">
                                <?=
                                wp_get_attachment_image(224, 'full', false, [
                                    'alt' => get_post_meta(224, '_wp_attachment_image_alt', true),
                                    'title' => get_the_title(224),
                                    'class' => 'filter__arrow-btn-icon'
                                ]);
                                ?>
                            </button>
                        </div>
                        <!-- filter item sub -->
                        <ul class="filter__sub-list">
                            <?php for ($i = 0; $i <= 4; $i++) { ?>
                                <li class="filter__sub-item">
                                    <input id="category" type="checkbox" name="">
                                    <label for="category">Название категории</label>
                                </li>
                            <?php } ?>
                        </ul>
                        <!-- filter item sub -->
                    </li>
                    <?php for ($i = 0; $i <= 6; $i++) { ?>
                        <li class="filter__item">
                            <div class="filter__item-main">
                                <p class="filter__item-main-title">Категория товара</p>
                                <button
                                    class="filter__arrow-btn">
                                    <?=
                                    wp_get_attachment_image(224, 'full', false, [
                                        'alt' => get_post_meta(224, '_wp_attachment_image_alt', true),
                                        'title' => get_the_title(224),
                                        'class' => 'filter__arrow-btn-icon'
                                    ]);
                                    ?>
                                </button>
                            </div>
                            <!-- filter item sub -->
                        </li>
                    <?php } ?>
                </ul>
                <!-- filter list -->
                <div class="filter-btns">
                    <button class="filter__btn filter__btn-show">Показать</button>
                    <button class="filter__btn filter__btn-reset">Сбросить</button>
                </div>
            </form>
        </aside>
        <!-- filter -->
        <!-- cart product -->
        <section class="cart__content">
            <!-- filter mobile button -->
            <button class="filter-mob__btn">
                Фильтр
                <?=
                wp_get_attachment_image(224, 'full', false, [
                    'alt' => get_post_meta(224, '_wp_attachment_image_alt', true),
                    'title' => get_the_title(224),
                    'class' => 'filter-mob__btn-arrow'
                ]);
                ?>
            </button>
            <!-- filter mobile button -->

            <!-- cart list -->
            <?php
            $subcategories = get_terms([
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent' => $current_cat,
            ]);
            ?>
            <?php if ($subcategories) { ?>
                <div class="cart__content">
                    <ul class="cart__list">
                        <!-- product cart -->
                        <?php foreach ($subcategories as $subcategory) {
                            $thumbnail_id = get_term_meta($subcategory->term_id, 'thumbnail_id', true);

                        ?>
                            <li class="cart__item">
                                <div class="cart__item-preview">
                                    <?=
                                    wp_get_attachment_image($thumbnail_id, 'medium', false, [
                                        'alt' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true),
                                        'title' => get_the_title($thumbnail_id),
                                        'class' => 'cart__item-preview-img'
                                    ]);
                                    ?>
                                </div>
                                <a href="<?= get_term_link($subcategory); ?>" class="cart__item-header-link">
                                    <h2 class="cart__item-title"><?= $subcategory->name; ?></h2>
                                </a>

                                <p class="cart__item-short-descr"><?= $subcategory->description; ?></p>

                                <?php
                                $current_url = $_SERVER['REQUEST_URI'];

                                // Проверяем, что URL — ровно /catalog или /catalog/
                                if (preg_match('#^/catalog/?$#', $current_url)) {
                                    $button_text = 'Подробнее';
                                } else {
                                    $button_text = 'Выбрать размер';
                                }
                                ?>

                                <div class="cart__item-btns">
                                    <a href="<?= get_term_link($subcategory); ?>" class="filter__btn filter__btn-reset"><?= $button_text ?></a>
                                </div>

                            </li>
                        <?php } ?>
                        <!-- product cart -->
                    </ul>
                </div>
            <?php } else { ?>
                <p>Здесь пока нет товаров!</p>
            <?php } ?>

            <?php if ($subcategories) { ?>
                <!-- pagination -->
                <nav class="pagintaion__content" aria-label="Пагинация">
                    <ul class="pagination">
                        <li class="page-item">
                            <a href="#first" class="page-link" aria-label="Первая страница">
                                <?=
                                wp_get_attachment_image(17, 'full', false, [
                                    'alt' => get_post_meta(17, '_wp_attachment_image_alt', true),
                                    'title' => get_the_title(17),
                                    'class' => 'pagination__left'
                                ]);
                                ?>
                            </a>
                        </li>

                        <li class="page-item" aria-current="page">
                            <a href="#current" class="page-link">1</a>
                        </li>
                        <?php for ($i = 2; $i <= 5; $i++) { ?>
                            <li class="page-item">
                                <a href="#current" class="page-link"><?= $i; ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item">
                            <a href="#last" class="page-link" aria-label="Последняя страница">
                                <?=
                                wp_get_attachment_image(17, 'full', false, [
                                    'alt' => get_post_meta(17, '_wp_attachment_image_alt', true),
                                    'title' => get_the_title(17),
                                    'class' => 'pagination__right'
                                ]);
                                ?>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php } ?>

            <!-- pagination -->

            <!-- cart list -->
        </section>
        <!-- cart product -->
    </section>
    <!-- сatalog content -->
</main>