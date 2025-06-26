import './bootstrap';
import $ from 'jquery';

// Глобальный доступ к jQuery
window.$ = window.jQuery = $;



// Функция для инициализации всех компонентов Bootstrap
function initializeBootstrapComponents() {
    if (typeof bootstrap !== 'undefined') {
        // Для dropdown НЕ создаем новые экземпляры, позволяем Bootstrap сделать это автоматически
        // Bootstrap сам инициализирует все dropdown по атрибуту data-bs-toggle="dropdown"
        
        // Для поповеров и тултипов продолжаем делать явную инициализацию
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        if (popoverTriggerList.length > 0) {
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        }
        
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        if (tooltipTriggerList.length > 0) {
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        console.log('Bootstrap компоненты успешно инициализированы');
    }
}

// Функция для инициализации боковой панели
function initializeSidebar() {
    const sidebarCollapseShow = document.getElementById('sidebarCollapseShow');
    if (sidebarCollapseShow) {
        sidebarCollapseShow.addEventListener('click', function(e) {
            console.log('Кнопка меню нажата');
            // Добавляем класс для показа боковой панели на мобильных устройствах
            document.getElementById('sidebar').classList.add('active');
            
            // Добавляем затемняющий фон
            addSidebarOverlay();
        });
    }
    
    // Функция для добавления затемняющего фона
    function addSidebarOverlay() {
        // Убедимся, что старый overlay удален
        removeSidebarOverlay();
        
        // Создаем новый overlay
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        overlay.id = 'sidebarOverlay';
        
        // Добавляем обработчик клика по overlay
        overlay.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.remove('active');
            }
            removeSidebarOverlay();
        });
        
        document.body.appendChild(overlay);
        console.log('Overlay добавлен');
    }
    
    // Функция для удаления затемняющего фона
    function removeSidebarOverlay() {
        const overlay = document.getElementById('sidebarOverlay');
        if (overlay && overlay.parentNode) {
            overlay.parentNode.removeChild(overlay);
            console.log('Overlay удален');
        }
    }
    
    // Добавляем обработчик клика по документу для закрытия сайдбара при клике вне его
    document.addEventListener('mousedown', function(event) {
        const sidebar = document.getElementById('sidebar');
        const sidebarCollapseShow = document.getElementById('sidebarCollapseShow');
        
        // Проверяем, что сайдбар активен, клик был вне его и не по кнопке открытия
        if (
            sidebar && 
            sidebar.classList.contains('active') && 
            !sidebar.contains(event.target) && 
            (!sidebarCollapseShow || !sidebarCollapseShow.contains(event.target))
        ) {
            sidebar.classList.remove('active');
            removeSidebarOverlay();
            console.log('Сайдбар закрыт по клику вне области');
        }
    });
}

// Инициализируем компоненты при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    initializeBootstrapComponents();
    initializeSidebar();
});

// Импортируем наш новый скрипт автозаполнения адресов
import './address-autocomplete.js';

// Импортируем остальные скрипты
import './project-filters.js';
import './project-file-upload.js';
import './project-tabs.js';
import './mask.js';

// Убеждаемся, что jQuery доступен глобально после загрузки всех модулей
window.addEventListener('DOMContentLoaded', function() {
    if (!window.$ && window.jQuery) {
        window.$ = window.jQuery;
    }
    console.log('jQuery статус:', window.$ ? 'доступен' : 'недоступен');
});