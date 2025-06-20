<div class="mb-4">
    <h5 class="mb-3">Схемы и чертежи</h5>

    <?php if($project->schemeFiles->isEmpty()): ?>
        <div class="alert alert-info">
            В этом разделе будут отображаться схемы и чертежи по объекту.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 files-container">
            <?php $__currentLoopData = $project->schemeFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col file-item" data-file-id="<?php echo e($file->id); ?>">
                    <div class="card h-100">
                        <?php if($file->is_image): ?>
                            <div class="card-img-top file-preview" style="height: 140px; background-image: url('<?php echo e(asset('storage/project_files/' . $project->id . '/' . $file->filename)); ?>'); background-size: cover; background-position: center;"></div>
                        <?php else: ?>
                            <div class="card-img-top text-center bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                <i class="<?php echo e($file->file_icon); ?> fa-3x text-secondary"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title text-truncate" title="<?php echo e($file->original_name); ?>"><?php echo e($file->original_name); ?></h6>
                            <p class="card-text text-muted small mb-2">
                                <span><?php echo e(number_format($file->size / 1024, 2)); ?> KB</span>
                                <span class="ms-2"><?php echo e($file->created_at->format('d.m.Y H:i')); ?></span>
                            </p>
                            <p class="card-text small text-muted">
                                <?php echo e($file->description); ?>

                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo e($file->download_url); ?>" class="btn btn-sm btn-outline-primary w-100" download>
                                <i class="fas fa-download me-1"></i>Скачать
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<style>
@media (max-width: 576px) {
    .file-preview {
        height: 120px !important;
    }
    
    .file-item .card {
        margin-bottom: 10px;
    }
    
    .file-item .card-body {
        padding: 0.75rem;
    }
    
    .file-item h6 {
        font-size: 0.9rem;
    }
}
</style>
<?php /**PATH C:\OSPanel\domains\remont\resources\views/client/projects/tabs/schemes.blade.php ENDPATH**/ ?>