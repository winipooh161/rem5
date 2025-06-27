

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><?php echo e(__('Просмотр пользователя')); ?></span>
                        <div>
                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-primary me-2">
                                <i class="fas fa-edit"></i> Редактировать
                            </a>
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Назад к списку
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="<?php echo e($user->getAvatarUrl()); ?>" alt="<?php echo e($user->name); ?>" class="img-fluid rounded-circle mb-2" style="max-width: 150px; max-height: 150px;">
                        <h3><?php echo e($user->name); ?></h3>
                        <span class="badge bg-<?php echo e($user->role == 'admin' ? 'danger' : ($user->role == 'partner' ? 'primary' : ($user->role == 'estimator' ? 'info' : 'secondary'))); ?> mb-3">
                            <?php echo e(ucfirst($user->role)); ?>

                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">ID</th>
                                    <td><?php echo e($user->id); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo e($user->email); ?></td>
                                </tr>
                                <tr>
                                    <th>Телефон</th>
                                    <td><?php echo e($user->phone ?? 'Не указан'); ?></td>
                                </tr>
                                <?php if($user->isEstimator() && $user->partner_id): ?>
                                    <tr>
                                        <th>Прикреплен к партнеру</th>
                                        <td>
                                            <?php if($partner = \App\Models\User::find($user->partner_id)): ?>
                                                <a href="<?php echo e(route('admin.users.show', $partner)); ?>"><?php echo e($partner->name); ?></a>
                                            <?php else: ?>
                                                Партнер не найден (ID: <?php echo e($user->partner_id); ?>)
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>Дата регистрации</th>
                                    <td><?php echo e($user->created_at->format('d.m.Y H:i')); ?></td>
                                </tr>
                                <tr>
                                    <th>Последнее обновление</th>
                                    <td><?php echo e($user->updated_at->format('d.m.Y H:i')); ?></td>
                                </tr>
                                <?php if(isset($user->email_verified_at)): ?>
                                <tr>
                                    <th>Email подтвержден</th>
                                    <td>
                                        <?php if($user->email_verified_at): ?>
                                            <span class="text-success">Да, <?php echo e($user->email_verified_at->format('d.m.Y H:i')); ?></span>
                                        <?php else: ?>
                                            <span class="text-danger">Нет</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if(isset($relatedData) && count($relatedData) > 0): ?>
                    <div class="mt-4">
                        <h5>Связанные данные</h5>
                        
                        <?php if($user->isPartner()): ?>
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <strong>Проекты (<?php echo e($relatedData['projects_count'] ?? 0); ?>)</strong>
                                </div>
                                <div class="card-body">
                                    <?php if(isset($relatedData['recent_projects']) && count($relatedData['recent_projects']) > 0): ?>
                                        <p>Последние проекты:</p>
                                        <div class="list-group">
                                            <?php $__currentLoopData = $relatedData['recent_projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="/partner/projects/<?php echo e($project->id); ?>" class="list-group-item list-group-item-action">
                                                    <?php echo e($project->name); ?> (<?php echo e($project->address); ?>)
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <p>Нет проектов</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif($user->isClient()): ?>
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <strong>Проекты клиента</strong>
                                </div>
                                <div class="card-body">
                                    <?php if(isset($relatedData['projects']) && count($relatedData['projects']) > 0): ?>
                                        <div class="list-group">
                                            <?php $__currentLoopData = $relatedData['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="/partner/projects/<?php echo e($project->id); ?>" class="list-group-item list-group-item-action">
                                                    <?php echo e($project->name); ?> (<?php echo e($project->address); ?>)
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <p>Нет проектов</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif($user->isEstimator()): ?>
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <strong>Проекты сметчика</strong>
                                </div>
                                <div class="card-body">
                                    <?php if(isset($relatedData['projects']) && count($relatedData['projects']) > 0): ?>
                                        <div class="list-group">
                                            <?php $__currentLoopData = $relatedData['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="/partner/projects/<?php echo e($project->id); ?>" class="list-group-item list-group-item-action">
                                                    <?php echo e($project->name); ?> (<?php echo e($project->address); ?>)
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <p>Нет проектов</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-center mt-3">
                        <div class="btn-group" role="group">
                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Редактировать
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.users.reset-password', $user)); ?>" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите сбросить пароль этому пользователю?');">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key"></i> Сбросить пароль
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i> <?php echo e(__('Удалить')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\admin\users\show.blade.php ENDPATH**/ ?>