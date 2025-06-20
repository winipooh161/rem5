

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
            <h1 class="h3 mb-2 mb-md-0"><?php echo e($project->client_name); ?>: <?php echo e($project->address); ?><?php echo e($project->apartment_number ? ', кв. ' . $project->apartment_number : ''); ?></h1>
            <div class="d-flex mt-2 mt-md-0">
                <a href="<?php echo e(route('client.projects.index')); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>К списку объектов
                </a>
            </div>
        </div>
        <p class="text-muted mb-0">
            <span class="badge <?php echo e($project->status == 'active' ? 'bg-success' : ($project->status == 'paused' ? 'bg-warning text-dark' : ($project->status == 'completed' ? 'bg-info' : 'bg-secondary'))); ?>">
                <?php echo e($project->status == 'active' ? 'Активен' : ($project->status == 'paused' ? 'Приостановлен' : ($project->status == 'completed' ? 'Завершен' : 'Отменен'))); ?>

            </span>
            <span class="ms-2"><?php echo e($project->work_type_text); ?></span>
        </p>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Панель вкладок с горизонтальной прокруткой -->
    <div class="card mb-4">
        <div class="card-header p-0 position-relative">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == null ? 'active' : ''); ?>" id="main-tab" data-bs-toggle="tab" data-bs-target="#main" type="button" role="tab" aria-controls="main" aria-selected="<?php echo e(request('tab') == null ? 'true' : 'false'); ?>">
                            <i class="fas fa-info-circle me-1"></i>Основная информация
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'finance' ? 'active' : ''); ?>" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance" type="button" role="tab" aria-controls="finance" aria-selected="<?php echo e(request('tab') == 'finance' ? 'true' : 'false'); ?>">
                            <i class="fas fa-money-bill-wave me-1"></i>Финансы
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'schedule' ? 'active' : ''); ?>" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="<?php echo e(request('tab') == 'schedule' ? 'true' : 'false'); ?>">
                            <i class="fas fa-calendar-alt me-1"></i>План-график
                        </button>
                    </li>                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'photos' ? 'active' : ''); ?>" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos" type="button" role="tab" aria-controls="photos" aria-selected="<?php echo e(request('tab') == 'photos' ? 'true' : 'false'); ?>">
                            <i class="fas fa-images me-1"></i>Фото
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'check' ? 'active' : ''); ?>" id="check-tab" data-bs-toggle="tab" data-bs-target="#check" type="button" role="tab" aria-controls="check" aria-selected="<?php echo e(request('tab') == 'check' ? 'true' : 'false'); ?>">
                            <i class="fas fa-clipboard-check me-1"></i>Проверка объекта
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'design' ? 'active' : ''); ?>" id="design-tab" data-bs-toggle="tab" data-bs-target="#design" type="button" role="tab" aria-controls="design" aria-selected="<?php echo e(request('tab') == 'design' ? 'true' : 'false'); ?>">
                            <i class="fas fa-paint-brush me-1"></i>Дизайн
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'schemes' ? 'active' : ''); ?>" id="schemes-tab" data-bs-toggle="tab" data-bs-target="#schemes" type="button" role="tab" aria-controls="schemes" aria-selected="<?php echo e(request('tab') == 'schemes' ? 'true' : 'false'); ?>">
                            <i class="fas fa-project-diagram me-1"></i>Схемы
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'documents' ? 'active' : ''); ?>" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="<?php echo e(request('tab') == 'documents' ? 'true' : 'false'); ?>">
                            <i class="fas fa-file-alt me-1"></i>Документы
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'contract' ? 'active' : ''); ?>" id="contract-tab" data-bs-toggle="tab" data-bs-target="#contract" type="button" role="tab" aria-controls="contract" aria-selected="<?php echo e(request('tab') == 'contract' ? 'true' : 'false'); ?>">
                            <i class="fas fa-file-signature me-1"></i>Договор
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e(request('tab') == 'other' ? 'active' : ''); ?>" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="<?php echo e(request('tab') == 'other' ? 'true' : 'false'); ?>">
                            <i class="fas fa-folder-open me-1"></i>Прочие файлы
                        </button>
                    </li>
                </ul>
                <div class="nav-tabs-scroll-indicator d-none d-md-block"></div>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="projectTabsContent">
                <div class="tab-pane fade <?php echo e(request('tab') == null ? 'show active' : ''); ?>" id="main" role="tabpanel" aria-labelledby="main-tab">
                    <?php echo $__env->make('client.projects.tabs.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(request('tab') == 'finance' ? 'show active' : ''); ?>" id="finance" role="tabpanel" aria-labelledby="finance-tab">
                    <?php echo $__env->make('client.projects.tabs.finance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(request('tab') == 'schedule' ? 'show active' : ''); ?>" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                    <?php echo $__env->make('client.projects.tabs.schedule', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>                <div class="tab-pane fade <?php echo e(request('tab') == 'photos' ? 'show active' : ''); ?>" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                    <?php echo $__env->make('client.projects.tabs.photos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(request('tab') == 'check' ? 'show active' : ''); ?>" id="check" role="tabpanel" aria-labelledby="check-tab">
                    <?php echo $__env->make('client.projects.tabs.check', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(request('tab') == 'design' ? 'show active' : ''); ?>" id="design" role="tabpanel" aria-labelledby="design-tab">
                    <?php echo $__env->make('client.projects.tabs.design', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(request('tab') == 'schemes' ? 'show active' : ''); ?>" id="schemes" role="tabpanel" aria-labelledby="schemes-tab">
                    <?php echo $__env->make('client.projects.tabs.schemes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(request('tab') == 'documents' ? 'show active' : ''); ?>" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                    <?php echo $__env->make('client.projects.tabs.documents', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(request('tab') == 'contract' ? 'show active' : ''); ?>" id="contract" role="tabpanel" aria-labelledby="contract-tab">
                    <?php echo $__env->make('client.projects.tabs.contract', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="tab-pane fade <?php echo e(request('tab') == 'other' ? 'show active' : ''); ?>" id="other" role="tabpanel" aria-labelledby="other-tab">
                    <?php echo $__env->make('client.projects.tabs.other', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views/client/projects/show.blade.php ENDPATH**/ ?>