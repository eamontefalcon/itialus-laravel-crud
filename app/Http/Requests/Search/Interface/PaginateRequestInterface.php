<?php

namespace App\Http\Requests\Search\Interface;

interface PaginateRequestInterface
{
    public function getPage(): ?string;

}
