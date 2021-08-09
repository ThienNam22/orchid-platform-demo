<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Company;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Cropper;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;

class CompanyEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new company';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Company Edit';

    /**
     * 
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Company $company): array
    {
        $this->exists = $company->exists;

        if ($this->exists) {
            $this->name = 'Edit Company';
        }

        return [
            'company' => $company,
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
            Button::make('Create company')
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
                Input::make('company.name')
                    ->title('Name')
                    ->placeholder('Company name')
                    ->help('Enter your company name')
                    ->required(),

                Select::make('company.location')
                    ->options([
                        'hanoi' => 'Hà Nội',
                        'tphcm' => 'TP.HCM',
                        'danang' => 'Đà Nẵng',
                    ])
                    ->title('Select location')
                    ->empty('Choose location', 0)
                    ->help('Pick your company location')
                    ->required(),

                Cropper::make('company.logo')
                    ->title('Small logo image')
                    ->width(100)
                    ->height(100),

            ]),
        ];
    }

    /**
     * 
     */
    public function createOrUpdate(Company $company, Request $request)
    {
        $company->fill($request->get('company'))->save();

        Alert::info('Company creted');
        return redirect()->route('platform.company.list');
    }

    public function remove(Company $company)
    {
        $company->delete();

        Alert::info('Company deleted');

        return redirect()->route('platform.company.list');
    }
}
