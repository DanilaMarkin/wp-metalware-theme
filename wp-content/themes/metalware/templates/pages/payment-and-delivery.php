<?= custom_header() ?>

<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>

<main class="container">
    <h1><?= get_the_title(); ?></h1>

    <section class="payment-delivery__info">
        <?= get_the_content(); ?>
    </section>

    <section class="tabs-delivery">
        <!-- tabs header button -->
        <div class="tabs-delivery__header">
            <div class="tabs-delivery__header-center">
                <button
                    data-tab="deliveryLine"
                    class="tabs-delivery__btn active">Деловые линии
                </button>
                <button
                    data-tab="sdek"
                    class="tabs-delivery__btn">СДЭК
                </button>
            </div>
        </div>
        <!-- tabs header button -->

        <!-- deliveryLine -->
        <div id="deliveryLine" class="tab-content active">
            <iframe
                src="https://widgets.dellin.ru/calculator?derival_to_door=off&arrival_to_door=on&disabled_calculation=off&insurance=0&package=1"
                width="350"
                height="400"
                scrolling="no"
                frameborder="0">
            </iframe>
        </div>
        <!-- deliveryLine -->

        <!-- sdek -->
        <div id="sdek" class="tab-content">
            <iframe
                id="sdek_calc_iframe"
                src="https://kit.cdek-calc.ru/calc.php?oplata=1&amp;tarifs=483,482"
                width="300"
                height="400"
                scrolling="no"
                frameborder="0">
            </iframe>
        </div>
        <!-- sdek -->
    </section>
</main>


<?= custom_footer() ?>