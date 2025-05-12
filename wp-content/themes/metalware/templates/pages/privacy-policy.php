<?= custom_header() ?>

<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>

<main class="container privacy-policy__blocks">
    <h1><?= get_the_title(); ?></h1>

    <section class="text-info">
        <?= get_the_content(); ?>
    </section>
</main>


<?= custom_footer() ?>