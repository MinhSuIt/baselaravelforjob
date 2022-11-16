<?php

namespace App\Base\Services;

use Error;
use Illuminate\Support\Arr;

abstract class BaseServices
{
    protected $repositories; //[]
    protected $relations; //[]

    public function __get($property) //khi lấy thuộc tính ko tồn tại
    {
        if (!array_key_exists($property, $this->repositories)) {
            throw new Error('This service hasn\'t $property');
        }
        info($this->repositories[$property]);
        return app()->make($this->repositories[$property]); //cẩn thân nếu xài kiểu này sợ sẽ tạo ra nhiều instance repository của 1 class,vậy nên khai báo thêm instance repository này là singleton trong provider
    }

    abstract public function setRepositories(array $repositories): void;
    abstract public function setRelations(array $relations): void;
    // {
    //     $this->repositories = $repositories;//['productRepository'=>ProductRepository::class,mainRepository=>...]
    // }
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
        $this->syncRelations($instance, $input);
    }
    public function update($id, $input)
    {
        $instance = $this->mainRepository->find($id);
        $instance = $instance->update($input);
        // $this->syncRelations($instance, $input);
    }
    public function delete($id)
    {
        $instance = $this->mainRepository->find($id);
        return $instance->delete();
    }
    public function destroy(array $ids)
    {
        return $this->mainRepository->model()::destroy($ids);
    }
}
