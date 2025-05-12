// Ожидаю загрузку страницы
document.addEventListener("DOMContentLoaded", function() {
    const contactForm = document.getElementById("contactForm");
    // Проверка на наличие формы
    if (contactForm) {
        // Отправка формы и ее валидация
        contactForm.addEventListener("submit", function(event) {
            // Останавливаем стандартное поведение браузера
            event.preventDefault();

            // Флаг валидности
            let isValid = true;

            const nameContact = document.getElementById("name");
            const nameLabel = document.getElementById("nameLabel");
            const nameError = nameContact.nextElementSibling;

            const emailContact = document.getElementById("email");
            const emailLabel = document.getElementById("emailLabel");
            const emailError = emailContact.nextElementSibling;

            const messageContact = document.getElementById("message");

            // Фунция для установки ошибки
            function setError(field, label, errorElement, message) {
                if (message) {
                    // Текст ошибки
                    errorElement.textContent = message;
                    // Добавление класса error к input и label
                    field.classList.add("error");
                    label.classList.add("error");
                    // Удаление класса success (если была успешная проверка ранее)
                    field.classList.remove("success");
                    label.classList.remove("success");
                    isValid = false;
                } else {
                    // Если нет ошибки, очищаем текст ошибки
                    errorElement.textContent = "";
                    // Удаляем error и добавляем success
                    field.classList.remove("error");
                    label.classList.remove("error");
                    // Добавляем класс об успешной отправки
                    field.classList.add("success");
                    label.classList.add("success");
                }
            }        

            // Проверка имени
            const namePattern = /^[А-Яа-яЁё\s-]+$/; // Разрешены только кириллические буквы, пробел и дефис
            if (nameContact.value.trim() === "") {
                setError(nameContact, nameLabel, nameError, "Введите ваше имя");
            } else if (!namePattern.test(nameContact.value)) {
                setError(nameContact, nameLabel, nameError, "Имя должно содержать только буквы кириллицы");
            } else if (/\d/.test(nameContact.value)) {
                setError(nameContact, nameLabel, nameError, "Имя не должно содержать цифры");
            } else {
                setError(nameContact, nameLabel, nameError, "");
            }

            // Проверка Email
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (emailContact.value.trim() === "") {
                setError(emailContact, emailLabel, emailError, "Введите ваш email");
            } else if (!emailPattern.test(emailContact.value)) {
                setError(emailContact, emailLabel, emailError, "Введите корректный email");
            } else if (emailContact.value.length > 320) {
                setError(emailContact, emailLabel, emailError, "Email слишком длинный");
            } else {
                setError(emailContact, emailLabel, emailError, "");
            }

            // Если нет ошибок выполнять отправку формы
            if (isValid) {
                // Отправляю запрос на сервер
                fetch("/wp-admin/admin-ajax.php", {
                    method: "POST",
                    body: new URLSearchParams({
                        action: "send_contact_form",
                        name: nameContact.value,
                        email: emailContact.value,
                        message: messageContact.value
                    }),
                })
                // Формат в виде json
                .then(response => response.json())
                .then(data => {
                    // Если все успешно, то ...
                    if (data.success) {
                        // Очищаем форму
                        document.getElementById("contactForm").reset();
                        // Удаляю все классы об успешной отправки
                        document.querySelectorAll("#contactForm input, #contactForm label").forEach(field => {
                            field.classList.remove("success");
                        });
                        // Форма об успешной отправки сообщения
                        Swal.fire({
                            title: "Успешно!",
                            text: "Мы скоро свяжемся с вами!",
                            icon: "success",
                            timer: 5000,
                            showConfirmButton: true,
                            confirmButtonText: "ОК",
                            customClass: {
                                confirmButton: "swal-confirm-button"
                            }
                        });
                    }
                })
                // Обработка ошибки
                .catch(error => console.error("Ошибка при отправке: " + error));
            }
        });
    }

    // Отправка и валидация формы Рассылка
    const formSubscriber = document.getElementById("formSubscriber");
    // Проверка на наличие формы
    if (formSubscriber) {
        document.getElementById("formSubscriber").addEventListener("submit", function(event) {
            // Останавливаю стандартное поведение формы
            event.preventDefault();

            // Флаг ошибок 
            let isValid = true; 

            // Поля формы
            const emailStock = document.getElementById("email_stock");

            // Проверка email
            if (emailStock.value.trim() === "") {
                emailStock.classList.add("error");
                isValid = false;
            } else {
                emailStock.classList.remove("error");
            }

            // Если ошибок нет, то отправлять форму
            if (isValid) {
                 // Отправляю запрос на сервер
                 fetch("/wp-admin/admin-ajax.php", {
                    method: "POST",
                    body: new URLSearchParams({
                        action: "subscribe_to_stocks",
                        email: emailStock.value,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    // Если все успешно, то ...
                    if (data.success) {
                        // Очищаем форму
                        document.getElementById("formSubscriber").reset();
                        // Удаляю все классы об успешной отправки
                        document.querySelectorAll("#formSubscriber input").forEach(field => {
                            field.classList.remove("success");
                        });
                        // Форма об успешной отправки сообщения
                        Swal.fire({
                            title: "Успешно!",
                            text: "Вы успешно подписались!",
                            icon: "success",
                            timer: 5000,
                            showConfirmButton: true,
                            confirmButtonText: "ОК",
                            customClass: {
                                confirmButton: "swal-confirm-button"
                            }
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }

    // Переключение между tabs калькуляторами доставки 
    const tabs = document.querySelectorAll(".tabs-delivery__btn");
    const contents = document.querySelectorAll(".tab-content");

    // Проверка на наличие переключателей
    if (tabs.length > 0 && contents.length > 0) {

        // Функция для переключения вкладок
        function switchTab(tabId) {
            tabs.forEach(t => t.classList.remove("active"));
            contents.forEach(c => c.classList.remove("active"));

            const activeTab = document.querySelector(`.tabs-delivery__btn[data-tab="${tabId}"]`);
            const activeContent = document.getElementById(tabId);

            if (activeTab && activeContent) {
                activeTab.classList.add("active");
                activeContent.classList.add("active");

                // Сохраняем выбранную вкладку в localStorage
                localStorage.setItem("activeTab", tabId);
            }
        }

        // Проверяем, есть ли сохраненная вкладка в localStorage
        const savedTab = localStorage.getItem("activeTab");
        if (savedTab && document.getElementById(savedTab)) {
            switchTab(savedTab);
        } else {
            // Если в хранилище ничего нет, активируем первую вкладку по умолчанию
            switchTab(tabs[0].getAttribute("data-tab"));
        }

        // Перебираем все кнопки
        tabs.forEach(tab => {
            // Клик по кнопке
            tab.addEventListener("click", () => {
                let tabId = tab.getAttribute("data-tab");
                switchTab(tabId);
            });
        });
    }

    // Отправка формы чтобы узнать наличие цены на сайте
    const formAvailab = document.querySelector(".availability-form");

    // Проверка на наличие формы
    if (formAvailab) {
        formAvailab.addEventListener("submit", (event) => {
        // Останавливаю стандартное поведение формы
        event.preventDefault();

        // Переменные формы
        const availNameLabel = document.getElementById("availNameLabel");
        const availName = document.getElementById("availName");

        const availEmailLabel = document.getElementById("availEmailLabel");
        const availEmail = document.getElementById("availEmail");

        const availMessageLabel = document.getElementById("availMessageLabel");
        const availMessage = document.getElementById("availMessage");

        // Флажок для валидации
        let isValid = true;

        if(availName.value.trim() === "") {
            availNameLabel.classList.add("error");
            availName.classList.add("error");
            isValid = false;
        } else {
            availNameLabel.classList.remove("error");
            availName.classList.remove("error");
        }

        if(availEmail.value.trim() === "") {
            availEmailLabel.classList.add("error");
            availEmail.classList.add("error");
            isValid = false;
        } else {
            availEmailLabel.classList.remove("error");
            availEmail.classList.remove("error");
        }

        if(availMessage.value.trim() === "") {
            availMessageLabel.classList.add("error");
            availMessage.classList.add("error");
            isValid = false;
        } else {
            availMessageLabel.classList.remove("error");
            availMessage.classList.remove("error");
        }

        // Если ошибок нет, то отправлять форму
        if (isValid) {
            // Отправляю запрос на сервер
            fetch("/wp-admin/admin-ajax.php", {
               method: "POST",
               body: new URLSearchParams({
                   action: "available_to_stock",
                   name: availName.value,
                   email: availEmail.value,
                   message: availMessage.value,
               }),
           })
           .then(response => response.json())
           .then(data => {
               // Если все успешно, то ...
               if (data.success) {
                   // Очищаем форму
                   formAvailab.reset();
                   // Удаляю все классы об успешной отправки
                   document.querySelectorAll(".availability-form input").forEach(field => {
                       field.classList.remove("error");
                   });
                   // Форма об успешной отправки сообщения
                   Swal.fire({
                       title: "Успешно!",
                       text: "Ваш запрос успешно отправлен! Наши менеджеры скоро свяжутся с вами.",
                       icon: "success",
                       timer: 5000,
                       showConfirmButton: true,
                       confirmButtonText: "ОК",
                       customClass: {
                           confirmButton: "swal-confirm-button"
                       }
                   });
               }
           })
           .catch(error => console.error('Error:', error));
       }

        });
    }

    // Открытие попапа "Заказать услугу"
    const servicesBtn = document.querySelectorAll(".services__btn");
    const servicesBtnClose = document.querySelector(".services-popup__btn-close");
    const popupService = document.querySelector(".services-popup");
    const overlay = document.getElementById("overlay");

    // Функция закрытия попапа
    function closePopup() {
        popupService.classList.remove("open");
        overlay.classList.remove("active");
        document.body.classList.remove("no-scroll");
    }

    // Открытие попапа по клику на кнопку
    servicesBtn.forEach((item) => {
        item.addEventListener("click", () => {
            popupService.classList.add("open");
            overlay.classList.add("active");
            document.body.classList.add("no-scroll");
        });
    });

    // Закрытие по крестику
    if (servicesBtnClose) {
        servicesBtnClose.addEventListener("click", closePopup);
    }

    // Закрытие при клике за пределы попапа (на overlay)
    overlay.addEventListener("click", closePopup);

    // Отправка формы с попап для услуг
    const servicesForm = document.querySelector(".services-popup__form");

    // Проверка на наличие формы
    if (servicesForm) {
        servicesForm.addEventListener("submit", (event) => {
        // Останавливаю стандартное поведение формы
        event.preventDefault();

        // Переменные формы
        const servicesName = document.getElementById("servicesName");

        const servicesPhone = document.getElementById("servicesPhone");

        const servicesEmail = document.getElementById("servicesEmail");

        const servicesMessage = document.getElementById("servicesMessage");

        // Флажок для валидации
        let isValid = true;

        if(servicesName.value.trim() === "") {
            servicesName.classList.add("error");
            isValid = false;
        } else {
            servicesName.classList.remove("error");
        }

        if(servicesPhone.value.trim() === "") {
            servicesPhone.classList.add("error");
            isValid = false;
        } else {
            servicesPhone.classList.remove("error");
        }


        // Если ошибок нет, то отправлять форму
        if (isValid) {
            // Отправляю запрос на сервер
            fetch("/wp-admin/admin-ajax.php", {
               method: "POST",
               body: new URLSearchParams({
                   action: "services_send_mail",
                   name: servicesName.value,
                   phone: servicesPhone.value,
                   email: servicesEmail.value,
                   message: servicesMessage.value,
               }),
           })
           .then(response => response.json())
           .then(data => {
               // Если все успешно, то ...
               if (data.success) {
                   // Очищаем форму
                   servicesForm.reset();
                   // Удаляю все классы об успешной отправки
                   document.querySelectorAll(".services-popup__form input").forEach(field => {
                       field.classList.remove("error");
                   });
                   popupService.classList.remove("open");
                   overlay.classList.remove("active");
                   // Форма об успешной отправки сообщения
                   Swal.fire({
                       title: "Успешно!",
                       text: "Ваш запрос успешно отправлен! Наши менеджеры скоро свяжутся с вами.",
                       icon: "success",
                       timer: 5000,
                       showConfirmButton: true,
                       confirmButtonText: "ОК",
                       customClass: {
                            confirmButton: "swal-confirm-button"
                       }
                   });
               }
           })
           .catch(error => console.error('Error:', error));
       }

        });
    }


});
