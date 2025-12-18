@extends('admin.layout')

@section('content')
<div class="flex h-screen">

    {{-- ============================
        SIDEBAR LIST PELANGGAN
    ============================= --}}
    <div class="w-1/4 bg-gray-100 border-r overflow-y-auto">
        <h2 class="p-4 font-bold text-lg border-b">Daftar Pesan Pelanggan</h2>

        @forelse ($customers as $cust)
            <a href="{{ route('admin.chat.show', $cust->id) }}"
               class="block p-4 border-b hover:bg-gray-200
                      @if(isset($selectedCustomer) && $selectedCustomer->id == $cust->id)
                        bg-gray-300 font-semibold
                      @endif">
                <div>{{ $cust->nama }}</div>
                <small class="text-gray-600">
                    {{ $cust->last_message ?? 'Belum ada pesan' }}
                </small>
            </a>
        @empty
            <p class="p-4 text-gray-500">Belum ada pesan masuk.</p>
        @endforelse
    </div>

    {{-- ============================
        CHAT WINDOW
    ============================= --}}
    <div class="flex-1 flex flex-col">

        {{-- Header --}}
        <div class="p-4 border-b bg-white">
            @if(isset($selectedCustomer))
                <h2 class="font-bold text-lg">
                    Chat dengan: {{ $selectedCustomer->nama }}
                </h2>
            @else
                <h2 class="font-bold text-lg text-gray-500">Pilih pelanggan untuk melihat chat</h2>
            @endif
        </div>

        {{-- CHAT BODY --}}
        <div class="flex-1 p-4 overflow-y-auto space-y-3 bg-gray-50">

            @if(isset($messages))
                @foreach($messages as $msg)

                    {{-- Pesan dari Pelanggan --}}
                    @if ($msg->sender_type === 'pelanggan')
                        <div class="flex">
                            <div class="bg-white px-4 py-2 rounded-xl shadow max-w-lg">
                                <div class="font-semibold">{{ $selectedCustomer->nama }}</div>
                                <div>{{ $msg->message }}</div>
                                <small class="text-gray-500">{{ $msg->created_at->format('H:i') }}</small>
                            </div>
                        </div>

                    {{-- Pesan dari Admin --}}
                    @else
                        <div class="flex justify-end">
                            <div class="bg-blue-500 text-white px-4 py-2 rounded-xl shadow max-w-lg">
                                <div class="font-semibold">Admin</div>
                                <div>{{ $msg->message }}</div>
                                <small class="text-gray-200">{{ $msg->created_at->format('H:i') }}</small>
                            </div>
                        </div>
                    @endif

                @endforeach
            @endif

        </div>

        {{-- FORM KIRIM PESAN --}}
        @if(isset($selectedCustomer))
        <form action="{{ route('admin.chat.send', $selectedCustomer->id) }}" method="POST"
              class="p-4 border-t bg-white flex gap-3">
            @csrf

            <input type="text" name="message" required
                   class="flex-1 border rounded-lg px-4 py-2"
                   placeholder="Ketik pesan...">

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Kirim
            </button>
        </form>
        @endif

    </div>
</div>
@endsection