@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div>
            <h1 class="h3 mb-2 mb-md-0">Объекты</h1>
            <p class="text-muted mb-3" id="projects-counter">
                Показано: <span>{{ $projects->count() }}</span> из <span>{{ $projects->total() }}</span> объектов
            </p>
        </div>
        <a href="{{ route('partner.projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Создать объект
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <!-- Фильтры и поиск - улучшенная версия для мобильных -->
    <div class="card mb-4">
        <div class="card-header p-2 d-flex justify-content-between align-items-center">
            <h5 class="m-0">Фильтры</h5>
            <button class="btn btn-sm btn-outline-secondary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                <i class="fas fa-sliders-h"></i>
            </button>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body p-2 p-md-3">
                <form action="{{ route('partner.projects.index') }}" method="GET" id="filterForm">
                    <input type="hidden" name="filter" value="true">
                    
                    <div class="row g-2">
                        <div class="col-12 mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" placeholder="Поиск по имени, адресу..." value="{{ $filters['search'] ?? '' }}">
                                <button type="submit" class="btn btn-primary d-md-none">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-4 mb-2">
                            <label class="d-block d-md-none small mb-1">Статус</label>
                            <select class="form-select" name="status" id="status">
                                <option value="">Все статусы</option>
                                <option value="active" {{ isset($filters['status']) && $filters['status'] == 'active' ? 'selected' : '' }}>Активные</option>
                                <option value="completed" {{ isset($filters['status']) && $filters['status'] == 'completed' ? 'selected' : '' }}>Завершенные</option>
                                <option value="paused" {{ isset($filters['status']) && $filters['status'] == 'paused' ? 'selected' : '' }}>Приостановленные</option>
                                <option value="cancelled" {{ isset($filters['status']) && $filters['status'] == 'cancelled' ? 'selected' : '' }}>Отмененные</option>
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-4 mb-2">
                            <label class="d-block d-md-none small mb-1">Тип работ</label>
                            <select class="form-select" name="work_type" id="work_type">
                                <option value="">Все типы работ</option>
                                <option value="repair" {{ isset($filters['work_type']) && $filters['work_type'] == 'repair' ? 'selected' : '' }}>Ремонт</option>
                                <option value="design" {{ isset($filters['work_type']) && $filters['work_type'] == 'design' ? 'selected' : '' }}>Дизайн</option>
                                <option value="construction" {{ isset($filters['work_type']) && $filters['work_type'] == 'construction' ? 'selected' : '' }}>Строительство</option>
                            </select>
                        </div>
                        
                        @if(Auth::user()->role === 'admin')
                        <div class="col-6 col-md-4 mb-2">
                            <label class="d-block d-md-none small mb-1">Партнер</label>
                            <select class="form-select" name="partner_id" id="partner_id">
                                <option value="">Все партнеры</option>
                                @foreach(\App\Models\User::where('role', 'partner')->orderBy('name')->get() as $partner)
                                <option value="{{ $partner->id }}" {{ isset($filters['partner_id']) && $filters['partner_id'] == $partner->id ? 'selected' : '' }}>
                                    {{ $partner->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <div class="col-6 d-md-none">
                            <a href="{{ route('partner.projects.index', ['clear' => true]) }}" class="btn btn-outline-secondary w-100">
                                Сбросить
                            </a>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-12 text-end d-none d-md-block">
                            <a href="{{ route('partner.projects.index', ['clear' => true]) }}" class="btn btn-outline-secondary">
                                Сбросить
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Информация о примененных фильтрах -->
    @if(!empty(array_filter($filters ?? [])))
        <div class="mb-3 overflow-auto hide-scroll">
            <div class="d-flex align-items-center flex-nowrap">
                <span class="me-2 text-nowrap">Фильтры:</span>
                @if(!empty($filters['search']))
                    <span class="badge bg-light text-dark me-2">Поиск: {{ Str::limit($filters['search'], 15) }}</span>
                @endif
                @if(!empty($filters['status']))
                    <span class="badge bg-light text-dark me-2">Статус: 
                        {{ $filters['status'] == 'active' ? 'Активные' : 
                          ($filters['status'] == 'completed' ? 'Завершенные' : 
                          ($filters['status'] == 'paused' ? 'Приостановленные' : 'Отмененные')) }}
                    </span>
                @endif
                @if(!empty($filters['work_type']))
                    <span class="badge bg-light text-dark me-2">Тип: 
                        {{ $filters['work_type'] == 'repair' ? 'Ремонт' : 
                          ($filters['work_type'] == 'design' ? 'Дизайн' : 'Строительство') }}
                    </span>
                @endif
                @if(Auth::user()->role === 'admin' && !empty($filters['partner_id']))
                    <span class="badge bg-light text-dark me-2">Партнер: 
                        {{ \App\Models\User::find($filters['partner_id'])->name ?? 'Не найден' }}
                    </span>
                @endif
            </div>
        </div>
    @endif
    
    @if($projects->isEmpty())
        <div class="card">
            <div class="card-body text-center py-4">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Объекты не найдены</h5>
                @if(!empty(array_filter($filters ?? [])))
                    <p>Попробуйте изменить параметры фильтрации или <a href="{{ route('partner.projects.index', ['clear' => true]) }}">сбросить все фильтры</a>.</p>
                @else
                    <p>Создайте свой первый объект, нажав на кнопку "Создать объект" выше.</p>
                    <a href="{{ route('partner.projects.create') }}" class="btn btn-outline-primary mt-2">
                        <i class="fas fa-plus-circle me-1"></i>Создать объект
                    </a>
                @endif
            </div>
        </div>
    @else
        <div class="row" id="projects-container">
            @include('partner.projects.partials.projects-cards')
        </div>
        
        <!-- Скрытый элемент для хранения данных о пагинации -->
        <div id="pagination-data" class="d-none" 
             data-current-page="{{ $projects->currentPage() }}" 
             data-last-page="{{ $projects->lastPage() }}" 
             data-has-more-pages="{{ $projects->hasMorePages() ? 'true' : 'false' }}">
        </div>
        
        <div id="loading-indicator" class="my-4" style="display: none;">
            <div class="text-center mb-3 loading-pulse">
                <div class="spinner-grow spinner-grow-sm text-primary me-1" role="status">
                    <span class="visually-hidden">Загрузка...</span>
                </div>
                <div class="spinner-grow spinner-grow-sm text-primary me-1" role="status">
                    <span class="visually-hidden">Загрузка...</span>
                </div>
                <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                    <span class="visually-hidden">Загрузка...</span>
                </div>
                <p class="mt-2 text-muted">Загрузка объектов...</p>
            </div>
            
            <div class="row" id="skeleton-loader">
                <!-- Скелетон-карточки для визуализации загрузки -->
                @for ($i = 0; $i < 3; $i++)
                <div class="col-12 col-md-6 col-xl-4 mb-3">
                    <div class="card h-100 skeleton-card">
                        <div class="card-header d-flex justify-content-between align-items-center p-2 px-3">
                            <div class="skeleton-text" style="width: 70%;"></div>
                            <div class="skeleton-badge"></div>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-2">
                                <div class="d-flex">
                                    <div class="skeleton-icon me-2"></div>
                                    <div class="skeleton-text" style="width: 90%;"></div>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="skeleton-icon me-2"></div>
                                        <div class="skeleton-text" style="width: 80%;"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="skeleton-icon me-2"></div>
                                        <div class="skeleton-text" style="width: 50%;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="skeleton-icon me-2"></div>
                                        <div class="skeleton-text" style="width: 70%;"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="skeleton-icon me-2"></div>
                                        <div class="skeleton-text" style="width: 60%;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-2">
                            
                            <div class="skeleton-text mb-2" style="width: 90%;"></div>
                            <div class="skeleton-text mb-2" style="width: 85%;"></div>
                            
                            <div class="text-end">
                                <div class="skeleton-text" style="width: 40%; float: right;"></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex p-2">
                            <div class="skeleton-button me-2" style="width: 50%;"></div>
                            <div class="skeleton-button" style="width: 50%;"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        
        <div id="end-of-content" class="text-center my-4 py-3" style="display: none;">
            <div class="d-inline-block px-4 py-3 rounded-pill bg-light">
                <i class="fas fa-check-circle text-success me-2"></i>
                <span class="text-muted">Вы просмотрели все объекты</span>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Получаем элементы формы
        const filterForm = document.getElementById('filterForm');
        
        // Проверяем существование формы фильтров перед работой с ней
        if (filterForm) {
            const filterSelects = filterForm.querySelectorAll('select');
            const searchInput = filterForm.querySelector('input[name="search"]');
        
        // Авто-отправка формы при изменении селектов
        filterSelects.forEach(function(select) {
            select.addEventListener('change', function() {
                filterForm.submit();
            });
        });
        
        // Отправка формы поиска после паузы в наборе текста на десктопах
        let typingTimer;
        const doneTypingInterval = 800; // время в мс
        
        searchInput.addEventListener('keyup', function() {
            // Для мобильных устройств не используем автоматическую отправку
            if (window.innerWidth > 768) {
                clearTimeout(typingTimer);
                if (searchInput.value) {
                    typingTimer = setTimeout(function() {
                        filterForm.submit();
                    }, doneTypingInterval);
                }
            }
        });
        
        // Логика бесконечной прокрутки и подгрузки объектов
        const projectsContainer = document.getElementById('projects-container');
        const loadingIndicator = document.getElementById('loading-indicator');
        const endOfContentMsg = document.getElementById('end-of-content');
        const paginationData = document.getElementById('pagination-data');
        
        // Глобальная переменная для отслеживания состояния загрузки
        let isLoading = false;
        let hasReachedEnd = false;
        
        // Функция для проверки, достигли ли мы последней страницы
        function isLastPage() {
            if (!paginationData) return true;
            
            const currentPage = parseInt(paginationData.dataset.currentPage);
            const lastPage = parseInt(paginationData.dataset.lastPage);
            return currentPage >= lastPage;
        }
        
        // Функция для обновления данных о пагинации
        function updatePaginationData(currentPage, hasMorePages) {
            if (paginationData) {
                paginationData.dataset.currentPage = currentPage;
                paginationData.dataset.hasMorePages = hasMorePages ? 'true' : 'false';
            }
        }
        
        // Функция для загрузки дополнительных проектов
        function loadMoreProjects() {
            // Если уже идет загрузка или достигнута последняя страница, выходим
            if (isLoading || hasReachedEnd || !paginationData) {
                return;
            }
            
            // Устанавливаем состояние загрузки
            isLoading = true;
            loadingIndicator.style.display = 'block';
            
            // Создаем URL с параметрами из текущего URL
            const url = new URL(window.location.href);
            const currentPage = parseInt(paginationData.dataset.currentPage);
            url.searchParams.set('page', currentPage + 1);
            url.searchParams.set('ajax', '1');
            
            // Получаем данные через AJAX
            fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Ошибка сети: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Добавляем новые проекты
                projectsContainer.insertAdjacentHTML('beforeend', data.html);
                
                // Обновляем текущую страницу
                updatePaginationData(currentPage + 1, data.hasMorePages);
                
                // Проверяем, есть ли еще страницы
                if (currentPage + 1 >= parseInt(paginationData.dataset.lastPage)) {
                    hasReachedEnd = true;
                    endOfContentMsg.style.display = 'block';
                } 
                
                // Обновляем счетчик проектов
                const projectsCounter = document.getElementById('projects-counter');
                if (projectsCounter) {
                    const total = data.total || 0;
                    const perPage = data.perPage || 10;
                    const loaded = perPage * (currentPage + 1);
                    
                    const spans = projectsCounter.querySelectorAll('span');
                    if (spans.length >= 2) {
                        spans[0].textContent = Math.min(loaded, total);
                        spans[1].textContent = total;
                    }
                }
            })
            .catch(error => {
                console.error('Ошибка при загрузке проектов:', error);
                // Показываем уведомление об ошибке пользователю
                const errorNotification = document.createElement('div');
                errorNotification.className = 'alert alert-danger alert-dismissible fade show mt-3';
                errorNotification.innerHTML = `
                    Ошибка при загрузке данных. <button class="btn btn-sm btn-outline-danger ms-2" onclick="loadMoreProjects()">Повторить</button>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                projectsContainer.parentNode.insertBefore(errorNotification, projectsContainer.nextSibling);
            })
            .finally(() => {
                // Сбрасываем состояние загрузки
                setTimeout(() => {
                    isLoading = false;
                    loadingIndicator.style.display = 'none';
                }, 500); // Небольшая задержка для предотвращения многократных запросов
            });
        }
        
        // Добавляем обработчик прокрутки страницы для автоматической подгрузки
        let scrollDebounceTimer;
        window.addEventListener('scroll', function() {
            if (scrollDebounceTimer) clearTimeout(scrollDebounceTimer);
            
            scrollDebounceTimer = setTimeout(() => {
                // Если уже идет загрузка или достигнут конец контента, выходим
                if (isLoading || hasReachedEnd) {
                    return;
                }
                
                // Проверяем, достиг ли пользователь конца страницы
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const windowHeight = window.innerHeight;
                const documentHeight = Math.max(
                    document.body.scrollHeight, document.body.offsetHeight,
                    document.documentElement.clientHeight, document.documentElement.scrollHeight, 
                    document.documentElement.offsetHeight
                );
                
                // Если пользователь прокрутил почти до конца страницы (за 350px до конца)
                if (scrollTop + windowHeight > documentHeight - 350) {
                    loadMoreProjects();
                }
            }, 100); // Задержка для предотвращения слишком частых вызовов
        });
        
        // Функция для проверки, виден ли индикатор конца контента без прокрутки
        function checkIfContentFillsPage() {
            // Если достигнут конец контента или идет загрузка, выходим
            if (hasReachedEnd || isLoading) {
                return;
            }
            
            const windowHeight = window.innerHeight;
            const documentHeight = Math.max(
                document.body.scrollHeight, document.body.offsetHeight,
                document.documentElement.clientHeight, document.documentElement.scrollHeight, 
                document.documentElement.offsetHeight
            );
            
            // Если контент занимает меньше высоты окна плюс запас
            if (documentHeight < windowHeight + 200) {
                loadMoreProjects();
            }
        }
        
        // Проверяем необходимость загрузки при первой загрузке страницы
        setTimeout(checkIfContentFillsPage, 500);
        
        // Сбросить таймер, если пользователь продолжил печатать
        // Проверяем наличие поля поиска перед добавлением слушателя событий
        if (searchInput) {
            searchInput.addEventListener('keydown', function() {
                clearTimeout(typingTimer);
            });
        }
    }
});
</script>

<style>
/* Дополнительные стили для мобильных устройств */
@media (max-width: 576px) {
    .project-card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    
    .project-card .card-header {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    
    .project-card .card-footer {
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.35em 0.65em;
    }
    
    /* Улучшения для фильтров */
    #filterCollapse label {
        font-weight: 500;
        color: #495057;
    }
    
    .form-select, .form-control, .btn {
        font-size: 16px; /* Оптимальный размер для предотвращения масштабирования на iOS */
    }
    
    /* Пагинация */
    .pagination {
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    
    .page-item {
        white-space: nowrap;
    }
    
    /* Растянутые ссылки */
    .stretched-link::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
        content: "";
    }
}

/* Улучшения для сетки карточек */
@media (max-width: 768px) {
    .row {
        margin-left: -8px;
        margin-right: -8px;
    }
    
    .row > [class*="col-"] {
        padding-left: 8px;
        padding-right: 8px;
    }
    
    /* Улучшенный стиль заголовков */
    h5.card-title {
        font-size: 1rem;
        font-weight: 600;
    }
}

/* Улучшенный стиль контейнера пагинации */
.pagination-container {
    max-width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    padding-bottom: 5px;
}

/* Стили для скелетон-загрузчика */
.skeleton-card {
    position: relative;
    overflow: hidden;
}

.skeleton-text, .skeleton-badge, .skeleton-icon, .skeleton-button {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    height: 16px;
    border-radius: 4px;
}

.skeleton-badge {
    width: 60px;
    height: 20px;
    border-radius: 12px;
}

.skeleton-icon {
    width: 16px;
    height: 16px;
    border-radius: 50%;
}

.skeleton-button {
    height: 36px;
    border-radius: 4px;
}

@keyframes shimmer {
    0% {
        background-position: -200% 0;
    }
    100% {
        background-position: 200% 0;
    }
}

/* Анимация для индикатора загрузки */
.loading-pulse .spinner-grow:nth-child(1) {
    animation-delay: 0s;
}
.loading-pulse .spinner-grow:nth-child(2) {
    animation-delay: 0.3s;
}
.loading-pulse .spinner-grow:nth-child(3) {
    animation-delay: 0.6s;
}
</style>
@endsection
