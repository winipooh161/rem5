

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-2">
            <div>
                <h4><?php echo e($project->client_name); ?></h4>
                <p class="text-muted mb-2">
                    <span class="badge <?php echo e($project->status == 'active' ? 'bg-success' : ($project->status == 'paused' ? 'bg-warning' : ($project->status == 'completed' ? 'bg-info' : 'bg-secondary'))); ?>">
                        <?php echo e($project->status == 'active' ? 'Активен' : ($project->status == 'paused' ? 'Приостановлен' : ($project->status == 'completed' ? 'Завершен' : 'Отменен'))); ?>

                    </span>
                    <span class="d-block d-md-inline mt-1 mt-md-0 ms-md-2"><?php echo e($project->address); ?><?php echo e($project->apartment_number ? ', кв. ' . $project->apartment_number : ''); ?></span>
                </p>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="action-buttons-mobile d-flex flex-column flex-md-row">
                    <a href="<?php echo e(route('partner.projects.edit', $project)); ?>" class="btn btn-outline-primary mb-2 mb-md-0 me-md-2">
                        <i class="fas fa-edit me-1"></i> Редактировать
                    </a>
                    <button type="button" class="btn btn-outline-danger mb-2 mb-md-0 me-md-2" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">
                        <i class="fas fa-trash-alt me-1"></i> Удалить
                    </button>
                    <a href="<?php echo e(route('partner.projects.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> К списку
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Панель вкладок -->
    <div class="card">
        <div class="card-header p-1 position-relative nav-tabs-wrapper">
            <ul class="nav nav-tabs card-header-tabs scrollable-x hide-scroll" id="projectTabs" role="tablist" data-project-id="<?php echo e($project->id); ?>">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="main-tab" data-bs-toggle="tab" data-bs-target="#main" type="button" role="tab" aria-controls="main" aria-selected="true">
                        <i class="fas fa-info-circle d-block d-md-none"></i>
                        <span class="d-none d-md-block">Основная</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance" type="button" role="tab" aria-controls="finance" aria-selected="false">
                        <i class="fas fa-money-bill d-block d-md-none"></i>
                        <span class="d-none d-md-block">Финансы</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="false">
                        <i class="fas fa-calendar d-block d-md-none"></i>
                        <span class="d-none d-md-block">График</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="camera-tab" data-bs-toggle="tab" data-bs-target="#camera" type="button" role="tab" aria-controls="camera" aria-selected="false">
                        <i class="fas fa-video d-block d-md-none"></i>
                        <span class="d-none d-md-block">Камера</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos" type="button" role="tab" aria-controls="photos" aria-selected="false">
                        <i class="fas fa-camera d-block d-md-none"></i>
                        <span class="d-none d-md-block">Фото</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="design-tab" data-bs-toggle="tab" data-bs-target="#design" type="button" role="tab" aria-controls="design" aria-selected="false">
                        <i class="fas fa-paint-brush d-block d-md-none"></i>
                        <span class="d-none d-md-block">Дизайн</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="schemes-tab" data-bs-toggle="tab" data-bs-target="#schemes" type="button" role="tab" aria-controls="schemes" aria-selected="false">
                        <i class="fas fa-sitemap d-block d-md-none"></i>
                        <span class="d-none d-md-block">Схемы</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">
                        <i class="fas fa-file d-block d-md-none"></i>
                        <span class="d-none d-md-block">Документы</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contract-tab" data-bs-toggle="tab" data-bs-target="#contract" type="button" role="tab" aria-controls="contract" aria-selected="false">
                        <i class="fas fa-file-contract d-block d-md-none"></i>
                        <span class="d-none d-md-block">Договор</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="check-tab" data-bs-toggle="tab" data-bs-target="#check" type="button" role="tab" aria-controls="check" aria-selected="false">
                        <i class="fas fa-check-square d-block d-md-none"></i>
                        <span class="d-none d-md-block">Проверка</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="false">
                        <i class="fas fa-ellipsis-h d-block d-md-none"></i>
                        <span class="d-none d-md-block">Прочее</span>
                    </button>
                </li>
            </ul>
            <div class="nav-tabs-scroll-indicator d-md-none"></div>
        </div>
        
        <div class="card-body">
            <div class="tab-content" id="projectTabsContent">
                <!-- Подключение содержимого вкладок из отдельных файлов -->
                <div class="tab-pane fade show active" id="main" role="tabpanel" aria-labelledby="main-tab">
                    <?php echo $__env->make('partner.projects.tabs.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="finance" role="tabpanel" aria-labelledby="finance-tab">
                    <?php echo $__env->make('partner.projects.tabs.finance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                    <?php echo $__env->make('partner.projects.tabs.schedule', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="camera" role="tabpanel" aria-labelledby="camera-tab">
                    <?php echo $__env->make('partner.projects.tabs.camera', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                    <?php echo $__env->make('partner.projects.tabs.photos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">
                    <?php echo $__env->make('partner.projects.tabs.design', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="schemes" role="tabpanel" aria-labelledby="schemes-tab">
                    <?php echo $__env->make('partner.projects.tabs.schemes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                    <?php echo $__env->make('partner.projects.tabs.documents', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="contract" role="tabpanel" aria-labelledby="contract-tab">
                    <?php echo $__env->make('partner.projects.tabs.contract', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="check" role="tabpanel" aria-labelledby="check-tab">
                    <?php echo $__env->make('partner.projects.tabs.check', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                
                <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                    <?php echo $__env->make('partner.projects.tabs.other', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно подтверждения удаления -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Подтверждение удаления</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Вы действительно хотите удалить объект "<?php echo e($project->client_name); ?>"?</p>
                <p class="text-danger">Это действие невозможно отменить.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <form action="<?php echo e(route('partner.projects.destroy', $project)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Добавляем скрипт для индикации горизонтальной прокрутки на мобильных устройствах
document.addEventListener('DOMContentLoaded', function() {
    const tabsContainer = document.querySelector('.nav-tabs');
    const scrollIndicator = document.querySelector('.nav-tabs-scroll-indicator');
    
    if (tabsContainer && scrollIndicator) {
        tabsContainer.addEventListener('scroll', function() {
            const isAtEnd = tabsContainer.scrollLeft + tabsContainer.clientWidth >= tabsContainer.scrollWidth - 5;
            scrollIndicator.style.opacity = isAtEnd ? '0' : '1';
        });
        
        // Проверка при загрузке
        const isAtEnd = tabsContainer.scrollLeft + tabsContainer.clientWidth >= tabsContainer.scrollWidth - 5;
        scrollIndicator.style.opacity = isAtEnd ? '0' : '1';
    }
});
</script>

<style>
/* Дополнительные стили для улучшения мобильного отображения */
@media (max-width: 768px) {
    .action-buttons-mobile {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    
    .action-buttons-mobile .btn {
        margin-bottom: 0.5rem;
    }
    
    /* Улучшение навигации по вкладкам */
    .nav-tabs .nav-link {
        padding: 0.5rem;
        min-width: 40px;
        text-align: center;
    }
    
    .nav-tabs .nav-link i {
        font-size: 1.2rem;
    }
    
    .card-header {
        padding: 0.5rem 0.25rem !important;
    }
    
    .card-body {
        padding: 1rem 0.75rem;
    }
    
    /* Улучшенный заголовок */
    h4 {
        font-size: 1.4rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views/partner/projects/show.blade.php ENDPATH**/ ?>