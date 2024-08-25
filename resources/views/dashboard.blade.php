<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ucfirst(__('app.products')) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl overflow-hidden bg-gradient-to-b from-blue-200 to-blue-100 p-10 my-3">
                <div class="text-center text-black text-5xl text-bold mb-5">
                    {{ ucfirst(__('app.products')) }}
                </div>
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.title')) }}</th>
                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.category')) }}</th>
                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.description')) }}</th>
                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.price')) }}</th>
                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.actions')) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="border border-black px-4 py-2 text-black font-medium">{{ $product->title }}</td>
                            <td class="border border-black px-4 py-2 text-black font-medium">{{ $product->category->name }}</td>
                            <td class="border border-black px-4 py-2 text-black font-medium">{{ $product->description }}</td>
                            <td class="border border-black px-4 py-2 text-black font-medium">{{ $product->display_price }}</td>
                            <td class="border border-black px-4 py-2 text-black font-medium">
                                <a id="submit-{{$product->id}}"
                                   class="inline-flex bg-blue-300 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                   href="{{ route('chart.push', ['id' => $product->id]) }}">
                                    {{ ucfirst(__('app.add_to_chart')) }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
