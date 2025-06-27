

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h2>Отладка файлов проектов</h2>
    <p class="text-muted">Эта страница доступна только в локальном окружении</p>

    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-info">
                <strong>Информация:</strong> Здесь отображаются последние 5 проектов с их файлами для отладки.
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Проект #<?php echo e($project->id); ?>: <?php echo e($project->name); ?>

            </div>
            <div class="card-body">
                <h5>Файлы проекта (<?php echo e($project->files->count()); ?>)</h5>
                
                <?php if($project->files->count() > 0): ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Путь</th>
                                <th>Тип</th>
                                <th>Размер</th>
                                <th>Существует</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $project->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($file->id); ?></td>
                                    <td><?php echo e($file->name); ?></td>
                                    <td><?php echo e($file->path); ?></td>
                                    <td><?php echo e($file->mime_type); ?></td>
                                    <td><?php echo e($file->size); ?> байт</td>
                                    <td>
                                        <?php if($file->exists): ?>
                                            <span class="badge bg-success">Да</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Нет</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>У этого проекта нет файлов.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="mt-4">
        <h3>Тестирование ошибок</h3>
        <p>Используйте ссылки ниже для проверки обработки ошибок в локальном окружении:</p>
        
        <a href="/debug/error-test" class="btn btn-danger">
            Тестировать ошибку с APP_DEBUG
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\debug\project-files.blade.php ENDPATH**/ ?>