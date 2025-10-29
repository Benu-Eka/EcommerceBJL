@extends('layouts.app')

@section('title', 'Chat Customer Service')

@section('content')
<x-navbar/>
<div class="min-h-screen bg-gray-50 flex justify-center py-5 px-4">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row">

        <div class="w-full md:w-2/3 flex flex-col border-r">
            {{-- Header --}}
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
                        <img src="{{ asset('build/assets/images/logo2.png') }}" class="w-16 h-8  border-white" alt="CS">
                        <div>
                            <p class="font-semibold text-sm">Customer Service</p>
                            <p class="text-xs text-red-100">Online</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="chatBox" class="flex-1 overflow-y-auto bg-gray-50 p-4 space-y-3">
                <div class="flex items-start space-x-2">
                    <div class="bg-gray-200 text-gray-800 px-5 py-2 rounded-2xl rounded-ts-none max-w-xs shadow">
                        <p>Halo 👋! Ada yang bisa kami bantu hari ini?</p>
                        <p class="text-xs text-gray-500 mt-1">08:30</p>
                    </div>
                </div>
            </div>
        </div>

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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('messageInput');
    const chatBox = document.getElementById('chatBox');
    const sendBtn = document.getElementById('sendBtn');

    function addUserMessage(message) {
        if (!message.trim()) return;

        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const userChat = document.createElement('div');
        userChat.classList.add('flex', 'justify-end', 'items-start', 'space-x-2', 'animate-fadeIn');
        userChat.innerHTML = `
            <div class="bg-green-600 text-white px-3 py-2 rounded-2xl rounded-tr-none max-w-xs shadow">
                <p>${message}</p>
                <p class="text-xs text-green-200 mt-1 text-right">${time}</p>
            </div>
            <img src="https://source.unsplash.com/40x40/?user" alt="User" class="w-8 h-8 rounded-full">
        `;
        chatBox.appendChild(userChat);
        chatBox.scrollTop = chatBox.scrollHeight;

        // Simulasi balasan admin
        setTimeout(() => {
            addAdminMessage("Terimakasih!!! Pesan Anda sudah kami terima 🙏");
        }, 1200);
    }

    function addAdminMessage(message) {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const adminChat = document.createElement('div');
        adminChat.classList.add('flex', 'items-start', 'space-x-2', 'animate-fadeIn');
        adminChat.innerHTML = `
            <img src="https://source.unsplash.com/40x40/?support" alt="Admin" class="w-8 h-8 rounded-full">
            <div class="bg-gray-200 text-gray-800 px-3 py-2 rounded-2xl rounded-tl-none max-w-xs shadow">
                <p>${message}</p>
                <p class="text-xs text-gray-500 mt-1">${time}</p>
            </div>
        `;
        chatBox.appendChild(adminChat);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    sendBtn.addEventListener('click', () => {
        addUserMessage(input.value);
        input.value = '';
        input.focus();
    });
});
</script>

{{-- Animasi kecil --}}
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
