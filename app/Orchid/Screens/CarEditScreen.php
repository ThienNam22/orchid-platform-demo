<?php

namespace App\Orchid\Screens;

use App\Models\Car;
use App\Models\Company;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Cropper;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class CarEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Car';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Car Edit';

    /**
     * 
     */
    public $exists = false;

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        'car.edit'
    ];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Car $car, Company $company): array
    {
        $this->exists = $car->exists;

        if ($this->exists) {
            $this->name = 'Edit Car';
        }

        $car->load('attachment');
        return [
            'car' => $car
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
            Button::make('Create car')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Delete')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
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
            Layout::rows([
                Input::make('car.name')
                    ->title('Name')
                    ->placeholder('Car name')
                    ->help('Enter your car name')
                    ->required(),

                Select::make('car.color')
                    ->options([
                        'red' => 'Red',
                        'black' => 'Black',
                        'blue' => 'Blue',
                        'white' => 'White',
                    ])
                    ->title('Select color')
                    ->empty('Choose color', 0)
                    ->help('Pick your car color')
                    ->required(),

                Input::make('car.price')
                    ->title('Price')
                    ->placeholder('Price')
                    ->help('Enter Price of car')
                    ->required()
                    ->horizontal()
                    ->canSee(true) // default: true
                    ->type('text')
                    ->popover('Your car price'),

                Cropper::make('car.image')
                    ->title('Large car image')
                    ->width(1000)
                    ->height(500)
                    ->targetRelativeUrl(),

                Relation::make('car.company')
                    ->fromModel(Company::class, 'name')
                    ->title('Choose company'),

                Upload::make('car.attachment')
                    ->title('All files'),
            ]),
        ];
    }

    /**
     * 
     */
    public function createOrUpdate(Car $car, Request $request)
    {
        $car->fill($request->get('car'))->save();
        $car->attachment()->syncWithoutDetaching(
            $request->input('car.attachment', [])
        );
        Alert::info($this->exists ? "Car created" : "Car updated");
        return redirect()->route('platform.car.list');
    }

    public function remove(Car $car)
    {
        $car->delete();

        Alert::info('Car deleted');

        return redirect()->route('platform.car.list');
    }
}
