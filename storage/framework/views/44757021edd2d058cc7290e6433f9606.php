

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Добро пожаловать на портал ремонтных услуг</h4>
                </div>
                <div class="card-body">
                    <?php if(auth()->guard()->guest()): ?>
                        <div class="alert alert-info">
                            Пожалуйста, <a href="<?php echo e(route('login')); ?>">войдите</a> или <a href="<?php echo e(route('register')); ?>">зарегистрируйтесь</a>, чтобы получить доступ ко всем функциям.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success">
                            Вы успешно вошли в систему!
                        </div>
                    <?php endif; ?>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">Последние новости</div>
                                <div class="card-body">
                                    <p>Здесь будут отображаться последние новости и обновления системы.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">Популярные услуги</div>
                                <div class="card-body">
                                    <p>Здесь будут отображаться популярные услуги и предложения.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\home.blade.php ENDPATH**/ ?>