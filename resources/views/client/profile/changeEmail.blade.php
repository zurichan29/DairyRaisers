<x-layout>
    @include('client.components.header')
    <form action="{{ URL::secure(route('email.change')) }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="add email">
        <button type="submit" name="submit">change</button>
    </form>
    @include('client.components.footer')
</x-layout>