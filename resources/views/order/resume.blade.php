<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="max-w-xs rounded overflow-hidden shadow-lg my-2">
                <img class="w-full" src="{{ $product->photo }}" alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ $product->name }}</div>
                </div>
                <div class="px-6 py-4">
                    <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">Precio: $ {{ $product->price }}</span>
                    <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">Datos cliente: {{ $order->customer_name }} - {{ $order->customer_email }} - {{ $order->customer_mobile }}</span>
                    <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">Cantidad: {{ $order->quantity }}</span>
                    <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">Total: {{ number_format($order->total_order) }}</span>
                    <a class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                       href="{{ route('order.create', ['product' => $product->id]) }}">
                        Pagar
                    </a>
                </div>
            </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />


        <br>
        <br>
        <br>
    </div>
</x-guest-layout>
