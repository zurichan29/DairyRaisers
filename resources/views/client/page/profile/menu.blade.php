<x-layout>
    @include('client.components.header')

    <p>{{ $user->mobile_number }}</p>
    <form action="{{ route('edit.name') }}" method="POST">
        @csrf
        <input type="text" name="first_name" value="{{ $user->first_name }}" placeholder="name">
        <input type="text" name="last_name" value="{{ $user->last_name }}" placeholder="name">
        <button type="submit">change</button>
    </form>
    @if ($user->email)
        <p>{{ $user->email }}</p>
        @if ($user->email_verified_at)
            <p>VERIFIED</p>
        @else
            <P>not yet verified</P>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ URL::secure(route('email.resend')) }}">
                @csrf
                <button type="submit">SEND CODE AGAIN</button>
            </form>
        @endif
    @else
        <form action="{{ URL::secure(route('email.create')) }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="add email">
            <button type="submit" name="submit">create</button>
        </form>

    @endif


    <a href="{{ route('profile.address') }}">go to address</a>
    <a href="{{ url()->previous() }}">go back</a>


    @include('client.components.footer')
</x-layout>
