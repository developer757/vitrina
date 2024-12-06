<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Post;
use Carbon\Carbon;

class ClicksChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Клики за 24 часа';

    // Делаем виджет на всю ширину
    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }

    protected function getHeight(): int | string | null
    {
        return '400px';
    }

    protected function getData(): array
    {
        // Создаем массив с временными метками за последние 24 часа
        $timestamps = collect(range(23, 0, -1))
            ->map(fn ($hoursAgo) => Carbon::now()->subHours($hoursAgo));

        $clicksByHour = [];
        $labels = [];

        foreach ($timestamps as $timestamp) {
            $startOfHour = $timestamp->copy()->startOfHour();
            $endOfHour = $timestamp->copy()->endOfHour();

            // Получаем сумму кликов за каждый час
            $clicks = Post::whereBetween('updated_at', [
                $startOfHour,
                $endOfHour
            ])->sum('clicks');

            $clicksByHour[] = $clicks;
            $labels[] = $timestamp->format('H:i');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Клики',
                    'data' => $clicksByHour,
                    'borderColor' => '#9BD0F5',
                    'backgroundColor' => 'rgba(155, 208, 245, 0.2)',
                    'fill' => true,
                    'tension' => 0.3,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ]
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                        'color' => '#666', // цвет текста
                    ],
                    'grid' => [
                        'color' => '#e5e5e5', // цвет сетки
                    ],
                ],
                'x' => [
                    'ticks' => [
                        'color' => '#666',
                    ],
                    'grid' => [
                        'color' => '#e5e5e5',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'elements' => [
                'line' => [
                    'borderWidth' => 2, // толщина линии
                ],
                'point' => [
                    'radius' => 4, // размер точек
                    'hoverRadius' => 6, // размер точек при наведении
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}
