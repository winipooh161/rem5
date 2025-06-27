<div class="check-details">
    <?php if(isset($details['title'])): ?>
        <h5 class="mb-3"><?php echo e($details['title']); ?></h5>
    <?php else: ?>
        <h5 class="mb-3">Проверка #<?php echo e($check_id); ?></h5>
    <?php endif; ?>

    <?php if(!empty($details['checkboxes'])): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Пункты проверки</h6>
            </div>
            <div class="card-body">
                <div class="checkbox-list">
                    <?php $__currentLoopData = $details['checkboxes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkbox): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input check-item-checkbox" 
                                   type="checkbox" 
                                   id="check-<?php echo e($checkbox['id']); ?>" 
                                   data-id="<?php echo e($checkbox['id']); ?>"
                                   data-category="<?php echo e($check_id); ?>"
                                   <?php echo e(isset($checkbox['checked']) && $checkbox['checked'] ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="check-<?php echo e($checkbox['id']); ?>">
                                <?php echo e($checkbox['text']); ?>

                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(!empty($details['photos'])): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Фото документация</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php $__currentLoopData = $details['photos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input check-item-checkbox" 
                                               type="checkbox" 
                                               id="photo-<?php echo e(isset($photo['id']) ? $photo['id'] : 'item-'.$loop->index); ?>" 
                                               data-id="<?php echo e(isset($photo['id']) ? $photo['id'] : 'item-'.$loop->index); ?>"
                                               data-category="<?php echo e($check_id); ?>"
                                               <?php echo e(isset($photo['checked']) && $photo['checked'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="photo-<?php echo e(isset($photo['id']) ? $photo['id'] : 'item-'.$loop->index); ?>">
                                            <?php echo e($photo['caption']); ?>

                                        </label>
                                    </div>
                                    
                                    <?php if(isset($photo['image'])): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo e($photo['image']); ?>" class="img-fluid rounded" alt="<?php echo e($photo['caption']); ?>">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">Комментарии</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="comment<?php echo e($check_id); ?>" class="form-label">Комментарий к проверке</label>
                <textarea class="form-control" id="comment<?php echo e($check_id); ?>" rows="3"><?php echo e($details['comment'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>
</div>

<style>
.check-details .card {
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
.check-details .card-header {
    background-color: rgba(0,0,0,0.03);
}
@media (max-width: 768px) {
    .check-details .card-body {
        padding: 1rem;
    }
}
</style>
<?php /**PATH C:\OSPanel\domains\remont\resources\views/partner/projects/partials/check_details.blade.php ENDPATH**/ ?>