<?= custom_header() ?>

<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>

<main class="container cart">
    <h1 class="cart-title"><?= get_the_title(); ?></h1>

    <!-- cart action -->
    <section class="cart-actions">
        <!-- select all -->
        <div class="select-all">
            <input type="checkbox" name="select-all" id="selectAll" class="custom-checkbox">
            <label for="selectAll" class="custom-select-all">Выделить все</label>
        </div>

        <!-- delete cart -->
        <button class="delete-cart-select">
            <?=
            wp_get_attachment_image(251, 'full', false, [
                'alt' => get_post_meta(251, '_wp_attachment_image_alt', true),
                'title' => get_the_title(251),
                'class' => 'delete-cart-select__icon'
            ]);
            ?>
            <p>Удалить выбранные</p>
        </button>
    </section>

    <!-- cart blocks -->
    <section class="cart-blocks">
        <!-- cart list -->
        <ul class="cart-list">
           
        </ul>

        <!-- cart total -->
        <aside class="total">
            <ul class="total-list">
                <li class="total-item">
                    <span class="total-item__info">Товаров на:</span>
                    <p id="totalPrice" class="total-item__current">2.990 руб.</p>
                </li>
                <li class="total-item">
                    <span class="total-item__info">НДС <span class="total-item__info-sub">(20%, включен в цену):</span></span>
                    <p class="total-item__current">598 руб.</p>
                </li>
                <li class="total-item">
                    <span class="total-item__info">Доставка:</span>
                    <p class="total-item__current green">бесплатно</p>
                </li>
            </ul>
            <div class="total-order">
                <span class="total-order__title">Итого к оплате:</span>
                <p class="total-order__price">2990 ₽</p>
            </div>
            <button class="total-order__btn">Оформить заказ</button>
        </aside>
    </section>

    <!-- delivery radio -->
    <section class="delivery-select">
        <h2 class="delivery-select__title">Доставка</h2>

        <div class="delevery-select__blocks">
            <!-- delivery free -->
            <div class="delivery-select__free">
                <div class="custom-radio-container">
                    <input type="radio" id="self-pickup" name="delivery-option" class="custom-radio">
                    <label for="self-pickup" class="custom-label">Самовывоз</label>
                </div>

                <div class="delevery-select__blocks-wrapper">
                    <span class="delivery__price">0 руб.</span>
                    <p class="delivery__text">Вы можете самостоятельно забрать заказ из нашего склада</p>
                </div>
            </div>

            <!-- delivery not free -->
            <div class="delivery-select__not-free">
                <div class="custom-radio-container">
                    <input type="radio" id="delivery" name="delivery-option" class="custom-radio">
                    <label for="delivery" class="custom-label">Доставка</label>
                </div>

                <div class="delevery-select__blocks-wrapper">
                    <span class="delivery__price">800 руб.</span>
                    <p class="delivery__text">Доставка осуществляется бесплатно до ТК</p>
                </div>

                <div class="select-company">
                    <button class="select-company__btn">
                        Выберите компанию
                        <?=
                        wp_get_attachment_image(224, 'full', false, [
                            'alt' => get_post_meta(224, '_wp_attachment_image_alt', true),
                            'title' => get_the_title(224),
                            'class' => 'select-company__head-icon'
                        ]);
                        ?>
                    </button>

                    <ul class="select-company__list">
                        <li class="select-company__item">
                            Деловые линии
                        </li>
                        <li class="select-company__item">
                            Сдэк
                        </li>
                        <li class="select-company__item">
                            По городу (СПб) - <span class="select-company__item-price">800р.</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <section class="data-order">
        <h2 class="data-order__title">Данные о покупателе</h2>
        <form action="#" class="data-order__form">
            <input type="text" id="company-name" name="company_name" class="data-order__input" placeholder="Название компании">

            <input type="text" id="company-inn" name="company_inn" class="data-order__input" placeholder="ИНН">

            <input type="text" id="contact-person" name="contact_person" class="data-order__input" placeholder="Контактное лицо">

            <input type="email" id="email" name="email" class="data-order__input" placeholder="E-mail">

            <input type="tel" id="phone" name="phone" class="data-order__input" placeholder="Телефон">

            <input type="text" id="city" name="city" class="data-order__input" placeholder="Город">

            <input type="text" id="address" name="address" class="data-order__input" placeholder="Адрес">

            <textarea id="order-comment" name="order_comment" class="data-order__textarea" placeholder="Комментарий к заказу:"></textarea>
        </form>
    </section>

</main>


<?= custom_footer() ?>