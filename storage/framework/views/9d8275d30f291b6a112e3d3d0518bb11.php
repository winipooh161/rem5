<h5 class="mb-3">Договор</h5>

<div class="contract-container mb-4">
    <?php if($project->contractFiles->isEmpty()): ?>
        <div class="alert alert-info">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-2 fa-lg"></i>
                <div>
                    В этом разделе будут отображаться документы договора и приложения к нему.
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Контейнер для файлов договора -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php $__currentLoopData = $project->contractFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <div class="card h-100 contract-file-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="file-icon me-3">
                                    <i class="far <?php echo e($file->is_image ? 'fa-file-image' : 'fa-file-pdf'); ?> fa-2x text-primary"></i>
                                </div>
                                <div class="file-info">
                                    <h6 class="mb-0 text-truncate" title="<?php echo e($file->original_name); ?>">
                                        <?php echo e($file->original_name); ?>

                                    </h6>
                                    <small class="text-muted"><?php echo e($file->created_at->format('d.m.Y H:i')); ?></small>
                                </div>
                            </div>
                            
                            <?php if($file->description): ?>
                                <p class="card-text small mb-3"><?php echo e($file->description); ?></p>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-secondary"><?php echo e($file->size_formatted); ?></span>
                                <div>
                                    <?php if($file->is_image): ?>
                                        <a href="<?php echo e($file->file_url); ?>" class="btn btn-sm btn-outline-info me-1" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <?php endif; ?>                                    <a href="<?php echo e(route('client.project-files.download', $file->id)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<style>
/* Адаптивные стили для мобильных устройств */
@media (max-width: 576px) {
    .contract-file-card .card-body {
        padding: 0.75rem;
    }
    
    .contract-file-card .file-icon i {
        font-size: 1.5rem;
    }
    
    .contract-file-card h6 {
        font-size: 0.9rem;
        max-width: 170px;
    }
    
    .contract-file-card .btn-sm {
        padding: 0.25rem 0.4rem;
        font-size: 0.75rem;
    }
}
</style>
<?php /**PATH C:\OSPanel\domains\remont\resources\views/client/projects/tabs/contract.blade.php ENDPATH**/ ?>