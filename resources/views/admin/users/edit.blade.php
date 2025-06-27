@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Редактирование пользователя') }}</span>
                        <div>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info me-2">
                                <i class="fas fa-eye"></i> Просмотр
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Назад
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="img-fluid rounded-circle mb-2" style="max-width: 150px; max-height: 150px;">
                            
                            @if($user->avatar)
                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="mt-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="remove_avatar" value="1">
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить аватар</button>
                                </form>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h4>{{ $user->name }}</h4>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Телефон:</strong> {{ $user->phone ?? 'Не указан' }}</p>
                            <p><strong>Роль:</strong> 
                                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'partner' ? 'primary' : ($user->role == 'estimator' ? 'info' : 'secondary')) }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </p>
                            <p><strong>Дата регистрации:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Имя') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Телефон') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Роль') }}</label>
                            <div class="col-md-6">
                                <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required onchange="togglePartnerSelect()">
                                    <option value="client" {{ (old('role', $user->role) == 'client') ? 'selected' : '' }}>Клиент</option>
                                    <option value="partner" {{ (old('role', $user->role) == 'partner') ? 'selected' : '' }}>Партнер</option>
                                    <option value="estimator" {{ (old('role', $user->role) == 'estimator') ? 'selected' : '' }}>Сметчик</option>
                                    <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Администратор</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3 row" id="partner-select-container" style="display: none;">
                            <label for="partner_id" class="col-md-4 col-form-label text-md-end">{{ __('Выберите партнера') }}</label>
                            <div class="col-md-6">
                                <select id="partner_id" class="form-select @error('partner_id') is-invalid @enderror" name="partner_id">
                                    <option value="">Выберите партнера</option>
                                    @foreach($partners as $partner)
                                        <option value="{{ $partner->id }}" {{ old('partner_id', $user->partner_id) == $partner->id ? 'selected' : '' }}>
                                            {{ $partner->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('partner_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-end">{{ __('Изменить аватар') }}</label>
                            <div class="col-md-6">
                                <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" accept="image/*">
                                <small class="form-text text-muted">Допустимые форматы: JPG, PNG, GIF. Максимальный размер: 2МБ.</small>
                                @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Новый пароль') }}</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                    <button type="button" class="btn btn-outline-secondary" onclick="generatePassword()">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">Оставьте пустым, если не хотите менять пароль.</small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Подтверждение пароля') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Сохранить изменения') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <hr>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Быстрые действия</h5>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите сбросить пароль этому пользователю?');">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-key"></i> Сбросить пароль
                                    </button>
                                </form>
                                
                                @if(isset($user->is_active))
                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn {{ $user->is_active ? 'btn-secondary' : 'btn-success' }}">
                                        <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i> 
                                        {{ $user->is_active ? 'Деактивировать' : 'Активировать' }}
                                    </button>
                                </form>
                                @endif
                                
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя? Это действие необратимо.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Удалить пользователя
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePartnerSelect() {
        var roleSelect = document.getElementById('role');
        var partnerSelectContainer = document.getElementById('partner-select-container');
        
        if (roleSelect.value === 'estimator') {
            partnerSelectContainer.style.display = 'flex';
        } else {
            partnerSelectContainer.style.display = 'none';
        }
    }
    
    function generatePassword() {
        // Генерируем случайный пароль длиной 10 символов
        var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        var password = '';
        for (var i = 0; i < 10; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        
        // Устанавливаем пароль в оба поля
        document.getElementById('password').value = password;
        document.getElementById('password-confirm').value = password;
        
        // Опционально: показываем пароль пользователю
        alert('Сгенерированный пароль: ' + password);
    }
    
    // Вызываем функцию при загрузке страницы для корректного отображения
    document.addEventListener('DOMContentLoaded', function() {
        togglePartnerSelect();
    });
</script>
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Новый пароль') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                <small class="form-text text-muted">Оставьте поле пустым, если не хотите менять пароль</small>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Подтверждение пароля') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-3 row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Сохранить') }}
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    {{ __('Отмена') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
