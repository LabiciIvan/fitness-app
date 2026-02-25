<x-layout>
    <div class="w-full min-h-full flex items-center justify-center">
        <x-form action="/login" formLabel="Log in your account">
            @csrf
            @method('POST')
            <x-input name="email" label="Email"/>
            <x-input type="password" name="password" label="Password"/>
            <x-button class="" innerHtml="Sign in" />
        </x-form>
    </div>
</x-layout>