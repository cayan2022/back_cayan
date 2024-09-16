<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Requests\Api\Dashboard\StoreCampaignRequest;
use App\Models\Branch;
use App\Models\Campaign;
use App\Services\CampaignWhatsappService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignResource;
use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Requests\Api\Dashboard\StoreBranchRequest;
use App\Http\Requests\Api\Dashboard\UpdateBranchRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CampaignController extends Controller
{

    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CampaignResource::collection(Campaign::filter()->latest()->paginate());
    }

    public function store(StoreCampaignRequest $request): CampaignResource
    {
        $data = collect($request->validated())->except(['image'])->toArray();
        $campaign = Campaign::create($data);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $campaign->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Campaign::MEDIA_COLLECTION_NAME);
        }
        return $campaign->getResource();
    }

    public function show(Campaign $campaign): CampaignResource
    {
        return $campaign->getResource();
    }

    public function update(StoreCampaignRequest $request, Campaign $campaign)
    {
        $data = collect($request->validated())->except(['image'])->toArray();
        $campaign->update($data);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $campaign->clearMediaCollection(Campaign::MEDIA_COLLECTION_NAME);
            $campaign->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Campaign::MEDIA_COLLECTION_NAME);
        }

        return $campaign->getResource();
    }


    public function destroy(Campaign $campaign): Response
    {
        $campaign->delete();
        return $this->success(__('auth.success_operation'));
    }

    public function send(Campaign $campaign)
    {
        $message = 'Cayan';
        CampaignWhatsappService::sendCampaign($campaign->name, $campaign->description, $message,$campaign->starting_time, $campaign->ending_time, $campaign->getAvatar(), $campaign->users->pluck('phone')->toArray());
        return $this->success(__('auth.success_operation'));
    }
}
