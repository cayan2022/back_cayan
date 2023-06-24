<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\OrdersImportRequest;
use App\Imports\OrdersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Traits\RespondsWithHttpStatus;

class ImportOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     */
    public function __invoke(OrdersImportRequest $request): \Illuminate\Http\JsonResponse
    {
        Excel::import(new OrdersImport, request()->file('excel_file'));

        return $this->success(__('auth.success_operation'));
    }
}