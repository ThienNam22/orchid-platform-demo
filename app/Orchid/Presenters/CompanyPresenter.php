<?php

namespace App\Orchid\Presenters;

use Orchid\Support\Presenter;
use Orchid\Screen\Contracts\Searchable;
use Laravel\Scout\Builder;

class CompanyPresenter extends Presenter implements Searchable
{
	/**
	 * @return stirng
	 */
	public function label(): string
	{
		return "Companies";
	}

	/**
     * @return string
     */
    public function title(): string
    {
        return $this->entity->name;
    }

    /**
     * @return string
     */
    public function subTitle(): string
    {
        return 'Small descriptions';
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return url('/');
    }

    /**
     * @return string
     */
    public function image(): ?string
    {
        return null;
    }

    /**
     * @param string|null $query
     *
     * @return Builder
     */
    public function searchQuery(string $query = null): Builder
    {
        return $this->entity->search($query);
    }

    /**
     * @return int
     */
    public function perSearchShow(): int
    {
        return 3;
    }
}