<li class="cart__item">
    <div class="cart__item-preview">
        <?=
        wp_get_attachment_image(96, 'medium', false, [
            'alt' => get_post_meta(96, '_wp_attachment_image_alt', true),
            'title' => get_the_title(96),
            'class' => 'cart__item-preview-img'
        ]);
        ?>
    </div>

    <h2 class="cart__item-title">Болт высокопрочный DIN 931</h2>

    <p class="cart__item-short-descr">Крепёж для строительных конструкций, класс прочности 10.9</p>

    <div class="cart__item-btns">
        <button class="filter__btn filter__btn-show">Заказать</button>
        <a href="http://metalware/product/%d0%b1%d0%be%d0%bb%d1%82-%d0%b2%d1%8b%d1%81%d0%be%d0%ba%d0%be%d0%bf%d1%80%d0%be%d1%87%d0%bd%d1%8b%d0%b9-din-931/" class="filter__btn filter__btn-reset">Подробнее</a>
    </div>
</li>