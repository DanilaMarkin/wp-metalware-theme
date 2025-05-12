<footer>
    <div class="footer-content container">
        <ul class="footer__list">
            <!-- logo site -->
            <li class="footer__item footer__item-logo">
                <?php the_custom_logo(); ?>
                <!-- <span class="footer__item-logo-subtext">Крепим будующее вместе!</span> -->
            </li>
            <!-- logo site -->

            <!-- footer general pages -->
            <li class="footer__item footer__item-pages">
                <ul class="footer__list-pages">
                    <li class="footer__item-page">
                        <a href="/">Главная</a>
                    </li>
                    <li class="footer__item-page">
                        <a href="/catalog">Каталог</a>
                    </li>
                    <li class="footer__item-page">
                        <a href="<?= get_permalink(22); ?>">Акции и Скидки</a>
                    </li>
                </ul>

                <ul class="footer__list-pages">
                    <li class="footer__item-page">
                        <p><a href="<?= get_permalink(53); ?>">О компании</a>/<a href="<?= get_permalink(93); ?>">Контакты</a></p>
                    </li>
                    <li class="footer__item-page">
                        <a href="<?= get_permalink(51); ?>">Доставка и Оплата </a>
                    </li>
                    <li class="footer__item-page">
                        <a href="<?= get_permalink(291); ?>">Политика конфиденциальности</a>
                    </li>
                </ul>

                <ul class="footer__list-pages">
                    <li class="footer__item-page">
                        <p>Адрес: <?= rawurldecode(get_theme_mod('address')); ?></p>
                    </li>
                </ul>
            </li>
            <!-- footer general pages -->

            <!-- footer general text -->
            <li class="footer__item footer__text">
                <p>Действующие цены уточняйте у менеджеров. Цены могут отличаться от указанных на сайте</p>
            </li>
            <!-- footer general text -->

            <!-- footer social contact -->
            <li class="footer__item footer__contacts">
                <ul class="footer__contacts-list">
                    <li class="footer__contacts-item footer__contacts-item-tel">
                        <a href="tel:<?= rawurldecode(get_theme_mod('phone')); ?>" rel="noindex nofollow">
                            <?= rawurldecode(get_theme_mod('phone')); ?>
                        </a>
                    </li>
                    <li class="footer__contacts-item footer__contacts-item-mail">
                        <a href="mailto:<?= rawurldecode(get_theme_mod('email')); ?>" rel="noindex nofollow">
                            <?= rawurldecode(get_theme_mod('email')); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- footer social contact -->
        </ul>
    </div>
</footer>


<?php
wp_footer();
?>
</body>

</html>

<script>
    // Слайдер по статьям
    const swiper = new Swiper('.banner-content', {
        slidesPerView: 1, // Кол-во слайдов
        spaceBetween: 10, // Растояние между ними
        loop: true, // Бесконечная прокрутка
        speed: 500, // Скрость слайдов в мс
        // Передвижание слайдов при помощи клавиатуры
        keyboard: {
            enabled: true,
            onlyInViewport: true
        },
        // Навигация по стрелочкам
        navigation: {
            nextEl: '.banner__slider-arrow-right',
            prevEl: '.banner__slider-arrow-left',
        },
        // Автопрокрутка
        autoplay: {
            delay: 40000000, // 4 секунды
            disableOnInteraction: false, // продолжать автопрокрутку после взаимодействия
        },
    });

    // Слайдер по статьям
    const swiperBanner = new Swiper('.articles__slider-content', {
        slidesPerView: 3, // Кол-во слайдов
        spaceBetween: 30, // Растояние между ними
        loop: false, // Бесконечная прокрутка
        speed: 500, // Скрость слайдов в мс
        // Передвижание слайдов при помощи клавиатуры
        keyboard: {
            enabled: true,
            onlyInViewport: true
        },
        // Навигация по стрелочкам
        navigation: {
            nextEl: '.articles-arrow-right',
            prevEl: '.articles-arrow-left',
        },
        // Автопрокрутка
        autoplay: {
            delay: 4000, // 4 секунды
            disableOnInteraction: false, // продолжать автопрокрутку после взаимодействия
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 25
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    });

      // Слайдер по Категориям
      const swiperCategory = new Swiper('.catalog-category', {
        slidesPerView: 'auto',
        spaceBetween: 10,
            freeMode: true,
            grabCursor: true,
    });
</script>