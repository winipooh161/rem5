@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
            <h1 class="h3 mb-2 mb-md-0">{{ $project->client_name }}: {{ $project->address }}{{ $project->apartment_number ? ', кв. ' . $project->apartment_number : '' }}</h1>
            <div class="d-flex mt-2 mt-md-0">
                <a href="{{ route('client.projects.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>К списку объектов
                </a>
            </div>
        </div>
        <p class="text-muted mb-0">
            <span class="badge {{ $project->status == 'active' ? 'bg-success' : ($project->status == 'paused' ? 'bg-warning text-dark' : ($project->status == 'completed' ? 'bg-info' : 'bg-secondary')) }}">
                {{ $project->status == 'active' ? 'Активен' : ($project->status == 'paused' ? 'Приостановлен' : ($project->status == 'completed' ? 'Завершен' : 'Отменен')) }}
            </span>
            <span class="ms-2">{{ $project->work_type_text }}</span>
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Панель вкладок с горизонтальной прокруткой -->
    <div class="card mb-4">
        <div class="card-header p-0 position-relative">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == null ? 'active' : ''}}" id="main-tab" data-bs-toggle="tab" data-bs-target="#main" type="button" role="tab" aria-controls="main" aria-selected="{{ request('tab') == null ? 'true' : 'false'}}">
                            <i class="fas fa-info-circle me-1"></i>Основная информация
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'finance' ? 'active' : ''}}" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance" type="button" role="tab" aria-controls="finance" aria-selected="{{ request('tab') == 'finance' ? 'true' : 'false'}}">
                            <i class="fas fa-money-bill-wave me-1"></i>Финансы
                        </button>
                    </li>                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'schedule' ? 'active' : ''}}" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="{{ request('tab') == 'schedule' ? 'true' : 'false'}}">
                            <i class="fas fa-tasks me-1"></i>План-график
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'calendar' ? 'active' : ''}}" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar" type="button" role="tab" aria-controls="calendar" aria-selected="{{ request('tab') == 'calendar' ? 'true' : 'false'}}">
                            <i class="fas fa-calendar-alt me-1"></i>Календарь
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'camera' ? 'active' : ''}}" id="camera-tab" data-bs-toggle="tab" data-bs-target="#camera" type="button" role="tab" aria-controls="camera" aria-selected="{{ request('tab') == 'camera' ? 'true' : 'false'}}">
                            <i class="fas fa-video me-1"></i>Камера
                        </button>
                    </li>                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'photos' ? 'active' : ''}}" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos" type="button" role="tab" aria-controls="photos" aria-selected="{{ request('tab') == 'photos' ? 'true' : 'false'}}">
                            <i class="fas fa-images me-1"></i>Фото
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'check' ? 'active' : ''}}" id="check-tab" data-bs-toggle="tab" data-bs-target="#check" type="button" role="tab" aria-controls="check" aria-selected="{{ request('tab') == 'check' ? 'true' : 'false'}}">
                            <i class="fas fa-clipboard-check me-1"></i>Проверка объекта
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'design' ? 'active' : ''}}" id="design-tab" data-bs-toggle="tab" data-bs-target="#design" type="button" role="tab" aria-controls="design" aria-selected="{{ request('tab') == 'design' ? 'true' : 'false'}}">
                            <i class="fas fa-paint-brush me-1"></i>Дизайн
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'schemes' ? 'active' : ''}}" id="schemes-tab" data-bs-toggle="tab" data-bs-target="#schemes" type="button" role="tab" aria-controls="schemes" aria-selected="{{ request('tab') == 'schemes' ? 'true' : 'false'}}">
                            <i class="fas fa-project-diagram me-1"></i>Схемы
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'documents' ? 'active' : ''}}" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="{{ request('tab') == 'documents' ? 'true' : 'false'}}">
                            <i class="fas fa-file-alt me-1"></i>Документы
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'contract' ? 'active' : ''}}" id="contract-tab" data-bs-toggle="tab" data-bs-target="#contract" type="button" role="tab" aria-controls="contract" aria-selected="{{ request('tab') == 'contract' ? 'true' : 'false'}}">
                            <i class="fas fa-file-signature me-1"></i>Договор
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'other' ? 'active' : ''}}" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="{{ request('tab') == 'other' ? 'true' : 'false'}}">
                            <i class="fas fa-folder-open me-1"></i>Прочие файлы
                        </button>
                    </li>
                </ul>
                <div class="nav-tabs-scroll-indicator d-none d-md-block"></div>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="projectTabsContent">
                <div class="tab-pane fade {{ request('tab') == null ? 'show active' : ''}}" id="main" role="tabpanel" aria-labelledby="main-tab">
                    @include('client.projects.tabs.main')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'finance' ? 'show active' : ''}}" id="finance" role="tabpanel" aria-labelledby="finance-tab">
                    @include('client.projects.tabs.finance')
                </div>                <div class="tab-pane fade {{ request('tab') == 'schedule' ? 'show active' : ''}}" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                    @include('client.projects.tabs.schedule')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'calendar' ? 'show active' : ''}}" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
                    @include('client.projects.tabs.calendar')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'camera' ? 'show active' : ''}}" id="camera" role="tabpanel" aria-labelledby="camera-tab">
                    @include('client.projects.tabs.camera')
                </div>                <div class="tab-pane fade{{ request('tab') == 'photos' ? 'show active' : ''}}" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                    @include('client.projects.tabs.photos')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'check' ? 'show active' : ''}}" id="check" role="tabpanel" aria-labelledby="check-tab">
                    @include('client.projects.tabs.check')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'design' ? 'show active' : ''}}" id="design" role="tabpanel" aria-labelledby="design-tab">
                    @include('client.projects.tabs.design')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'schemes' ? 'show active' : ''}}" id="schemes" role="tabpanel" aria-labelledby="schemes-tab">
                    @include('client.projects.tabs.schemes')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'documents' ? 'show active' : ''}}" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                    @include('client.projects.tabs.documents')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'contract' ? 'show active' : ''}}" id="contract" role="tabpanel" aria-labelledby="contract-tab">
                    @include('client.projects.tabs.contract')
                </div>
                <div class="tab-pane fade {{ request('tab') == 'other' ? 'show active' : ''}}" id="other" role="tabpanel" aria-labelledby="other-tab">
                    @include('client.projects.tabs.other')
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Добавляем скрипт для индикации горизонтальной прокрутки на мобильных устройствах
document.addEventListener('DOMContentLoaded', function() {
    const tabsContainer = document.querySelector('.nav-tabs');
    
    if (tabsContainer) {
        // Проверяем наличие горизонтальной прокрутки
        function checkScroll() {
            const hasScroll = tabsContainer.scrollWidth > tabsContainer.clientWidth;
            const indicator = document.querySelector('.nav-tabs-scroll-indicator');
            
            if (indicator) {
                indicator.style.display = hasScroll ? 'block' : 'none';
            }
        }
        
        // Вызываем при загрузке и при изменении размера окна
        checkScroll();
        window.addEventListener('resize', checkScroll);
        
        // Сохраняем активную вкладку в URL
        const tabLinks = document.querySelectorAll('.nav-link');
        tabLinks.forEach(link => {
            link.addEventListener('click', function() {
                const tabId = this.getAttribute('id').replace('-tab', '');
                const url = new URL(window.location);
                
                if (tabId === 'main') {
                    url.searchParams.delete('tab');
                } else {
                    url.searchParams.set('tab', tabId);
                }
                
                window.history.pushState({}, '', url);
            });
        });
        
        // Добавляем класс для мобильной адаптации таблиц при загрузке
        const tables = document.querySelectorAll('.table');
        tables.forEach(table => {
            if (window.innerWidth <= 768) {
                table.classList.add('table-card-view');
            }
        });
    }
});
</script>

<style>
/* Дополнительные стили для улучшения мобильного отображения */
@media (max-width: 768px) {
    .card-header {
        padding: 0.5rem;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .tab-content {
        padding: 0.5rem;
    }
    
    /* Улучшенные вкладки для мобильных устройств */
    .nav-tabs {
        padding: 0;
        margin: 0;
    }
    
    .nav-tabs .nav-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    /* Мобильные версии таблиц */
    .table-card-view td {
        white-space: normal;
    }
    
    /* Стили для камеры */
    .camera-container {
        padding: 1rem 0;
    }
    
    .camera-view-container {
        background: #f5f5f5;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
    }
    
    @media (max-width: 768px) {
        .camera-view-container iframe {
            height: 240px;
        }
        
        .iv-embed {
            width: 100% !important;
        }
        
        .camera-info {
            font-size: 0.9rem;
        }
    }
}
</style>
@endsection
