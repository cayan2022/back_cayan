<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreTemplateRequest;
use App\Http\Requests\Api\Dashboard\UpdateTemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Country;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Http;

class TemplateController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TemplateResource::collection(Template::filter()->latest()->paginate());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTemplateRequest $request
     * @return Response
     */
    public function store(StoreTemplateRequest $request)
    {
        // Step 1: Store data in local DB
        $data = collect($request->validated())->except(['image'])->toArray();
        $template = Template::create($data);

        // Step 2: Handle image if provided
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $template->addMediaFromRequest('image')
                ->toMediaCollection(Template::MEDIA_COLLECTION_NAME);
        }

        // Step 3: Attempt external API request with error handling
        $externalData = $request->validated();
        try {
            $response = Http::post('https://api.cayan.llc/api/site/create-template', $externalData);

            // Log response data for debugging
            \Log::info('External API Response', [
                'status' => $response->status(),
                'response_body' => $response->json()
            ]);

            if ($response->successful()) {
                return response()->json([
                    'message' => 'Template stored successfully in local DB and external API',
                    'data' => $template->getResource()
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Template stored in local DB, but external API request failed',
                    'error' => $response->json() ?? 'Unknown error'
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Log exception details if the request completely fails
            \Log::error('External API Exception', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Template stored in local DB, but external API request failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Template $template
     * @return TemplateResource
     */
    public function show(Template $template)
    {
        return $template->getResource();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTemplateRequest $request
     * @param Template $template
     * @return TemplateResource
     */
    public function update(UpdateTemplateRequest $request, Template $template)
    {
        $data = collect($request->validated())->except(['image'])->toArray();
        $template->update($data);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $template->clearMediaCollection(Template::MEDIA_COLLECTION_NAME);
            $template->addMediaFromRequest('image')->toMediaCollection(Template::MEDIA_COLLECTION_NAME);
        }

        // store the template in saas db
        Http::post('https://api.cayan.llc/api/site/update-template/' . $template, $request->validated());

        return $template->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Template $template
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Template $template)
    {
        $template->delete();

        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param Template $template
     * @return Application|ResponseFactory|Response
     */
    public function block(Template $template)
    {
        $template->block();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param Template $template
     * @return Application|ResponseFactory|Response
     */
    public function active(Template $template)
    {
        $template->active();
        return $this->success(__('auth.success_operation'));
    }
}
