

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Левая колонка с формой -->
        <div class="col-md-6 bg-white">
            <div class="login-form-container d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-8 mx-auto">
                            <h3 class="display-6 mb-4"><?php echo e(__('Вход')); ?></h3>
                            <div class="card border-0 shadow rounded-3">
                                <div class="card-body p-4 p-sm-5">
                                    <?php if($errors->has('db_error')): ?>
                                    <div class="alert alert-danger mb-3">
                                        <?php echo e($errors->first('db_error')); ?>

                                    </div>
                                    <?php endif; ?>
                                    <form method="POST" action="<?php echo e(route('login')); ?>">
                                        <?php echo csrf_field(); ?>

                                        <div class="mb-3">
                                            <label for="phone" class="form-label"><?php echo e(__('Номер телефона')); ?></label>
                                            <input id="phone" type="tel" class="form-control maskphone <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(old('phone')); ?>" required autocomplete="phone" autofocus>
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
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label"><?php echo e(__('Пароль')); ?></label>
                                            <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">
                                            <?php $__errorArgs = ['password'];
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

                                        <div class="mb-3 form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="remember">
                                                <?php echo e(__('Запомнить меня')); ?>

                                            </label>
                                        </div>

                                        <div class="d-grid gap-2 mb-3">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <?php echo e(__('Войти')); ?>

                                            </button>
                                        </div>

                                        <div class="text-center">
                                            <?php if(Route::has('password.request')): ?>
                                                <a class="text-decoration-none" href="<?php echo e(route('password.request')); ?>">
                                                    <?php echo e(__('Забыли пароль?')); ?>

                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Правая колонка с фоновым изображением -->
        <div class="col-md-6 d-none d-md-block p-0">
            <div class="bg-image h-100" style="background-image: url('https://images.unsplash.com/photo-1556156653-e5a7c69cc263?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80'); background-size: cover; background-position: center;"></div>
        </div>
    </div>
</div>
<style>
.login-form-container {
    min-height: calc(100vh - 72px);
}
.bg-image {
    min-height: calc(100vh - 72px);
}
</style>
<script>
 
document.addEventListener("DOMContentLoaded", function () {
    var inputs = document.querySelectorAll("input.maskphone");
    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        input.addEventListener("input", mask);
        input.addEventListener("focus", mask);
        input.addEventListener("blur", mask);
        
        // Вызываем маску при загрузке страницы для полей с существующим значением
        if (input.value && input.value.length > 0) {
            mask.call(input);
        }
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
        } else {
            setCursorPosition(this, this.value.length);
        }
    }
    function setCursorPosition(elem, pos) {
        elem.focus();
        if (elem.setSelectionRange) {
            elem.setSelectionRange(pos, pos);
            return;
        }
        if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.collapse(true);
            range.moveEnd("character", pos);
            range.moveStart("character", pos);
            range.select();
            return;
        }
    }
});
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\remont\resources\views/auth/login.blade.php ENDPATH**/ ?>