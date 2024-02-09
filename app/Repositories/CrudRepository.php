<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;

class CrudRepository implements CrudRepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $model = $this->model->findOrFail($id);

        $model->update($data);

        return $model;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id): bool
    {
        $model = $this->findOrFail($id);

        return $model->delete();
    }
}
