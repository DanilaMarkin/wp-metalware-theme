<main class="catalog container">
    <!-- catalog title -->
    <h1 class="category__title"><?= single_cat_title(); ?></h1>
    <!-- catalog title -->

    <!-- сatalog content -->
    <section class="catalog__wrapper">
        <!-- filter -->
        <aside class="filter subcatalog-filter">
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
            // Получаем текущий объект категории
            $category = get_queried_object();

            $args = [
                'limit'    => -1,
                'status'   => 'publish',
                'category' => [$category->slug],
            ];

            $products = wc_get_products($args);

            if ($products) {
            ?>

            <div class="cart__content">
                <ul class="cart-category__list">
                    <li class="cart-category__list-header">
                        <span>Изображение</span>
                        <span>Наименование</span>
                        <span>Размер упак.</span>
                        <span>Цена упак. руб.</span>
                        <span>Кол-во</span>
                    </li>

                    <?php foreach ($products as $product): ?>
                        <li class="cart-category__item">
                            <!-- image -->
                            <?= $product->get_image('medium', ['class' => 'cart-category__item-img']); ?>

                            <!-- name -->
                             <a href="<?= get_permalink($product->get_id()); ?>" class="cart-category__item-link">
                                 <h2 class="cart-category__item-title"><?= $product->get_name(); ?></h2>
                             </a>

                            <!-- count -->
                            <p class="cart-category__item-count">
                                <span class="cart-category__item-count-mob">Размер упаковки:</span>
                                <?= $product->get_stock_quantity() ? $product->get_stock_quantity() . ' шт.' : '—'; ?>
                            </p>

                            <!-- price -->
                            <p class="cart-category__item-price">Цена:
                                <span class="cart-category__item-price-current"><?= wc_price($product->get_price()); ?></span>
                            </p>

                            <!-- quantity -->
                            <div class="cart-category__item-actions">
                                <div class="cart-category__item-availability">
                                    <p class="cart-category__item-availability-text">в наличии</p>
                                    <div class="status-availability green"></div>
                                </div>

                                <!-- кнопка купить -->
                                <button class="cart-category__item-add">Купить</button>

                                <!-- количество -->
                                <div class="cart-category__item-quantity-blocks hidden">
                                    <div class="cart-category__item-quantity">
                                        <button class="cart-category__item-quantity-btn cart-category__item-quantity-btn-minus">
                                            <img src="<?= wp_get_attachment_url(257); ?>" alt="−" class="cart-category__item-quantity-btn-icon">
                                        </button>
                                        <input type="number" class="cart-category__item-quantity-input" value="1" min="1">
                                        <button class="cart-category__item-quantity-btn cart-category__item-quantity-btn-plus">
                                            <img src="<?= wp_get_attachment_url(258); ?>" alt="+" class="cart-category__item-quantity-btn-icon">
                                        </button>
                                    </div>
                                    <p class="cart-category__item-quantity-total">на сумму
                                        <span class="cart-category__item-quantity-total-current">
                                            <?= wc_price($product->get_price()); ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php } else { ?>
                <p>Здесь пока нет товаров!</p>
            <?php } ?>


            <?php if ($products) { ?>
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
            <!-- pagination -->
            <?php } ?>

            <!-- cart list -->
        </section>
        <!-- cart product -->
    </section>
    <!-- сatalog content -->
</main>