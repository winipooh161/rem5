

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4><?php echo e(__('Изменение пароля')); ?></h4>
                        <a href="<?php echo e(route('profile.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> <?php echo e(__('Назад к профилю')); ?>

                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('profile.update-password')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label for="current_password" class="form-label"><?php echo e(__('Текущий пароль')); ?></label>
                            <input id="current_password" type="password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="current_password" required>
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo e(__('Новый пароль')); ?></label>
                            <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">Минимальная длина: 8 символов</div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label"><?php echo e(__('Подтвердите новый пароль')); ?></label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-2"></i><?php echo e(__('Изменить пароль')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Мобильная адаптация для страницы смены пароля */
@media (max-width: 768px) {
    .col-md-8 {
        padding: 0 0.5rem;
    }
    
    .card-header .d-flex {
        flex-direction: column;
        align-items: stretch !important;
        gap: 1rem;
    }
    
    .card-header h4 {
        text-align: center;
        margin-bottom: 0;
    }
    
    .btn-outline-secondary {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding: 0 0.5rem;
    }
    
    .card {
        margin: 0.5rem 0;
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
        padding: 1rem;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .form-control {
        padding: 0.75rem;
        font-size: 1rem;
        border-radius: 0.5rem;
    }
    
    .btn {
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border-radius: 0.5rem;
        width: 100%;
    }
    
    .form-text {
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }
    
    .mb-3 {
        margin-bottom: 1.5rem !important;
    }
    
    .d-grid.gap-2.d-md-flex {
        display: grid !important;
        gap: 0.75rem !important;
    }
}

@media (max-width: 400px) {
    .card {
        margin: 0.25rem 0;
    }
    
    .card-header h4 {
        font-size: 1.2rem;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .form-control {
        padding: 0.65rem;
        font-size: 0.95rem;
    }
    
    .btn {
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
    }
    
    .form-text {
        font-size: 0.8rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\profile\change-password.blade.php ENDPATH**/ ?>