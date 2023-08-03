@extends('layouts.polos')

@section('content')
    <div class="container">
        <h1>List of Disabled Users</h1>
        @if ($disabledUsers->isEmpty())
            <p>No disabled users found.</p>
        @else
            <ul>
                @foreach ($disabledUsers as $user)
                    <li>
                        {{ $user->name }} ({{ $user->email }})
                        <form action="{{ route('user.reactivate', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit">Reactivate</button>
                        </form>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to permanently delete this user?')">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
