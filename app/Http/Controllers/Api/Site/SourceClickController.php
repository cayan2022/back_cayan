<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Models\Source;
use App\Models\SourceClicks;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SourceClickController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function addClick(Request $request)
    {
        $source = Source::where('identifier', $request->identifier)->first();
        SourceClicks::updateOrCreate(
            [
                'source_id' => $source->id,
                'clickable_type' => $request->type,
            ],
            [
                'clicks' => \DB::raw('clicks + 1'),
            ]
        );

        return $this->success(__('auth.success_operation'));
    }
}
