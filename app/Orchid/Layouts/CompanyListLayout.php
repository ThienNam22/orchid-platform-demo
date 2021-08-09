<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Company;
use Orchid\Screen\Actions\Link;

class CompanyListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'companies';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('logo', 'Logo')
                ->render(function (Company $company) {
                    $src = $company->logo;
                    $src = substr_replace($src, ":8000", 16, 0);
                    return "<img src='{$src}' alt='Company logo' width='100' height='100'>";
                }),
            TD::make('name', 'Name')
                ->sort()
                ->render(function (Company $company) {
                    return Link::make($company->name)
                                ->route('platform.company.edit', $company);
                }),

            TD::make('location', 'Location')
                ->filter(TD::FILTER_TEXT)
                ->sort(),
            TD::make('created_at', 'Created')
                ->sort()
                ->render(function (Company $company) {
                    return date_format($company->created_at, 'Y-m-d');
                }),
            TD::make('updated_at', 'Last edit')
                ->sort()
                ->render(function (Company $company) {
                    return date_format($company->updated_at, 'Y-m-d H:i:s');
                }),

        ];
    }
}
