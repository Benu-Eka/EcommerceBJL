<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
public function index()
{
    $userId = auth()->id(); // Pastikan user sudah login
    
    $messages = Message::where(function($q) use ($userId) {
            $q->where('sender_id', $userId)->where('sender_type', 'pelanggan');
        })
        ->orWhere(function($q) use ($userId) {
            $q->where('receiver_id', $userId)->where('receiver_type', 'pelanggan');
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return view('chat.index', compact('messages'));
}

    public function send(Request $request)
    {
        // Pastikan pelanggan ter-autentikasi
        if (!Auth::guard('pelanggan')->check()) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
        }

        \Log::info('Chat send request', ['user' => Auth::guard('pelanggan')->id(), 'message_preview' => \Illuminate\Support\Str::limit($request->message, 120)]);

        $request->validate(['message' => 'required|string']);

        try {
            $msg = Message::create([
                'sender_id' => Auth::guard('pelanggan')->id(),
                'sender_type' => 'pelanggan',
                'receiver_id' => 1,               // ADMIN ID (sesuaikan)
                'receiver_type' => 'admin',
                'message' => $request->message
            ]);

            return response()->json(['status' => true, 'id' => $msg->id]);
        } catch (\Exception $e) {
            \Log::error('ChatController@send failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['status' => false, 'message' => 'Server error while saving message'], 500);
        }
    }

public function fetch()
{
    $userId = auth()->id();

    $messages = Message::where(function ($q) use ($userId) {
            // Skenario A: Pesan yang dikirim oleh pelanggan ini
            $q->where('sender_id', $userId)
              ->where('sender_type', 'pelanggan');
        })
        ->orWhere(function ($q) use ($userId) {
            // Skenario B: Pesan yang diterima oleh pelanggan ini dari admin
            $q->where('receiver_id', $userId)
              ->where('receiver_type', 'pelanggan'); // Di database Anda adalah 'pelanggan'
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json($messages);
}

}

