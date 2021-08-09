<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Company;
use App\Orchid\Layouts\CompanyListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;

class CompanyListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Company List';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Company List';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'companies' => Company::filters()->defaultSort('name')->paginate()
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
                ->route('platform.company.edit')
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
            CompanyListLayout::class,
        ];
    }
}
