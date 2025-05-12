document.addEventListener("DOMContentLoaded", function () {
    // Глобальные переменные
    const overlay = document.getElementById("overlay");
    // Глобальные переменные
    const burger = document.querySelector(".burger-menu");
    const burgerContent = document.querySelector(".burger-menu__content");
    const menu = document.querySelector(".header__bottom");
    const menuPhone = document.querySelector(".header__right-tel");
    const menuEmail = document.querySelector(".header__right-mail");

    const searchBtn = document.querySelector(".search-mob");
    const searchContent = document.querySelector(".header__top-search");

     // Открытие мод окна "Каталог"
     const btnPopupCatalog = document.querySelector(".header__top-catalog");
     const popupCatalog = document.querySelector(".popup-catalog");
     

    // Функция для проверки, нужно ли блокировать прокрутку
    function toggleBodyScroll() {
        // Проверяем, открыты ли хотя бы одно меню
        const isMenuOpen = menu.classList.contains("open");
        const isSearchOpen = searchContent.classList.contains("open");
        const ispopupCatalog = popupCatalog.classList.contains("open");
        
        // Если хотя бы одно из меню открыто, блокируем прокрутку
        if (isMenuOpen || isSearchOpen || ispopupCatalog) {
            document.body.classList.add("no-scroll");
        } else {
            document.body.classList.remove("no-scroll");
        }
    }

    // Открытие/закрытие бургер-меню
    burger.addEventListener("click", function () {
        this.classList.toggle("open");
        burgerContent.classList.toggle("open");
        menu.classList.toggle("open");
        menuPhone.classList.toggle("active");
        menuEmail.classList.toggle("active");

        // Обновляем состояние прокрутки
        toggleBodyScroll();
    });

    // Открытие/закрытие поиска
    searchBtn.addEventListener("click", () => {
        // Если меню открыто, закрываем его перед открытием поиска
        if (menu.classList.contains("open")) {
            menu.classList.remove("open");
            burger.classList.remove("open");
            burgerContent.classList.remove("open");
            menuPhone.classList.remove("active");
            menuEmail.classList.remove("active");

        }

        // Переключаем состояние поиска
        searchContent.classList.toggle("open");

        // Обновляем состояние прокрутки
        toggleBodyScroll();
    });

    // Закрытие поиска при клике за пределами
    document.addEventListener("click", (event) => {
        if (!searchContent.contains(event.target) && !searchBtn.contains(event.target)) {
            searchContent.classList.remove("open");

            // Обновляем состояние прокрутки после закрытия поиска
            toggleBodyScroll();
        }
    });

    // Открытие попап Фильтрации на странице Каталог для моб версии
    const filterMobBtnOpen = document.querySelector(".filter-mob__btn");
    const filterMobBtnClose = document.querySelector(".filter-mob__btn-close");
    const filterMobPopup = document.querySelector(".filter");

    // Проверка на наличие кнопки
    if (filterMobBtnOpen && filterMobPopup && filterMobBtnClose) {
        // Клик по кнопке
        filterMobBtnOpen.addEventListener("click", () => {
            filterMobPopup.classList.add("open");
        });

        // Закрытие по кнопке
        filterMobBtnClose.addEventListener("click", () => {
            filterMobPopup.classList.remove("open");
        });
    }

    // Открытие мод окна "Каталог"
    btnPopupCatalog.addEventListener("click", () => {
      btnPopupCatalog.classList.toggle("open");
      popupCatalog.classList.toggle("open");
      overlay.classList.toggle("active");
      toggleBodyScroll();
    });

     // Закрытие поиска при клике за пределами
     document.addEventListener("click", (event) => {
      if (!popupCatalog.contains(event.target) && !btnPopupCatalog.contains(event.target)) {
          btnPopupCatalog.classList.remove("open");
          popupCatalog.classList.remove("open");
          // Обновляем состояние прокрутки после закрытия поиска
          toggleBodyScroll();
          overlay.classList.remove("active");
      }
  });

  // Шапка следующая за пользователем
  const header = document.querySelector(".header__other-page");
  let lastScroll = window.scrollY;
  let timeout;

  const hideHeader = () => {
    header.classList.add("header__hidden");
  };

  const showHeader = () => {
    header.classList.remove("header__hidden");
  };

  window.addEventListener("scroll", () => {
    const currentScroll = window.scrollY;

    // Если пользователь скроллит (в любом направлении)
    if (currentScroll !== lastScroll) {
      hideHeader();

      // Если уже есть таймер — сбросим его
      clearTimeout(timeout);

      // Если пользователь остановился на 400мс — покажем хедер
      timeout = setTimeout(() => {
        showHeader();
      }, 300);
    }

    lastScroll = currentScroll;
  });

});

// Живой поиск по товарам
document.addEventListener('DOMContentLoaded', function () {
    // Переменные для поиска и выдачи
    const input = document.querySelector('#search');
    const resultBlock = document.querySelector('.header__top-search-result');
    const resultList = document.querySelector('.header__top-search-result-list');
  
    // Отслеживание изменений в поле ввода
    input.addEventListener('input', function () {
      const query = this.value;
  
      if (query.length < 2) {
        resultBlock.classList.add('hidden');
        return;
      }
  
      fetch('/wp-admin/admin-ajax.php?action=custom_product_search&term=' + query)
        .then(res => res.json())
        .then(data => {
          resultList.innerHTML = '';
  
          if (data.length === 0) {
            resultBlock.classList.add('hidden');
            return;
          }
  
          data.forEach(product => {
            const item = document.createElement('li');
            item.className = 'header__top-search-result-item';
            item.innerHTML = `
              <div class="header__top-search-result-item-preview">
                <img src="${product.image}" alt="${product.title}" class="header__top-search-result-item-preview-img">
              </div>
              <a href="${product.link}" class="header__top-search-result-title">${product.title}</a>
            `;
            resultList.appendChild(item);
          });
  
          resultBlock.classList.remove('hidden');
        });
    });
  });

