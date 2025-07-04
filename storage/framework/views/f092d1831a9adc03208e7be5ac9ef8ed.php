

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo e(__('Мой профиль')); ?></h4>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="text-center">
                                <img src="<?php echo e($user->getAvatarUrl()); ?>" alt="<?php echo e($user->name); ?>" class="img-fluid rounded-circle img-thumbnail profile-avatar">
                                <h4 class="mt-3"><?php echo e($user->name); ?></h4>
                                <div class="badge bg-secondary mb-3"><?php echo e(ucfirst($user->role)); ?></div>
                                <div class="d-grid gap-2 mt-3">
                                    <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary">
                                        <i class="fas fa-edit me-2"></i><?php echo e(__('Редактировать профиль')); ?>

                                    </a>
                                    <a href="<?php echo e(route('profile.change-password')); ?>" class="btn btn-outline-primary">
                                        <i class="fas fa-key me-2"></i><?php echo e(__('Изменить пароль')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5><?php echo e(__('Контактная информация')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="text-muted"><?php echo e(__('Имя')); ?>:</label>
                                        <p class="lead"><?php echo e($user->name); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted"><?php echo e(__('Номер телефона')); ?>:</label>
                                        <p class="lead"><?php echo e($user->phone); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted"><?php echo e(__('Email')); ?>:</label>
                                        <p class="lead"><?php echo e($user->email ?? 'Не указан'); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted"><?php echo e(__('Дата регистрации')); ?>:</label>
                                        <p class="lead"><?php echo e($user->created_at->format('d.m.Y')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar {
    width: 200px;
    height: 200px;
    object-fit: cover;
}

/* Мобильная адаптация для профиля */
@media (max-width: 768px) {
    .profile-avatar {
        width: 150px;
        height: 150px;
    }
    
    .card-header h4 {
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 0;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .lead {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .text-muted {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .profile-avatar {
        width: 120px;
        height: 120px;
    }
    
    .card {
        margin: 0.5rem;
        border-radius: 1rem;
    }
    
    .card-header {
        padding: 1rem;
        text-align: center;
    }
    
    .card-header h4 {
        font-size: 1.3rem;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .btn {
        padding: 0.75rem;
        font-size: 0.9rem;
        border-radius: 0.5rem;
    }
    
    .mb-3 {
        margin-bottom: 1rem !important;
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
    }
    
    h4.mt-3 {
        font-size: 1.2rem;
        margin-top: 1rem !important;
    }
    
    .lead {
        font-size: 0.95rem;
    }
    
    .text-muted {
        font-size: 0.85rem;
    }
}

@media (max-width: 400px) {
    .profile-avatar {
        width: 100px;
        height: 100px;
    }
    
    .card {
        margin: 0.25rem;
    }
    
    .card-header h4 {
        font-size: 1.2rem;
    }
    
    h4.mt-3 {
        font-size: 1.1rem;
    }
    
    .btn {
        padding: 0.65rem;
        font-size: 0.85rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\profile\index.blade.php ENDPATH**/ ?>