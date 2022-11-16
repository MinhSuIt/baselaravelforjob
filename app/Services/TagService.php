<?php

namespace App\Services;

use App\Base\Services\BaseService;
use App\Repositories\TagRepository;

class TagService extends BaseService
{
    public function setRepository(): string
    {
        return TagRepository::class;
    }
}
