

<?php $__env->startSection('title', 'Сервис временно недоступен'); ?>
<?php $__env->startSection('code', '503'); ?>
<?php $__env->startSection('icon', '🔧'); ?>
<?php $__env->startSection('message'); ?>
    Сервис временно недоступен из-за технических работ или большой нагрузки.
    Пожалуйста, попробуйте снова позже.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\errors\503.blade.php ENDPATH**/ ?>