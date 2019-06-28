<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Contract to access database using an ORM
 */
interface RepositoryInterface
{
    public function __construct(Model $model);
    
    public function getModel(): Model;
    
    public function setModel(Model $model): Repository;
    
    public function first(): Model;
    
    public function with(array $relations): void;

    public function all(): Collection;
    
    public function count(): int;
    
    public function page(int $limit, array $relations, string $orderBy, string $sorting): LengthAwarePaginator;
    
    public function find(string $id, array $relations): Model;
    
    public function findBy(string $attribute, string $value, array $relations): Model;
    
    public function getByAttributes(array $attributes, string $operator, array $relations): Collection;
    
    public function fill(array $attributes): Model;
    
    public function fillAndSave(array $attributes): Model;
    
    public function update(string $id, array $attributes): bool;

    public function remove(string $key): bool;
}//end interface
