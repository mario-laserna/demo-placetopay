<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="table-auto border-solid">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total Orden</th>
                            <th>Status</th>
                            <th>Created at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="border border-solid">{{ $order->customer_name }}</td>
                                <td class="border border-solid">{{ $order->customer_email }}</td>
                                <td class="border border-solid">{{ $order->customer_mobile }}</td>
                                <td class="border border-solid">{{ $order->product->name }}</td>
                                <td class="border border-solid">{{ $order->quantity }}</td>
                                <td class="border border-solid">${{ number_format($order->total_order) }}</td>
                                <td class="border border-solid">{{ $order->status }}</td>
                                <td class="border border-solid">{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="p-6 bg-white border-b border-gray-200">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
