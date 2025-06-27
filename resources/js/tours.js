/**
 * Система пошагового обучения для платформы ремонта
 * Подробные туры для всех страниц с обязательным прохождением для клиентов
 */

// Импортируем Intro.js
import introJs from 'intro.js';

// Функция для определения роли пользователя
function getUserRole() {
    // Получаем роль из data-атрибута на body или другом элементе
    const userRole = document.body.dataset.userRole || '';
    return userRole;
}

// Базовые настройки для всех туров
const tourDefaults = {
    nextLabel: 'Далее',
    prevLabel: 'Назад',

    doneLabel: 'Готово',
    showStepNumbers: true,
    showBullets: true,
    showProgress: true,
    scrollToElement: true,
    disableInteraction: false,
    exitOnOverlayClick: false,
    exitOnEsc: false,
    hidePrev: true,
    hideNext: false
};

// Базовые настройки для обязательных туров (для клиентов)
const mandatoryTourDefaults = {
    ...tourDefaults,
    skipLabel: '', // Скрываем кнопку пропуска для клиентов
    exitOnOverlayClick: false,
    exitOnEsc: false,
    tooltipClass: 'client-tour',
};

// Тур для партнёров на главной странице (dashboard)
const partnerDashboardTour = [
    {
        intro: '<h4>Добро пожаловать в панель управления!</h4><p>Сейчас мы проведем для вас подробное обучение по использованию системы. Это обучение поможет вам эффективно работать с проектами, сметами и клиентами.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '#sidebar, .sidebar',
        intro: '<h4>Боковое меню</h4><p>Основная навигация по системе. Здесь расположены все разделы:</p><ul><li><strong>Главная</strong> - общая статистика и последние проекты</li><li><strong>Проекты</strong> - управление вашими проектами</li><li><strong>Сметы</strong> - создание и редактирование смет</li><li><strong>Сотрудники</strong> - управление командой</li><li><strong>Калькулятор</strong> - расчёт материалов и работ</li><li><strong>Настройки</strong> - конфигурация системы</li></ul><p>Меню адаптивно и может сворачиваться на мобильных устройствах.</p>',
        position: 'right',
        tooltipClass: 'intro-sidebar'
    },
    {
        element: '.stats-cards, .dashboard-stats',
        intro: '<h4>Статистические карточки</h4><p>Быстрый обзор ваших ключевых показателей:</p><ul><li><strong>Активные проекты</strong> - количество проектов в работе</li><li><strong>Завершенные проекты</strong> - выполненные за период</li><li><strong>Общий доход</strong> - финансовые показатели</li><li><strong>Количество клиентов</strong> - база заказчиков</li></ul><p>Данные обновляются в реальном времени.</p>',
        position: 'bottom',
        tooltipClass: 'intro-stats'
    },
    {
        element: '.recent-projects, .project-list',
        intro: '<h4>Последние проекты</h4><p>Список ваших недавних проектов с кратким статусом:</p><ul><li>Название проекта и номер</li><li>Информация о клиенте</li><li>Текущий статус выполнения</li><li>Даты начала и планируемого завершения</li><li>Прогресс-бар выполнения</li></ul><p>Нажмите на любой проект для перехода к детальному просмотру.</p>',
        position: 'top',
        tooltipClass: 'intro-projects'
    },
    {
        element: '.btn-create-project, .create-project-btn',
        intro: '<h4>Создание нового проекта</h4><p>Кнопка для создания нового проекта. При нажатии откроется форма с полями:</p><ul><li>Название проекта</li><li>Выбор или создание клиента</li><li>Описание работ и требований</li><li>Планируемые даты начала и окончания</li><li>Адрес объекта</li><li>Бюджет проекта</li></ul><p>Все поля можно будет отредактировать позже.</p>',
        position: 'bottom',
        tooltipClass: 'intro-action-button'
    },
    {
        element: '.notifications, .notification-bell',
        intro: '<h4>Центр уведомлений</h4><p>Здесь отображаются важные события и оповещения:</p><ul><li>Новые сообщения от клиентов</li><li>Изменения статусов проектов</li><li>Приближающиеся дедлайны</li><li>Системные уведомления</li><li>Уведомления о платежах</li></ul><p>Красная точка показывает количество непрочитанных уведомлений.</p>',
        position: 'left',
        tooltipClass: 'intro-notifications'
    },
    {
        element: '.profile-menu, .user-dropdown',
        intro: '<h4>Меню профиля</h4><p>Доступ к личным настройкам и функциям:</p><ul><li>Просмотр и редактирование профиля</li><li>Изменение пароля</li><li>Настройки уведомлений</li><li>Настройки безопасности</li><li>Выход из системы</li></ul>',
        position: 'left',
        tooltipClass: 'intro-profile'
    },
    {
        element: '.help-tour-button',
        intro: '<h4>Кнопка помощи</h4><p>Эта кнопка всегда доступна для повторного прохождения обучения. Если вы забудете, как пользоваться какой-то функцией, просто нажмите на неё.</p><p>На каждой странице доступно своё обучение, адаптированное под конкретный функционал.</p>',
        position: 'left',
        tooltipClass: 'intro-help-button'
    }
];

// Тур для списка проектов партнёра
const partnerProjectsListTour = [
    {
        intro: '<h4>Управление проектами</h4><p>Добро пожаловать на страницу управления проектами! Здесь вы можете просматривать, создавать и управлять всеми вашими проектами.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.projects-filter, .filter-panel',
        intro: '<h4>Фильтры проектов</h4><p>Используйте фильтры для быстрого поиска нужных проектов:</p><ul><li><strong>По статусу</strong> - новые, в работе, завершенные</li><li><strong>По клиенту</strong> - все проекты конкретного заказчика</li><li><strong>По датам</strong> - проекты за определенный период</li><li><strong>По сумме</strong> - диапазон бюджета проекта</li></ul><p>Комбинируйте фильтры для точного поиска.</p>',
        position: 'bottom',
        tooltipClass: 'intro-filters'
    },
    {
        element: '.projects-table, .projects-grid',
        intro: '<h4>Список проектов</h4><p>Таблица со всеми вашими проектами и ключевой информацией:</p><ul><li><strong>Номер проекта</strong> - уникальный идентификатор</li><li><strong>Название</strong> - описание проекта</li><li><strong>Клиент</strong> - заказчик</li><li><strong>Статус</strong> - текущее состояние</li><li><strong>Бюджет</strong> - стоимость проекта</li><li><strong>Даты</strong> - сроки выполнения</li><li><strong>Прогресс</strong> - процент завершения</li></ul>',
        position: 'top',
        tooltipClass: 'intro-projects-table'
    },
    {
        element: '.project-actions, .actions-column',
        intro: '<h4>Действия с проектами</h4><p>Для каждого проекта доступны быстрые действия:</p><ul><li><strong>Просмотр</strong> - переход к детальной странице</li><li><strong>Редактирование</strong> - изменение параметров</li><li><strong>Копирование</strong> - создание копии проекта</li><li><strong>Архивирование</strong> - перемещение в архив</li><li><strong>Удаление</strong> - окончательное удаление</li></ul>',
        position: 'left',
        tooltipClass: 'intro-project-actions'
    },
    {
        element: '.btn-create-project',
        intro: '<h4>Создать новый проект</h4><p>Нажмите эту кнопку, чтобы создать новый проект. Откроется пошаговый мастер создания с разделами:</p><ul><li>Основная информация о проекте</li><li>Данные клиента</li><li>Техническое задание</li><li>Планирование и бюджет</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-create-project'
    }
];

// Тур для списка смет партнёра
const partnerEstimatesListTour = [
    {
        intro: '<h4>Управление сметами</h4><p>На этой странице вы можете создавать, редактировать и управлять всеми сметами ваших проектов.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.estimates-filter',
        intro: '<h4>Фильтры смет</h4><p>Фильтрация смет по различным критериям:</p><ul><li><strong>По проекту</strong> - сметы конкретного проекта</li><li><strong>По статусу</strong> - черновик, на согласовании, утверждена</li><li><strong>По датам</strong> - период создания/обновления</li><li><strong>По сумме</strong> - диапазон стоимости</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-estimates-filter'
    },
    {
        element: '.estimates-table',
        intro: '<h4>Список смет</h4><p>Таблица со всеми сметами содержит:</p><ul><li><strong>Номер сметы</strong> - уникальный номер документа</li><li><strong>Название</strong> - описание сметы</li><li><strong>Проект</strong> - к какому проекту относится</li><li><strong>Статус</strong> - стадия согласования</li><li><strong>Общая сумма</strong> - итоговая стоимость</li><li><strong>Дата создания/изменения</strong></li></ul>',
        position: 'top',
        tooltipClass: 'intro-estimates-table'
    },
    {
        element: '.estimate-actions',
        intro: '<h4>Действия со сметами</h4><p>Доступные операции для каждой сметы:</p><ul><li><strong>Просмотр</strong> - открыть смету для просмотра</li><li><strong>Редактирование</strong> - изменить содержание</li><li><strong>Копирование</strong> - создать копию сметы</li><li><strong>Экспорт в PDF</strong> - скачать документ</li><li><strong>Отправка клиенту</strong> - уведомление о готовности</li></ul>',
        position: 'left',
        tooltipClass: 'intro-estimate-actions'
    },
    {
        element: '.btn-create-estimate',
        intro: '<h4>Создать новую смету</h4><p>Кнопка для создания новой сметы. Процесс включает:</p><ul><li>Выбор проекта</li><li>Выбор шаблона сметы</li><li>Добавление позиций работ</li><li>Указание материалов и их стоимости</li><li>Расчет итоговой суммы</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-create-estimate'
    }
];

// Тур для страницы сотрудников
const partnerEmployeesTour = [
    {
        intro: '<h4>Управление сотрудниками</h4><p>Страница для управления вашей командой и распределения ролей в проектах.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.employees-list',
        intro: '<h4>Список сотрудников</h4><p>Здесь отображаются все члены вашей команды:</p><ul><li><strong>Фото и имя</strong> сотрудника</li><li><strong>Должность</strong> и специализация</li><li><strong>Контактные данные</strong> - телефон, email</li><li><strong>Статус</strong> - активен, в отпуске, уволен</li><li><strong>Текущие проекты</strong> - на каких проектах работает</li></ul>',
        position: 'top',
        tooltipClass: 'intro-employees-list'
    },
    {
        element: '.employee-roles',
        intro: '<h4>Роли и права доступа</h4><p>Каждому сотруднику можно назначить роль:</p><ul><li><strong>Администратор</strong> - полный доступ к системе</li><li><strong>Менеджер проектов</strong> - управление проектами</li><li><strong>Сметчик</strong> - работа со сметами</li><li><strong>Мастер</strong> - выполнение работ</li><li><strong>Наблюдатель</strong> - только просмотр</li></ul>',
        position: 'right',
        tooltipClass: 'intro-employee-roles'
    },
    {
        element: '.btn-add-employee',
        intro: '<h4>Добавить сотрудника</h4><p>Кнопка для приглашения нового сотрудника в команду. Нужно указать:</p><ul><li>Личные данные сотрудника</li><li>Email для отправки приглашения</li><li>Назначаемую роль</li><li>Проекты, к которым предоставить доступ</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-add-employee'
    }
];

// Тур для калькулятора
const partnerCalculatorTour = [
    {
        intro: '<h4>Калькулятор материалов и работ</h4><p>Инструмент для быстрого расчета стоимости материалов и работ по различным видам ремонта.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.calculator-categories',
        intro: '<h4>Категории работ</h4><p>Выберите тип работ для расчета:</p><ul><li><strong>Отделочные работы</strong> - шпаклевка, покраска, поклейка обоев</li><li><strong>Сантехнические работы</strong> - замена труб, установка сантехники</li><li><strong>Электромонтажные работы</strong> - проводка, розетки, освещение</li><li><strong>Напольные покрытия</strong> - ламинат, плитка, паркет</li></ul>',
        position: 'right',
        tooltipClass: 'intro-calculator-categories'
    },
    {
        element: '.calculator-form',
        intro: '<h4>Форма расчета</h4><p>Введите параметры для расчета:</p><ul><li><strong>Площадь помещения</strong> - в квадратных метрах</li><li><strong>Высота потолков</strong> - для расчета стен</li><li><strong>Сложность работ</strong> - стандарт, премиум, VIP</li><li><strong>Дополнительные услуги</strong> - демонтаж, вывоз мусора</li></ul>',
        position: 'left',
        tooltipClass: 'intro-calculator-form'
    },
    {
        element: '.calculator-results',
        intro: '<h4>Результаты расчета</h4><p>Здесь отображается детальная смета с разбивкой по:</p><ul><li>Стоимости материалов</li><li>Стоимости работ</li><li>Общей сумме проекта</li><li>Сроках выполнения</li></ul><p>Результаты можно сохранить как шаблон сметы.</p>',
        position: 'top',
        tooltipClass: 'intro-calculator-results'
    }
];

// Тур для создания сметы
const partnerEstimateCreateTour = [
    {
        intro: '<h4>Создание новой сметы</h4><p>Пошаговый процесс создания детальной сметы для проекта.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.estimate-header',
        intro: '<h4>Заголовок сметы</h4><p>Основная информация о смете:</p><ul><li><strong>Номер сметы</strong> - генерируется автоматически</li><li><strong>Название</strong> - краткое описание</li><li><strong>Проект</strong> - выбор из списка проектов</li><li><strong>Дата создания</strong> - текущая дата</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-estimate-header'
    },
    {
        element: '.estimate-items',
        intro: '<h4>Позиции сметы</h4><p>Список работ и материалов:</p><ul><li><strong>Наименование</strong> - описание работы/материала</li><li><strong>Единица измерения</strong> - м², шт., м.п.</li><li><strong>Количество</strong> - объем работ</li><li><strong>Цена за единицу</strong> - стоимость</li><li><strong>Общая сумма</strong> - автоматический расчет</li></ul>',
        position: 'right',
        tooltipClass: 'intro-estimate-items'
    },
    {
        element: '.btn-add-item',
        intro: '<h4>Добавить позицию</h4><p>Кнопка для добавления новой строки в смету. Можно:</p><ul><li>Выбрать из справочника работ</li><li>Добавить материал из каталога</li><li>Создать собственную позицию</li><li>Импортировать из шаблона</li></ul>',
        position: 'left',
        tooltipClass: 'intro-add-item'
    },
    {
        element: '.estimate-totals',
        intro: '<h4>Итоговые суммы</h4><p>Автоматический расчет итогов сметы:</p><ul><li><strong>Материалы</strong> - сумма всех материалов</li><li><strong>Работы</strong> - стоимость работ</li><li><strong>Накладные расходы</strong> - процент от общей суммы</li><li><strong>Итого</strong> - финальная сумма проекта</li></ul>',
        position: 'top',
        tooltipClass: 'intro-estimate-totals'
    }
];

// Тур по странице проекта для партнёров
const partnerProjectTour = [
    {
        intro: '<h4>Страница управления проектом</h4><p>Добро пожаловать на страницу управления проектом! Здесь вы можете контролировать все аспекты работы над проектом. Пройдите все шаги обучения, чтобы эффективно использовать все возможности.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.project-info-card',
        intro: '<h4>Карточка проекта</h4><p>Здесь представлена основная информация:</p><ul><li><strong>Название проекта</strong> и его уникальный номер</li><li><strong>Клиент</strong> - заказчик данного проекта</li><li><strong>Статус</strong> - текущее состояние работы</li><li><strong>Даты</strong> - сроки начала и завершения</li><li><strong>Адрес объекта</strong></li><li><strong>Площадь</strong> и другие технические параметры</li></ul>',
        position: 'right',
        tooltipClass: 'intro-project-info'
    },
    {
        element: '.project-actions',
        intro: '<h4>Управление проектом</h4><p>Кнопки для основных действий с проектом:</p><ul><li><strong>Редактировать</strong> - изменение информации о проекте</li><li><strong>Печать</strong> - экспорт в PDF</li><li><strong>Поделиться</strong> - отправка ссылки другим участникам</li><li><strong>Архивировать</strong> - перемещение завершенного проекта в архив</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-project-actions'
    },
    {
        element: '.project-tabs',
        intro: '<h4>Вкладки проекта</h4><p>Используйте эти вкладки для доступа к различным аспектам проекта:</p><ul><li><strong>Обзор</strong> - общая информация и статус</li><li><strong>Файлы</strong> - документы, чертежи, планы</li><li><strong>Фотографии</strong> - изображения объекта и прогресс работ</li><li><strong>Сметы</strong> - финансовые документы и расчёты</li><li><strong>График работ</strong> - план и сроки выполнения этапов</li><li><strong>Финансы</strong> - бюджет и транзакции</li><li><strong>Чеклисты</strong> - контроль выполнения задач</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-project-tabs'
    },
    {
        element: '.project-status-dropdown',
        intro: '<h4>Статус проекта</h4><p>В этом выпадающем меню вы можете изменить текущий статус проекта:</p><ul><li><strong>Новый</strong> - только что созданный проект</li><li><strong>В работе</strong> - проект в активной фазе</li><li><strong>На согласовании</strong> - ожидает решения клиента</li><li><strong>Завершен</strong> - все работы выполнены</li><li><strong>Отменен</strong> - проект не будет реализован</li></ul><p>При изменении статуса клиент получит уведомление.</p>',
        position: 'left',
        tooltipClass: 'intro-project-status'
    },
    {
        element: '.project-schedule-container',
        intro: '<h4>График работ</h4><p>В этом разделе вы планируете и отслеживаете выполнение работ:</p><ul><li>Создавайте этапы проекта с конкретными датами</li><li>Назначайте ответственных исполнителей</li><li>Отмечайте процент выполнения задач</li><li>Добавляйте комментарии к каждому этапу</li></ul><p>График автоматически рассчитывает общий прогресс проекта.</p>',
        position: 'top',
        tooltipClass: 'intro-project-schedule'
    },
    {
        element: '.project-communication',
        intro: '<h4>Общение с клиентом</h4><p>Здесь находятся инструменты для коммуникации:</p><ul><li><strong>Чат</strong> - обмен сообщениями с клиентом</li><li><strong>Комментарии</strong> - обсуждение конкретных элементов проекта</li><li><strong>Уведомления</strong> - автоматические оповещения о событиях</li></ul>',
        position: 'right',
        tooltipClass: 'intro-project-communication'
    }
];

// Тур по странице файлов проекта
const partnerProjectFilesTour = [
    {
        intro: '<h4>Управление файлами проекта</h4><p>В этом разделе вы можете хранить и организовывать все документы, связанные с проектом. Пройдите это обучение, чтобы научиться эффективно управлять файлами.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.files-categories',
        intro: '<h4>Категории файлов</h4><p>Файлы разделены на следующие категории для удобства:</p><ul><li><strong>Документы</strong> - договоры, акты, спецификации</li><li><strong>Чертежи</strong> - планы, схемы, разрезы</li><li><strong>Визуализации</strong> - 3D-модели и рендеры</li><li><strong>Фотографии</strong> - фото объекта</li><li><strong>Другое</strong> - прочие файлы</li></ul><p>Нажмите на категорию, чтобы увидеть только файлы из неё.</p>',
        position: 'top',
        tooltipClass: 'intro-file-categories'
    },
    {
        element: '.drop-zone',
        intro: '<h4>Загрузка файлов</h4><p>Есть два способа добавить файлы в проект:</p><ul><li>Перетащите файлы из проводника прямо в эту область</li><li>Нажмите на область и выберите файлы в открывшемся диалоговом окне</li></ul><p>Поддерживаются файлы размером до 50 МБ следующих форматов: PDF, DOC, XLS, JPG, PNG, DWG, SKP и др.</p>',
        position: 'bottom',
        tooltipClass: 'intro-file-upload'
    },
    {
        element: '.files-list',
        intro: '<h4>Список файлов</h4><p>Здесь отображаются все загруженные файлы с важной информацией:</p><ul><li><strong>Название файла</strong> и миниатюра</li><li><strong>Категория</strong> и тип файла</li><li><strong>Размер</strong> в мегабайтах</li><li><strong>Дата загрузки</strong></li><li><strong>Автор</strong> - кто загрузил файл</li></ul><p>Вы можете сортировать файлы по любому из этих параметров.</p>',
        position: 'right',
        tooltipClass: 'intro-files-list'
    },
    {
        element: '.files-search',
        intro: '<h4>Поиск файлов</h4><p>Используйте поисковую строку, чтобы найти нужный файл в проекте. Поиск работает по:</p><ul><li>Названию файла</li><li>Категории</li><li>Имени автора</li><li>Дате (в формате ДД.ММ.ГГГГ)</li></ul>',
        position: 'top',
        tooltipClass: 'intro-files-search'
    },
    {
        element: '.file-actions',
        intro: '<h4>Управление файлами</h4><p>Для каждого файла доступны следующие действия:</p><ul><li><strong>Просмотр</strong> - открытие файла в браузере без скачивания</li><li><strong>Скачать</strong> - сохранение файла на компьютер</li><li><strong>Переименовать</strong> - изменение названия файла</li><li><strong>Переместить</strong> - смена категории</li><li><strong>Поделиться</strong> - отправка ссылки на файл</li><li><strong>Удалить</strong> - удаление файла из проекта</li></ul>',
        position: 'left',
        tooltipClass: 'intro-file-actions'
    },
    {
        element: '.file-version-control',
        intro: '<h4>Управление версиями</h4><p>Система сохраняет предыдущие версии файлов, что позволяет:</p><ul><li>Просматривать историю изменений</li><li>Возвращаться к предыдущим версиям</li><li>Сравнивать разные версии документов</li></ul><p>Нажмите на иконку истории рядом с файлом, чтобы увидеть все его версии.</p>',
        position: 'bottom',
        tooltipClass: 'intro-version-control'
    }
];

// Тур по странице смет для партнёров
const partnerEstimatesTour = [
    {
        intro: '<h4>Управление сметами проекта</h4><p>Эта страница предназначена для создания и управления сметами по проекту. Следуйте инструкциям, чтобы научиться эффективно работать со сметами.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.estimates-list',
        intro: '<h4>Список смет</h4><p>Здесь представлены все сметы текущего проекта:</p><ul><li><strong>Название сметы</strong> и её уникальный номер</li><li><strong>Тип сметы</strong> (материалы, работы, комплексная)</li><li><strong>Сумма</strong> - итоговая стоимость</li><li><strong>Дата создания</strong> и последнего обновления</li><li><strong>Статус</strong> - черновик, согласованная, утвержденная</li></ul><p>Нажмите на любую смету для просмотра подробностей.</p>',
        position: 'right',
        tooltipClass: 'intro-estimates-list'
    },
    {
        element: '.estimates-filter',
        intro: '<h4>Фильтрация смет</h4><p>Используйте эти параметры для фильтрации списка смет:</p><ul><li><strong>По типу</strong> - материалы, работы, комплексная</li><li><strong>По статусу</strong> - черновик, согласованная, утвержденная</li><li><strong>По периоду</strong> - даты создания/обновления</li></ul><p>Вы также можете включить архивные сметы или показывать только актуальные версии.</p>',
        position: 'top',
        tooltipClass: 'intro-estimates-filter'
    },
    {
        element: '.btn-create-estimate',
        intro: '<h4>Создание сметы</h4><p>Эта кнопка открывает форму создания новой сметы. Вам потребуется указать:</p><ul><li><strong>Название сметы</strong></li><li><strong>Тип</strong> (материалы, работы или комплексная)</li><li><strong>Шаблон</strong> для быстрого заполнения</li><li><strong>Валюту</strong> и другие параметры</li></ul><p>После создания вы сможете добавлять позиции в смету.</p>',
        position: 'bottom',
        tooltipClass: 'intro-create-estimate'
    },
    {
        element: '.estimate-template-dropdown',
        intro: '<h4>Шаблоны смет</h4><p>Выберите подходящий шаблон для ускорения создания сметы:</p><ul><li><strong>Базовый ремонт</strong> - стандартные работы</li><li><strong>Капитальный ремонт</strong> - полный комплекс работ</li><li><strong>Дизайнерский ремонт</strong> - эксклюзивные материалы</li><li><strong>Отделка новостройки</strong> - работы с нуля</li><li><strong>Материалы</strong> - только расходные материалы</li></ul><p>Вы также можете загрузить собственный шаблон.</p>',
        position: 'bottom',
        tooltipClass: 'intro-template-dropdown'
    },
    {
        element: '.estimate-actions',
        intro: '<h4>Действия со сметой</h4><p>Для каждой сметы доступны следующие операции:</p><ul><li><strong>Просмотр</strong> - детальная информация по смете</li><li><strong>Редактирование</strong> - изменение позиций и параметров</li><li><strong>Экспорт в Excel</strong> - выгрузка в формате таблицы</li><li><strong>Экспорт в PDF</strong> - создание документа для печати</li><li><strong>Отправка клиенту</strong> - согласование сметы</li><li><strong>Дублирование</strong> - создание копии</li><li><strong>Архивирование</strong> - перемещение в архив</li></ul>',
        position: 'left',
        tooltipClass: 'intro-estimate-actions'
    },
    {
        element: '.estimate-summary',
        intro: '<h4>Итоги по сметам</h4><p>В этом блоке отображается сводная информация:</p><ul><li><strong>Общая сумма</strong> - итог по всем сметам</li><li><strong>Оплачено</strong> - сумма внесенных средств</li><li><strong>Осталось</strong> - необходимый платеж</li><li><strong>Предстоящие платежи</strong> - график внесения оплаты</li></ul><p>Система автоматически рассчитывает все показатели.</p>',
        position: 'bottom',
        tooltipClass: 'intro-estimate-summary'
    }
];


// Тур для клиентов на главной странице
const clientDashboardTour = [
    {
        intro: '<h4>Добро пожаловать в личный кабинет!</h4><p>Вас приветствует система управления проектами дизайна и ремонта. Сейчас мы проведем короткое обучение, которое поможет вам освоиться в системе. Это обязательный тур, который необходимо пройти для полноценной работы с платформой.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '#sidebar',
        intro: '<h4>Навигационное меню</h4><p>Здесь расположены основные разделы личного кабинета:</p><ul><li><strong>Главная</strong> - обзор всех проектов</li><li><strong>Проекты</strong> - ваши текущие и завершенные проекты</li><li><strong>Документы</strong> - договоры и акты</li><li><strong>Сообщения</strong> - общение с дизайнерами</li><li><strong>Настройки</strong> - управление вашим аккаунтом</li></ul>',
        position: 'right',
        tooltipClass: 'intro-client-sidebar'
    },
    {
        element: '.project-list-container',
        intro: '<h4>Ваши проекты</h4><p>Здесь представлены все ваши активные проекты с дизайн-студией:</p><ul><li>Название и текущий статус проекта</li><li>Прогресс выполнения работ</li><li>Даты начала и планируемого завершения</li><li>Ответственный дизайнер/менеджер</li></ul><p>Нажмите на любой проект, чтобы увидеть подробную информацию о нём.</p>',
        position: 'right',
        tooltipClass: 'intro-client-projects'
    },
    {
        element: '.project-status-summary',
        intro: '<h4>Обзор статусов проектов</h4><p>Эта секция показывает общий прогресс по всем вашим проектам:</p><ul><li>Текущая стадия работ по каждому проекту</li><li>Ближайшие запланированные события</li><li>Необходимые согласования с вашей стороны</li></ul><p>Элементы, требующие вашего внимания, выделены оранжевым цветом.</p>',
        position: 'bottom',
        tooltipClass: 'intro-status-summary'
    },
    {
        element: '.notifications-bell',
        intro: '<h4>Центр уведомлений</h4><p>Здесь собраны все важные оповещения:</p><ul><li>Новые файлы и документы в проекте</li><li>Сообщения от дизайнеров и менеджеров</li><li>Изменения статусов проекта</li><li>Запросы на согласование смет и этапов</li></ul><p>Красная точка означает наличие непрочитанных уведомлений.</p>',
        position: 'left',
        tooltipClass: 'intro-client-notifications'
    },
    {
        element: '.profile-dropdown',
        intro: '<h4>Ваш профиль</h4><p>В этом меню вы можете:</p><ul><li>Просматривать и редактировать личные данные</li><li>Изменять пароль и контактную информацию</li><li>Настраивать способы уведомлений</li><li>Выйти из системы</li></ul><p>Регулярно обновляйте ваши контактные данные для бесперебойной коммуникации.</p>',
        position: 'left',
        tooltipClass: 'intro-client-profile'
    },
    {
        element: '.upcoming-events',
        intro: '<h4>Ближайшие события</h4><p>Календарь отображает запланированные встречи и важные даты:</p><ul><li>Встречи с дизайнером или менеджером</li><li>Даты согласования этапов проекта</li><li>Сроки оплаты по договору</li><li>Плановые проверки выполненных работ</li></ul>',
        position: 'right',
        tooltipClass: 'intro-upcoming-events'
    },
    {
        element: '.help-tour-button',
        intro: '<h4>Кнопка помощи</h4><p>Если вам понадобится повторить обучение или вы забудете, как использовать какой-либо функционал системы, всегда можно нажать на эту кнопку для запуска тура заново.</p>',
        position: 'left',
        tooltipClass: 'intro-help-button'
    }
];

// Тур по странице проекта для клиентов
const clientProjectTour = [
    {
        intro: 'Добро пожаловать на страницу вашего проекта! Здесь вы можете следить за прогрессом работ и просматривать файлы.'
    },
    {
        element: '.project-info-card',
        intro: 'Здесь отображается основная информация о вашем проекте.',
        position: 'right'
    },
    {
        element: '.project-tabs',
        intro: 'Используйте эти вкладки для просмотра различных аспектов проекта: файлы, фотографии, сметы и т.д.',
        position: 'bottom'
    },
    {
        element: '.project-progress',
        intro: 'Здесь вы можете видеть текущий прогресс по вашему проекту.',
        position: 'top'
    },
    {
        element: '.project-chat',
        intro: 'Используйте этот чат для общения с вашим дизайнером.',
        position: 'left'
    }
];

// Тур по странице смет для клиентов
const clientEstimatesTour = [
    {
        intro: 'На этой странице вы можете просматривать сметы по вашему проекту.'
    },
    {
        element: '.estimates-list',
        intro: 'Здесь отображаются все сметы по вашему проекту.',
        position: 'right'
    },
    {
        element: '.estimate-details',
        intro: 'Нажмите на смету, чтобы увидеть подробную информацию.',
        position: 'bottom'
    },
    {
        element: '.estimate-download-btn',
        intro: 'Нажмите эту кнопку, чтобы скачать смету в формате Excel или PDF.',
        position: 'left'
    }
];

// Тур по странице редактирования сметы
const partnerEstimateEditTour = [
    {
        intro: '<h4>Редактирование сметы</h4><p>На этой странице вы можете внести изменения в существующую смету. Следуйте инструкции, чтобы научиться эффективно редактировать сметы.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.estimate-header',
        intro: '<h4>Заголовок сметы</h4><p>Здесь отображается основная информация о смете и доступны действия:</p><ul><li><strong>Название сметы</strong> и её уникальный номер</li><li><strong>Проект</strong>, к которому привязана смета</li><li><strong>Дата создания</strong> и последнего обновления</li><li><strong>Статус</strong> - черновик, согласованная, утвержденная</li></ul>',
        position: 'top',
        tooltipClass: 'intro-estimate-header'
    },
    {
        element: '.estimate-summary',
        intro: '<h4>Сводная информация</h4><p>В этом блоке отображаются финансовые итоги по смете:</p><ul><li><strong>Общая стоимость</strong> работ и материалов</li><li><strong>Сумма налогов</strong> (НДС или другие)</li><li><strong>Скидки</strong> и дополнительные коэффициенты</li><li><strong>Итоговая сумма</strong> к оплате</li></ul><p>Все расчеты производятся автоматически при изменении позиций.</p>',
        position: 'right',
        tooltipClass: 'intro-estimate-summary'
    },
    {
        element: '.estimate-items',
        intro: '<h4>Таблица позиций</h4><p>Здесь представлены все работы и материалы, входящие в смету:</p><ul><li><strong>Наименование</strong> - название работы или материала</li><li><strong>Единица измерения</strong> - штуки, м², м³ и т.д.</li><li><strong>Количество</strong> - объем работ или материалов</li><li><strong>Цена</strong> - стоимость за единицу</li><li><strong>Сумма</strong> - рассчитывается автоматически</li><li><strong>Примечания</strong> - дополнительная информация</li></ul>',
        position: 'right',
        tooltipClass: 'intro-estimate-items'
    },
    {
        element: '.add-item-btn',
        intro: '<h4>Добавление позиций</h4><p>Нажмите эту кнопку, чтобы добавить новую позицию в смету. Вы можете:</p><ul><li>Добавить позицию вручную, заполнив все поля</li><li>Выбрать из каталога стандартных работ и материалов</li><li>Импортировать из других смет или шаблонов</li></ul><p>Новая позиция будет добавлена в конец текущего раздела.</p>',
        position: 'bottom',
        tooltipClass: 'intro-add-item'
    },
    {
        element: '.edit-item-btn',
        intro: '<h4>Редактирование позиций</h4><p>Используйте эту кнопку для изменения существующей позиции в смете:</p><ul><li>Исправление наименования или единицы измерения</li><li>Корректировка количества или цены</li><li>Добавление дополнительной информации</li><li>Применение индивидуальных скидок или коэффициентов</li></ul>',
        position: 'left',
        tooltipClass: 'intro-edit-item'
    },
    {
        element: '.remove-item-btn',
        intro: '<h4>Удаление позиций</h4><p>Нажатие на эту кнопку удалит выбранную позицию из сметы. Важно:</p><ul><li>При удалении система запросит подтверждение</li><li>Вместе с позицией будут удалены все связанные данные</li><li>Эта операция не может быть отменена</li></ul>',
        position: 'left',
        tooltipClass: 'intro-remove-item'
    },
    {
        element: '.section-management',
        intro: '<h4>Управление разделами</h4><p>Здесь вы можете организовать структуру сметы:</p><ul><li><strong>Добавление</strong> новых разделов</li><li><strong>Переименование</strong> существующих разделов</li><li><strong>Изменение порядка</strong> - перетаскивание секций</li><li><strong>Удаление</strong> пустых разделов</li></ul>',
        position: 'top',
        tooltipClass: 'intro-section-management'
    },
    {
        element: '.save-estimate-btn',
        intro: '<h4>Сохранение сметы</h4><p>После внесения всех изменений нажмите эту кнопку, чтобы сохранить смету. Возможные действия:</p><ul><li><strong>Сохранить изменения</strong> - обновить текущую смету</li><li><strong>Сохранить как новую версию</strong> - создать новую редакцию</li><li><strong>Сохранить как шаблон</strong> - для использования в будущих сметах</li></ul>',
        position: 'top',
        tooltipClass: 'intro-save-changes'
    },
    {
        element: '.export-estimate-btn',
        intro: '<h4>Экспорт сметы</h4><p>Эта кнопка позволяет выгрузить смету в различных форматах:</p><ul><li><strong>Excel</strong> - для дальнейшего редактирования</li><li><strong>PDF</strong> - для печати или отправки клиенту</li><li><strong>HTML</strong> - для просмотра в браузере</li><li><strong>Экспорт в 1С</strong> - для бухгалтерского учета</li></ul><p>Выберите нужный формат в выпадающем меню.</p>',
        position: 'left',
        tooltipClass: 'intro-export-estimate'
    }
];

// Тур по странице фотографий проекта
const partnerProjectPhotosTour = [
    {
        intro: '<h4>Фотографии проекта</h4><p>В этом разделе собраны все фотографии, связанные с проектом. Следуйте инструкциям, чтобы эффективно управлять визуальным контентом.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.photos-gallery',
        intro: '<h4>Галерея фотографий</h4><p>Здесь отображаются все фотографии проекта:</p><ul><li><strong>Фото до начала работ</strong> - исходное состояние</li><li><strong>Фото этапов работ</strong> - прогресс выполнения</li><li><strong>Фото материалов</strong> - используемые материалы</li><li><strong>Итоговые фото</strong> - завершенные работы</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-photos-gallery'
    },
    {
        element: '.upload-photos-btn',
        intro: '<h4>Загрузка фотографий</h4><p>Нажмите эту кнопку для добавления новых фотографий. Вы можете:</p><ul><li>Загружать фото с устройства</li><li>Делать фото через камеру</li><li>Добавлять описания к каждому фото</li><li>Группировать фото по этапам работ</li></ul>',
        position: 'left',
        tooltipClass: 'intro-upload-photos'
    }
];

// Тур по странице расписания проекта
const partnerProjectScheduleTour = [
    {
        intro: '<h4>Расписание проекта</h4><p>Здесь вы можете планировать этапы работ и контролировать сроки выполнения проекта.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.schedule-timeline',
        intro: '<h4>Временная шкала</h4><p>Наглядное отображение всех этапов проекта:</p><ul><li><strong>Планируемые даты</strong> начала и окончания этапов</li><li><strong>Фактические даты</strong> выполнения работ</li><li><strong>Зависимости между этапами</strong></li><li><strong>Критический путь</strong> проекта</li></ul>',
        position: 'bottom',
        tooltipClass: 'intro-schedule-timeline'
    },
    {
        element: '.add-task-btn',
        intro: '<h4>Добавление задач</h4><p>Создавайте новые задачи и этапы работ для детального планирования проекта.</p>',
        position: 'top',
        tooltipClass: 'intro-add-task'
    }
];

// Тур по странице финансов проекта
const partnerProjectFinanceTour = [
    {
        intro: '<h4>Финансы проекта</h4><p>В этом разделе отслеживается финансовая сторона проекта: бюджет, расходы, платежи.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.finance-summary',
        intro: '<h4>Финансовая сводка</h4><p>Общий обзор финансового состояния проекта:</p><ul><li><strong>Общий бюджет</strong> проекта</li><li><strong>Потрачено</strong> на данный момент</li><li><strong>Остаток бюджета</strong></li><li><strong>Ожидаемые расходы</strong></li></ul>',
        position: 'right',
        tooltipClass: 'intro-finance-summary'
    },
    {
        element: '.payments-list',
        intro: '<h4>История платежей</h4><p>Список всех поступлений и расходов по проекту с детализацией.</p>',
        position: 'left',
        tooltipClass: 'intro-payments-list'
    }
];

// Тур по странице чек-листов проекта
const partnerProjectChecksTour = [
    {
        intro: '<h4>Чек-листы проекта</h4><p>Система контрольных списков для обеспечения качества выполнения работ.</p>',
        tooltipClass: 'intro-welcome'
    },
    {
        element: '.checks-list',
        intro: '<h4>Список проверок</h4><p>Контрольные точки и чек-листы для каждого этапа проекта:</p><ul><li><strong>Проверки качества</strong> выполненных работ</li><li><strong>Соответствие техническим требованиям</strong></li><li><strong>Безопасность</strong> на объекте</li><li><strong>Готовность к следующему этапу</strong></li></ul>',
        position: 'right',
        tooltipClass: 'intro-checks-list'
    }
];

// Туры для клиентов

// Тур по списку проектов клиента
const clientProjectsListTour = [
    {
        intro: '<h4>Ваши проекты</h4><p>Здесь представлены все ваши проекты с дизайн-студией. Это обязательное обучение поможет вам освоиться в системе.</p>',
        tooltipClass: 'intro-welcome client-tour'
    },
    {
        element: '.projects-list',
        intro: '<h4>Список проектов</h4><p>Ваши активные и завершенные проекты:</p><ul><li><strong>Название</strong> и статус проекта</li><li><strong>Прогресс выполнения</strong></li><li><strong>Ответственный дизайнер</strong></li><li><strong>Сроки</strong> выполнения</li></ul>',
        position: 'right',
        tooltipClass: 'intro-projects-list client-tour'
    }
];

// Туры для вкладок клиентского проекта
const clientProjectFilesTour = [
    {
        intro: '<h4>Файлы проекта</h4><p>Здесь хранятся все документы вашего проекта: чертежи, дизайн-проекты, техническая документация.</p>',
        tooltipClass: 'intro-welcome client-tour'
    },
    {
        element: '.files-list',
        intro: '<h4>Список файлов</h4><p>Все документы организованы по категориям для удобного поиска и просмотра.</p>',
        position: 'right',
        tooltipClass: 'intro-files-list client-tour'
    }
];

const clientProjectPhotosTour = [
    {
        intro: '<h4>Фотографии проекта</h4><p>Визуальная документация хода выполнения работ по вашему проекту.</p>',
        tooltipClass: 'intro-welcome client-tour'
    },
    {
        element: '.photos-gallery',
        intro: '<h4>Галерея фотографий</h4><p>Фотографии этапов работ, используемых материалов и итоговых результатов.</p>',
        position: 'bottom',
        tooltipClass: 'intro-photos-gallery client-tour'
    }
];

const clientProjectEstimatesTour = [
    {
        intro: '<h4>Сметы проекта</h4><p>Здесь представлены все сметы по вашему проекту для ознакомления и согласования.</p>',
        tooltipClass: 'intro-welcome client-tour'
    },
    {
        element: '.estimates-list',
        intro: '<h4>Список смет</h4><p>Все сметы с указанием стоимости работ и материалов. Вы можете просматривать детали и задавать вопросы.</p>',
        position: 'right',
        tooltipClass: 'intro-estimates-list client-tour'
    }
];

const clientProjectScheduleTour = [
    {
        intro: '<h4>График работ</h4><p>Планируемые и фактические сроки выполнения этапов вашего проекта.</p>',
        tooltipClass: 'intro-welcome client-tour'
    },
    {
        element: '.schedule-timeline',
        intro: '<h4>Временная шкала</h4><p>Наглядное отображение прогресса работ по вашему проекту.</p>',
        position: 'bottom',
        tooltipClass: 'intro-schedule-timeline client-tour'
    }
];

const clientProjectFinanceTour = [
    {
        intro: '<h4>Финансовая информация</h4><p>Информация о стоимости проекта, произведенных платежах и планируемых расходах.</p>',
        tooltipClass: 'intro-welcome client-tour'
    },
    {
        element: '.finance-summary',
        intro: '<h4>Финансовая сводка</h4><p>Общая информация о бюджете проекта и произведенных платежах.</p>',
        position: 'right',
        tooltipClass: 'intro-finance-summary client-tour'
    }
];

const clientProjectChecksTour = [
    {
        intro: '<h4>Контроль качества</h4><p>Результаты проверок качества выполненных работ на различных этапах проекта.</p>',
        tooltipClass: 'intro-welcome client-tour'
    },
    {
        element: '.checks-list',
        intro: '<h4>Результаты проверок</h4><p>Отчеты о контроле качества работ и соответствии требованиям проекта.</p>',
        position: 'right',
        tooltipClass: 'intro-checks-list client-tour'
    }
];


// Словарь туров по ключам страниц и ролей
const tours = {
    'partner': {
        'dashboard': partnerDashboardTour,
        'projects-list': partnerProjectsListTour,
        'estimates-list': partnerEstimatesListTour,
        'employees': partnerEmployeesTour,
        'calculator': partnerCalculatorTour,
        'estimate-create': partnerEstimateCreateTour,
        'estimate-edit': partnerEstimateEditTour,
        'project': partnerProjectTour,
        'project-files': partnerProjectFilesTour,
        'project-photos': partnerProjectPhotosTour,
        'project-estimates': partnerEstimatesTour,
        'project-schedule': partnerProjectScheduleTour,
        'project-finance': partnerProjectFinanceTour,
        'project-checks': partnerProjectChecksTour
    },
    'client': {
        'client-dashboard': clientDashboardTour,
        'client-projects-list': clientProjectsListTour,
        'client-project': clientProjectTour,
        'client-project-files': clientProjectFilesTour,
        'client-project-photos': clientProjectPhotosTour,
        'client-project-estimates': clientProjectEstimatesTour,
        'client-project-schedule': clientProjectScheduleTour,
        'client-project-finance': clientProjectFinanceTour,
        'client-project-checks': clientProjectChecksTour
    }
};

// Функция для запуска тура
function startTour(pageKey) {
    const userRole = getUserRole();
    
    // Если роль не партнер и не клиент, не запускаем тур
    if (userRole !== 'partner' && userRole !== 'client') {
        return;
    }
    
    // Получаем тур для текущей страницы и роли
    const tourSteps = tours[userRole]?.[pageKey];
    
    if (!tourSteps || tourSteps.length === 0) {
        console.log(`Тур для страницы ${pageKey} и роли ${userRole} не найден`);
        return;
    }
    
    // Создаем экземпляр IntroJs
    const tour = introJs();
    
    // Выбираем настройки в зависимости от роли пользователя
    const tourOptions = userRole === 'client' 
        ? { ...mandatoryTourDefaults, steps: tourSteps }
        : { ...tourDefaults, steps: tourSteps };
    
    // Применяем настройки
    tour.setOptions(tourOptions);
    
    // Для клиента блокируем возможность пропуска тура
    if (userRole === 'client') {
        // Перехватываем событие перед выходом
        tour.onbeforeexit(function() {
            // Проверяем, был ли тур завершён
            const tourKey = `tour_${userRole}_${pageKey}_completed`;
            const completed = localStorage.getItem(tourKey) === 'true';
            
            // Если тур не был завершен, не разрешаем выход
            return completed;
        });
    }
    
    // Запускаем тур
    tour.start();
    
    // Сохраняем информацию о просмотре тура только при полном завершении
    tour.oncomplete(function() {
        saveTourCompletion(userRole, pageKey);
    });
    
    // Для клиента не сохраняем прогресс при простом выходе, только при завершении
    if (userRole !== 'client') {
        tour.onexit(function() {
            saveTourCompletion(userRole, pageKey);
        });
    }
}

// Функция для сохранения информации о завершении тура
function saveTourCompletion(role, pageKey) {
    // Сохраняем в localStorage информацию о том, что пользователь прошел тур
    const tourKey = `tour_${role}_${pageKey}_completed`;
    localStorage.setItem(tourKey, 'true');
    
    // Можно также отправить запрос на сервер для сохранения этой информации
    // в базе данных для конкретного пользователя
    fetch('/api/tours/complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            role: role,
            page: pageKey
        })
    }).catch(error => console.error('Ошибка при сохранении информации о туре:', error));
}

// Функция для проверки, нужно ли показывать тур
function shouldShowTour(pageKey) {
    const userRole = getUserRole();
    
    if (userRole !== 'partner' && userRole !== 'client') {
        return false;
    }
    
    // Проверяем, есть ли тур для данной страницы и роли
    const tourExists = tours[userRole]?.[pageKey];
    
    if (!tourExists) {
        return false;
    }
    
    // Проверяем, проходил ли пользователь этот тур ранее
    const tourKey = `tour_${userRole}_${pageKey}_completed`;
    const completed = localStorage.getItem(tourKey) === 'true';
    
    // Тур показывается, если он существует и пользователь его еще не проходил
    return !completed;
}

// Функция для инициализации тура на странице
function initTour(pageKey) {
    if (shouldShowTour(pageKey)) {
        // Добавляем небольшую задержку для уверенности, что DOM загружен
        setTimeout(() => {
            startTour(pageKey);
        }, 1000);
    }
}

// Функция для запуска тура вручную
function manualStartTour(pageKey) {
    startTour(pageKey);
}

// Функция для сброса всех просмотренных туров
function resetAllTours() {
    // Находим все ключи в localStorage, относящиеся к турам
    const tourKeys = [];
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith('tour_') && key.endsWith('_completed')) {
            tourKeys.push(key);
        }
    }
    
    // Удаляем все ключи туров
    tourKeys.forEach(key => localStorage.removeItem(key));
    
    // Опционально: отправляем запрос на сервер для сброса информации о турах
    fetch('/api/tours/reset', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).catch(error => console.error('Ошибка при сбросе информации о турах:', error));
}

// Экспортируем функции
export { initTour, manualStartTour, resetAllTours };
