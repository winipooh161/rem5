<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Показать панель управления администратора с аналитикой.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Статистика пользователей по ролям
        try {
            $usersByRole = User::select('role', DB::raw('count(*) as count'))
                ->groupBy('role')
                ->get();
                
            // Активные пользователи
            $activeUsers = User::where('is_active', true)->count();
            $inactiveUsers = User::where('is_active', false)->count();
        } catch(\Exception $e) {
            $usersByRole = collect([
                (object)['role' => 'admin', 'count' => 1],
                (object)['role' => 'client', 'count' => 0],
                (object)['role' => 'partner', 'count' => 0],
                (object)['role' => 'estimator', 'count' => 0]
            ]);
            $activeUsers = 1;
            $inactiveUsers = 0;
            
            \Illuminate\Support\Facades\Log::error('Error fetching user statistics: ' . $e->getMessage());
        }
        
        // Статистика проектов
        try {
            $totalProjects = Project::count();
            $projectsMonthly = Project::select(
                    DB::raw('MONTH(created_at) as month'), 
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereYear('created_at', date('Y'))
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
        } catch(\Exception $e) {
            $totalProjects = 0;
            $projectsMonthly = collect([]);
            \Illuminate\Support\Facades\Log::error('Error fetching project statistics: ' . $e->getMessage());
        }
            
        // Преобразуем данные для графиков
        $chartLabels = [];
        $chartData = [];
        $monthNames = [
            1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
        ];
        
        foreach($projectsMonthly as $stat) {
            $chartLabels[] = $monthNames[$stat->month];
            $chartData[] = $stat->count;
        }
        
        // Последние проекты
        try {
            $latestProjects = Project::with('client')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } catch(\Exception $e) {
            $latestProjects = collect([]);
            \Illuminate\Support\Facades\Log::error('Error fetching latest projects: ' . $e->getMessage());
        }
              // Финансовая статистика (если доступна)
        try {
            $totalEstimateValue = Estimate::sum('total_amount') ?? 0;
        } catch(\Exception $e) {
            $totalEstimateValue = 0;
            \Illuminate\Support\Facades\Log::error('Error calculating total estimate value: ' . $e->getMessage());
        }

        // Статистика по партнерам
        try {
            $partnerStats = User::where('role', 'partner')
                ->withCount('projects')
                ->orderBy('projects_count', 'desc')
                ->limit(5)
                ->get();
        } catch(\Exception $e) {
            $partnerStats = collect([]);
            \Illuminate\Support\Facades\Log::error('Error fetching partner statistics: ' . $e->getMessage());
        }
            
        return view('admin.dashboard', compact(
            'usersByRole', 
            'activeUsers', 
            'inactiveUsers', 
            'totalProjects', 
            'chartLabels', 
            'chartData',
            'latestProjects',
            'totalEstimateValue',
            'partnerStats'
        ));
    }
}
