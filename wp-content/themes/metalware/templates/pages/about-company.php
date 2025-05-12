<?= custom_header() ?>

<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>

<main class="container">
    <h1><?= get_the_title(); ?></h1>

    <section class="about-company__text">
        <?= get_the_content(); ?>
    </section>

    <!-- quality -->
    <section class="quality">
        <!-- quality header -->
        <div class="quality-header">
            <div class="quality-header_wrapper">
                <h2 class="quality-header__title">
                    <?= get_field("number_of_clients"); ?>
                </h2>
            </div>
        </div>
        <!-- quality header -->

        <!-- quality content -->
        <?php if (have_rows("list_of_benefits")) { ?>
            <div class="quality__content">
                <ul class="quality__list">
                    <?php while (have_rows("list_of_benefits")) {
                        the_row(); ?>
                        <li class="quality__item">
                            <div class="quality__item-header">
                                <div class="quality__item-header-image">
                                    <?=
                                    wp_get_attachment_image(get_sub_field("icon_advantages"), 'full', false, [
                                        'alt' => get_post_meta(get_sub_field("icon_advantages"), '_wp_attachment_image_alt', true),
                                        'title' => get_the_title(get_sub_field("icon_advantages")),
                                    ]);
                                    ?>
                                </div>
                                <h2><?= get_sub_field("header_advantages") ?></h2>
                            </div>
                            <span><?= get_sub_field("description_advantages") ?></span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <!-- quality content -->
    </section>
    <!-- quality -->

    <!-- about contact form -->
    <section class="feedback">
        <!-- contacts block -->
        <div class="contacts__content">
            <h2 class="contacts-title"><?= get_field("title_block_contacts"); ?></h2>
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
            <!-- <ul class="contacts-social__links">
                <li class="contacts-social__item">
                    <a href="<?= rawurldecode(get_theme_mod('link_wa')); ?>" target="_blank" rel="noopener noreferrer">
                        <?=
                        wp_get_attachment_image(65, 'full', false, [
                            'alt' => get_post_meta(65, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(65),
                        ]);
                        ?>
                    </a>
                </li>
                <li class="contacts-social__item">
                    <a href="<?= rawurldecode(get_theme_mod('link_vk')); ?>" target="_blank" rel="noopener noreferrer">
                        <?=
                        wp_get_attachment_image(64, 'full', false, [
                            'alt' => get_post_meta(64, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(64),
                        ]);
                        ?>
                    </a>
                </li>
                <li class="contacts-social__item">
                    <a href="<?= rawurldecode(get_theme_mod('link_telegram')); ?>" target="_blank" rel="noopener noreferrer">
                        <?=
                        wp_get_attachment_image(63, 'full', false, [
                            'alt' => get_post_meta(63, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(63),
                        ]);
                        ?>
                    </a>
                </li>
            </ul> -->
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

</main>

<?= custom_footer() ?>