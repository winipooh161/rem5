

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><?php echo e(__('Редактирование пользователя')); ?></span>
                        <div>
                            <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="btn btn-sm btn-info me-2">
                                <i class="fas fa-eye"></i> Просмотр
                            </a>
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Назад
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <img src="<?php echo e($user->getAvatarUrl()); ?>" alt="<?php echo e($user->name); ?>" class="img-fluid rounded-circle mb-2" style="max-width: 150px; max-height: 150px;">
                            
                            <?php if($user->avatar): ?>
                                <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>" class="mt-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="hidden" name="remove_avatar" value="1">
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить аватар</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <h4><?php echo e($user->name); ?></h4>
                            <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
                            <p><strong>Телефон:</strong> <?php echo e($user->phone ?? 'Не указан'); ?></p>
                            <p><strong>Роль:</strong> 
                                <span class="badge bg-<?php echo e($user->role == 'admin' ? 'danger' : ($user->role == 'partner' ? 'primary' : ($user->role == 'estimator' ? 'info' : 'secondary'))); ?>">
                                    <?php echo e(ucfirst($user->role)); ?>

                                </span>
                            </p>
                            <p><strong>Дата регистрации:</strong> <?php echo e($user->created_at->format('d.m.Y H:i')); ?></p>
                        </div>
                    </div>

                    <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Имя')); ?></label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                                <?php $__errorArgs = ['name'];
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
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Email')); ?></label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                <?php $__errorArgs = ['email'];
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
                        </div>

                        <div class="mb-3 row">
                            <label for="phone" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Телефон')); ?></label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>">
                                <?php $__errorArgs = ['phone'];
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
                        </div>

                        <div class="mb-3 row">
                            <label for="role" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Роль')); ?></label>
                            <div class="col-md-6">
                                <select id="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="role" required onchange="togglePartnerSelect()">
                                    <option value="client" <?php echo e((old('role', $user->role) == 'client') ? 'selected' : ''); ?>>Клиент</option>
                                    <option value="partner" <?php echo e((old('role', $user->role) == 'partner') ? 'selected' : ''); ?>>Партнер</option>
                                    <option value="estimator" <?php echo e((old('role', $user->role) == 'estimator') ? 'selected' : ''); ?>>Сметчик</option>
                                    <option value="admin" <?php echo e((old('role', $user->role) == 'admin') ? 'selected' : ''); ?>>Администратор</option>
                                </select>
                                <?php $__errorArgs = ['role'];
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
                        </div>
                        
                        <div class="mb-3 row" id="partner-select-container" style="display: none;">
                            <label for="partner_id" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Выберите партнера')); ?></label>
                            <div class="col-md-6">
                                <select id="partner_id" class="form-select <?php $__errorArgs = ['partner_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="partner_id">
                                    <option value="">Выберите партнера</option>
                                    <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($partner->id); ?>" <?php echo e(old('partner_id', $user->partner_id) == $partner->id ? 'selected' : ''); ?>>
                                            <?php echo e($partner->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['partner_id'];
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
                        </div>

                        <div class="mb-3 row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Изменить аватар')); ?></label>
                            <div class="col-md-6">
                                <input id="avatar" type="file" class="form-control <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="avatar" accept="image/*">
                                <small class="form-text text-muted">Допустимые форматы: JPG, PNG, GIF. Максимальный размер: 2МБ.</small>
                                <?php $__errorArgs = ['avatar'];
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
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Новый пароль')); ?></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password">
                                    <button type="button" class="btn btn-outline-secondary" onclick="generatePassword()">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">Оставьте пустым, если не хотите менять пароль.</small>
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
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Подтверждение пароля')); ?></label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(__('Сохранить изменения')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <hr>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Быстрые действия</h5>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <form method="POST" action="<?php echo e(route('admin.users.reset-password', $user)); ?>" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите сбросить пароль этому пользователю?');">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-key"></i> Сбросить пароль
                                    </button>
                                </form>
                                
                                <?php if(isset($user->is_active)): ?>
                                <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn <?php echo e($user->is_active ? 'btn-secondary' : 'btn-success'); ?>">
                                        <i class="fas <?php echo e($user->is_active ? 'fa-ban' : 'fa-check-circle'); ?>"></i> 
                                        <?php echo e($user->is_active ? 'Деактивировать' : 'Активировать'); ?>

                                    </button>
                                </form>
                                <?php endif; ?>
                                
                                <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя? Это действие необратимо.');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Удалить пользователя
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePartnerSelect() {
        var roleSelect = document.getElementById('role');
        var partnerSelectContainer = document.getElementById('partner-select-container');
        
        if (roleSelect.value === 'estimator') {
            partnerSelectContainer.style.display = 'flex';
        } else {
            partnerSelectContainer.style.display = 'none';
        }
    }
    
    function generatePassword() {
        // Генерируем случайный пароль длиной 10 символов
        var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        var password = '';
        for (var i = 0; i < 10; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        
        // Устанавливаем пароль в оба поля
        document.getElementById('password').value = password;
        document.getElementById('password-confirm').value = password;
        
        // Опционально: показываем пароль пользователю
        alert('Сгенерированный пароль: ' + password);
    }
    
    // Вызываем функцию при загрузке страницы для корректного отображения
    document.addEventListener('DOMContentLoaded', function() {
        togglePartnerSelect();
    });
</script>
                                </select>

                                <?php $__errorArgs = ['role'];
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
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Новый пароль')); ?></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" autocomplete="new-password">
                                <small class="form-text text-muted">Оставьте поле пустым, если не хотите менять пароль</small>

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
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Подтверждение пароля')); ?></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-3 row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(__('Сохранить')); ?>

                                </button>
                                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                                    <?php echo e(__('Отмена')); ?>

                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\admin\users\edit.blade.php ENDPATH**/ ?>