<?php

namespace App\Repositories;

use App\Base\Repositories\BaseRepository;
use App\Models\Blog\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository
{
    public function model(): string
    {
        return Category::class;
    }
    public function query(): Builder //query có thể nhận request()->query()(có thể lọc lại tùy theo service), từ đây viết thêm các điều kiện mà ko dùng dạng when(request()->id)
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
