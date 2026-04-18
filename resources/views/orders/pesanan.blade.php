@extends('layouts.app')

@section('title', 'Pesanan Saya | Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

<div class="min-h-screen bg-[#f9fafb] py-10 px-4 font-sans">
    <main class="max-w-6xl mx-auto">
        
        {{-- Header & Tombol Kembali Konsisten --}}
        <div class="mb-8">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center text-gray-500 hover:text-red-700 font-medium transition-colors duration-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Beranda
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">Pesanan Anda</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau status pengiriman dan riwayat belanja Anda.</p>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm font-medium">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Tabs Navigation (Modern Pill Style) --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-2 mb-8 overflow-x-auto custom-scrollbar">
            <div class="flex flex-nowrap md:flex-wrap gap-1 min-w-max">
                <button data-tab="tab-belum-bayar" class="tab-btn {{ ($activeTab ?? 'belum-bayar') == 'belum-bayar' ? 'active' : 'text-gray-500 hover:bg-gray-50' }} px-6 py-3 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                    Belum Bayar
                </button>
                <button data-tab="tab-dibayar" class="tab-btn {{ ($activeTab ?? '') == 'dibayar' ? 'active' : 'text-gray-500 hover:bg-gray-50' }} px-6 py-3 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                    Dibayar
                </button>
                <button data-tab="tab-dikemas" class="tab-btn {{ ($activeTab ?? '') == 'dikemas' ? 'active' : 'text-gray-500 hover:bg-gray-50' }} px-6 py-3 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                    Dikemas
                </button>
                <button data-tab="tab-dikirim" class="tab-btn {{ ($activeTab ?? '') == 'dikirim' ? 'active' : 'text-gray-500 hover:bg-gray-50' }} px-6 py-3 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                    Dikirim
                </button>
                <button data-tab="tab-selesai" class="tab-btn {{ ($activeTab ?? '') == 'selesai' ? 'active' : 'text-gray-500 hover:bg-gray-50' }} px-6 py-3 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                    Selesai
                </button>
                <button data-tab="tab-dibatalkan" class="tab-btn {{ ($activeTab ?? '') == 'dibatalkan' ? 'active' : 'text-gray-500 hover:bg-gray-50' }} px-6 py-3 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap">
                    Dibatalkan
                </button>
            </div>
        </div>

        {{-- Panels Container --}}
        <div class="space-y-6">
            {{-- BELUM BAYAR --}}
            <div id="tab-belum-bayar" class="tab-panel animate-fadeIn {{ ($activeTab ?? 'belum-bayar') != 'belum-bayar' ? 'hidden' : '' }}">
                @forelse ($pesananBelumBayar ?? [] as $order)
                    @include('components.order-card', ['order' => $order])
                @empty
                    <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                        <img src="https://cdn-icons-png.flaticon.com/512/10522/10522166.png" class="w-20 h-20 mx-auto opacity-20 mb-4" alt="empty">
                        <p class="text-gray-400 font-medium">Tidak ada pesanan yang menunggu pembayaran.</p>
                    </div>
                @endforelse
            </div>

            {{-- DIBAYAR --}}
            <div id="tab-dibayar" class="tab-panel animate-fadeIn {{ ($activeTab ?? '') != 'dibayar' ? 'hidden' : '' }}">
                @forelse ($orders['dibayar'] ?? [] as $order)
                    @include('components.order-card', ['order' => $order])
                @empty
                    <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                        <img src="https://cdn-icons-png.flaticon.com/512/10522/10522166.png" class="w-20 h-20 mx-auto opacity-20 mb-4" alt="empty">
                        <p class="text-gray-400 font-medium">Tidak ada pesanan yang sudah dibayar.</p>
                    </div>
                @endforelse
            </div>

            {{-- DIKEMAS --}}
            <div id="tab-dikemas" class="tab-panel animate-fadeIn {{ ($activeTab ?? '') != 'dikemas' ? 'hidden' : '' }}">
                @forelse ($orders['dikemas'] ?? [] as $order)
                    @include('components.order-card', ['order' => $order])
                @empty
                    <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                        <p class="text-gray-400 font-medium">Belum ada pesanan yang sedang dikemas.</p>
                    </div>
                @endforelse
            </div>

            {{-- DIKIRIM --}}
            <div id="tab-dikirim" class="tab-panel animate-fadeIn {{ ($activeTab ?? '') != 'dikirim' ? 'hidden' : '' }}">
                @forelse ($orders['dikirim'] ?? [] as $order)
                    @include('components.order-card', ['order' => $order])
                @empty
                    <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                        <p class="text-gray-400 font-medium">Belum ada pesanan yang sedang dikirim.</p>
                    </div>
                @endforelse
            </div>

            {{-- SELESAI --}}
            <div id="tab-selesai" class="tab-panel animate-fadeIn {{ ($activeTab ?? '') != 'selesai' ? 'hidden' : '' }}">
                @forelse ($orders['selesai'] ?? [] as $order)
                    @include('components.order-card', ['order' => $order])
                @empty
                    <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                        <p class="text-gray-400 font-medium">Belum ada pesanan yang selesai.</p>
                    </div>
                @endforelse
            </div>

            {{-- DIBATALKAN --}}
            <div id="tab-dibatalkan" class="tab-panel animate-fadeIn {{ ($activeTab ?? '') != 'dibatalkan' ? 'hidden' : '' }}">
                @forelse ($orders['dibatalkan'] ?? [] as $order)
                    @include('components.order-card', ['order' => $order])
                @empty
                    <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                        <p class="text-gray-400 font-medium">Tidak ada pesanan yang dibatalkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>

<x-footer />

<style>
    /* Tab Active State */
    .tab-btn.active {
        background-color: #ef4444; /* red-500 */
        color: white;
        box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.2);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }

    /* Custom Scrollbar for Mobile Tabs */
    .custom-scrollbar::-webkit-scrollbar { height: 0px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');

    function activate(tabBtn) {
        // reset tab
        tabs.forEach(b => {
            b.classList.remove('active', 'text-white');
            b.classList.add('text-gray-500');
        });

        // reset panel
        panels.forEach(p => p.classList.add('hidden'));

        // aktifkan tab
        tabBtn.classList.add('active', 'text-white');
        tabBtn.classList.remove('text-gray-500');

        // tampilkan panel sesuai data-tab
        const id = tabBtn.dataset.tab;
        document.getElementById(id)?.classList.remove('hidden');
    }

    tabs.forEach(btn => {
        btn.addEventListener('click', function () {
            activate(this);
        });
    });

    // Aktifkan tab yang sudah ditandai active oleh server
    const activeTab = document.querySelector('.tab-btn.active');
    if(activeTab) {
        activate(activeTab);
    } else if (tabs.length > 0) {
        activate(tabs[0]);
    }
});
</script>

<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const payBtns = document.querySelectorAll('.btn-pay-pending');
    payBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.dataset.orderId;
            const originalText = this.innerHTML;
            this.innerHTML = "Memproses...";
            this.disabled = true;

            fetch(`/orders/pay-pending/${orderId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    this.innerHTML = originalText;
                    this.disabled = false;
                    return;
                }
                
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function () {
                            window.location.href = `/orders/success/${orderId}`;
                        },
                        onPending: function () {
                            window.location.href = "?tab=belum-bayar";
                        },
                        onError: function () {
                            window.location.href = "?tab=dibatalkan";
                        },
                        onClose: function () {
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        }
                    });
                } else {
                    alert("Token pembayaran tidak valid.");
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(err => {
                alert("Terjadi kesalahan sistem: " + err);
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
});
</script>

@endsection
