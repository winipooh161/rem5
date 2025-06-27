<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Схемы и чертежи</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadSchemeModal">
            <i class="fas fa-upload me-1"></i>Загрузить схемы
        </button>
    </div>

    <?php if($project->schemeFiles->isEmpty()): ?>
        <div class="alert alert-info">
            В этом разделе будут отображаться схемы и чертежи по объекту. 
            Нажмите на кнопку "Загрузить схемы", чтобы добавить схемы и чертежи.
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
                        <div class="card-footer d-flex justify-content-between">
                            <a href="<?php echo e($file->download_url); ?>" class="btn btn-sm btn-outline-primary" download>
                                <i class="fas fa-download me-1"></i>Скачать
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-file" data-file-id="<?php echo e($file->id); ?>">
                                <i class="fas fa-trash me-1"></i>Удалить
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<!-- Модальное окно загрузки схем -->
<div class="modal fade" id="uploadSchemeModal" tabindex="-1" aria-labelledby="uploadSchemeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadSchemeModalLabel">Загрузить схемы и чертежи</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadSchemeForm" method="POST" enctype="multipart/form-data" action="<?php echo e(route('partner.project-files.store', $project)); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="file_type" value="scheme">
                    
                    <div class="mb-3">
                        <label for="schemeFile" class="form-label">Выберите файлы для загрузки</label>
                        <input class="form-control" type="file" id="schemeFile" name="file" required>
                        <div class="form-text">Поддерживаются все форматы файлов: JPG, PNG, PDF, DWG, DXF, SVG, CAD и др. без ограничений по размеру.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="schemeType" class="form-label">Тип схемы/чертежа</label>
                        <select class="form-select" id="schemeType" name="document_type">
                            <option value="floor">Планы этажей</option>
                            <option value="electrical">Электрические схемы</option>
                            <option value="plumbing">Водоснабжение/Канализация</option>
                            <option value="ventilation">Вентиляция/Кондиционирование</option>
                            <option value="construction">Строительные чертежи</option>
                            <option value="other">Другое</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="schemeDescription" class="form-label">Описание файла (необязательно)</label>
                        <textarea class="form-control" id="schemeDescription" name="description" rows="2" placeholder="Добавьте краткое описание файла"></textarea>
                    </div>
                    
                    <!-- Контейнер прогресса загрузки (по умолчанию скрыт) -->
                    <div class="upload-progress d-none">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress-info text-center">Загрузка...</div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-primary upload-file-btn">Загрузить</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
<?php /**PATH C:\OSPanel\domains\remont\resources\views\partner\projects\tabs\schemes.blade.php ENDPATH**/ ?>