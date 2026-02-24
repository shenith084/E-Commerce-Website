<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', '🗑️ Message deleted.');
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['status' => 'read']);
        return back()->with('success', 'Message marked as read.');
    }
}
