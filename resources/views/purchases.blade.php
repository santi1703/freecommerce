<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ucfirst(__('app.purchases')) }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl overflow-hidden bg-gradient-to-b from-blue-200 to-blue-100 p-10 my-3">
                <div class="text-center text-black text-5xl text-bold mb-5">
                    {{ ucfirst(__('app.purchases')) }}
                </div>
                <div id="accordion-collapse" data-accordion="collapse">
                    @forelse($purchases as $purchase)
                        <h2 id="accordion-collapse-heading-{{ $loop->iteration }}">
                            <button type="button"
                                    class="{{ $loop->first?'rounded-t-xl':'' }} {{ $loop->last?'rounded-b-xl':'' }} flex items-center bg-blue-100 justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-300 dark:hover:bg-gray-800 gap-3"
                                    data-accordion-target="#accordion-collapse-body-{{ $loop->iteration }}"
                                    aria-expanded="false"
                                    aria-controls="accordion-collapse-body-{{ $loop->iteration }}">
                                <span>{{ __('app.purchase.committed_on', ['date' => $purchase->created_at->format('d/m/Y H:i')]) }}</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-{{ $loop->iteration }}" class="hidden"
                             aria-labelledby="accordion-collapse-heading-{{ $loop->iteration }}">
                            <div
                                class="p-5 border border-b-0 bg-blue-100 border-gray-200 dark:border-gray-700 dark:bg-gray-900">

                                <table class="table-auto w-full">
                                    <thead>
                                    <tr>
                                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.title')) }}</th>
                                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.category')) }}</th>
                                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.price')) }}</th>
                                        <th class="border border-black px-4 py-2 text-black">{{ ucfirst(__('app.product.quantity')) }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($purchase->products as $product)
                                        <tr>
                                            <td class="border border-black px-4 py-2 text-black font-medium">{{ $product->id }} {{ $product->title }}</td>
                                            <td class="border border-black px-4 py-2 text-black font-medium">{{ $product->category->name }}</td>
                                            <td class="border border-black px-4 py-2 text-black font-medium">{{ $product->display_price }}</td>
                                            <td class="border border-black px-4 py-2 text-black font-medium">{{ $product->pivot->quantity }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4"
                                            class="text-center border border-black px-4 py-2 text-black font-medium">
                                            Total: ${{ $purchase->total }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div>
                            <p class="text-2xl">
                                {{ ucfirst(__('app.purchase.empty')) }}
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
