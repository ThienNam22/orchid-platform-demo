<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Car;
use App\Models\Company;
use Orchid\Screen\Actions\Link;

class CarListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'cars';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('image', 'Image')
                ->render(function (Car $car) {
                    $src = $car->image;
                    $src = substr_replace($src, ":8000", 16, 0);
                    return "<img src='{$src}' alt='Car Image' width='100' height='50'>";
                }),
            TD::make('name', 'Name')
                ->sort()
                ->render(function (Car $car) {
                    return Link::make($car->name)
                                ->route('platform.car.edit', $car);
                }),

            TD::make('color', 'Color')
                ->filter(TD::FILTER_TEXT)
                ->sort(),
            TD::make('price', 'Price')
                ->sort()
                ->render(function (Car $car) {
                        return '$ '.number_format($car->price, 2);
                    }),
            TD::make('company', 'Company')
                ->sort()
                ->render(function (Car $car) {
                        $companyid = $car->company;
                        $company = Company::find($companyid);
                        $companyname = is_null($company) ? "Chưa có" : $company->name;
                        return $companyname;
                    }),
            TD::make('created_at', 'Created')
                ->sort()
                ->render(function (Car $car) {
                    return date_format($car->created_at, 'Y-m-d');
                }),
            TD::make('updated_at', 'Last edit')
                ->sort()
                ->render(function (Car $car) {
                    return date_format($car->updated_at, 'Y-m-d H:i:s');
                }),

        ];
    }
}
