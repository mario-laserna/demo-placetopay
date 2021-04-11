<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
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

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('order.store') }}">
        @csrf
            <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}" />
            <div>
                <label for="name" value="Nombre">Nombre</label>
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" maxlength="80" required autofocus />
            </div>
            <div>
                <label for="email">Email</label>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" maxlength="120" required />
            </div>
            <div>
                <label for="mobile">Teléfono</label>
                <x-input id="mobile" class="block mt-1 w-full" type="text" name="mobile" :value="old('mobile')" maxlength="40" required />
            </div>
            <div>
                <label for="quantity">Cantidad</label>
                <x-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" min="1" max="9" required />
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    Comprar
                </x-button>
            </div>
        </form>
        <br>
        <br>
        <br>
    </div>
</x-guest-layout>
