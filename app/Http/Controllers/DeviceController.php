<?php
// app/Http/Controllers/DeviceController.php
namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    private function getBrand($userAgent) {
        $brands = [
            'iPhone' => 'Apple iPhone',
            'iPad' => 'Apple iPad',
            'Macintosh' => 'Apple Mac',
            'Samsung' => 'Samsung',
            'Huawei' => 'Huawei',
            'Xiaomi' => 'Xiaomi',
            'POCO' => 'Xiaomi POCO',
            'Redmi' => 'Xiaomi Redmi',
            'OPPO' => 'OPPO',
            'vivo' => 'Vivo',
            'OnePlus' => 'OnePlus',
            'Google' => 'Google',
            'Microsoft' => 'Microsoft',
            'Dell' => 'Dell',
            'HP' => 'HP',
            'Lenovo' => 'Lenovo',
            'Asus' => 'Asus',
            'Acer' => 'Acer',
            'LG' => 'LG',
            'Sony' => 'Sony',
            'HTC' => 'HTC',
            'Nokia' => 'Nokia',
            'Motorola' => 'Motorola',
            'Honor' => 'Honor',
            'Realme' => 'Realme',
        ];

        foreach ($brands as $key => $brand) {
            if (stripos($userAgent, $key) !== false) {
                return $brand;
            }
        }

        return 'Неизвестный бренд';
    }

    public function index()
    {
        return view('welcome', ['deviceInfo' => null]);
    }

    public function detectDevice(Request $request)
    {
        $userAgent = $request->input('user_agent', request()->header('User-Agent'));

        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        // Получаем название устройства из Agent
        $device = $agent->device();

        // Определяем бренд
        $brand = $this->getBrand($userAgent);

        // Если это Apple устройство, уточняем модель
        if (stripos($brand, 'Apple') !== false) {
            if (stripos($userAgent, 'iPhone')) {
                preg_match('/iPhone(?:\d+,\d+)?/i', $userAgent, $matches);
                $device = $matches[0] ?? 'iPhone';
            } elseif (stripos($userAgent, 'iPad')) {
                preg_match('/iPad(?:\d+,\d+)?/i', $userAgent, $matches);
                $device = $matches[0] ?? 'iPad';
            }
        }

        $deviceInfo = [
            'brand' => $brand,
            'device' => $device,
            'model' => $device,
            'platform' => $agent->platform(),
            'platform_version' => $agent->version($agent->platform()),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'is_desktop' => $agent->isDesktop(),
            'is_mobile' => $agent->isMobile(),
            'is_tablet' => $agent->isTablet(),
            'robot' => $agent->robot(),
            'languages' => $agent->languages(),
            'user_agent' => $userAgent
        ];

        return view('welcome', ['deviceInfo' => $deviceInfo]);
    }
}
