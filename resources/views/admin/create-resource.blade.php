<x-layout>
    <div class="w-full min-h-full flex flex-col items-center" >
        <x-filters-panel />


        <x-form formLabel="You are creating new {{ ucfirst($controller) }}." action="{{ route('admin.callControllerMethodForPost', ['controller' => $controller, 'method' => 'store']) }}">
            @csrf()
            @method('POST')

            @foreach ($columns as $column)
                <div class="flex flex-col w-full mb-4">
                    <x-input label="{{ ucfirst(str_replace('_', ' ', $column)) }}" name="{{ $column }}" />
                </div>
            @endforeach

            <x-button innerHtml="Create" />
    </x-form>

    </div>
</x-layout>
