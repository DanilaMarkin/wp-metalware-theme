<?= custom_header() ?>

<!-- custom breadcrubms -->
<section class="container custom-breadcrumbs">
    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>
<!-- custom breadcrubms -->

<?php
// Получаем текущую категорию
$term = get_queried_object();

// Проверяем, является ли это категорией товара и получаем её display_type
if (is_product_category() && isset($term->term_id)) {
    $display_type = get_term_meta($term->term_id, 'display_type', true);

    if ($display_type === 'subcategories') {
        // Подключаем шаблон подкатегорий
        get_template_part('templates/catalogs/subcatalog');
    } else {
        // Подключаем основной каталог
        get_template_part('templates/catalogs/catalog');
    }
}
?>

<?= custom_footer() ?>