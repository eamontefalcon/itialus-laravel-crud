<?php

namespace App\Http\Requests\Search\Interface;

interface SearchRequestInterface
{
    public function getSearchValue(): ?string;

}
