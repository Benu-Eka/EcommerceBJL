@extends('layouts.app')

@section('title', 'Chat Customer Service')

@section('content')
<x-navbar/>

<div class="min-h-[calc(100vh-80px)] bg-gray-50 flex justify-center py-6 px-4">
    <div class="w-full max-w-5xl bg-white shadow-2xl rounded-3xl overflow-hidden flex flex-col md:flex-row border border-gray-100">

        {{-- LEFT: CHAT AREA --}}
        <div class="w-full md:w-2/3 flex flex-col bg-white">
            
            {{-- HEADER CHAT --}}
            <div class="bg-gradient-to-r from-red-700 to-red-900 text-white flex items-center justify-between px-6 py-4 shadow-md">
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="bg-white/20 hover:bg-white/30 p-2 rounded-xl transition-all backdrop-blur-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <img src="{{ asset('build/assets/images/Logo_fanjaya_1.png') }}" class="w-12 h-10 object-contain bg-white rounded-lg p-1" alt="CS">
                            <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-red-800 rounded-full animate-pulse"></span>
                        </div>
                        <div>
                            <p class="font-bold text-sm tracking-wide">Customer Service BJL</p>
                            <p class="text-[10px] text-red-100 uppercase font-semibold flex items-center">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span> Online
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHAT BOX --}}
            <div id="chatBox" class="flex-1 overflow-y-auto bg-[#F8F9FA] p-6 scroll-smooth" 
                 style="height: 500px; max-height: 500px;">
                
                {{-- Welcome Message --}}
                <div id="welcomeMessage" class="flex items-start space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 shadow-sm border border-red-200">
                        <i class="fa-solid fa-robot text-xs"></i>
                    </div>
                    <div class="bg-white text-gray-700 px-5 py-3 rounded-2xl rounded-tl-none max-w-[80%] shadow-sm border border-gray-100">
                        <p class="text-sm leading-relaxed font-medium">Halo 👋! Ada yang bisa kami bantu hari ini?</p>
                        <p class="text-[10px] text-gray-400 mt-2 font-mono uppercase">{{ now()->format('H:i') }}</p>
                    </div>
                </div>

                {{-- Container Pesan --}}
                <div id="messageContainer" class="space-y-4">
                    @foreach ($messages as $msg)
                        <div class="message-item" data-id="{{ $msg->id }}">
                            @if ($msg->sender_type === 'pelanggan')
                                <div class="flex justify-end items-start space-x-3 mb-4">
                                    <div class="bg-gradient-to-br from-red-600 to-red-800 text-white px-5 py-3 rounded-2xl rounded-tr-none max-w-[85%] shadow-md">
                                        <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                                        <p class="text-[10px] text-red-200 mt-2 text-right font-mono">{{ $msg->created_at->format('H:i') }}</p>
                                    </div>
                                    <img src="https://ui-avatars.com/api/?name=Me&background=b91c1c&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                                </div>
                            @else
                                <div class="flex items-start space-x-3 mb-4">
                                    <img src="https://ui-avatars.com/api/?name=CS&background=1e293b&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                                    <div class="bg-white text-gray-800 px-5 py-3 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm border border-gray-100">
                                        <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                                        <p class="text-[10px] text-gray-400 mt-2 font-mono uppercase">{{ $msg->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT: INPUT AREA --}}
        <div class="w-full md:w-1/3 bg-gray-50 flex flex-col border-l border-gray-100">
            <div class="p-6 border-b bg-white">
                <h3 class="font-bold text-gray-800 text-base flex items-center">
                    <i class="fa-solid fa-paper-plane text-red-600 mr-2 text-sm"></i> Kirim Pesan
                </h3>
                <p class="text-xs text-gray-500 mt-1 italic">Tim kami akan membalas secepat mungkin.</p>
            </div>

            <div class="p-6 flex-1 flex flex-col justify-between bg-white/50">
                <div class="space-y-4">
                    <textarea id="messageInput" rows="5" placeholder="Tulis pesan..."
                        class="w-full border-2 border-gray-100 rounded-2xl p-4 text-sm focus:ring-4 focus:ring-red-50/50 focus:border-red-500 focus:outline-none resize-none transition-all shadow-inner bg-gray-50/30"></textarea>
                    
                    <button id="sendBtn"
                        class="w-full bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-white py-3.5 rounded-2xl font-bold shadow-xl shadow-red-200 transition-all transform active:scale-95 flex items-center justify-center space-x-2">
                        <span>Kirim Sekarang</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>

                <div class="mt-8 p-4 bg-red-50 rounded-2xl border border-red-100">
                    <p class="text-[11px] text-red-700 font-medium italic">
                        <i class="fa-solid fa-circle-info mr-1"></i> Jam Operasional BJL:
                    </p>
                    <p class="text-[10px] text-red-600/70 mt-1 uppercase font-bold tracking-wider">Senin - Sabtu: 08:00 - 17:00</p>
                </div>
            </div>
        </div>
    </div>
</div>

<x-footer/>

<style>
    #chatBox::-webkit-scrollbar { width: 5px; }
    #chatBox::-webkit-scrollbar-track { background: transparent; }
    #chatBox::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chatBox');
    const messageContainer = document.getElementById('messageContainer');
    const input = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');

    function scrollBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function formatTime(dateString) {
        const date = dateString ? new Date(dateString) : new Date();
        return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false});
    }

    const createMessageHTML = (msg) => {
        const isCustomer = msg.sender_type === "pelanggan";
        const time = formatTime(msg.created_at);
        
        if (isCustomer) {
            return `
                <div class="flex justify-end items-start space-x-3 animate-fadeIn mb-4">
                    <div class="bg-gradient-to-br from-red-600 to-red-800 text-white px-5 py-3 rounded-2xl rounded-tr-none max-w-[85%] shadow-md">
                        <p class="text-sm leading-relaxed">${msg.message}</p>
                        <p class="text-[10px] text-red-200 mt-2 text-right font-mono">${time}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Me&background=b91c1c&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                </div>`;
        } else {
            return `
                <div class="flex items-start space-x-3 animate-fadeIn mb-4">
                    <img src="https://ui-avatars.com/api/?name=CS&background=1e293b&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                    <div class="bg-white text-gray-800 px-5 py-3 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm border border-gray-100">
                        <p class="text-sm leading-relaxed">${msg.message}</p>
                        <p class="text-[10px] text-gray-400 mt-2 font-mono uppercase">${time}</p>
                    </div>
                </div>`;
        }
    };

    async function fetchMessages() {
        try {
            const res = await fetch("{{ route('chat.fetch') }}", { 
                headers: { 'Accept': 'application/json' } 
            });
            const data = await res.json();
            let addedNew = false;

            data.forEach(msg => {
                if (!document.querySelector(`[data-id="${msg.id}"]`)) {
                    const div = document.createElement('div');
                    div.className = 'message-item';
                    div.setAttribute('data-id', msg.id);
                    div.innerHTML = createMessageHTML(msg);
                    messageContainer.appendChild(div);
                    addedNew = true;
                }
            });

            if (addedNew) scrollBottom();
        } catch (err) { console.error('Fetch Error:', err); }
    }

    sendBtn.addEventListener('click', async () => {
        const message = input.value.trim();
        if (!message) return;
        input.value = "";
        
        try {
            await fetch("{{ route('chat.send') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: message })
            });
            fetchMessages(); 
        } catch (err) { console.error('Send Error:', err); }
    });

    // Inisialisasi
    scrollBottom();
    setInterval(fetchMessages, 2000);
});
</script>
@endsection