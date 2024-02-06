<?php

namespace App\Http\Requests\Search\Interface;

interface SortRequestInterface
{
    public function getColumn(): string;

    public function getDirection(): string;

}
