<?php

namespace App\Base\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

//ctrl shift p > generate php class
abstract class BaseRepository
{
    protected $perPage = 10;
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }
    public abstract function query(): Builder;
    // $this->model()::where()...
    public abstract function model(): string; // App\Model\TestModel.php
    protected function setModel()
    {
        $model = app()->make($this->model());
        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }
    public function first()
    {
        return $this->query()->first();
    }
    public function get()
    {
        return $this->query()->get();
    }
    public function paginate()
    {
        return $this->query()->paginate($this->perPage);
    }
    public function create($input)
    {
        $instance = $this->model->create($input);
        return $instance ?? false;
    }
    public function update($id, $input)
    {
        $instance = $this->find($id);
        if(!$instance) return false;
        return $instance->update($input) ?? false;
    }
    public function delete($id, $input): bool
    {
        $instance = $this->find($id);
        if(!$instance) return false;
        return $instance->delete() ?? false;
    }
    public function destroy(array $ids)
    {
        return $this->model()::destroy($ids);
    }
    public function find($id)
    {
        $instance = $this->model->find($id);
        return $instance ?? false;
    }
}
