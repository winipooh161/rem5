

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><?php echo e(__('Управление пользователями')); ?></h2>
                <div>
                    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-success mb-2">
                        <i class="fas fa-plus"></i> Добавить пользователя
                    </a>
                    <a href="<?php echo e(route('admin.notifications.form')); ?>" class="btn btn-warning mb-2 ms-2">
                        <i class="fas fa-envelope"></i> Отправить уведомления
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Карточки со статистикой -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Всего пользователей</h5>
                    <p class="card-text display-4"><?php echo e($stats['total']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Администраторы</h5>
                    <p class="card-text display-4"><?php echo e($stats['admins']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Партнеры</h5>
                    <p class="card-text display-4"><?php echo e($stats['partners']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Клиенты</h5>
                    <p class="card-text display-4"><?php echo e($stats['clients']); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <span class="h5 m-0"><?php echo e(__('Список пользователей')); ?></span>
                        <div class="d-flex align-items-center">
                            <!-- Фильтры -->
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter"></i> Фильтры
                                </button>
                                <div class="dropdown-menu p-3" style="min-width: 250px;">
                                    <form method="GET" action="<?php echo e(route('admin.users.index')); ?>">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Роль</label>
                                            <select class="form-select" name="role" id="role">
                                                <option value="all" <?php echo e(request('role') == 'all' ? 'selected' : ''); ?>>Все</option>
                                                <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Администраторы</option>
                                                <option value="partner" <?php echo e(request('role') == 'partner' ? 'selected' : ''); ?>>Партнеры</option>
                                                <option value="client" <?php echo e(request('role') == 'client' ? 'selected' : ''); ?>>Клиенты</option>
                                                <option value="estimator" <?php echo e(request('role') == 'estimator' ? 'selected' : ''); ?>>Сметчики</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sort" class="form-label">Сортировка</label>
                                            <select class="form-select" name="sort" id="sort">
                                                <option value="created_at" <?php echo e(request('sort') == 'created_at' ? 'selected' : ''); ?>>Дата регистрации</option>
                                                <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Имя</option>
                                                <option value="email" <?php echo e(request('sort') == 'email' ? 'selected' : ''); ?>>Email</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="direction" class="form-label">Направление</label>
                                            <select class="form-select" name="direction" id="direction">
                                                <option value="desc" <?php echo e(request('direction') == 'desc' ? 'selected' : ''); ?>>По убыванию</option>
                                                <option value="asc" <?php echo e(request('direction') == 'asc' ? 'selected' : ''); ?>>По возрастанию</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Применить</button>
                                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">Сбросить</a>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Поиск -->
                            <form method="GET" action="<?php echo e(route('admin.users.search')); ?>" class="d-flex me-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Поиск..." value="<?php echo e(request('q') ?? ''); ?>">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Экспорт/Импорт -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                                    <i class="fas fa-download"></i> Экспорт/Импорт
                                </button>
                                <div class="dropdown-menu">
                                    <h6 class="dropdown-header">Экспорт</h6>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.users.export', ['format' => 'xlsx'])); ?>">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </a>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.users.export', ['format' => 'csv'])); ?>">
                                        <i class="fas fa-file-csv"></i> CSV
                                    </a>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.users.export', ['format' => 'pdf'])); ?>">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">Импорт</h6>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importModal">
                                        <i class="fas fa-file-import"></i> Импорт из файла
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    
                    <?php if(session('new_password')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Новый пароль:</strong> <?php echo e(session('new_password')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form id="bulkActionForm" action="<?php echo e(route('admin.users.bulk-action')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="40">
                                            <div class="form-check">
                                                <input class="form-check-input select-all" type="checkbox" value="" id="selectAll">
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Аватар</th>
                                        <th>Имя</th>
                                        <th>Email/Телефон</th>
                                        <th>Роль</th>
                                        <th>Дата регистрации</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input user-checkbox" type="checkbox" name="user_ids[]" value="<?php echo e($user->id); ?>">
                                            </div>
                                        </td>
                                        <td><?php echo e($user->id); ?></td>
                                        <td>
                                            <img src="<?php echo e($user->getAvatarUrl()); ?>" alt="<?php echo e($user->name); ?>" class="rounded-circle" width="40" height="40">
                                        </td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td>
                                            <div><?php echo e($user->email); ?></div>
                                            <small class="text-muted"><?php echo e($user->phone); ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($user->role == 'admin' ? 'danger' : ($user->role == 'partner' ? 'primary' : ($user->role == 'estimator' ? 'info' : 'secondary'))); ?>">
                                                <?php echo e(ucfirst($user->role)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($user->created_at->format('d.m.Y H:i')); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Действия
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="dropdown-item">
                                                            <i class="fas fa-eye"></i> Просмотр
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="dropdown-item">
                                                            <i class="fas fa-edit"></i> Редактировать
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#resetPasswordModal<?php echo e($user->id); ?>">
                                                            <i class="fas fa-key"></i> Сбросить пароль
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changeRoleModal<?php echo e($user->id); ?>">
                                                            <i class="fas fa-user-tag"></i> Изменить роль
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sendNotificationModal<?php echo e($user->id); ?>">
                                                            <i class="fas fa-bell"></i> Отправить уведомление
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal<?php echo e($user->id); ?>">
                                                            <i class="fas fa-trash"></i> Удалить
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <!-- Модальное окно сброса пароля -->
                                            <div class="modal fade" id="resetPasswordModal<?php echo e($user->id); ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Сбросить пароль</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Вы уверены, что хотите сбросить пароль для пользователя <strong><?php echo e($user->name); ?></strong>?</p>
                                                            <p>Новый случайный пароль будет сгенерирован автоматически.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                            <form action="<?php echo e(route('admin.users.reset-password', $user)); ?>" method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <button type="submit" class="btn btn-primary">Сбросить пароль</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Модальное окно изменения роли -->
                                            <div class="modal fade" id="changeRoleModal<?php echo e($user->id); ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Изменить роль</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?php echo e(route('admin.users.change-role', $user)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="role<?php echo e($user->id); ?>" class="form-label">Выберите новую роль</label>
                                                                    <select class="form-select" id="role<?php echo e($user->id); ?>" name="role" required>
                                                                        <option value="admin" <?php echo e($user->role === 'admin' ? 'selected' : ''); ?>>Администратор</option>
                                                                        <option value="partner" <?php echo e($user->role === 'partner' ? 'selected' : ''); ?>>Партнер</option>
                                                                        <option value="client" <?php echo e($user->role === 'client' ? 'selected' : ''); ?>>Клиент</option>
                                                                        <option value="estimator" <?php echo e($user->role === 'estimator' ? 'selected' : ''); ?>>Сметчик</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div id="partnerSelectContainer<?php echo e($user->id); ?>" class="mb-3" style="<?php echo e($user->role === 'estimator' ? '' : 'display: none;'); ?>">
                                                                    <label for="partner_id<?php echo e($user->id); ?>" class="form-label">Выберите партнера для сметчика</label>
                                                                    <select class="form-select" id="partner_id<?php echo e($user->id); ?>" name="partner_id">
                                                                        <option value="">-- Выберите партнера --</option>
                                                                        <?php $__currentLoopData = App\Models\User::where('role', 'partner')->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($partner->id); ?>" <?php echo e(($user->partner_id == $partner->id) ? 'selected' : ''); ?>>
                                                                                <?php echo e($partner->name); ?>

                                                                            </option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                                <button type="submit" class="btn btn-primary">Изменить роль</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Модальное окно отправки уведомления -->
                                            <div class="modal fade" id="sendNotificationModal<?php echo e($user->id); ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Отправить уведомление</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?php echo e(route('admin.users.send-notification', $user)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="subject<?php echo e($user->id); ?>" class="form-label">Тема</label>
                                                                    <input type="text" class="form-control" id="subject<?php echo e($user->id); ?>" name="subject" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message<?php echo e($user->id); ?>" class="form-label">Сообщение</label>
                                                                    <textarea class="form-control" id="message<?php echo e($user->id); ?>" name="message" rows="5" required></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="channel<?php echo e($user->id); ?>" class="form-label">Способ отправки</label>
                                                                    <select class="form-select" id="channel<?php echo e($user->id); ?>" name="channel">
                                                                        <option value="email">Email</option>
                                                                        <option value="sms">SMS</option>
                                                                        <option value="both">Email + SMS</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                                <button type="submit" class="btn btn-primary">Отправить</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Модальное окно удаления пользователя -->
                                            <div class="modal fade" id="deleteUserModal<?php echo e($user->id); ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Удаление пользователя</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Вы действительно хотите удалить пользователя <strong><?php echo e($user->name); ?></strong>?</p>
                                                            <p class="text-danger">Это действие невозможно отменить!</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                            <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="btn btn-danger">Удалить</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Пользователи не найдены</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Групповые действия -->
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <span class="me-3">С выбранными:</span>
                                <select name="action" class="form-select me-2" style="width: auto;">
                                    <option value="" selected>Выберите действие</option>
                                    <option value="delete">Удалить</option>
                                    <option value="activate">Активировать</option>
                                    <option value="deactivate">Деактивировать</option>
                                    <option value="change_role">Изменить роль</option>
                                </select>
                                <div id="roleSelectContainer" style="display: none;" class="me-2">
                                    <select name="role" class="form-select">
                                        <option value="admin">Администратор</option>
                                        <option value="partner">Партнер</option>
                                        <option value="client">Клиент</option>
                                        <option value="estimator">Сметчик</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" id="applyBulkAction" disabled>Применить</button>
                            </div>
                        </div>
                    </form>

                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($users->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно импорта -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Импорт пользователей</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.users.import')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <?php if(session('import_errors')): ?>
                        <div class="alert alert-danger">
                            <h6>Ошибки при импорте:</h6>
                            <ul class="list-unstyled">
                                <?php $__currentLoopData = session('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">Выберите файл (CSV или XLSX)</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".csv,.xlsx" required>
                        <div class="form-text">
                            Файл должен содержать следующие столбцы: name, email, phone, role
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="<?php echo e(route('admin.users.export', ['format' => 'csv', 'template' => true])); ?>" class="btn btn-outline-secondary btn-sm me-2">
                            <i class="fas fa-download"></i> Скачать шаблон CSV
                        </a>
                        <a href="<?php echo e(route('admin.users.export', ['format' => 'xlsx', 'template' => true])); ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-download"></i> Скачать шаблон XLSX
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Импортировать</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/admin-users.js')); ?>?v=<?php echo e(time()); ?>"></script>
<script src="<?php echo e(asset('js/admin-users-actions.js')); ?>?v=<?php echo e(time()); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\admin\users\index.blade.php ENDPATH**/ ?>