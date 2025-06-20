<h5 class="mb-3">Фотоотчет по объекту</h5>
    
<?php if($project->photos->isEmpty()): ?>
    <div class="alert alert-info">
        Пока не загружено ни одной фотографии.
    </div>
<?php else: ?>
    <ul class="nav nav-tabs mb-3" id="photosTab" role="tablist">
        <?php $__currentLoopData = $project->getPhotoCategories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo e($index === 0 ? 'active' : ''); ?>" 
                        id="photo-tab-<?php echo e($index); ?>"
                        data-bs-toggle="tab"
                        data-bs-target="#photo-content-<?php echo e($index); ?>"
                        type="button"
                        role="tab"
                        aria-controls="photo-content-<?php echo e($index); ?>"
                        aria-selected="<?php echo e($index === 0 ? 'true' : 'false'); ?>">
                    <?php echo e($category); ?>

                </button>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    
    <div class="tab-content" id="photosTabContent">
        <?php $__currentLoopData = $project->getPhotoCategories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tab-pane fade <?php echo e($index === 0 ? 'show active' : ''); ?>"
                 id="photo-content-<?php echo e($index); ?>"
                 role="tabpanel"
                 aria-labelledby="photo-tab-<?php echo e($index); ?>">
                
                <div class="row g-3">
                    <?php $__currentLoopData = $project->getPhotosByCategory($category); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <a href="<?php echo e($photo->photo_url); ?>" target="_blank" class="photo-link" data-lightbox="category-<?php echo e($index); ?>">
                                    <img src="<?php echo e($photo->photo_url); ?>" class="card-img-top img-fluid" style="height: 200px; object-fit: cover;" alt="Фото объекта">
                                </a>
                                <div class="card-body">
                                    <p class="card-text small text-muted mb-1">
                                        <?php echo e($photo->created_at->format('d.m.Y H:i')); ?>

                                    </p>
                                    <?php if($photo->comment): ?>
                                        <p class="card-text"><?php echo e($photo->comment); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<style>
/* Улучшения для мобильных устройств */
@media (max-width: 576px) {
    .photo-link img {
        height: 150px !important;
    }
    
    #photosTab {
        overflow-x: auto;
        flex-wrap: nowrap;
        white-space: nowrap;
    }
    
    #photosTab .nav-link {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }
}
</style>
<?php /**PATH C:\OSPanel\domains\remont\resources\views/client/projects/tabs/photos.blade.php ENDPATH**/ ?>