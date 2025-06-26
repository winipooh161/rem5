@if($project->camera_link)
    <div class="camera-container">
        <h5 class="mb-3">Онлайн трансляция с объекта</h5>
        <div class="camera-view-container mb-3">
            @php
                $cameraUrl = $project->camera_link;
                $isIvideon = strpos($cameraUrl, 'ivideon.com') !== false;
                
                // Извлекаем ID сервера и камеры из URL Ivideon
                $server = '';
                $camera = '0';
                
                if ($isIvideon) {
                    // Извлекаем ID сервера из URL типа https://public.ivideon.com/camera/100-sSiKDFtaCMbj2btWMkSgh2/0/
                    if (preg_match('/public\.ivideon\.com\/camera\/([^\/]+)\/([^\/\?]+)/i', $cameraUrl, $matches)) {
                        $server = $matches[1];  // ID сервера (например, 100-sSiKDFtaCMbj2btWMkSgh2)
                        $camera = $matches[2];  // ID камеры (обычно 0)
                    }
                }
                
                // Формируем корректный URL для iframe
                $embeddedUrl = "https://open.ivideon.com/embed/v3/?server={$server}&camera={$camera}&width=&height=&lang=ru";
            @endphp
            
            @if($isIvideon && !empty($server))
                <!-- Ivideon камера -->
                <div class="iv-embed" style="padding:0;border:0;height:1000px; width:100%;max-width:1042px;">
                    <div class="iv-v" style="display:block;margin:0;padding:1px;border:0;background:#000;">
                        <iframe class="iv-i" style="display:block;margin:0;padding:0;border:0;    max-height: 1000px;
    min-height: 500px;" 
                            src="{{ $embeddedUrl }}" 
                            width="100%" height="360" frameborder="0" 
                            allow="autoplay; fullscreen; clipboard-write; picture-in-picture">
                        </iframe>
                    </div>
                    <div class="iv-b" style="display:block;margin:0;padding:0;border:0;">
                        <div style="float:right;text-align:right;padding:0 0 10px;line-height:10px;">
                            <a class="iv-a" style="font:10px Verdana,sans-serif;color:inherit;opacity:.6;" href="https://www.ivideon.com/" target="_blank">Powered by Ivideon</a>
                        </div>
                        <div style="clear:both;height:0;overflow:hidden;">&nbsp;</div>
                        <script src="https://open.ivideon.com/embed/v3/embedded.js"></script>
                    </div>
                </div>
            @else
                <!-- Обычная ссылка на камеру -->
                <div class="ratio ratio-16x9 mb-3">
                    <iframe src="{{ $project->camera_link }}" allowfullscreen allow="autoplay; fullscreen"></iframe>
                </div>
            @endif
        </div>
        <div class="camera-info alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <span>Вы можете наблюдать за ходом работ в режиме реального времени.</span>
        </div>
    </div>
@else
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <span>Ссылка на камеру наблюдения не настроена для этого объекта.</span>
    </div>
@endif

<style>
/* Дополнительные стили для адаптации на мобильных устройствах */
@media (max-width: 576px) {
    .camera-view-container {
        padding: 5px;
    }
    
    .camera-info {
        font-size: 0.875rem;
    }
}
</style>
