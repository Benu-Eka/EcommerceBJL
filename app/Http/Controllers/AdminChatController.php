<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    public function index()
{
    $customers = Pelanggan::whereHas('messages')
        ->with(['messages' => function($q){
            $q->latest();
        }])
        ->get()
        ->map(function($cust){
            $cust->last_message = $cust->messages->first()->message ?? null;
            return $cust;
        });

    return view('admin.chat.index', compact('customers'));
}

public function show($pelanggan_id)
{
    $customers = Pelanggan::whereHas('messages')
        ->get();

    $selectedCustomer = Pelanggan::findOrFail($pelanggan_id);

    $messages = Message::where('pelanggan_id', $pelanggan_id)
                ->orderBy('created_at', 'asc')
                ->get();

    return view('admin.chat.index',
        compact('customers', 'selectedCustomer', 'messages'));
}

public function send(Request $request, $pelanggan_id)
{
    Message::create([
        'pelanggan_id' => $pelanggan_id,
        'admin_id' => auth()->id(),
        'sender_type' => 'admin',
        'message' => $request->message
    ]);

    return back();
}

}
