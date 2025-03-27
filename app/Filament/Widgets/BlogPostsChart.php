<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;


class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    // protected static ?int $columnSpan = 2;

    protected function getData(): array
    {
        return [
            'default' => 12, // Full width di layar besar
            'md' => 8, // 8 kolom di layar medium
            'sm' => 6,
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

}
