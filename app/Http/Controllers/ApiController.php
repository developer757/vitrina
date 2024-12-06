<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        // Получаем страну клиента из заголовка запроса
        $userCountry = $request->header('X-Country');

        // Проверяем наличие страны и фильтруем записи по значению geo
        if ($userCountry) {
            $posts = Post::where('geo', $userCountry)->get();
        } else {
            $posts = Post::all();
        }

        // Добавляем домен к изображениям
        $domain = config('app.url');
        foreach ($posts as $post) {
            $post->image_url = $domain . '/storage/' . $post->image;
        }

        // Увеличиваем просмотры
        Post::increment('views');

        return response()->json($posts);
    }

    public function incrementClicks($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('clicks');
        return response()->json(['success' => true, 'clicks' => $post->clicks]);
    }

    public function getStats()
    {
        $stats = [
            'total_views' => Post::sum('views'),
            'total_clicks' => Post::sum('clicks'),
            'posts' => Post::select('id', 'title', 'views', 'clicks')->get()
        ];

        return response()->json($stats);
    }
}
