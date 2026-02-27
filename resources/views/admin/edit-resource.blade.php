<x-layout>
    <div class="w-full min-h-full flex flex-col items-center" >
        <x-filters-panel />

        <x-form formLabel="You are editing {{ ucfirst($controller) }}." action="{{ route('admin.callControllerMethodForPatch', ['controller' => $controller, 'method' => 'patch', 'id' => data_get($resource, 'id') ]) }}">
            @csrf()
            @method('PATCH')

            @foreach ($columns as $column)
                <div class="flex flex-col w-full mb-4">
                    <x-input label="{{ ucfirst(str_replace('_', ' ', $column)) }}" name="{{ $column }}" value="{{ data_get($resource, $column) }}" />
                </div>
            @endforeach

            <x-button innerHtml="Update" />
        </x-form>
    </div>
</x-layout>
