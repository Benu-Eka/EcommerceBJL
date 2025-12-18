@extends('layouts.app')

@section('title', 'Chat Customer Service')

@section('content')
<x-navbar/>

<div class="min-h-screen bg-gray-50 flex justify-center py-5 px-4">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row">

        {{-- LEFT: CHAT AREA --}}
        <div class="w-full md:w-2/3 flex flex-col border-r">

            {{-- HEADER --}}
            <div class="bg-red-700 text-white flex items-center justify-between px-4 py-3">
                <div class="flex items-center space-x-3">
                    <a href="{{ url('/') }}" class="hover:bg-red-800 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('build/assets/images/logo2.png') }}" class="w-16 h-8" alt="CS">
                        <div>
                            <p class="font-semibold text-sm">Customer Service</p>
                            <p class="text-xs text-red-100">Online</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHAT BOX --}}
            <div id="chatBox" class="flex-1 overflow-y-auto bg-gray-50 p-4 space-y-3">

                {{-- FIRST MESSAGE --}}
                <div class="flex items-start space-x-2">
                    <div class="bg-gray-200 text-gray-800 px-5 py-2 rounded-2xl rounded-ts-none max-w-xs shadow">
                        <p>Halo 👋! Ada yang bisa kami bantu hari ini?</p>
                        <p class="text-xs text-gray-500 mt-1">{{ now()->format('H:i') }}</p>
                    </div>
                </div>

                {{-- LOOP PESAN DARI DATABASE --}}
                @foreach ($messages as $msg)
                    
                    {{-- Pesan pelanggan --}}
                    @if ($msg->sender_type === 'pelanggan')
                        <div class="flex justify-end items-start space-x-2">
                            <div class="bg-green-600 text-white px-3 py-2 rounded-2xl rounded-tr-none max-w-xs shadow">
                                <p>{{ $msg->message }}</p>
                                <p class="text-xs text-green-200 mt-1 text-right">
                                    {{ $msg->created_at->format('H:i') }}
                                </p>
                            </div>
                            <img src="https://source.unsplash.com/40x40/?user" alt="User" class="w-8 h-8 rounded-full">
                        </div>

                    {{-- Pesan admin --}}
                    @else
                        <div class="flex items-start space-x-2">
                            <img src="https://source.unsplash.com/40x40/?support" alt="Admin" class="w-8 h-8 rounded-full">
                            <div class="bg-gray-200 text-gray-800 px-3 py-2 rounded-2xl rounded-tl-none max-w-xs shadow">
                                <p>{{ $msg->message }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $msg->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif

                @endforeach

            </div>
        </div>

        {{-- RIGHT: INPUT AREA --}}
        <div class="w-full md:w-1/3 bg-white flex flex-col justify-between border-l">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-gray-800 text-sm">Kirim Pesan</h3>
                <p class="text-xs text-gray-500">Tulis pesan Anda di sini</p>
            </div>

            <div class="flex-1 flex flex-col justify-end">
                <div class="p-4 space-y-2">
                    <textarea id="messageInput" rows="3" placeholder="Ketik pesan..."
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-red-400 focus:outline-none resize-none"></textarea>
                    <button id="sendBtn"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-semibold transition">
                        Kirim Pesan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<x-footer/>


{{-- AJAX SEND + AUTO RELOAD --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chatBox');
    const input = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');

    // Auto scroll
    function scrollBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    scrollBottom();

    // Kirim pesan AJAX
    sendBtn.addEventListener('click', () => {
        let message = input.value.trim();
        if (!message) return;

        // --- Perubahan #1: Tambahkan pesan ke UI secara INSTAN ---
        // Simpan pesan saat ini untuk ditampilkan
        const tempMessage = message; 

        // Tampilkan pesan instan (Optimistic Update)
        chatBox.innerHTML += `
            <div class="flex justify-end items-start space-x-2 animate-fadeIn">
                <div class="bg-green-600 text-white px-3 py-2 rounded-2xl rounded-tr-none max-w-xs shadow">
                    <p>${tempMessage}</p>
                    <p class="text-xs text-green-200 mt-1 text-right">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                </div>
                <img src="https://source.unsplash.com/40x40/?user" class="w-8 h-8 rounded-full">
            </div>`;

        scrollBottom(); // Gulir ke bawah segera setelah pesan ditambahkan
        input.value = ""; // Kosongkan input

        // Lakukan pengiriman ke server
        fetch("{{ route('chat.send') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message: tempMessage }) // Gunakan tempMessage
        }).then(res => res.json()).then(data => {
            // >>> Perubahan #2: Hapus fetchMessages() di sini. <<<
            // Biarkan setInterval yang menangani auto-refresh
            console.log('Pesan terkirim ke server:', data);
        }).catch(error => {
            // Handle error jika pengiriman gagal
            console.error('Gagal mengirim pesan:', error);
            alert('Gagal mengirim pesan. Silakan coba lagi.');
            // Opsional: Hapus pesan optimistic atau berikan feedback error di UI
        });
    });

    // Ambil pesan terbaru tiap 1 detik (Pertahankan fungsi ini)
    function fetchMessages() {
        fetch("{{ route('chat.fetch') }}")
            .then(res => res.json())
            .then(data => {
                // Hapus semua pesan kecuali pesan pertama CS
                let newChatContent = `
                    <div class='flex items-start space-x-2'>
                        <div class='bg-gray-200 text-gray-800 px-5 py-2 rounded-2xl rounded-ts-none max-w-xs shadow'>
                            <p>Halo 👋! Ada yang bisa kami bantu hari ini?</p>
                            <p class="text-xs text-gray-500 mt-1">{{ now()->format('H:i') }}</p>
                        </div>
                    </div>`;

                data.forEach(msg => {
    const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    // Pastikan ini membandingkan dengan "pelanggan"
    if (msg.sender_type === "pelanggan") {
        // HTML untuk KANAN (Pelanggan)
        newChatContent += `
            <div class="flex justify-end items-start space-x-2 mb-3">
                <div class="bg-green-600 text-white px-3 py-2 rounded-2xl rounded-tr-none max-w-xs shadow">
                    <p>${msg.message}</p>
                    <p class="text-xs text-green-200 mt-1 text-right">${time}</p>
                </div>
                <img src="https://ui-avatars.com/api/?name=Me&background=059669&color=fff" class="w-8 h-8 rounded-full">
            </div>`;
    } else {
        // HTML untuk KIRI (Admin)
        newChatContent += `
            <div class="flex items-start space-x-2 mb-3">
                <img src="https://ui-avatars.com/api/?name=CS&background=BE123C&color=fff" class="w-8 h-8 rounded-full">
                <div class="bg-gray-200 text-gray-800 px-3 py-2 rounded-2xl rounded-tl-none max-w-xs shadow">
                    <p>${msg.message}</p>
                    <p class="text-xs text-gray-500 mt-1">${time}</p>
                </div>
            </div>`;
    }
});

                // Periksa apakah ada perubahan pada konten sebelum memperbarui
                if (chatBox.innerHTML.trim() !== newChatContent.trim()) {
                    chatBox.innerHTML = newChatContent;
                    scrollBottom(); // Gulir ke bawah hanya jika ada pesan baru/perubahan
                }
            });
    }

    // Interval Auto-Refresh
    // Pertahankan interval 1000ms (1 detik)
    setInterval(fetchMessages, 1000); 
});
</script>


{{-- Animasi --}}
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.3s ease-in-out;
}
</style>

@endsection
