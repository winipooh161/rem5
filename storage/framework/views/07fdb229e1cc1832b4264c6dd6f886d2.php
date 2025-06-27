

<?php $__env->startSection('title', 'Доступ запрещен'); ?>
<?php $__env->startSection('code', '403'); ?>
<?php $__env->startSection('icon', '🚫'); ?>
<?php $__env->startSection('message'); ?>
    У вас нет прав доступа к запрошенной странице.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views/errors/403.blade.php ENDPATH**/ ?>