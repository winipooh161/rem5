

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="h3 mb-2 mb-md-0">Шаблоны Excel</h1>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Шаблоны смет</h5>
                </div>
                <div class="card-body">
                    <p class="mb-4">Шаблон сметы содержит структуру для создания смет с автоматическим расчетом стоимости работ и материалов.</p>
                    
                    <a href="<?php echo e(route('partner.templates.estimate-excel')); ?>" class="btn btn-primary mb-3">
                        <i class="fas fa-download me-2"></i>Скачать шаблон сметы
                    </a>
                    
                    <div class="mt-4">
                        <h6>Инструкция по использованию:</h6>
                        <ol>
                            <li>Скачайте шаблон.</li>
                            <li>Заполните название сметы, объект и заказчика.</li>
                            <li>Внесите позиции в соответствующие строки.</li>
                            <li>Укажите количество, цены и при необходимости - наценки и скидки.</li>
                            <li>Стоимость будет рассчитана автоматически.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views\partner\templates\excel.blade.php ENDPATH**/ ?>