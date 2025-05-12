<?= custom_header() ?>

<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>
<script src="/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

<main class="container">
    <!-- about contact form -->
    <section class="our-contacts">
        <!-- contacts block -->
        <div class="contacts__content">
            <h1 class="contacts-title"><?= get_field("block_title_contacts"); ?></h1>
            <ul class="contacts__list">
                <li class="contacts__item">
                    <?=
                    wp_get_attachment_image(59, 'full', false, [
                        'alt' => get_post_meta(59, '_wp_attachment_image_alt', true),
                        'title' => get_the_title(59),
                    ]);
                    ?>
                    <div class="contacts__item-text">
                        <h3>Наш офис расположен по адресу</h3>
                        <p><?= rawurldecode(get_theme_mod('address', 'Адрес не указан')); ?></p>
                    </div>
                </li>
                <li class="contacts__item">
                    <?=
                    wp_get_attachment_image(60, 'full', false, [
                        'alt' => get_post_meta(60, '_wp_attachment_image_alt', true),
                        'title' => get_the_title(60),
                    ]);
                    ?>
                    <div class="contacts__item-text">
                        <h3>Часы работы</h3>
                        <p>Понедельник – Пятница: <?= rawurldecode(get_theme_mod('working_hours', 'Часы работы не указаны')); ?></p>
                        <p>Суббота – Воскресенье: Выходные</p>
                    </div>
                </li>
                <li class="contacts__item">
                    <div class="contacts__item-tel">
                        <?=
                        wp_get_attachment_image(62, 'full', false, [
                            'alt' => get_post_meta(62, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(62),
                        ]);
                        ?>
                        <div class="contacts__item-text">
                            <h3>Наши контакты</h3>
                            <p><?= rawurldecode(get_theme_mod('phone', 'Телефон не указан')); ?></p>
                        </div>
                    </div>
                    <div class="contacts__item-email">
                        <?=
                        wp_get_attachment_image(61, 'full', false, [
                            'alt' => get_post_meta(61, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(61),
                        ]);
                        ?>
                        <div class="contacts__item-text">
                            <h3>Наш Email</h3>
                            <p><?= rawurldecode(get_theme_mod('email', 'Email не указан')); ?></p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!-- contacts block -->

        <!-- contact-form -->
        <div class="contacts__form">
            <p>Напишите нам</p>
            <form id="contactForm" action="#">
                <div class="contacts-form__item">
                    <label id="nameLabel" for="name">Ваше Имя</label>
                    <input id="name" type="text" name="name" placeholder="Степан Степанович">
                    <span id="messageForm"></span>
                </div>

                <div class="contacts-form__item">
                    <label id="emailLabel" for="email">Ваш Email</label>
                    <input id="email" type="email" name="email" placeholder="hello@nrs.com">
                    <span id="messageForm"></span>
                </div>

                <div class="contacts-form__item">
                    <label id="messageLabel" for="message">Комментарий</label>
                    <input id="message" type="text" name="message" placeholder="Ваш вопрос">
                    <span id="messageForm"></span>
                </div>
                <button type="submit" class="contacts__form-btn">Отправить заявку</button>
            </form>
        </div>
        <!-- contact-form -->
    </section>
    <!-- about contact form -->

    <!-- map -->
    <section class="map">
        <?php if (get_field('map')) {
            echo get_field('map');
        } ?>
    </section>
    <!-- map -->

</main>

<?= custom_footer() ?>