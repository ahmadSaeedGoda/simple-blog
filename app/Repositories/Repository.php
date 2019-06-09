<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model, $per_page = null)
    {
        $this->model = $model;
        $this->per_page = $per_page;
    }

    // Get all instances of model with paging
    public function all()
    {
        return $this->model->latest()->paginate($this->per_page);
    }

    // Get all instances of model with no paging
    public function allWithoutPagination()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create()
    {
        return new $this->model;
    }

    // create a new record in the database
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->findOrFail($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations)->latest()->paginate($this->per_page);
    }

    // Get count of all instances of the model
    public function count()
    {
        return $this->model->count();
    }
}