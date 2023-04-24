@extends('index')
@section('title', 'Manage Users')
@section('content')
<table class="table mx-2">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Last Seen</th>
        <th scope="col">Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        @foreach($user as $u)
      <tr>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->last_seen }}</td>
        <td>
            @if(Cache::has('user-is-online-' . $u->id))
                <span class="text-success">Online</span>
            @else
                <span class="text-secondary">Offline</span>
            @endif
        </td>
        <td>
          <form action="{{ route('admin.delete-user', $u) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>


@endsection