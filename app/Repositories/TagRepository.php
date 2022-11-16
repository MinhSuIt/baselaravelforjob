<?php

namespace App\Repositories;

use App\Base\Repositories\BaseRepository;
use App\Models\Blog\Tag;
use Illuminate\Database\Eloquent\Builder;

class TagRepository extends BaseRepository
{
    public function model(): string
    {
        return Tag::class;
    }
    public function query(): Builder
    {
        // dd(request()->all()); // ở service sẽ lọc request query nếu cần thiết
        $result = $this->model->query();
        $result->when(request()->id, function ($query, $id) {
            $query->id($id); //model > scopeId
        });
        $result->when(request()->name, function ($query, $name) {
            $query->name($name);
        });
        return $result;
    }
}
