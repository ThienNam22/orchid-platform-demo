<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;

class ReusableEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * 
     */
    private $prefix;

    public function __construct(string $prefix, string $title)
    {
        $this->prefix = $prefix;
        $this->title = $title;
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Label::make('label')
                ->title($this->title),

            Input::make($this->prefix . '.address')
                ->required()
                ->title('Address')
                ->placeholder('Hanoi'),
        ];
    }
}
