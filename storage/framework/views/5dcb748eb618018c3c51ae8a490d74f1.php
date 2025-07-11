

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-2">Сотрудники</h1>
            <p class="text-muted">Управление сотрудниками-сметчиками</p>
        </div>
        <div class="col-md-4 text-md-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <i class="fas fa-plus-circle me-1"></i>Добавить сотрудника
            </button>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    <?php endif; ?>

    <!-- Список сотрудников -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Мои сотрудники</h5>
        </div>
        <div class="card-body">
            <?php if($employees->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Сотрудник</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Email</th>
                                <th scope="col">Роль</th>
                                <th scope="col">Дата добавления</th>
                                <th scope="col">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo e($employee->getAvatarUrl()); ?>" alt="<?php echo e($employee->name); ?>" 
                                                 class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                            <div>
                                                <div class="fw-bold"><?php echo e($employee->name); ?></div>
                                                <?php if($employee->email): ?>
                                                    <small class="text-muted"><?php echo e($employee->email); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($employee->phone); ?></td>
                                    <td><?php echo e($employee->email ?? 'Не указан'); ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e(ucfirst($employee->role)); ?></span>
                                    </td>
                                    <td><?php echo e($employee->created_at->format('d.m.Y')); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="editEmployee(<?php echo e($employee->id); ?>)" 
                                                    data-bs-toggle="modal" data-bs-target="#editEmployeeModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="removeEmployee(<?php echo e($employee->id); ?>, '<?php echo e($employee->name); ?>')">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>Нет добавленных сотрудников</h5>
                    <p class="text-muted">Добавьте своих сотрудников-сметчиков для совместной работы</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                        <i class="fas fa-plus-circle me-1"></i>Добавить первого сотрудника
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Модальное окно добавления сотрудника -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('partner.employees.store')); ?>" method="POST" id="addEmployeeForm">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Добавить сотрудника</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               placeholder="+7 (___) ___-__-__" required>
                        <div class="form-text">Введите номер телефона сотрудника в формате +7 (790) 000-00-00</div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя сотрудника</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               placeholder="Будет заполнено автоматически при привязке">
                        <div class="form-text">Если пользователь уже зарегистрирован, имя заполнится автоматически</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Добавить сотрудника</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Модальное окно редактирования сотрудника -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editEmployeeForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Редактировать сотрудника</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">Номер телефона <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="edit_phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Имя сотрудника</label>
                        <input type="text" class="form-control" id="edit_name" name="name" readonly>
                        <div class="form-text">Имя берется из профиля пользователя</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Маска для телефона
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '');
            x = x.replace(/^7/, '');
            x = x.substring(0, 10);
            
            let formatted = '+7';
            if (x.length > 0) {
                formatted += ' (' + x.substring(0, 3);
            }
            if (x.length >= 4) {
                formatted += ') ' + x.substring(3, 6);
            }
            if (x.length >= 7) {
                formatted += '-' + x.substring(6, 8);
            }
            if (x.length >= 9) {
                formatted += '-' + x.substring(8, 10);
            }
            
            e.target.value = formatted;
        });
    });
});

function editEmployee(employeeId) {
    // Получаем данные сотрудника для редактирования
    fetch(`/partner/employees/${employeeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_phone').value = data.employee.phone;
                document.getElementById('edit_name').value = data.employee.name;
                document.getElementById('editEmployeeForm').action = `/partner/employees/${employeeId}`;
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Ошибка при загрузке данных сотрудника');
        });
}

function removeEmployee(employeeId, employeeName) {
    if (confirm(`Вы уверены, что хотите убрать сотрудника "${employeeName}" из вашей команды?\n\nЭто действие изменит его роль с "Сметчик" на "Клиент".`)) {
        fetch(`/partner/employees/${employeeId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Ошибка при удалении сотрудника: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при удалении сотрудника');
        });
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views/partner/employees/index.blade.php ENDPATH**/ ?>