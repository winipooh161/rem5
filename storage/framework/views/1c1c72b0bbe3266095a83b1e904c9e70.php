

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><?php echo e(__('Массовая отправка уведомлений')); ?></h2>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Вернуться к списку пользователей
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Получатели</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Всего пользователей
                            <span class="badge bg-primary rounded-pill"><?php echo e($stats['total']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Администраторы
                            <span class="badge bg-danger rounded-pill"><?php echo e($stats['by_role']['admins']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Партнеры
                            <span class="badge bg-success rounded-pill"><?php echo e($stats['by_role']['partners']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Клиенты
                            <span class="badge bg-info rounded-pill"><?php echo e($stats['by_role']['clients']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Сметчики
                            <span class="badge bg-secondary rounded-pill"><?php echo e($stats['by_role']['estimators']); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Отправка уведомления</h5>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>
                    
                    <div class="alert alert-info mb-4">
                        <h5><i class="fas fa-info-circle"></i> Информация о способах отправки</h5>
                        <ul class="mb-0">
                            <li><strong>Email:</strong> Отправка на адреса электронной почты пользователей</li>
                            <li><strong>SMS:</strong> Отправка SMS через сервис SMS.ru (на российские номера)</li>
                            <li><strong>Email + SMS:</strong> Отправка через оба канала одновременно</li>
                        </ul>
                    </div>

                    <form action="<?php echo e(route('admin.notifications.send')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="target_type" class="form-label">Кому отправить</label>
                            <select class="form-select <?php $__errorArgs = ['target_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="target_type" name="target_type">
                                <option value="all" <?php echo e(old('target_type') == 'all' ? 'selected' : ''); ?>>Всем пользователям</option>
                                <option value="role" <?php echo e(old('target_type') == 'role' ? 'selected' : ''); ?>>По роли</option>
                            </select>
                            <?php $__errorArgs = ['target_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="mb-3" id="roleSelectContainer" style="display: none;">
                            <label for="role" class="form-label">Выберите роль</label>
                            <select class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="role" name="role">
                                <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Администраторы</option>
                                <option value="partner" <?php echo e(old('role') == 'partner' ? 'selected' : ''); ?>>Партнеры</option>
                                <option value="client" <?php echo e(old('role') == 'client' ? 'selected' : ''); ?>>Клиенты</option>
                                <option value="estimator" <?php echo e(old('role') == 'estimator' ? 'selected' : ''); ?>>Сметчики</option>
                            </select>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="channel" class="form-label">Способ отправки</label>
                            <select class="form-select <?php $__errorArgs = ['channel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="channel" name="channel">
                                <option value="email" <?php echo e(old('channel') == 'email' ? 'selected' : ''); ?>>Email</option>
                                <option value="sms" <?php echo e(old('channel') == 'sms' ? 'selected' : ''); ?>>SMS</option>
                                <option value="both" <?php echo e(old('channel') == 'both' ? 'selected' : ''); ?>>Email + SMS</option>
                            </select>
                            <?php $__errorArgs = ['channel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Тема</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" required>
                            <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Сообщение</label>
                            <textarea class="form-control <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="message" name="message" rows="5" required><?php echo e(old('message')); ?></textarea>
                            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Отправить уведомление</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const targetTypeSelect = document.getElementById('target_type');
        const roleSelectContainer = document.getElementById('roleSelectContainer');
        
        // Показываем/скрываем выбор роли при загрузке страницы
        if (targetTypeSelect.value === 'role') {
            roleSelectContainer.style.display = 'block';
        } else {
            roleSelectContainer.style.display = 'none';
        }
        
        // Показываем/скрываем выбор роли при изменении типа цели
        targetTypeSelect.addEventListener('change', function() {
            if (targetTypeSelect.value === 'role') {
                roleSelectContainer.style.display = 'block';
            } else {
                roleSelectContainer.style.display = 'none';
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\admin\notifications\send.blade.php ENDPATH**/ ?>