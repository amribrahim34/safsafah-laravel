<?php

namespace App\Services\Admin;

use App\Models\ContactMessages;
use Illuminate\Support\Facades\Storage;

class ContactMessageService
{
    public function getAllContactMessagesPaginated($search = null)
    {
        return ContactMessages::query()
            ->search($search)
            ->paginate(10);
    }

    public function getContactMessageById($id)
    {
        return ContactMessages::findOrFail($id);
    }

    public function deleteContactMessage($id)
    {
        $message = ContactMessages::findOrFail($id);
        if ($message->file) {
            Storage::disk('public')->delete($message->file);
        }
        return $message->delete();
    }
}
