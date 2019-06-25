<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Base Repository.
 */
class Repository implements RepositoryInterface
{
    /**
     * The model instance.
     *
     * @var Model
     */
    protected $model;

    /**
     * The repository instance.
     *
     * @param Model $model
     * @param Int $per_page
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }//end __construct()

    /**
     * Get the associated model
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;

    }//end getModel()


    /**
     * Setter For Class Model Atrribute to different one
     * The Model To Set Might has different db connection
     *
     * @param Model $model
     * @return Repository
     */
    public function setModel(Model $model): Repository
    {
        $this->model = $model;
        return $this;

    }//end setModel()

    /**
     * Returns the first record in the database.
     *
     * @return Model
     */
    public function first(): Model
    {
        return $this->model->first();
    }//end first()

    /**
     * Eager loads database relationships
     *
     * @return Model
     */
    public function with(Array $relations): void
    {
        $this->model->with($relations);
    }//end first()

    /**
     * Returns all the records.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }//end all()

    /**
     * Returns the count of all the records.
     *
     * @return Int
     */
    public function count(): Int
    {
        return $this->model->count();
    }//end count()

    /**
     * Returns a range of records bounded by pagination parameters.
     *
     * @param Int $limit
     * @param Array $relations
     * @param String $orderBy
     * @param String $sorting
     *
     * @return LengthAwarePaginator
     */
    public function page(Int $limit = 500, Array $relations = [], String $orderBy = 'updated_at', String $sorting = 'desc'): LengthAwarePaginator
    {
        return $this->model->with($relations)->orderBy($orderBy, $sorting)->paginate($limit);
    }//end page()

    /**
     * Find a record by its identifier.
     *
     * @param String $id
     * @param Array  $relations
     *
     * @return Model
     */
    public function find(String $id, Array $relations = NULL): Model
    {
        return $this->findBy($this->model->getKeyName(), $id, $relations);
    }//end find()

    /**
     * Find a record by an attribute.
     * Fails if no model is found.
     *
     * @param String $attribute
     * @param String $value
     * @param Array  $relations
     *
     * @return Model
     */
    public function findBy(String $attribute, String $value, Array $relations = NULL): Model
    {
        $query = $this->model->where($attribute, $value);
        if ($relations && is_array($relations)) {
            foreach ($relations as $relation) {
                $query->with($relation);
            }
        }
        return $query->firstOrFail();
    }//end findBy()

    /**
     * Get all records by an associative array of attributes.
     * Two operators values are handled: AND | OR.
     *
     * @param Array  $attributes
     * @param String $operator
     * @param Array  $relations
     *
     * @return Collection
     */
    public function getByAttributes(Array $attributes, String $operator = 'AND', Array $relations = NULL): Collection
    {
        // In the following it doesn't matter wivh element to start with, in all cases all attributes will be appended to the
        // builder.
        // Get the last value of the associative array
        $lastValue = end($attributes);
        // Get the last key of the associative array
        $lastKey = key($attributes);
        // Builder
        $query = $this->model->where($lastKey, $lastValue);
        // Pop the last key value pair of the associative array now that it has been added to Builder already
        array_pop($attributes);
        $method = 'where';
        if (strtoupper($operator) === 'OR') {
            $method = 'orWhere';
        }
        foreach ($attributes as $key => $value) {
            $query->$method($key, $value);
        }
        if ($relations && is_array($relations)) {
            foreach ($relations as $relation) {
                $query->with($relation);
            }
        }
        return $query->get();
    }//end getByAttributes()

    /**
     * Fills out an instance of the model
     * with $attributes.
     *
     * @param Array $attributes
     *
     * @return Model
     */
    public function fill(Array $attributes): Model
    {
        return $this->model->fill($attributes);
    }//end fill()

    /**
     * Fills out an instance of the model
     * and saves it, pretty much like mass assignment.
     *
     * @param Array $attributes
     *
     * @return Model
     */
    public function fillAndSave(Array $attributes): Model
    {
        $this->model->fill($attributes);
        $this->model->save();
        return $this->model;
    }//end fillAndSave()

    /**
     * Updates an instance of the model and saves it
     *
     * @param Array $attributes
     *
     * @return bool
     */
    public function update(String $id, Array $attributes): bool
    {
        return $this->model->find($id)->update($attributes);
    }//end update()

    /**
     * Remove a selected record.
     *
     * @param String $key
     *
     * @return bool
     */
    public function remove(String $key): bool
    {
        return $this->model->find($key)->delete();
    }//end remove()


}//end class
