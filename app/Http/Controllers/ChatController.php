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
        $request->validate(['message' => 'required']);

        Message::create([
            'sender_id' => Auth::id(),
            'sender_type' => 'pelanggan',
            'receiver_id' => 1,               // ADMIN ID (sesuaikan)
            'receiver_type' => 'admin',
            'message' => $request->message
        ]);

        return response()->json(['status' => true]);
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


