<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Laravel\Scout\Searchable;
use App\Orchid\Presenters\CompanyPresenter;

class Company extends Model
{
    use HasFactory, AsSource, Attachable, Filterable, Searchable;

    /**
     * 
     */
    protected $fillable = [
        'name',
        'logo',
        'location'
    ];

    /**
     * 
     */
    protected $allowedSorts = [
        'name',
        'created_at',
        'updated_at'
    ];

    /**
     * 
     */
    protected $allowedFilters = [
        'location'
    ];

    /**
     * Get the presenter for the model.
     *
     * @return IdeaPresenter
     */
    public function presenter()
    {
        return new CompanyPresenter($this);
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
