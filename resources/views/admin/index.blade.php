<x-layout>
    <h1>Hello {{ auth()->user()->first_name }}</h1>
    <a href="{{ route('logout') }}">logout</a>
    <ul>
        <a href="{{ route('admin.products.index') }}"><li>Products</li></a>
        <a href="{{ route('index') }}"><li>Order</li></a>
        <a href="{{ route('index') }}"><li>Buffalo</li></a>
    </ul>
</x-layout>