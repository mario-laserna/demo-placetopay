<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        @forelse($products as $product)
        <div class="max-w-xs rounded overflow-hidden shadow-lg my-2">
            <img class="w-full" src="{{ $product->photo }}" alt="Sunset in the mountains">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">{{ $product->name }}</div>
                <p class="text-grey-darker text-base">
                    {{ $product->description }}
                </p>
            </div>
            <div class="px-6 py-4">
                <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">$ {{ number_format($product->price) }}</span>
            </div>
        </div>
        @empty
            There are not products to show
        @endforelse
    </div>
</x-guest-layout>
