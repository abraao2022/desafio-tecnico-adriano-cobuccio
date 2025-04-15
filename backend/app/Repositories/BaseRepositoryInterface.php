<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']);
    public function find(int $id);
    public function findOrFail(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
