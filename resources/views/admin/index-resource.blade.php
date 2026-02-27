<x-layout>
    <div class="w-full min-h-full flex flex-col items-center" >
        <x-filters-panel />

        @if ($resource->count())
            <div class="overflow-x-auto w-full max-w-6xl h-screen">
                <table class="min-w-full border border-gray-200 bg-white">
                    <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        <tr>
                            @foreach ($columns as $column)
                                <th class="px-4 py-3 border-b">
                                    {{ ucfirst(str_replace('_', ' ', $column)) }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3 border-b text-right w-12"></th>
                        </tr>
                    </thead>

                    <tbody class="text-sm text-gray-700">
                        @foreach ($resource as $model)
                                <tr class="hover:bg-gray-50">
                                    @foreach ($columns as $column)
                                        <td class="px-4 py-3 border-b">
                                            <a href="{{route('admin.callControllerMethod', ['controller' => $controller, 'method' => 'show', 'id' => $model->id]) }}">
                                                {{ data_get($model, $column) }}
                                            </a>
                                        </td>
                                    @endforeach

                                    <td class="px-4 py-3 border-b text-right relative">
                                        <button
                                            onclick="toggleDropdown(this)"
                                            class="text-gray-500 hover:text-gray-800 focus:outline-none"
                                        >
                                            +
                                        </button>

                                        <div class="hidden absolute right-2 mt-2 w-32 bg-white border rounded-md shadow-lg z-10">
                                            <button
                                                class="w-full text-left px-4 py-2 text-blue-600 hover:bg-blue-50"
                                            >
                                                ✏ Edit
                                            </button>

                                            <button
                                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50"
                                            >
                                                🗑 Delete
                                            </button>

                                            <button
                                                class="w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-100"
                                            >
                                                👁 View
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No records found.</p>
        @endif

        {{-- PAGINATION --}}
        @if ($resource instanceof \Illuminate\Contracts\Pagination\Paginator && $resource->hasPages())
            <div class="mt-6">
                {{ $resource->links() }}
            </div>
        @endif

        <script>
            function toggleDropdown(button) {
                const dropdown = button.nextElementSibling;

                document.querySelectorAll('.absolute.bg-white').forEach(el => {
                    if (el !== dropdown) el.classList.add('hidden');
                });

                dropdown.classList.toggle('hidden');
            }

            document.addEventListener('click', function (e) {
                if (!e.target.closest('td')) {
                    document.querySelectorAll('.absolute.bg-white')
                        .forEach(el => el.classList.add('hidden'));
                }
            });
        </script>
    </div>

</x-layout>
