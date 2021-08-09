<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Car;
use App\Orchid\Layouts\CarListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;

class CarListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Car List';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Car Storage';

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        'car.list'
    ];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'cars' => Car::filters()->defaultSort('name')->paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.car.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            CarListLayout::class,

            Layout::modal('branchModal', Layout::rows([

            ])),
        ];
    }
}
