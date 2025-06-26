<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        
        // Обработка ошибок аутентификации
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Требуется авторизация'], 401);
            }
            
            return redirect()->guest(route('login'))->with('error', 'Срок сессии истек. Пожалуйста, авторизуйтесь снова.');
        });
        
        // Обработка ошибок CSRF токена
        $this->renderable(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            Log::warning('CSRF token mismatch', [
                'ip' => $request->ip(),
                'uri' => $request->fullUrl(),
                'user_id' => auth()->id() ?? 'guest'
            ]);
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'CSRF token expired. Please refresh the page.'], 419);
            }
            
            return redirect()->back()->with('error', 'Ваша сессия истекла. Пожалуйста, обновите страницу и повторите действие.');
        });
        
        // Обработка исключений для API запросов
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                Log::error('API Error: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ]);

                // Аутентификация
                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Необходима авторизация'
                    ], 401);
                }
                
                // Валидация
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка валидации данных',
                        'errors' => $e->errors()
                    ], 422);
                }
                
                // Общие ошибки
                $statusCode = 500; // По умолчанию 500 для внутренней ошибки сервера
                
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Произошла ошибка на сервере',
                    'error_type' => get_class($e)
                ], $statusCode);
            }
            
            return null;
        });
        
        // Добавляем обработчик для всех исключений при Ajax-запросах
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                Log::error('API Error: ' . $e->getMessage(), [
                    'exception' => $e,
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_id' => $request->user() ? $request->user()->id : null
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Произошла ошибка на сервере: ' . $e->getMessage(),
                    'error_type' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ], 500);
            }
        });
    }
}
