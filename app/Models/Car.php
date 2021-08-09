<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Laravel\Scout\Searchable;
use App\Orchid\Presenters\CarPresenter;


class Car extends Model
{
    use HasFactory, AsSource, Attachable, Filterable, Searchable;

    /**
     * 
     */
    protected $fillable = [
        'name',
        'color',
        'price',
        'image',
        'company'
    ];

    /**
     * 
     */
    protected $allowedSorts = [
        'name',
        'color',
        'price'
    ];

    /**
     * 
     */
    protected $allowedFilters = [
        'name',
        'color'
    ];

    /**
     * Get the presenter for the model.
     *
     * @return CarPresenter
     */
    public function presenter()
    {
        return new CarPresenter($this);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }
}
