

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="h3 mb-2 mb-md-0"><?php echo e($estimate->name); ?></h1>
        <div class="mt-2 mt-md-0 d-flex">
            <a href="<?php echo e(route('partner.estimates.export', $estimate)); ?>" class="btn btn-outline-primary me-2">
                <i class="fas fa-download me-1"></i>Скачать Excel
            </a>
            <a href="<?php echo e(route('partner.estimates.edit', $estimate)); ?>" class="btn btn-primary me-2">
                <i class="fas fa-edit me-1"></i>Редактировать
            </a>
            <a href="<?php echo e(route('partner.estimates.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>К списку
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <!-- Карточка с основной информацией -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i> Основная информация
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Название сметы</label>
                        <p><?php echo e($estimate->name); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Объект</label>
                        <?php if($estimate->project): ?>
                            <p>
                                <a href="<?php echo e(route('partner.projects.show', $estimate->project)); ?>" class="text-decoration-none">
                                    <?php echo e($estimate->project->address); ?>

                                </a><br>
                                <small class="text-muted">Заказчик: <?php echo e($estimate->project->client_name); ?></small>
                            </p>
                        <?php else: ?>
                            <p class="text-muted">Не привязана к объекту</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Тип сметы</label>
                        <p>
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
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Статус</label>
                        <p>
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
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Итоговая сумма</label>
                        <p class="h4"><?php echo e(number_format($estimate->total_amount, 2, '.', ' ')); ?> ₽</p>
                    </div>
                    
                    <?php if($estimate->description): ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Примечания</label>
                        <p><?php echo e($estimate->description); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
          
        </div>
        
        <div class="col-md-8">
            <!-- История изменений -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-history me-1"></i> История изменений
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Создание сметы</h5>
                                <small><?php echo e($estimate->created_at->format('d.m.Y H:i')); ?></small>
                            </div>
                            <p class="mb-1">Смета была создана пользователем <?php echo e($estimate->user->name ?? 'Неизвестно'); ?></p>
                        </div>
                        
                        <?php if($estimate->file_updated_at && $estimate->file_updated_at != $estimate->created_at): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Обновление файла</h5>
                                <small><?php echo e($estimate->file_updated_at->format('d.m.Y H:i')); ?></small>
                            </div>
                            <p class="mb-1">Файл сметы был обновлен</p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($estimate->updated_at != $estimate->created_at): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Обновление информации</h5>
                                <small><?php echo e($estimate->updated_at->format('d.m.Y H:i')); ?></small>
                            </div>
                            <p class="mb-1">Информация о смете была обновлена</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Элементы сметы (если они есть) -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-list me-1"></i> Содержание сметы</span>
                    <span class="badge bg-primary"><?php echo e($estimate->items->count()); ?> позиций</span>
                </div>
                <div class="card-body p-0">
                    <?php if($estimate->items->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">#</th>
                                        <th scope="col" width="40%">Наименование</th>
                                        <th scope="col" width="10%">Ед. изм.</th>
                                        <th scope="col" width="10%">Кол-во</th>
                                        <th scope="col" width="15%">Цена</th>
                                        <th scope="col" width="20%">Стоимость</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $estimate->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr <?php if($item->is_section_header): ?> class="table-light" <?php endif; ?>>
                                            <td><?php echo e($item->position_number ?? ''); ?></td>
                                            <td class="<?php if($item->is_section_header): ?> fw-bold <?php endif; ?>"><?php echo e($item->name); ?></td>
                                            <td><?php echo e($item->unit); ?></td>
                                            <td class="text-center"><?php echo e($item->is_section_header ? '' : $item->quantity); ?></td>
                                            <td class="text-end"><?php echo e($item->is_section_header ? '' : number_format($item->price, 2, '.', ' ')); ?></td>
                                            <td class="text-end fw-bold"><?php echo e($item->is_section_header ? '' : number_format($item->client_cost, 2, '.', ' ')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="table-primary">
                                        <td colspan="5" class="text-end fw-bold">ИТОГО:</td>
                                        <td class="text-end fw-bold"><?php echo e(number_format($estimate->total_amount, 2, '.', ' ')); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="mb-3">В этой смете пока нет элементов.</p>
                            <a href="<?php echo e(route('partner.estimates.edit', $estimate)); ?>" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Редактировать смету
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views/partner/estimates/show.blade.php ENDPATH**/ ?>