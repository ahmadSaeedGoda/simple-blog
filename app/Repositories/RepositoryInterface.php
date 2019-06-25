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
    
    public function with(Array $relations): Void;

    public function all(): Collection;
    
    public function count(): Int;
    
    public function page(Int $limit, Array $relations, String $orderBy, String $sorting): LengthAwarePaginator;
    
    public function find(String $id, Array $relations): Model;
    
    public function findBy(String $attribute, String $value, Array $relations): Model;
    
    public function getByAttributes(Array $attributes, String $operator, Array $relations): Collection;
    
    public function fill(Array $attributes): Model;
    
    public function fillAndSave(Array $attributes): Model;
    
    public function update(String $id, Array $attributes): bool;

    public function remove(String $key): bool;
}//end interface
