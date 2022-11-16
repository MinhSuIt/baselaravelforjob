<?php

namespace App\Services;

use App\Base\Services\BaseService;
use App\Repositories\PostRepository;

class PostService extends BaseService
{
    public function setRepository(): string
    {
        return PostRepository::class;
    }
}
