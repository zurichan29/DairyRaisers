<form action="{{ route('test.send') }}" method="POST">
@csrf
<input type="text" name="name">
<button type="submit">submit</button>
</form>