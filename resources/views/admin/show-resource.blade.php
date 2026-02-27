<x-layout>
    <div class="w-full min-h-full flex flex-col items-center" >
        <x-filters-panel />

        @foreach ($columns as $column)
            <div>
                {{ ucfirst(str_replace('_', ' ', $column)) }} : {{ data_get($resource, $column) }}
            </div>
        @endforeach


        <a href="{{ route('admin.callControllerMethod', ['controller' => $controller, 'method' => 'index']) }}" class="p-2 rounded-md shadow-md text-white bg-blue-700">
            Back
        </a>

        <a href="{{ route('admin.callControllerMethod', ['controller' => $controller, 'method' => 'delete', 'id' => $resource->id]) }}" class="p-2 rounded-md shadow-md text-white bg-red-700">
            Delete
        </a>

        <a href="{{ route('admin.callControllerMethod', ['controller' => $controller, 'method' => 'edit', 'id' => $resource->id]) }}" class="p-2 rounded-md shadow-md text-white bg-purple-700">
            Edit
        </a>
    </div>
</x-layout>
