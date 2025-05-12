<?= custom_header() ?>

<!-- breadcrumbs -->
<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>
<!-- breadcrumbs -->

<main class="container">
    <h1 class="articles__title"><?= get_the_title(); ?></h1>

    <section class="articles__content">
        <?= get_the_content(); ?>
    </section>
</main>


<?= custom_footer() ?>