@extends('layouts.app')

@section('head')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-3">{{ __('Панель управления администратора') }}</h1>
        </div>
    </div>
    
    <!-- Карточки статистики -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Всего пользователей</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeUsers + $inactiveUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Активные пользователи</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Проекты</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProjects }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Общая сумма сделок</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ isset($totalEstimateValue) ? number_format($totalEstimateValue, 0, ',', ' ') : '0' }} ₽</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ruble-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Графики и таблицы данных -->
    <div class="row">
        <!-- График динамики проектов -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Динамика создания проектов</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="projectsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Круговой график по ролям пользователей -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Распределение пользователей</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="userRolesChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($usersByRole as $roleData)
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: {{ ['admin' => '#4e73df', 'partner' => '#1cc88a', 'client' => '#36b9cc', 'estimator' => '#f6c23e'][$roleData->role] ?? '#858796' }}"></i> 
                                {{ ['admin' => 'Администраторы', 'partner' => 'Партнеры', 'client' => 'Клиенты', 'estimator' => 'Сметчики'][$roleData->role] ?? ucfirst($roleData->role) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Последние проекты -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Последние проекты</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Клиент</th>
                                    <th>Дата создания</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestProjects as $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->name ?? $project->client_name ?? 'Проект №'.$project->id }}</td>
                                    <td>{{ optional($project->client)->name ?? $project->client_name ?? 'Не назначен' }}</td>
                                    <td>{{ $project->created_at ? $project->created_at->format('d.m.Y') : 'Не указано' }}</td>
                                    <td>
                                        @if($project->status == 'new')
                                            <span class="badge bg-primary">Новый</span>
                                        @elseif($project->status == 'in_progress')
                                            <span class="badge bg-info">В работе</span>
                                        @elseif($project->status == 'completed')
                                            <span class="badge bg-success">Завершен</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $project->status ?? 'Неизвестно' }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Проекты не найдены</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Топ партнеров -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Топ партнеров по количеству проектов</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Партнер</th>
                                    <th>Кол-во проектов</th>
                                    <th>Email</th>
                                    <th>Телефон</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($partnerStats as $partner)
                                <tr>
                                    <td>{{ $partner->name }}</td>
                                    <td>{{ $partner->projects_count }}</td>
                                    <td>{{ $partner->email }}</td>
                                    <td>{{ $partner->phone ?? 'Не указан' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Партнеры не найдены</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript для инициализации графиков -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // График проектов по месяцам
    var ctx = document.getElementById('projectsChart');
    var projectsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Количество проектов',
                lineTension: 0.3,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(78, 115, 223, 1)',
                pointHoverRadius: 3,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: {!! json_encode($chartData) !!},
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: "rgba(0, 0, 0, 0.05)",
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleColor: "#6e707e",
                    titleMarginBottom: 10,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    displayColors: false,
                }
            }
        }
    });

    // Круговой график ролей пользователей
    var userRolesCtx = document.getElementById('userRolesChart');
    var userRolesData = {!! json_encode($usersByRole->pluck('count', 'role')->toArray()) !!};
    var roles = Object.keys(userRolesData);
    var roleColors = {
        'admin': '#4e73df',
        'partner': '#1cc88a',
        'client': '#36b9cc',
        'estimator': '#f6c23e'
    };
    
    var backgroundColor = roles.map(role => roleColors[role] || '#858796');
    
    var roleLabels = {
        'admin': 'Администраторы',
        'partner': 'Партнеры',
        'client': 'Клиенты',
        'estimator': 'Сметчики'
    };

    var userRolesChart = new Chart(userRolesCtx, {
        type: 'doughnut',
        data: {
            labels: roles.map(role => roleLabels[role] || role),
            datasets: [{
                data: roles.map(role => userRolesData[role]),
                backgroundColor: backgroundColor,
                hoverBackgroundColor: backgroundColor,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    displayColors: false
                }
            },
            cutout: '60%',
        },
    });
});
</script>
@endsection
