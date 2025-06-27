

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">Личный кабинет клиента</h1>
            <p class="text-muted">Добро пожаловать, <?php echo e(Auth::user()->name); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Всего объектов</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($projects->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Активные объекты</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($activeProjects); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hammer fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Завершенные объекты</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($completedProjects); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Мои объекты</h6>
                    <a href="<?php echo e(route('client.projects.index')); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-list me-1"></i>Все объекты
                    </a>
                </div>
                <div class="card-body">
                    <?php if($projects->isEmpty()): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">У вас пока нет объектов</h5>
                            <p>Объекты появятся здесь, когда партнер создаст их с вашим номером телефона</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th>Адрес</th>
                                        <th>Статус</th>
                                        <th>Дата обновления</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $projects->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($project->client_name); ?></td>
                                            <td><?php echo e($project->address); ?></td>
                                            <td>
                                                <span class="badge <?php echo e($project->status == 'active' ? 'bg-success' : ($project->status == 'paused' ? 'bg-warning' : ($project->status == 'completed' ? 'bg-info' : 'bg-secondary'))); ?>">
                                                    <?php echo e(ucfirst($project->status)); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e($project->updated_at->format('d.m.Y')); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('client.projects.show', $project)); ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\client\dashboard.blade.php ENDPATH**/ ?>