<?php

namespace App\Base\Services;

use App\Base\Repositories\BaseRepository;
use Illuminate\Support\Arr;

abstract class BaseService
{
    protected $mainRepository;

    abstract public function setRepository(): string;
    public function __construct()
    {
        $this->mainRepository = app()->make($this->setRepository());
    }
    public function syncRelations($instance, $relationData)
    {
        if ($this->relations) {
            $relations = Arr::only($relationData, $this->relations);
            foreach ($relations as $relation => $data) {
                $instance->{$relation}()->sync($data);
            }
        }
    }
    public function create($input)
    {
        $instance = $this->mainRepository->create($input);
        // $this->syncRelations($instance, $input);
        return $instance;
    }
    public function update($instance, $input)
    {
        $instance = $instance->update($input);
        // $this->syncRelations($instance, $input);
        return $instance;
    }
    public function delete($instance)
    {
        return $instance->delete();
    }
    public function destroy(array $ids)
    {
        return $this->mainRepository->model()::destroy($ids);
    }
    public function get()
    {
        // dd($this->mainRepository);
        return $this->mainRepository->query()->get();
    }
    public function paginate($perPage = 10)
    {
        return $this->mainRepository->query()->paginate($perPage);
    }
    public function first()
    {
        return $this->mainRepository->query()->first();
    }

    public function find($id)
    {
        return $this->mainRepository->find($id);
    }
}
