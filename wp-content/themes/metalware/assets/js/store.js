document.addEventListener("DOMContentLoaded", () => {
    // ---Функционал "Добавление в избранное---"
    function updateFavouriteCount() {
        const countElem = document.querySelector(".header__right-favourite-count");
        const favourites = JSON.parse(localStorage.getItem("favourites") || "[]");
        if (countElem) {
            countElem.textContent = favourites.length > 0 ? favourites.length : '0';
        }
    }

    updateFavouriteCount(); // при загрузке страницы
    
    // Определение переменных
    const addFavourite = document.querySelector(".favourite-btn");
    if (!addFavourite) return; // Защита, если кнопки нет

    const icon = addFavourite.querySelector(".favourite-btn__icon");
    const productId = document.querySelector(".product").dataset.productId;
    if (!productId) return; // Защита, если блока с товаром нет

    // Используем функцию для получения URL темы
    const themeUrl = document.body.getAttribute('data-theme-url'); 

    // Переменная для хранение товаров в избранное
    const favorites = JSON.parse(localStorage.getItem("favourites") || "[]");

    const isFavourite = favorites.includes(productId);
    if (isFavourite) {
        addFavourite.classList.add("active");
        icon.src = `${themeUrl}/assets/icons/favorites-fill.svg`;
    } else {
        icon.src = `${themeUrl}/assets/icons/favorites.svg`;
    }
    
    // Обработчик клика
    addFavourite.addEventListener("click", () => {
        let favourites = JSON.parse(localStorage.getItem("favourites") || "[]");
        const index = favourites.indexOf(productId);
        const isActive = addFavourite.classList.toggle("active");

        if (isActive && index === -1) {
            favourites.push(productId);
        } else if (!isActive && index !== -1) {
            favourites.splice(index, 1);
        }

        localStorage.setItem("favourites", JSON.stringify(favourites));

        icon.src = isActive
            ? `${themeUrl}/assets/icons/favorites-fill.svg`
            : `${themeUrl}/assets/icons/favorites.svg`;

            updateFavouriteCount(); // при клике
    });
    
    // ---Функционал "Добавление в избранное---"
});

document.addEventListener("DOMContentLoaded", () => {
    const favouriteList = document.getElementById("favourite__list");
    const favouriteNotCart = document.getElementById("favourite__not-cart");
    
    // Получаем массив избранных товаров из localStorage
    const favourites = JSON.parse(localStorage.getItem("favourites") || "[]");

    // Функция для вывода товара в избранное
    function getProductDetails(productId) {
        // Проверяем, есть ли кэшированные данные для данного товара в localStorage
        const cachedProduct = localStorage.getItem(`product_${productId}`);
        if (cachedProduct) {
            return Promise.resolve(JSON.parse(cachedProduct)); // Возвращаем кэшированные данные
        }

        // Если данных нет, делаем запрос
        return fetch(`/wp-json/wp/v2/products/${productId}`)
            .then(response => response.json())
            .then(product => {
                // Сохраняем данные товара в localStorage для будущих запросов
                localStorage.setItem(`product_${productId}`, JSON.stringify(product));
                return product;
            });
    }

    // Функция для обновления отображения избранных товаров
    function updateFavouriteDisplay() {
        if (favourites.length > 0) {
            if (favouriteList) {
                favouriteList.style.display = 'grid';  // Показываем список избранных
            }

            if (favouriteNotCart) {
                favouriteNotCart.style.display = 'none';  // Скрываем сообщение о пустом избранном
            }

            // Получаем данные каждого товара и вставляем их в список
            Promise.all(favourites.map(productId => getProductDetails(productId)))
                .then(productHtmlArray => {
                    if (favouriteList) {
                        favouriteList.innerHTML = productHtmlArray.map(product => {
                            return `
                                <li class="cart__item">
                                    <div class="cart__item-preview">
                                        <img src="${product.image_url}" alt="${product.title}" class="cart__item-preview-img" loading="lazy" />
                                    </div>
                                    <h2 class="cart__item-title">${product.title}</h2>
                                    <p class="cart__item-short-descr">Крепёж для строительных конструкций, класс прочности 10.9</p>
                                    <div class="cart__item-btns">
                                        <button class="filter__btn filter__btn-show">Заказать</button>
                                        <a href="${product.product_url}" class="filter__btn filter__btn-reset">Подробнее</a>
                                    </div>
                                </li>`;
                        }).join('');
                    }
                });
        } else {
            favouriteList.style.display = 'none';  // Скрываем список избранных
            favouriteNotCart.style.display = 'grid';  // Показываем сообщение о пустом избранном
        }
    }

    // Вызов функции при загрузке страницы
    updateFavouriteDisplay();
});

// Доббавление товара в корзину
document.addEventListener("DOMContentLoaded", () => {
    // Кнопка доб-ие в корзину
    const addCart = document.querySelector(".cart-add");

    // Кнопки для управление input
    const btnPlus = document.querySelector(".quantity-plus");
    const btnMunus = document.querySelector(".quantity-minus");

    // Поля ввода кол-ва товаров
    const countInput = document.querySelector(".quantity-input");

    // Число для отображение в навигации
    const navCount = document.querySelector(".header__right-cart-count");

    const productId = document.querySelector(".product")?.dataset?.productId;

    // Функия для обновление числа товаров в шапке
    function updateCartCounttNav() {
        navCount.textContent = localStorage.getItem("cartCount") || 0;
    }

    function successNotif() {
        iziToast.show({
            message: 'Товар добавлен в корзину',
            backgroundColor: '#2a9e44', // Зелёный фон (можно свой HEX)
            messageColor: '#fff',       // Белый текст
            position: 'bottomRight',
            timeout: 3000,
            transitionIn: 'fadeInUp',
            transitionOut: 'fadeOut',
            close: true // Кнопка закрытия
            });
    }

    function errorNotif() {
        iziToast.show({
            message: 'Товар удален из корзины',
            backgroundColor: '#e74c3c', // Красный фон для ошибки
            messageColor: '#fff',       // Белый текст
            position: 'bottomRight',
            timeout: 3000,
            transitionIn: 'fadeInUp',
            transitionOut: 'fadeOut',
            close: true // Кнопка закрытия
          });
    }

    function updateCartData() {
        const count = parseInt(countInput.value) || 0;

        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        if (count > 0) {
            const isProduct = cart.find(item => item.productId === productId);

            if (isProduct) {
                isProduct.quantity = count;
            } else {
                cart.push({ productId, quantity: count});
            }
        } else {
            cart = cart.filter(item => item.productId !== productId);
        }

        localStorage.setItem('cart', JSON.stringify(cart));

        localStorage.setItem('cartCount', cart.reduce((acc, item) => acc + item.quantity, 0));
        updateCartCounttNav();
    }

    function setInitCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        const product = cart.find(item => item.productId === productId);

        if (product) {
            countInput.value = product.quantity;
        }
    }

    // Клик по кнопке + для увел-ие
    if (btnPlus) {
        btnPlus.addEventListener("click", () => {
            countInput.value = parseInt(countInput.value) + 1;
        });
    }

    // Клик по кнопке - для умен-ие
    if (btnPlus) {
        btnMunus.addEventListener("click", () => {
            // Проверка что зн-ие не меньше 1
            if (parseInt(countInput.value) > 0) {
                countInput.value = parseInt(countInput.value) - 1;
            }
        });
    }

    if (addCart) {
        addCart.addEventListener("click", () => {
            // Если число больше 1
            if (parseInt(countInput.value) >= 1) {
                successNotif();
                updateCartData();
            } else {
                errorNotif();
                updateCartData();
            }
        });
    }


    // Обновление информации о товарах в корзине при загрузке страницы
    updateCartCounttNav();

    // Устанавливаем начальное количество товара при загрузке страницы
    setInitCount();

});
