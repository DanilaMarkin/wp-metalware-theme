<?= custom_header() ?>

<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>

<main class="container favourite">
    <h1><?= get_the_title(); ?></h1>

    <section class="favourite-block">
        <!-- text for empty favourite cart -->
        <p id="favourite__not-cart" class="favourite__not-cart">Нет избранных товаров</p>
        <!-- text for empty favourite cart -->

        <!-- text not empty cart for favourite -->
        <ul id="favourite__list" class="favourite__list">
            <!-- список избранных -->
        </ul>
        <!-- text not empty cart for favourite -->
    </section>
</main>

<!-- availability form -->
<section class="availability container">
    <h2 class="availability-title">Не нашли интересующий Вас товар? Уточните наличие на складе у наших менеджеров</h2>
    <form action="#" class="availability-form">
        <!-- name -->
        <div class="availability-form__block">
            <label id="availNameLabel" for="availName" >Ваше Имя</label>
            <input id="availName" name="name-availab" type="text" class="availability-form__input" placeholder="Степан Степанович">
        </div>
        <!-- name -->

        <!-- email -->
        <div class="availability-form__block">
            <label id="availEmailLabel" for="availEmail">Ваш Email</label>
            <input id="availEmail" name="email-availab type="email" class="availability-form__input" placeholder="hello@nrs.com">
        </div>
        <!-- email -->

        <!-- message -->
        <div class="availability-form__block">
            <label id="availMessageLabel" for="availMessage">Комментарий</label>
            <input id="availMessage" name="message-availab type="text" class="availability-form__input" placeholder="Ваш вопрос">
        </div>
        <!-- message -->

        <button class="availability-btn">Отправить заявку</button>
    </form>
</section>
<!-- availability form -->

<?= custom_footer() ?>