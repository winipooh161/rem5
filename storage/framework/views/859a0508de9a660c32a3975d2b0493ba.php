

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0">Панель сметчика</h1>
            <p class="text-muted">Добро пожаловать, <?php echo e(Auth::user()->name); ?>!</p>
        </div>
    </div>

    <!-- Статистические карточки -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo e($stats['total_estimates']); ?></h4>
                            <p class="card-text">Смет в работе</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-invoice fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo e($stats['assigned_projects']); ?></h4>
                            <p class="card-text">Назначенных объектов</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo e($stats['pending_estimates']); ?></h4>
                            <p class="card-text">На рассмотрении</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title"><?php echo e($stats['approved_estimates']); ?></h4>
                            <p class="card-text">Утверждено</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Последние сметы -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Последние сметы</h5>
                    <a href="<?php echo e(route('estimator.estimates.index')); ?>" class="btn btn-sm btn-outline-primary">
                        Все сметы
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if($recent_estimates->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $recent_estimates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estimate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <a href="<?php echo e(route('partner.estimates.edit', $estimate)); ?>" class="text-decoration-none">
                                                <?php echo e($estimate->name); ?>

                                            </a>
                                        </h6>
                                        <small><?php echo e($estimate->created_at->diffForHumans()); ?></small>
                                    </div>
                                    <p class="mb-1">
                                        <?php if($estimate->project): ?>
                                            <?php echo e($estimate->project->client_name); ?> - <?php echo e($estimate->project->address); ?>

                                        <?php else: ?>
                                            Не привязана к проекту
                                        <?php endif; ?>
                                    </p>
                                    <small><?php echo $estimate->statusBadge(); ?> <?php echo $estimate->typeBadge(); ?></small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Нет созданных смет</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Сметы, требующие внимания -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Требуют внимания</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($pending_estimates->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $pending_estimates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estimate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <a href="<?php echo e(route('partner.estimates.edit', $estimate)); ?>" class="text-decoration-none">
                                                <?php echo e($estimate->name); ?>

                                            </a>
                                        </h6>
                                        <small><?php echo e($estimate->updated_at->diffForHumans()); ?></small>
                                    </div>
                                    <p class="mb-1">
                                        <?php if($estimate->project): ?>
                                            <?php echo e($estimate->project->client_name); ?>

                                        <?php else: ?>
                                            Не привязана к проекту
                                        <?php endif; ?>
                                    </p>
                                    <small><?php echo $estimate->statusBadge(); ?></small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Все сметы в порядке!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Быстрые действия -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Быстрые действия</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="<?php echo e(route('estimator.estimates.create')); ?>" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-plus-circle me-2"></i>Создать смету
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="<?php echo e(route('estimator.estimates.index')); ?>" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="fas fa-list me-2"></i>Мои сметы
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views/estimator/dashboard.blade.php ENDPATH**/ ?>