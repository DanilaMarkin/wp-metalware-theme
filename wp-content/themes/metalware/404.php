<?= custom_header() ?>

<!-- banner -->
<section class="banner">
    <div class="banner-content container">
        <ul class="banner__list">
            <li class="banner__item">
                <!-- banner image -->
                <?=
                wp_get_attachment_image(13, 'full', false, [
                    'alt' => get_post_meta(13, '_wp_attachment_image_alt', true),
                    'title' => get_the_title(13),
                    'class' => 'banner__item-image'
                ]);
                ?>
                <!-- banner image -->

                <!-- banner info -->
                <div class="banner__item-info banner__item-info-error">
                    <div class="banner__item-info-header">
                        <p class="error-title">Такой страницы не существует или она была удалена</p>
                    </div>
                    <div class="banner__item-info-btns banner__item-info-btns-error">
                        <a href="/" class="banner__item-info-btn banner__item-info-btn-error">На главную</a>
                        <a href="#" class="banner__item-info-btn banner__item-info-btn-error">В каталог</a>
                    </div>
                </div>
                <!-- banner info -->
            </li>
        </ul>
    </div>
</section>
<!-- banner -->

<main>
    
</main>

<?= custom_footer() ?>