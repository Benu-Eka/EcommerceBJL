
<a href="#" class="flex flex-col items-center p-3 rounded-lg border {{ $active ? 'border-green-500 shadow-md' : 'border-gray-200 hover:shadow-lg' }} transition duration-300 min-w-[100px] w-full">
    <div class="w-12 h-12 mb-2">
        <img src="{{ asset('images/icons/' . $image) }}" alt="{{ $title }}" class="w-full h-full object-contain">
    </div>
    <span class="text-xs text-center font-medium {{ $active ? 'text-green-600' : 'text-gray-700' }}">{{ $title }}</span>
</a>