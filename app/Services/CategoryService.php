<?php

namespace App\Services;

use App\Base\Services\BaseService;
use App\Repositories\CategoryRepository;

class CategoryService extends BaseService
{
    public function setRepository(): string
    {
        return CategoryRepository::class;
    }
}
