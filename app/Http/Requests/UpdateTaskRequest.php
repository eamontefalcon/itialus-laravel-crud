<?php

namespace App\Http\Requests;

use App\Services\UpdateTaskService\UpdateTaskInterface;

class UpdateTaskRequest extends CreateTaskRequest implements UpdateTaskInterface
{

}
