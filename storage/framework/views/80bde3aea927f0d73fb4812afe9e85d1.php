

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4><?php echo e(__('Редактирование профиля')); ?></h4>
                     
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <img id="avatar-preview" src="<?php echo e($user->getAvatarUrl()); ?>" alt="<?php echo e($user->name); ?>" class="img-fluid rounded-circle img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="avatar" class="form-label"><?php echo e(__('Изменить аватар')); ?></label>
                                        <input id="avatar" type="file" class="form-control <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="avatar" accept="image/*">
                                        <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="form-text">Допустимые форматы: JPG, PNG, GIF. Максимальный размер: 2MB</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><?php echo e(__('Имя')); ?></label>
                                    <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name', $user->name)); ?>" required autocomplete="name">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label"><?php echo e(__('Номер телефона')); ?></label>
                                    <div class="input-group">
                                        <input id="phone" type="tel" class="form-control maskphone <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" required autocomplete="tel" placeholder="+7 (___) ___-__-__" readonly>
                                        <button type="button" class="btn btn-outline-primary" id="changePhoneBtn">
                                            <i class="fas fa-edit me-1"></i><?php echo e(__('Изменить')); ?>

                                        </button>
                                    </div>
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted"><?php echo e(__('Для изменения номера телефона требуется подтверждение через SMS')); ?></small>
                                </div>

                                <!-- Скрытая секция для изменения номера телефона -->
                                <div class="phone-change-section d-none mb-4">
                                    <div class="card border-warning">
                                        <div class="card-header bg-warning text-dark">
                                            <h6 class="mb-0"><i class="fas fa-mobile-alt me-2"></i><?php echo e(__('Изменение номера телефона')); ?></h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <?php echo e(__('Для смены номера телефона сначала подтвердите текущий номер с помощью SMS-кода')); ?>

                                            </div>
                                            
                                            <div class="verification-step" id="currentPhoneVerification">
                                                <h6><?php echo e(__('Шаг 1: Подтвердите текущий номер')); ?></h6>
                                                <p class="text-muted"><?php echo e(__('Мы отправим SMS-код на ваш текущий номер')); ?>: <strong><?php echo e($user->phone); ?></strong></p>
                                                
                                                <div class="mb-3">
                                                    <button type="button" class="btn btn-primary" id="sendCurrentPhoneCode">
                                                        <?php echo e(__('Отправить код на текущий номер')); ?>

                                                    </button>
                                                </div>
                                                
                                                <div class="code-verification-section d-none">
                                                    <label class="form-label"><?php echo e(__('Введите код из SMS')); ?></label>
                                                    <div class="d-flex align-items-center gap-2 mb-3">
                                                        <div class="code-inputs d-flex gap-2">
                                                            <input type="text" class="form-control code-digit text-center" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="0" style="width: 50px;">
                                                            <input type="text" class="form-control code-digit text-center" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="1" style="width: 50px;">
                                                            <input type="text" class="form-control code-digit text-center" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="2" style="width: 50px;">
                                                            <input type="text" class="form-control code-digit text-center" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="3" style="width: 50px;">
                                                        </div>
                                                        <button type="button" class="btn btn-success" id="verifyCurrentPhone" disabled>
                                                            <?php echo e(__('Подтвердить')); ?>

                                                        </button>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button type="button" class="btn btn-link p-0" id="resendCurrentCode" disabled>
                                                            <?php echo e(__('Отправить повторно')); ?> <span id="currentTimer"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="cancelPhoneChange">
                                                            <?php echo e(__('Отмена')); ?>

                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="verification-step d-none" id="newPhoneInput">
                                                <h6 class="text-success"><?php echo e(__('Шаг 2: Введите новый номер телефона')); ?></h6>
                                                <div class="mb-3">
                                                    <label for="new_phone" class="form-label"><?php echo e(__('Новый номер телефона')); ?></label>
                                                    <input id="new_phone" type="tel" class="form-control maskphone" name="new_phone" placeholder="+7 (___) ___-__-__">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <button type="button" class="btn btn-primary" id="saveNewPhone">
                                                    <i class="fas fa-save me-2"></i><?php echo e(__('Сохранить новый номер')); ?>

                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
                                    <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email', $user->email)); ?>" autocomplete="email">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Разделы для партнеров и администраторов -->
                                <?php if(auth()->user()->role === 'partner' || auth()->user()->role === 'admin'): ?>
                                    <hr class="my-4">
                                    <h5 class="mb-4"><?php echo e(__('Банковские реквизиты')); ?></h5>

                                    <div class="mb-3">
                                        <label for="bank" class="form-label"><?php echo e(__('Банк')); ?></label>
                                        <input id="bank" type="text" class="form-control <?php $__errorArgs = ['bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="bank" value="<?php echo e(old('bank', $user->bank)); ?>" placeholder="ФИЛИАЛ &quot;ЦЕНТРАЛЬНЫЙ&quot; БАНКА ВТБ ПАО Г. МОСКВА">
                                        <?php $__errorArgs = ['bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bik" class="form-label"><?php echo e(__('БИК')); ?></label>
                                            <input id="bik" type="text" class="form-control <?php $__errorArgs = ['bik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="bik" value="<?php echo e(old('bik', $user->bik)); ?>">
                                            <?php $__errorArgs = ['bik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="checking_account" class="form-label"><?php echo e(__('Р/с')); ?></label>
                                            <input id="checking_account" type="text" class="form-control <?php $__errorArgs = ['checking_account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="checking_account" value="<?php echo e(old('checking_account', $user->checking_account)); ?>">
                                            <?php $__errorArgs = ['checking_account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="correspondent_account" class="form-label"><?php echo e(__('К/с')); ?></label>
                                        <input id="correspondent_account" type="text" class="form-control <?php $__errorArgs = ['correspondent_account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="correspondent_account" value="<?php echo e(old('correspondent_account', $user->correspondent_account)); ?>">
                                        <?php $__errorArgs = ['correspondent_account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="recipient_bank" class="form-label"><?php echo e(__('Банк получателя')); ?></label>
                                        <input id="recipient_bank" type="text" class="form-control <?php $__errorArgs = ['recipient_bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="recipient_bank" value="<?php echo e(old('recipient_bank', $user->recipient_bank)); ?>">
                                        <?php $__errorArgs = ['recipient_bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inn" class="form-label"><?php echo e(__('ИНН')); ?></label>
                                            <input id="inn" type="text" class="form-control <?php $__errorArgs = ['inn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="inn" value="<?php echo e(old('inn', $user->inn)); ?>">
                                            <?php $__errorArgs = ['inn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kpp" class="form-label"><?php echo e(__('КПП')); ?></label>
                                            <input id="kpp" type="text" class="form-control <?php $__errorArgs = ['kpp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="kpp" value="<?php echo e(old('kpp', $user->kpp)); ?>">
                                            <?php $__errorArgs = ['kpp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h5 class="mb-4"><?php echo e(__('Подпись и печать')); ?></h5>

                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3">
                                            <label for="signature_file" class="form-label"><?php echo e(__('Файл подписи')); ?></label>
                                            <input id="signature_file" type="file" class="form-control <?php $__errorArgs = ['signature_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="signature_file" accept="image/*">
                                            <?php $__errorArgs = ['signature_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <div class="form-text">Допустимые форматы: JPG, PNG, GIF. Максимальный размер: 2MB</div>
                                            
                                            <?php if($user->signature_file): ?>
                                                <div class="mt-2">
                                                    <img src="<?php echo e($user->getSignatureUrl()); ?>" alt="Подпись" class="img-thumbnail" style="max-height: 100px;">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="stamp_file" class="form-label"><?php echo e(__('Файл печати')); ?></label>
                                            <input id="stamp_file" type="file" class="form-control <?php $__errorArgs = ['stamp_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="stamp_file" accept="image/*">
                                            <?php $__errorArgs = ['stamp_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <div class="form-text">Допустимые форматы: JPG, PNG, GIF. Максимальный размер: 2MB</div>
                                            
                                            <?php if($user->stamp_file): ?>
                                                <div class="mt-2">
                                                    <img src="<?php echo e($user->getStampUrl()); ?>" alt="Печать" class="img-thumbnail" style="max-height: 100px;">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i><?php echo e(__('Сохранить изменения')); ?>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Предварительный просмотр аватара
    document.getElementById('avatar').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Инициализация маски для телефона
    function initPhoneMask() {
        var inputs = document.querySelectorAll("input.maskphone");
        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            input.addEventListener("input", mask);
            input.addEventListener("focus", mask);
            input.addEventListener("blur", mask);
        }
        
        function mask(event) {
            var blank = "+_ (___) ___-__-__";
            var i = 0;
            var val = this.value.replace(/\D/g, "").replace(/^8/, "7").replace(/^9/, "79");
            this.value = blank.replace(/./g, function (char) {
                if (/[_\d]/.test(char) && i < val.length) return val.charAt(i++);
                return i >= val.length ? "" : char;
            });
            if (event.type == "blur") {
                if (this.value.length == 2) this.value = "";
            }
        }
    }

    // Система верификации номера телефона
    const changePhoneBtn = document.getElementById('changePhoneBtn');
    const phoneChangeSection = document.querySelector('.phone-change-section');
    const sendCurrentPhoneCode = document.getElementById('sendCurrentPhoneCode');
    const codeVerificationSection = document.querySelector('.code-verification-section');
    const codeDigits = document.querySelectorAll('.code-digit');
    const verifyCurrentPhone = document.getElementById('verifyCurrentPhone');
    const cancelPhoneChange = document.getElementById('cancelPhoneChange');
    const resendCurrentCode = document.getElementById('resendCurrentCode');
    const currentTimer = document.getElementById('currentTimer');
    const currentPhoneVerification = document.getElementById('currentPhoneVerification');
    const newPhoneInput = document.getElementById('newPhoneInput');
    const saveNewPhone = document.getElementById('saveNewPhone');
    const phoneInput = document.getElementById('phone');
    const newPhoneField = document.getElementById('new_phone');
    
    let currentTimer_interval;
    let currentCountdown = 60;
    let isCurrentPhoneVerified = false;
    
    // Инициализация маски
    initPhoneMask();
    
    // Показать секцию изменения номера
    changePhoneBtn.addEventListener('click', function() {
        phoneChangeSection.classList.remove('d-none');
        changePhoneBtn.style.display = 'none';
    });
    
    // Отмена изменения номера
    cancelPhoneChange.addEventListener('click', function() {
        phoneChangeSection.classList.add('d-none');
        changePhoneBtn.style.display = 'block';
        resetPhoneChangeForm();
    });
    
    // Сброс формы изменения номера
    function resetPhoneChangeForm() {
        codeVerificationSection.classList.add('d-none');
        currentPhoneVerification.classList.remove('d-none');
        newPhoneInput.classList.add('d-none');
        clearCodeInputs();
        isCurrentPhoneVerified = false;
        newPhoneField.value = '';
        clearInterval(currentTimer_interval);
        resendCurrentCode.disabled = false;
        currentTimer.textContent = '';
    }
    
    // Отправка кода на текущий номер
    sendCurrentPhoneCode.addEventListener('click', function() {
        sendCurrentPhoneCode.disabled = true;
        sendCurrentPhoneCode.textContent = 'Отправляем...';
        
        fetch('<?php echo e(route("profile.send-phone-verification-code")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                phone: phoneInput.value,
                type: 'current'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert('success', data.message);
                codeVerificationSection.classList.remove('d-none');
                startCurrentTimer();
                codeDigits[0].focus();
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Произошла ошибка при отправке кода');
        })
        .finally(() => {
            sendCurrentPhoneCode.disabled = false;
            sendCurrentPhoneCode.textContent = 'Отправить код на текущий номер';
        });
    });
    
    // Таймер для повторной отправки
    function startCurrentTimer() {
        currentCountdown = 60;
        resendCurrentCode.disabled = true;
        currentTimer.textContent = `(${currentCountdown})`;
        
        clearInterval(currentTimer_interval);
        currentTimer_interval = setInterval(() => {
            currentCountdown--;
            currentTimer.textContent = `(${currentCountdown})`;
            
            if (currentCountdown <= 0) {
                clearInterval(currentTimer_interval);
                resendCurrentCode.disabled = false;
                currentTimer.textContent = '';
            }
        }, 1000);
    }
    
    // Обработка ввода кода
    codeDigits.forEach((input, index) => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value) {
                if (index < codeDigits.length - 1) {
                    codeDigits[index + 1].focus();
                }
            }
            
            checkCodeComplete();
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                codeDigits[index - 1].focus();
                codeDigits[index - 1].value = '';
            }
        });
    });
    
    // Проверка заполнения всех полей кода
    function checkCodeComplete() {
        const code = Array.from(codeDigits).map(input => input.value).join('');
        verifyCurrentPhone.disabled = code.length !== 4;
    }
    
    // Очистка полей кода
    function clearCodeInputs() {
        codeDigits.forEach(input => {
            input.value = '';
            input.classList.remove('is-invalid');
        });
        verifyCurrentPhone.disabled = true;
    }
    
    // Подтверждение текущего номера
    verifyCurrentPhone.addEventListener('click', function() {
        const code = Array.from(codeDigits).map(input => input.value).join('');
        
        verifyCurrentPhone.disabled = true;
        verifyCurrentPhone.textContent = 'Проверяем...';
        
        fetch('<?php echo e(route("profile.verify-phone-code")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                phone: phoneInput.value,
                code: code,
                type: 'current'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                isCurrentPhoneVerified = true;
                currentPhoneVerification.classList.add('d-none');
                newPhoneInput.classList.remove('d-none');
                showAlert('success', 'Текущий номер успешно подтвержден!');
            } else {
                showAlert('danger', data.message);
                codeDigits.forEach(input => input.classList.add('is-invalid'));
                setTimeout(() => {
                    codeDigits.forEach(input => input.classList.remove('is-invalid'));
                    clearCodeInputs();
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Произошла ошибка при проверке кода');
        })
        .finally(() => {
            verifyCurrentPhone.disabled = false;
            verifyCurrentPhone.textContent = 'Подтвердить';
        });
    });
    
    // Повторная отправка кода
    resendCurrentCode.addEventListener('click', function() {
        sendCurrentPhoneCode.click();
    });
    
    // Сохранение нового номера
    saveNewPhone.addEventListener('click', function() {
        const newPhone = newPhoneField.value.trim();
        
        if (!newPhone) {
            showAlert('danger', 'Введите новый номер телефона');
            return;
        }
        
        if (newPhone === phoneInput.value) {
            showAlert('danger', 'Новый номер не может совпадать с текущим');
            return;
        }
        
        saveNewPhone.disabled = true;
        saveNewPhone.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Сохраняем...';
        
        fetch('<?php echo e(route("profile.update-phone")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                new_phone: newPhone
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert('success', data.message);
                phoneInput.value = newPhone;
                phoneChangeSection.classList.add('d-none');
                changePhoneBtn.style.display = 'block';
                resetPhoneChangeForm();
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Произошла ошибка при сохранении номера');
        })
        .finally(() => {
            saveNewPhone.disabled = false;
            saveNewPhone.innerHTML = '<i class="fas fa-save me-2"></i>Сохранить новый номер';
        });
    });
    
    // Функция показа уведомлений
    function showAlert(type, message) {
        // Удаляем существующие алерты
        const existingAlerts = document.querySelectorAll('.alert-dismissible');
        existingAlerts.forEach(alert => alert.remove());
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.querySelector('.card-body').insertBefore(alertDiv, document.querySelector('.card-body').firstChild);
        
        // Автоматически скрыть через 5 секунд
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});
</script>

<style>
.code-digit {
    width: 50px;
    height: 50px;
    font-size: 1.5rem;
    font-weight: bold;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.code-digit:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.code-digit.is-invalid {
    border-color: #dc3545;
    animation: shake 0.5s;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
    20%, 40%, 60%, 80% { transform: translateX(3px); }
}

.verification-step {
    transition: all 0.3s ease;
}

.phone-change-section {
    transition: all 0.3s ease;
}

/* Мобильная адаптация */
@media (max-width: 768px) {
    .code-digit {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
    }
    
    .phone-change-section .card-body {
        padding: 1rem;
    }
    
    .d-flex.gap-2 {
        flex-wrap: wrap;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .code-digit {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .code-inputs {
        gap: 0.5rem !important;
    }
    
    .d-flex.align-items-center.gap-2 {
        flex-direction: column;
        align-items: stretch !important;
        gap: 1rem !important;
    }
    
  
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views/profile/edit.blade.php ENDPATH**/ ?>