@php
    $modifiedName = str_replace(' ', '', $user->first_name);
    $displayedName = strlen($modifiedName) > 9 ? substr($modifiedName, 0, 9) . '...' : $modifiedName;
@endphp
<a href="{{ route('profile') }}" class=" btn btn-sm btn-dark">
    <span id="user-name">{{ $displayedName }}</span> <i class="fa-solid fa-user-gear"></i>
</a>
