<?= custom_header() ?>

<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>

<main class="container">
    <h1><?= get_the_title(); ?></h1>

    <section class="text-info">
        <?= get_the_content(); ?>
    </section>

    <section class="stock__content">
        <?php if (have_rows("stock_list")) { ?>
            <ul class="stock__list">
                <?php while (have_rows("stock_list")) : the_row(); ?>
                    <li class="stock__item">
                        <div class="stock__item-preview">
                            <?=
                            wp_get_attachment_image(get_sub_field("stock_image"), 'full', false, [
                                'alt' => get_post_meta(get_sub_field("stock_image"), '_wp_attachment_image_alt', true),
                                'title' => get_the_title(get_sub_field("stock_image")),
                                'class' => 'stock__item-image'
                            ]);
                            ?>
                            <div class="stock__item-header">
                                <h2 class="stock__item-header-title"><?= get_sub_field("stock_title"); ?></h2>
                            </div>
                        </div>
                        <span><?= get_sub_field("stock_sub_text"); ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php } else { ?>
            <p>Здесь пока нет акций!</p>
        <?php } ?>
    </section>
</main>

<section class="stock__content-send">
    <div class="container stock__form">
        <h2>Будьте в курсе выгодных предложений!</h2>
        <form id="formSubscriber" class="stock__content-form">
            <input
                type="text"
                name="name_stock"
                placeholder="Имя"
                id="name_stock">
            <input
                type="email"
                name="email_stock"
                placeholder="Email"
                id="email_stock">
            <button class="stock__content-btn">
                Подписаться
            </button>
        </form>
    </div>
</section>

<?= custom_footer() ?>