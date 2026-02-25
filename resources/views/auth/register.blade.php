<x-layout>
    <div class="w-full flex flex-col items-center justify-center">
        <x-form action="/register" formLabel="Create account">
            @csrf
            @method('POST')
            <x-input name="name" label="Name"/>
            <x-input name="email" label="Email"/>
            <x-select-input name="type" label="Are you a trainer ?" :options="config('tables.types.title')"/>
            <x-input type="password" name="password" label="Password"/>
            <x-input type="password" name="password_confirmation" label="Password confirmation"/>
            <x-button class="" innerHtml="Sign up" />
        </x-form>
    </div>

</x-layout>