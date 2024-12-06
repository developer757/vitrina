<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Информация об устройстве</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-100">
<div class="max-w-2xl mx-auto">
    <!-- Форма ввода User-Agent -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <form action="{{ route('detect-device') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="user_agent" class="block text-sm font-medium text-gray-700">Введите User-Agent:</label>
                <textarea
                    name="user_agent"
                    id="user_agent"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    rows="3"
                >{{ $deviceInfo['user_agent'] ?? request()->header('User-Agent') }}</textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Определить устройство
            </button>
        </form>
    </div>

    @if($deviceInfo)
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Информация об устройстве</h1>

            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div class="font-semibold">Бренд:</div>
                    <div>{{ $deviceInfo['brand'] }}</div>

                    <div class="font-semibold">Модель:</div>
                    <div>{{ $deviceInfo['model'] ?: 'Неизвестно' }}</div>

                    <div class="font-semibold">Платформа:</div>
                    <div>{{ $deviceInfo['platform'] }} {{ $deviceInfo['platform_version'] }}</div>

                    <div class="font-semibold">Браузер:</div>
                    <div>{{ $deviceInfo['browser'] }} {{ $deviceInfo['browser_version'] }}</div>

                    <div class="font-semibold">Тип устройства:</div>
                    <div>
                        @if($deviceInfo['is_mobile'])
                            Мобильное устройство
                        @elseif($deviceInfo['is_tablet'])
                            Планшет
                        @elseif($deviceInfo['is_desktop'])
                            Десктоп
                        @endif
                    </div>

                    @if($deviceInfo['robot'])
                        <div class="font-semibold">Бот:</div>
                        <div>{{ $deviceInfo['robot'] }}</div>
                    @endif

                    <div class="font-semibold">Языки:</div>
                    <div>{{ implode(', ', $deviceInfo['languages']) }}</div>
                </div>
            </div>
        </div>
    @endif
</div>
</body>
</html>
