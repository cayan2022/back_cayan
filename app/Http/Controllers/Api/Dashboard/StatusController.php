<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Source;
use App\Models\Status;
use App\Models\SubStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Http\Resources\SubStatusResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $statusesQuery = Status::query();

        // Handle date range filtering
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $statusesQuery->withCount(['orders' => function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->get('start_date'), $request->get('end_date')])
                    ->where('type', 1);  // Apply 'type = 1' only in the Order query
            }]);
        }

        // Handle employee filtering
        if ($request->filled('employee')) {
            $order_ids = $this->getOrderIdsByEmployee($request->get('employee'));
            $statusesQuery->withCount(['orders' => function ($query) use ($order_ids) {
                $query->whereIn('id', $order_ids)
                    ->where('type', 1);  // Apply 'type = 1' only in the Order query
            }]);
        }

        // Handle source filtering
        if ($request->filled('source')) {
            $order_ids = $this->getOrderIdsBySource($request->get('source'));
            $statusesQuery->withCount(['orders' => function ($query) use ($order_ids) {
                $query->whereIn('id', $order_ids)
                    ->where('type', 1);  // Apply 'type = 1' only in the Order query
            }]);
        }

        // Default case where no filters are applied
        if (!$request->filled('start_date') && !$request->filled('end_date') && !$request->filled('employee') && !$request->filled('source')) {
            $statusesQuery->withCount(['orders' => function ($query) {
                $query->where('type', 1);  // Apply 'type = 1' only in the Order query
            }]);
        }

        $statuses = $statusesQuery->filter()->get();

        return StatusResource::collection($statuses);
    }

// Helper function to get order IDs based on employee name with type condition
    private function getOrderIdsByEmployee($employeeName) {
        $user = User::where('name', $employeeName)->first();
        return $user ? OrderHistory::where('user_id', $user->id)
            ->groupBy('order_id')
            ->pluck('order_id') : collect();
    }

// Helper function to get order IDs based on source identifier (type condition applied here)
    private function getOrderIdsBySource($sourceIdentifier) {
        $source = Source::where('identifier', $sourceIdentifier)->first();
        return $source ? Order::where('source_id', $source->id)
            ->groupBy('order_id')
            ->pluck('id') : collect();
    }

    /**
     * Display the specified resource.
     *
     * @param Status $status
     * @return StatusResource
     */
    public function show(Status $status): StatusResource
    {
        return new StatusResource($status);
    }

    public function substatuses(Status $status): AnonymousResourceCollection
    {
        return SubStatusResource::collection(SubStatus::where('status_id', $status->id)->paginate());
    }
}
