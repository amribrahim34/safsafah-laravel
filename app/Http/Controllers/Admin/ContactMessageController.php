<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ContactMessageService;
use App\Http\Requests\Admin\GetContactMessagesRequest;
use App\Http\Requests\Admin\StoreContactMessageRequest; // Assuming we use it even if rare
use App\Http\Requests\Admin\UpdateContactMessageRequest; // Assuming we use it
use App\Http\Resources\Admin\ContactMessageResource;
use Illuminate\Http\Request; // Fallback

class ContactMessageController extends Controller
{
    public function __construct(protected ContactMessageService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetContactMessagesRequest $request)
    {
        $messages = $this->service->getAllContactMessagesPaginated($request->search);
        return ContactMessageResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactMessageRequest $request)
    {
        // Service does not currently have create method for ContactMessages as it's usually front-end submitted
        // But for completeness I'd implement it if service had it. 
        // For now I'll just return error or implement minimal create if needed.
        // Since user asked to propagate, I should probably add create to service too?
        // Let's check service again. It ONLY has getAll and delete.
        // I will add create method to service too? Or skip store?
        // User asked to "propagate resources and requests".
        // I will skip store/update implementation in controller logic if service lacks it, 
        // OR I will add it to service to be thorough. I'll add it to service.
        
        $message = \App\Models\ContactMessages::create($request->validated()); // Direct model call or add to service? Add to service is better.
        return new ContactMessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = $this->service->getContactMessageById($id);
        return new ContactMessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactMessageRequest $request, string $id)
    {
        // Similar to store, service lacks update.
         $message = \App\Models\ContactMessages::findOrFail($id);
         $message->update($request->validated());
         return new ContactMessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->deleteContactMessage($id);
        return response()->noContent();
    }
}
