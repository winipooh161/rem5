<table class="table table-hover table-striped align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th scope="col" width="5%">ID</th>
            <th scope="col" width="25%">Название</th>
            <th scope="col" width="20%">Объект</th>
            <th scope="col" width="10%">Тип</th>
            <th scope="col" width="10%">Сумма, ₽</th>
            <th scope="col" width="10%">Статус</th>
            <th scope="col" width="10%">Дата</th>
            <th scope="col" width="10%">Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $estimates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estimate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($estimate->id); ?></td>
                <td>
                    <a href="<?php echo e(route('partner.estimates.edit', $estimate)); ?>" class="text-decoration-none fw-bold">
                        <?php echo e($estimate->name); ?>

                    </a>
                    <?php if($estimate->description): ?>
                        <p class="text-muted small mb-0"><?php echo e(Str::limit($estimate->description, 50)); ?></p>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($estimate->project): ?>
                        <a href="<?php echo e(route('partner.projects.show', $estimate->project)); ?>" class="text-decoration-none">
                            <?php echo e($estimate->project->address); ?>

                        </a>
                        <p class="text-muted small mb-0"><?php echo e($estimate->project->client_name); ?></p>
                    <?php else: ?>
                        <span class="text-muted">Не привязана</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php switch($estimate->type):
                        case ('main'): ?>
                            <span class="badge bg-primary">Основная</span>
                            <?php break; ?>
                        <?php case ('additional'): ?>
                            <span class="badge bg-info">Дополнительная</span>
                            <?php break; ?>
                        <?php case ('materials'): ?>
                            <span class="badge bg-warning text-dark">Материалы</span>
                            <?php break; ?>
                        <?php default: ?>
                            <span class="badge bg-secondary"><?php echo e($estimate->type); ?></span>
                    <?php endswitch; ?>
                </td>
                <td class="text-end">
                    <?php if($estimate->total_amount > 0): ?>
                        <?php echo e(number_format($estimate->total_amount, 2, '.', ' ')); ?>

                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php switch($estimate->status):
                        case ('draft'): ?>
                            <span class="badge bg-secondary">Черновик</span>
                            <?php break; ?>
                        <?php case ('pending'): ?>
                            <span class="badge bg-warning text-dark">На рассмотрении</span>
                            <?php break; ?>
                        <?php case ('approved'): ?>
                            <span class="badge bg-success">Утверждена</span>
                            <?php break; ?>
                        <?php case ('rejected'): ?>
                            <span class="badge bg-danger">Отклонена</span>
                            <?php break; ?>
                        <?php default: ?>
                            <span class="badge bg-secondary"><?php echo e($estimate->status); ?></span>
                    <?php endswitch; ?>
                </td>
                <td class="date-format">
                    <?php echo e($estimate->updated_at); ?>

                </td>
                <td>
                    <div class="dropdown estimate-action-dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle estimate-action-btn" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false"
                                data-bs-auto-close="true"
                                id="dropdown-<?php echo e($estimate->id); ?>">
                            <i class="fas fa-cogs me-1"></i> Действия
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('partner.estimates.edit', $estimate->id)); ?>">
                                    <i class="fas fa-edit me-2"></i>Редактировать
                                </a>
                            </li>                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('partner.estimates.export', $estimate->id)); ?>">
                                    <i class="fas fa-file-excel me-2"></i>Скачать Excel
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('partner.estimates.exportClient', $estimate->id)); ?>">
                                    <i class="fas fa-file-excel me-2"></i>Скачать Excel для заказчика
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('partner.estimates.exportContractor', $estimate->id)); ?>">
                                    <i class="fas fa-file-excel me-2"></i>Скачать Excel для мастера
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('partner.estimates.exportPdf', $estimate->id)); ?>">
                                    <i class="fas fa-file-pdf me-2"></i>Скачать PDF
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('partner.estimates.exportPdfClient', $estimate->id)); ?>">
                                    <i class="fas fa-file-pdf me-2"></i>Скачать PDF для заказчика
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('partner.estimates.exportPdfContractor', $estimate->id)); ?>">
                                    <i class="fas fa-file-pdf me-2"></i>Скачать PDF для мастера
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('partner.estimates.show', $estimate->id)); ?>">
                                    <i class="fas fa-eye me-2"></i>Просмотреть
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo e(route('partner.estimates.destroy', $estimate->id)); ?>" method="POST" class="d-inline delete-form" data-name="<?php echo e($estimate->name); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-trash me-2"></i>Удалить
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                        <h5>Нет сохраненных смет</h5>
                        <p class="text-muted">Создайте свою первую смету, нажав кнопку "Создать смету"</p>
                        <a href="<?php echo e(route('partner.estimates.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i>Создать смету
                        </a>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Подтверждение удаления сметы
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = this.dataset.name;
            
            if (confirm(`Вы уверены, что хотите удалить смету "${name}"? Это действие нельзя отменить.`)) {
                this.submit();
            }
        });
    });
    
    // Принудительная инициализация выпадающих меню
    function initEstimateActionDropdowns() {
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap не загружен, пробуем еще раз через 200мс');
            setTimeout(initEstimateActionDropdowns, 200);
            return;
        }
        
        console.log('Инициализация выпадающих меню для действий со сметами');
        
        document.querySelectorAll('.estimate-action-btn').forEach(function(button) {
            try {
                // Создаем новый экземпляр Dropdown
                const dropdown = new bootstrap.Dropdown(button);
                
                // Добавляем обработчик для предотвращения закрытия меню при клике внутри
                const dropdownMenu = button.nextElementSibling;
                if (dropdownMenu) {
                    dropdownMenu.addEventListener('click', function(e) {
                        if (!e.target.classList.contains('dropdown-item') || 
                            e.target.closest('form.delete-form')) {
                            e.stopPropagation();
                        }
                    });
                }
                
                console.log('Dropdown инициализирован для', button.id);
            } catch (err) {
                console.error('Ошибка при инициализации dropdown:', err);
            }
        });
    }
    
    // Запускаем инициализацию с задержкой, чтобы DOM точно был готов
    setTimeout(initEstimateActionDropdowns, 300);
});
</script>
<?php /**PATH C:\OSPanel\domains\remont\resources\views\partner\estimates\partials\estimates-list.blade.php ENDPATH**/ ?>