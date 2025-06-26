@foreach($projects as $project)
    <div class="col-12 col-md-6 col-xl-4 mb-3 project-card-container">
        <div class="card h-100 project-card">
            <div class="card-header d-flex justify-content-between align-items-center p-2 px-3">
                <h5 class="card-title mb-0 text-truncate" style="max-width: 70%;">
                    <a href="{{ route('partner.projects.show', $project) }}" class="text-decoration-none text-dark stretched-link">
                        {{ $project->client_name }}
                    </a>
                </h5>
                <span class="badge {{ $project->status == 'active' ? 'bg-success' : ($project->status == 'paused' ? 'bg-warning' : ($project->status == 'completed' ? 'bg-info' : 'bg-secondary')) }}">
                    {{ ucfirst($project->status) }}
                </span>
            </div>
            <div class="card-body p-3">
                <div class="mb-2">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-map-marker-alt text-muted mt-1 me-2"></i>
                        <div class="text-truncate" style="max-width: 100%;">
                            {{ $project->address }}{{ $project->apartment_number ? ', кв. ' . $project->apartment_number : '' }}
                        </div>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-muted me-2"></i>
                            <div class="text-truncate">{{ $project->phone }}</div>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="d-flex align-items-center justify-content-end">
                            <i class="fas fa-ruler-combined text-muted me-2"></i>
                            {{ $project->area ?? '-' }} м²
                        </div>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-tools text-muted me-2"></i>
                            <span class="text-truncate">{{ $project->work_type_text }}</span>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="d-flex align-items-center justify-content-end">
                            <i class="fas fa-home text-muted me-2"></i>
                            <span class="text-truncate">{{ $project->object_type ?? 'Не указан' }}</span>
                        </div>
                    </div>
                </div>
                
                <hr class="my-2">
                
                @if($project->contract_date)
                <div class="small text-muted mb-1">
                    <i class="fas fa-file-signature me-1"></i> Договор: 
                    {{ $project->contract_date->format('d.m.Y') }}, 
                    №{{ $project->contract_number ?? '-' }}
                </div>
                @endif
                
                @if(Auth::user()->role === 'admin')
                <div class="small text-muted mb-1">
                    <i class="fas fa-user-tie me-1"></i> Партнер: 
                    {{ $project->partner ? $project->partner->name : 'Не указан' }}
                </div>
                @endif
                
                <div class="small text-end">
                    <strong>
                        <i class="fas fa-money-bill-wave text-success me-1"></i>
                        {{ number_format($project->total_amount, 0, '.', ' ') }} ₽
                    </strong>
                </div>
            </div>
            <div class="card-footer d-flex p-2">
                <a href="{{ route('partner.projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary flex-grow-1 me-2">
                    <i class="fas fa-edit"></i>
                    <span class="ms-1">Редактировать</span>
                </a>
                <a href="{{ route('partner.projects.show', $project) }}" class="btn btn-sm btn-primary flex-grow-1">
                    <i class="fas fa-eye"></i>
                    <span class="ms-1">Просмотр</span>
                </a>
            </div>
        </div>
    </div>
@endforeach
