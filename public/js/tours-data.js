/**
 * Файл содержит данные всех туров для системы обучения
 * Подключается отдельно для уменьшения размера основного бандла
 */
window.appTours = {
    'partner': {
        'dashboard': [
            {
                intro: '<h4>Добро пожаловать в панель управления!</h4><p>Здесь вы найдете инструменты для управления проектами, сметами и сотрудниками.</p>',
                tooltipClass: 'intro-welcome'
            },
            {
                element: '.stats-cards',
                intro: '<h4>Статистика</h4><p>Общая информация о ваших проектах, сметах и платежах.</p>',
                position: 'bottom',
                tooltipClass: 'intro-stats'
            }
        ],
        'projects-list': [
            {
                intro: '<h4>Управление проектами</h4><p>Здесь отображаются все ваши проекты и инструменты для работы с ними.</p>',
                tooltipClass: 'intro-welcome'
            },
            {
                element: '.filter-section',
                intro: '<h4>Фильтры проектов</h4><p>Используйте фильтры для быстрого поиска нужных проектов.</p>',
                position: 'bottom',
                tooltipClass: 'intro-filters'
            },
            {
                element: '.projects-list',
                intro: '<h4>Список проектов</h4><p>Все ваши проекты с основной информацией и статусами.</p>',
                position: 'right',
                tooltipClass: 'intro-projects'
            }
        ],
        'estimates-list': [
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
            }
        ],
        'project-estimates': [
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
        ],
        // Остальные туры для партнеров
        'employees': [
            {
                intro: '<h4>Управление сотрудниками</h4><p>Здесь вы можете управлять доступом сотрудников к системе.</p>',
                tooltipClass: 'intro-welcome'
            }
        ],
        'calculator': [
            {
                intro: '<h4>Калькулятор материалов</h4><p>Инструмент для быстрого расчета необходимых материалов.</p>',
                tooltipClass: 'intro-welcome'
            }
        ]
    },
    'client': {
        'client-dashboard': [
            {
                intro: '<h4>Добро пожаловать в личный кабинет!</h4><p>Здесь вы можете отслеживать все этапы вашего ремонта.</p>',
                tooltipClass: 'intro-welcome client-tour'
            },
            {
                element: '.project-cards',
                intro: '<h4>Ваши проекты</h4><p>Здесь отображаются все ваши текущие проекты ремонта.</p>',
                position: 'bottom',
                tooltipClass: 'intro-projects client-tour'
            }
        ],
        'client-projects-list': [
            {
                intro: '<h4>Ваши проекты</h4><p>Здесь отображаются все ваши текущие и завершенные проекты ремонта.</p>',
                tooltipClass: 'intro-welcome client-tour'
            }
        ],
        'client-project-estimates': [
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
        ]
    }
};
