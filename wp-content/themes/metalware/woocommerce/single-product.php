<?php
custom_header();

global $product;

// Получаем ID текущего товара
$product_id = get_the_ID();

// Получаем ID изображения товара
$thumbnail_id = get_post_thumbnail_id($product_id);
?>

<!-- custom breadcrumbs -->
<section class="container custom-breadcrumbs">
	<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
</section>
<!-- custom breadcrumbs -->

<main class="product__content container">
	<section class="product" data-product-id="<?= $product_id; ?>">
		<!-- preview block image -->
		<div class="product-preview">
			<!-- Фото товара -->
			<a href="<?= wp_get_attachment_url($thumbnail_id); ?>" data-fancybox="gallery">
				<?= wp_get_attachment_image($thumbnail_id, 'full', false, [
					'alt' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true),
					'title' => get_the_title($thumbnail_id),
					'class' => 'product-preview__img'
				]); ?>
			</a>

			<!-- Кнопка лупы -->
			<button class="magnifying-glass__btn" data-src="<?= wp_get_attachment_url($thumbnail_id); ?>">
				<?= wp_get_attachment_image(254, 'full', false, [
					'alt' => get_post_meta(254, '_wp_attachment_image_alt', true),
					'title' => get_the_title(254),
					'class' => 'magnifying-glass_icon'
				]); ?>
			</button>
		</div>

		<!-- product short info -->
		<div class="product-info">
			<!-- product header -->
			<div class="product-info__header">
				<h1 class="product-info__header-title"><?= the_title(); ?></h1>
				<span class="product-info__header-sku">Артикул: <?= $product->get_sku(); ?></span>
			</div>

			<!-- product price and count -->
			<div class="product-info__action">
				<p class="product-info__price">
					Цена: <span class="product-info__price-current">от <?= $product->get_price_html(); ?>/шт</span>
				</p>
				<div class="product-info__availability">
					<p class="product-info__availability-text">в наличии</p>
					<div class="product-info__availability-green"></div>
				</div>
				<div class="product-info__block">
					<!-- quantity -->
					<div class="quantity">
						<button class="quantity-btn quantity-minus" aria-label="Уменьшить количество">
							<?=
							wp_get_attachment_image(257, 'full', false, [
								'alt' => get_post_meta(257, '_wp_attachment_image_alt', true),
								'title' => get_the_title(257),
								'class' => 'quantity-btn__icon'
							]);
							?>
						</button>
						<input type="number" class="quantity-input" value="0" min="0" aria-label="Количество">
						<button class="quantity-btn quantity-plus" aria-label="Увеличить количество">
							<?=
							wp_get_attachment_image(258, 'full', false, [
								'alt' => get_post_meta(258, '_wp_attachment_image_alt', true),
								'title' => get_the_title(258),
								'class' => 'quantity-btn__icon'
							]);
							?>
						</button>
					</div>

					<div class="action-cart">
						<!-- cart add -->
						<button class="cart-add">
							В корзину
							<?=
							wp_get_attachment_image(256, 'full', false, [
								'alt' => get_post_meta(256, '_wp_attachment_image_alt', true),
								'title' => get_the_title(254),
								'class' => 'cart-add__icon'
							]);
							?>
						</button>

						<!-- favourite -->
						<button class="favourite-btn">
							<img
								src="<?= get_template_directory_uri(); ?>/assets/icons/favorites.svg"
								class="favourite-btn__icon"
								width="25"
								height="23"
								alt=""
								loading="lazy">
						</button>
					</div>
				</div>
				<p class="action-cart__info">Товар продаётся кратно упаковкам, актуальные цены определяются после общения с менеджером продаж.</p>
			</div>

			<!-- product specs -->
			<?php
			// Получаем атрибуты товара
			$attributes = $product->get_attributes();

			// Проверяем, есть ли атрибуты
			if (!empty($attributes)) {
				echo '<dl class="product-specs">';

				// Счетчик для атрибутов
				$counter = 0;

				// Проходим по каждому атрибуту
				foreach ($attributes as $attribute) {
					// Останавливаем цикл, если достигли 4 атрибута
					if ($counter >= 4) {
						break;
					}

					// Получаем "красивое" название атрибута
					$label = wc_attribute_label($attribute->get_name());
					$value = '';

					// Таксономические или нет
					if ($attribute->is_taxonomy()) {
						// Получаем названия терминов
						$terms = wp_get_post_terms($product->get_id(), $attribute->get_name(), ['fields' => 'names']);
						$value = implode(', ', $terms);
					} else {
						// Если не таксономия — просто берем значения
						$value = implode(', ', $attribute->get_options());
					}

					// Выводим атрибут
					echo '<div>';
					echo '<dt>' . esc_html($label) . '</dt>';
					echo '<dd>' . esc_html($value) . '</dd>';
					echo '</div>';

					// Увеличиваем счетчик
					$counter++;
				}

				echo '</dl>';
			}
			?>

		</div>
	</section>

	<!-- product full info -->
	<section class="product__full-info">
		<!-- product tabs -->
		<div class="product__tabs-block">
			<div class="product-tabs">
				<button data-tab="description" class="product-tab active">Описание</button>
				<button data-tab="characteristics" class="product-tab">Характеристики</button>
				<button data-tab="payment" class="product-tab">Доставка и оплата</button>
			</div>
		</div>

		<!-- description tabs -->
		<div id="description" class="product__tab-content active">
			<div class="description">
				<h2 class="product__tabs-title">Описание:</h2>
				<?= the_content(); ?>
			</div>
		</div>

		<!-- characteristics tabs -->
		<div id="characteristics" class="product__tab-content">
			<div class="characteristics">
				<h2 class="product__tabs-title">Характеристики:</h2>
				<?php
				// Получаем атрибуты товара
				$attributes = $product->get_attributes();

				// Проверяем, есть ли атрибуты
				if (! empty($attributes)) {
					echo '<dl class="product-characteristics">';

					// Проходим по каждому атрибуту
					foreach ($attributes as $attribute) {
						$label = wc_attribute_label($attribute->get_name());
						$value = '';

						// Если атрибут таксономический (pa_*) — получаем термины
						if ($attribute->is_taxonomy()) {
							$terms = wp_get_post_terms($product->get_id(), $attribute->get_name(), ['fields' => 'names']);
							$value = implode(', ', $terms);
						} else {
							// Если это пользовательский атрибут (не таксономия)
							$value = implode(', ', $attribute->get_options());
						}

						// Выводим
						echo '<div>';
						echo '<dt>' . esc_html($label) . '</dt>';
						echo '<dd>' . esc_html($value) . '</dd>';
						echo '</div>';
					}

					echo '</dl>';
				}
				?>
			</div>
		</div>

		<!-- payment and delivery tabs -->
		<div id="payment" class="product__tab-content">
			<div class="payment">
				<h2 class="product__tabs-title">Доставка и оплата:</h2>
				<div>
					<h3 class="product__tabs-sub-title">Оплата:</h3>
					<p>Безналичный расчет для юридических лиц: счет выставляется менеджером после оформления заказа</p>
				</div>
				<h3 class="product__tabs-sub-title">Доставка:</h3>
				<div>
					<p>Вы можете забрать заказ из нашего офиса или склада.</p>
					<p>Указание адресов с картой Google/Yandex Maps.</p>
					<p>Курьерская доставка</p>
					<p>Доставка до термина ТК в СПБ бесплатная.</p>
				</div>

				<div>
					<p>Зоны доставки:</p>
					<p>Доступно в пределах города и ближайших населенных пунктов.</p>
					<p>Сроки: "Доставка осуществляется в течение 1-3 дней после подтверждения заказа."</p>
				</div>

				<div>
					<p>Цена:</p>
					<p>В пределах города: от 800 руб.</p>
					<p>За пределами города: Рассчитывается индивидуально.</p>
				</div>

				<div>
					<p>Поддерживаемые ТК: СДЭК, Деловые Линии, ПЭК</p>
					<p>Сроки: В зависимости от региона (от 2 до 10 дней).</p>
					<p>Особенности: Доставка до терминала ТК в вашем городе или до двери.</p>
					<p>Стоимость рассчитывается менеджером после оформлении заказа. </p>
				</div>
			</div>
		</div>

	</section>
</main>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		const tabs = document.querySelectorAll(".product-tab");
		const contents = document.querySelectorAll(".product__tab-content");

		tabs.forEach(tab => {
			tab.addEventListener("click", function() {
				const tabId = this.getAttribute("data-tab");

				// Убираем активные классы
				tabs.forEach(t => t.classList.remove("active"));
				contents.forEach(c => c.classList.remove("active"));

				// Добавляем активные классы
				this.classList.add("active");
				document.getElementById(tabId).classList.add("active");
			});
		});
	});
</script>


<?= custom_footer() ?>