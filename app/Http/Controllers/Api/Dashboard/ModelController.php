<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ModelResource;
use App\Models\AppModel;


class ModelController extends Controller
{
    use RespondsWithHttpStatus;

    public function all()
    {
        return ModelResource::collection(AppModel::latest()->get());
    }
}
