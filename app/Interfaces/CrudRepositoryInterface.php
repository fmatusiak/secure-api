<?php

namespace App\Interfaces;

interface CrudRepositoryInterface
{
    public function findOrFail(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id): bool;
}
