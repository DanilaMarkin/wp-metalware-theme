<?php
// Кастомные стили
function custom_styles()
{
    wp_enqueue_style("midleware-style", get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));

    wp_enqueue_style("midleware-global", get_template_directory_uri() . '/assets/css/global.css', array(), filemtime(get_template_directory() . '/assets/css/global.css'));

    // Применять стили для некоторых страниц
    if (is_page(array(22, 51, 93, 53, 226, 248, 291))) {
        wp_enqueue_style("midleware-pages", get_template_directory_uri() . '/assets/css/pages.css', array(), filemtime(get_template_directory() . '/assets/css/pages.css'));
    }

    // Применять стили только для статей
    if (is_single()) {
        wp_enqueue_style("midleware-articles", get_template_directory_uri() . '/assets/css/articles.css', array(), filemtime(get_template_directory() . '/assets/css/articles.css'));
    }

    // Подключаем CSS файл Swiper
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', array(), null);
    // Подключаем CSS файл izitoast
    wp_enqueue_style('izitoast-css', '/node_modules/izitoast/dist/css/iziToast.min.css', array(), null);
}
add_action('wp_enqueue_scripts', 'custom_styles');

// Кастомные скрипты
function custom_scripts()
{
    // Общшие стили для всех страниц
    wp_enqueue_script('midleware-general', get_template_directory_uri() . '/assets/js/general.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/general.js'), true);
    // Фунционал для магазина
    wp_enqueue_script('midleware-store', get_template_directory_uri() . '/assets/js/store.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/store.js'), true);
    // Функционал для страницы Корзина
    wp_enqueue_script('midleware-cart', get_template_directory_uri() . '/assets/js/cart.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/cart.js'), true);

     // Локализуем переменные для JS
     wp_localize_script('midleware-cart', 'my_theme_vars', array(
        'template_url' => get_template_directory_uri()
    ));

    // Подключаем глобальный JS файл с версией по времени изменения
    if (is_page(array(22, 51, 93, 53, 226, 248))) {
        wp_enqueue_script('midleware-pages', get_template_directory_uri() . '/assets/js/pages.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/pages.js'), true);
        wp_enqueue_script('sweetalert2', '/node_modules/sweetalert2/dist/sweetalert2.all.min.js', array(), null, true);
    }
    // Библиотека izitoast для уведомлений
    wp_enqueue_script('izitoast-js', '/node_modules/izitoast/dist/js/iziToast.min.js', array(), null, true);

    // Подключаем JS файл для Swiper
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), null, true);
}
add_action("wp_enqueue_scripts", "custom_scripts");

function enqueue_fancybox()
{
    wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css');
    wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_fancybox');

// Поддержка WooCommerce в теме
function europe_woocommerce_setup()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'europe_woocommerce_setup');


// Кастомная шапка сайта
function custom_header()
{
    get_template_part('/templates/partials/header');
}

// Кастомный подвал сайта
function custom_footer()
{
    get_template_part('/templates/partials/footer');
}

// Добавлению в тему поддержки добавление логотипа сайта
function custom_theme_setup()
{
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

// Регистрация меню
function register_my_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Меню в шапке'),
        )
    );
}
add_action('after_setup_theme', 'register_my_menus');

class Custom_Walker_Nav_Menu  extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        if ($depth === 0) {
            $output .= '<li class="header__bottom-item">';
            $output .= '<a href="' . esc_url($item->url) . '" title="' . esc_attr($item->attr_title) . '">';
            $output .= esc_html($item->title);
            $output .= '</a>';
            $output .= '</li>';
        }
    }
}

// Отправка на почту с формы "Напишите нам"
function send_contact_form()
{
    // Проверка что данные есть
    if (!isset($_POST['name'], $_POST['email'], $_POST['message'])) {
        wp_send_json_error(['message' => 'Не все поля заполнены']);
        return;
    }

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // Формируем письмо
    $to = 'info@krepion.ru';
    $subject = 'Новое сообщение с контактной формы';
    $headers = [
        'From: ' . get_bloginfo('name') . ' <' . $to . '>',
        'Reply-To: ' . $email,
        'Content-Type: text/html; charset=UTF-8',
    ];

    $body = "
        <h2>Новое сообщение:</h2>
        <p><strong>Имя:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Сообщение:</strong><br>$message</p>
    ";

    // Отправляем письмо
    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Сообщение успешно отправлено!']);
    } else {
        wp_send_json_error(['message' => 'Ошибка при отправке письма']);
    }
}
add_action('wp_ajax_send_contact_form', 'send_contact_form');
add_action('wp_ajax_nopriv_send_contact_form', 'send_contact_form');

// Отправка на почту с формы "Уточните наличие на складе у наших менеджеров"
function available_to_stock()
{
    // Проверка что данные есть
    if (!isset($_POST['name'], $_POST['email'], $_POST['message'])) {
        wp_send_json_error(['message' => 'Не все поля заполнены']);
        return;
    }

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // Формируем письмо
    $to = 'info@krepion.ru';
    $subject = 'Новое сообщение с формы "Не нашли интересующий Вас товар?"';
    $headers = [
        'From: ' . get_bloginfo('name') . ' <' . $to . '>',
        'Reply-To: ' . $email,
        'Content-Type: text/html; charset=UTF-8',
    ];

    $body = "
        <h2>Новое сообщение:</h2>
        <p><strong>Имя:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Сообщение:</strong><br>$message</p>
    ";

    // Отправляем письмо
    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Сообщение успешно отправлено!']);
    } else {
        wp_send_json_error(['message' => 'Ошибка при отправке письма']);
    }
}
add_action('wp_ajax_available_to_stock', 'available_to_stock');
add_action('wp_ajax_nopriv_available_to_stock', 'available_to_stock');

// Отправка на почту с формы "Заказать услугу"
function services_send_mail()
{
    // Проверка что данные есть
    if (!isset($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['message'])) {
        wp_send_json_error(['message' => 'Не все поля заполнены']);
        return;
    }

    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // Формируем письмо
    $to = 'info@krepion.ru';
    $subject = 'Новое сообщение с формы "Закажите выбранную услугу"';
    $headers = [
        'From: ' . get_bloginfo('name') . ' <' . $to . '>',
        'Reply-To: ' . $email,
        'Content-Type: text/html; charset=UTF-8',
    ];

    $body = "
        <h2>Новое сообщение:</h2>
        <p><strong>Имя:</strong> $name</p>
        <p><strong>Телефон:</strong> $phone</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Сообщение:</strong><br>$message</p>
    ";

    // Отправляем письмо
    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Сообщение успешно отправлено!']);
    } else {
        wp_send_json_error(['message' => 'Ошибка при отправке письма']);
    }
}
add_action('wp_ajax_services_send_mail', 'services_send_mail');
add_action('wp_ajax_nopriv_services_send_mail', 'services_send_mail');

// Подписка на рассылку на странице Акции
function subscribe_to_stocks()
{
    $email = sanitize_email($_POST['email']);
    $subscribers = get_option('stock_subscribers', []);

    if (!in_array($email, $subscribers)) {
        $subscribers[] = $email;
        update_option('stock_subscribers', $subscribers);
    }

    wp_send_json_success(['message' => 'Вы успешно подписались!']);
}
add_action('wp_ajax_subscribe_to_stocks', 'subscribe_to_stocks');
add_action('wp_ajax_nopriv_subscribe_to_stocks', 'subscribe_to_stocks');

// Добавляем страницу в админку
function add_subscribers_menu_page()
{
    add_menu_page('Подписчики рассылки', 'Подписчики', 'manage_options', 'stock-subscribers', 'display_subscribers_in_admin', 'dashicons-email', 6);
}
add_action('admin_menu', 'add_subscribers_menu_page');

// Функция отображения страницы подписчиков + редактора письма
function display_subscribers_in_admin()
{
    $subscribers = get_option('stock_subscribers', []);
    $email_content = get_option('stock_newsletter_content', ''); // Загружаем шаблон письма

    echo '<div class="wrap">';
    echo '<h1>Список подписчиков</h1>';

    if (!empty($subscribers)) {
        echo '<ul>';
        foreach ($subscribers as $subscriber) {
            echo '<li>' . esc_html($subscriber) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Нет подписчиков на рассылку.</p>';
    }

    echo '<h2>Редактирование письма</h2>';
    echo '<form method="post">';
    echo '<input type="hidden" name="update_newsletter_content" value="1">';

    wp_editor($email_content, 'stock_newsletter_content', [
        'textarea_name' => 'stock_newsletter_content',
        'media_buttons' => false,
        'teeny' => false,
        'quicktags' => true,
        'tinymce' => [
            'valid_elements' => '*[*]' // Разрешает все элементы (но осторожно с безопасностью)
        ]
    ]);

    submit_button('Сохранить письмо');

    echo '</form>';

    // Кнопка отправки
    echo '<form method="post" style="margin-top: 20px;">';
    echo '<input type="hidden" name="send_stock_newsletter" value="1">';
    submit_button('Отправить рассылку', 'primary large', 'send_newsletter');
    echo '</form>';
    echo '</div>';
}

// Обрабатываем сохранение письма
function save_stock_newsletter_content()
{
    if (isset($_POST['update_newsletter_content'])) {
        update_option('stock_newsletter_content', wp_kses_post($_POST['stock_newsletter_content']));
        add_action('admin_notices', function () {
            echo '<div class="updated notice is-dismissible"><p>Шаблон письма обновлен!</p></div>';
        });
    }
}
add_action('admin_init', 'save_stock_newsletter_content');

// Обрабатываем отправку рассылки
function handle_stock_newsletter()
{
    if (isset($_POST['send_stock_newsletter'])) {
        $subscribers = get_option('stock_subscribers', []);
        $subject = 'Новая акция!';
        $message = get_option('stock_newsletter_content', 'Привет! Мы подготовили для вас новые акции. Заходите на сайт, чтобы узнать больше!');
        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: Крепион'
        ];

        foreach ($subscribers as $email) {
            wp_mail($email, $subject, $message, $headers);
        }

        add_action('admin_notices', function () {
            echo '<div class="updated notice is-dismissible"><p>Рассылка успешно отправлена!</p></div>';
        });
    }
}
add_action('admin_init', 'handle_stock_newsletter');

// Кастомная регистрация новых полей в редактор темы
function my_theme_customize_register($wp_customize)
{
    // Создаем новую секцию для настроек
    $wp_customize->add_section('my_theme_settings', array(
        'title'    => 'Контактные данные',
        'priority' => 30,
    ));

    // Добавляем поле "Адрес"
    $wp_customize->add_setting('address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('address_control', array(
        'label'    => 'Адрес',
        'section'  => 'my_theme_settings',
        'settings' => 'address',
        'type'     => 'text',
    ));

    // Добавляем поле "Часы работы"
    $wp_customize->add_setting('working_hours', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('working_hours_control', array(
        'label'    => 'Часы работы',
        'section'  => 'my_theme_settings',
        'settings' => 'working_hours',
        'type'     => 'text',
    ));

    // Добавляем поле "Телефон"
    $wp_customize->add_setting('phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('phone_control', array(
        'label'    => 'Телефон',
        'section'  => 'my_theme_settings',
        'settings' => 'phone',
        'type'     => 'text',
    ));

    // Добавляем поле "Электронная почта"
    $wp_customize->add_setting('email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('email_control', array(
        'label'    => 'Электронная почта',
        'section'  => 'my_theme_settings',
        'settings' => 'email',
        'type'     => 'email',
    ));

    // Добавляем поле "Ссылка на WhatsApp"
    $wp_customize->add_setting('link_wa', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('link_wa_control', array(
        'label'    => 'Ссылка на WhatsApp',
        'section'  => 'my_theme_settings',
        'settings' => 'link_wa',
        'type'     => 'text',
    ));

    // Добавляем поле "Ссылка на VK"
    $wp_customize->add_setting('link_vk', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('link_vk_control', array(
        'label'    => 'Ссылка на VK',
        'section'  => 'my_theme_settings',
        'settings' => 'link_vk',
        'type'     => 'text',
    ));

    // Добавляем поле "Ссылка на Telegram"
    $wp_customize->add_setting('link_telegram', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('link_telegram_control', array(
        'label'    => 'Ссылка на Telegram',
        'section'  => 'my_theme_settings',
        'settings' => 'link_telegram',
        'type'     => 'text',
    ));
}

add_action('customize_register', 'my_theme_customize_register');

// Функция для автоматической установки для статей шаблона Single
function custom_single_template($template)
{
    if (is_singular('post')) {
        return get_theme_file_path('templates/articles/single.php');
    }
    return $template;
}
add_filter('single_template', 'custom_single_template');

// Фунция для шаблона по умолчанию для товаров WooCommerce
function custom_single_product_template($template)
{
    // Проверяем, что это страница товара
    if (is_singular('product')) {
        // Путь к вашему кастомному шаблону
        $custom_template = get_stylesheet_directory() . '/woocommerce/single-product.php';

        // Проверка, существует ли файл
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    return $template; // Возвращаем стандартный шаблон, если кастомный не найден
}

add_filter('template_include', 'custom_single_product_template');

// Живой поиск
add_action('wp_ajax_custom_product_search', 'custom_product_search');
add_action('wp_ajax_nopriv_custom_product_search', 'custom_product_search');

function custom_product_search() {
    $term = sanitize_text_field($_GET['term'] ?? '');

    $args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        's'              => $term
    ];

    add_filter('posts_search', 'custom_search_by_title_and_sku', 10, 2);

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        foreach ($query->posts as $product) {
            $product_id = $product->ID;
            $results[] = [
                'title' => get_the_title($product_id),
                'link' => get_permalink($product_id),
                'image' => get_the_post_thumbnail_url($product_id, 'thumbnail')
            ];
        }
    }

    remove_filter('posts_search', 'custom_search_by_title_and_sku', 10);

    wp_send_json($results);
}

function custom_search_by_title_and_sku($search, $wp_query) {
    global $wpdb;

    if (!isset($wp_query->query_vars['s']) || empty($wp_query->query_vars['s'])) {
        return $search;
    }

    $term = esc_sql($wpdb->esc_like($wp_query->query_vars['s']));
    
    // Убираем стандартную часть поиска
    $search = " AND (";
    $search .= "{$wpdb->posts}.post_title LIKE '%{$term}%' ";
    $search .= "OR {$wpdb->posts}.ID IN (
        SELECT post_id FROM {$wpdb->postmeta}
        WHERE meta_key = '_sku' AND meta_value LIKE '%{$term}%'
    )";
    $search .= ")";

    return $search;
}

// Живой поиск

// Темы для страниц разбитые под папки для страниц
add_filter('theme_page_templates', function ($templates) {
    $templates['templates/pages/stock.php'] = 'Акции';
    $templates['templates/pages/payment-and-delivery.php'] = 'Доставка и оплата';
    $templates['templates/pages/about-company.php'] = 'О компании';
    $templates['templates/pages/our-contacts.php'] = 'Наши контакты';
    $templates['templates/pages/services.php'] = 'Услуги';
    $templates['templates/pages/privacy-policy.php'] = 'Политика конфиденциальности';
    $templates['/woocommerce/favourite.php'] = 'Избранное';
    $templates['/woocommerce/cart.php'] = 'Корзина';

    return $templates;
});

// Поддержка миниатюр в "Записи" в Admin Panel
add_theme_support('post-thumbnails');

// Регистрация кастомного REST API для получения информации о товаре
function custom_product_endpoint() {
    register_rest_route('wp/v2', '/products/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_product_details',
    ));
}
add_action('rest_api_init', 'custom_product_endpoint');

// Функция для получения данных товара с кэшированием и получение для избранного
function get_product_details(WP_REST_Request $request) {
    $product_id = $request['id'];
    
    // Проверяем, есть ли кэшированные данные для этого товара
    $cached_product = wp_cache_get("product_{$product_id}", 'product_data');
    
    if (!$cached_product) {
        // Если кэша нет, получаем данные о товаре
        $product = wc_get_product($product_id);

        if (!$product) {
            return new WP_Error('no_product', 'Product not found', array('status' => 404));
        }

        // Подготавливаем данные для возвращения
        $cached_product = [
            'id' => $product->get_id(),
            'title' => $product->get_title(),
            'image_url' => wp_get_attachment_url($product->get_image_id()),
            'product_url' => get_permalink($product_id),
        ];

        // Кэшируем данные товара на 1 час (3600 секунд)
        wp_cache_set("product_{$product_id}", $cached_product, 'product_data', 3600);
    }

    return $cached_product;
}

add_action('wp_ajax_get_cart_products', 'get_cart_products_callback');
add_action('wp_ajax_nopriv_get_cart_products', 'get_cart_products_callback');

function get_cart_products_callback() {
    $ids = isset($_POST['ids']) ? json_decode(stripslashes($_POST['ids']), true) : [];

    if (empty($ids)) wp_send_json([]);

    $result = [];

    foreach ($ids as $id) {
        $product = wc_get_product($id);
        if (!$product) continue;

        $result[] = [
            'id'    => $product->get_id(),
            'title' => $product->get_name(),
            'sku'   => $product->get_sku(),
            'price' => wc_price($product->get_price()),
            'image' => wp_get_attachment_image_url($product->get_image_id(), 'thumbnail'),
        ];
    }

    wp_send_json($result);
}



