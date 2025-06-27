

<?php $__env->startSection('title', 'Ошибка запроса'); ?>
<?php $__env->startSection('code', '422'); ?>
<?php $__env->startSection('icon', '✗'); ?>
<?php $__env->startSection('message'); ?>
    Предоставленные данные не прошли валидацию.
    Пожалуйста, проверьте правильность введенной информации и повторите попытку.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\errors\422.blade.php ENDPATH**/ ?>