<?= custom_header() ?>

<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>

<main class="container">
    <h1><?= get_the_title(); ?></h1>

    <section class="services__blocks">
        <?= get_the_content(); ?>
    </section>

    <!-- popup services -->
    <div class="services-popup">
        <div class="services-popup__header">
            <p class="services-popup__title">Закажите выбранную услугу</p>
            <button class="services-popup__btn-close">
                <?=
                wp_get_attachment_image(251, 'full', false, [
                    'alt' => get_post_meta(251, '_wp_attachment_image_alt', true),
                    'title' => get_the_title(251),
                    'class' => 'services-popup__btn-close-icon'
                ]);
                ?>
            </button>

        </div>
        <form action="#" class="services-popup__form">
            <div class="services-popup__form-block">
                <label for="servicesName" class="services-popup__label">Ваше Имя<span class="services-popup__form-required">*</span> </label>
                <input id="servicesName" name="servicesName" class="services-popup__input" placeholder="Степан Степанович" type="text">
            </div>

            <div class="services-popup__form-block">
                <label for="servicesPhone" class="services-popup__label">Ваш телефон<span class="services-popup__form-required">*</span> </label>
                <input id="servicesPhone" name="servicesPhone" class="services-popup__input" placeholder="7 (999) 999 99-99" type="tel">
            </div>

            <div class="services-popup__form-block">
                <label for="servicesEmail" class="services-popup__label">Ваше E-mail</label>
                <input id="servicesEmail" name="servicesEmail" class="services-popup__input" placeholder="info@mail" type="email">
            </div>

            <div class="services-popup__form-block">
                <label for="servicesMessage" class="services-popup__label">Комментарий</label>
                <input id="servicesMessage" name="servicesMessage" class="services-popup__input" placeholder="Ваш вопрос" type="text">
            </div>

            <button class="services-popup__form-btn">Заказать услугу</button>
        </form>
    </div>
    <!-- popup services -->

</main>

<?= custom_footer() ?>