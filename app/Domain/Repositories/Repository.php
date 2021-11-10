<?php


namespace App\Domain\Repositories;

use App\Domain\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    public function __call($method, $arguments)
    {
        return $this->model->{$method}(...$arguments);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return tap($this->getById($id), function ($record) use ($attributes) {
            $record->update($attributes);
        });
    }

    public function delete($id)
    {
        return $this->getById($id)->delete();
    }
}
