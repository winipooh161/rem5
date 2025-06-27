

<?php $__env->startSection('title', 'Слишком много запросов'); ?>
<?php $__env->startSection('code', '429'); ?>
<?php $__env->startSection('icon', '🛑'); ?>
<?php $__env->startSection('message'); ?>
    Вы отправили слишком много запросов.
    Пожалуйста, подождите некоторое время перед повторной попыткой.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\errors\429.blade.php ENDPATH**/ ?>