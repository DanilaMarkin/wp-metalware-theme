document.addEventListener("DOMContentLoaded", function () {
    const cartData = JSON.parse(localStorage.getItem("cart") || "[]");
    if (cartData.length === 0) return;

    const productIds = cartData.map(item => item.productId);

    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'get_cart_products',
            ids: JSON.stringify(productIds)
        })
    })
    .then(res => res.json())
    .then(products => {
        let html = "";
        console.log(products);
        products.forEach(product => {
            // Фунции для работы с данными
            const producInCart = cartData.find(item => parseInt(item.productId) === product.id);
            const quantity = producInCart ? producInCart.quantity : 1;

            html += `
            <li class="cart-item" data-id="${product.id}">
                    <!-- checkbox -->
                    <div class="cart-item__select">
                        <input type="checkbox" name="select-all" id="selectAll${product.id}" class="custom-checkbox">
                        <label for="selectAll${product.id}" class="custom-select-all"></label>
                    </div>

                    <!-- cart item info -->
                    <div class="cart-item__block">
                        <div class="cart-item__preview">
                            <img src="${product.image}" alt="${product.title}" title="${product.title}" class="cart-item__img">
                        </div>

                        <!-- cart item info -->
                        <div class="cart-item__info">
                            <h2 class="cart-item__info-title">${product.title}</h2>
                            <span class="cart-item__info-sku">Артикул: ${product.sku || "–"}</span>
                        </div>

                        <!-- cart item price -->
                        <span class="cart-item__price">${product.price}</span>

                        <!-- cart item action -->
                        <div class="cart-item__action">
                            <!-- quantity -->
                            <div class="quantity cart-item__action-quantity">
                                <button class="cart-item__action-quantity-minus quantity-btn quantity-minus" aria-label="Уменьшить количество">
                                    <img src="${my_theme_vars.template_url}/assets/icons/minus.svg" class="quantity-btn__icon">
                                </button>
                                <input type="number" class="cart-item__action-quantity-input quantity-input" value="${quantity}" min="1" aria-label="Количество">
                                <button class="cart-item__action-quantity-plus quantity-btn quantity-plus" aria-label="Увеличить количество">
                                    <img src="${my_theme_vars.template_url}/assets/icons/plus.svg" class="quantity-btn__icon">
                                </button>
                            </div>

                            <div class="cart-item__action-last">
                                <!-- favourite one product -->
                                <button class="cart-item-favourite-btn">
                                    <img src="${my_theme_vars.template_url}/assets/icons/favorites.svg" class="favourite-btn__icon">
                                </button>

                                <!-- delete one producy -->
                                <button class="cart-item__delete-btn">
                                    <img src="${my_theme_vars.template_url}/assets/icons/close-icon.svg" class="cart-item__delete-btn">
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            `;
        });
        const cartList = document.querySelector(".cart-list");
        if (cartList) {
            cartList.innerHTML = html;
        }
    });

});
