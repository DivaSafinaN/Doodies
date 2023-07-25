@extends('index')
@section('title', 'Manage Users')
@section('content')
<table class="table mx-2">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone Number</th>
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
        <td>{{ $u->phone_number }}</td>
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
            <button type="submit" id="manage-delete" class="btn btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="d-flex justify-content-center">
    {{ $user->links() }}
  </div>


@endsection

@section('javascript')
<script>
  $(document).on('click','#manage-delete', function(e){
    e.preventDefault();
    var form = $(this).closest('form');

    Swal.fire({
      title: 'Are you sure?',
      text: "Data will be deleted permanently.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete it.'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    })
  })

  @if (session()->has('message'))
    Swal.fire(
      'Success!',
      'User has been deleted.',
      'success'
    )
  @endif
</script>
@endsection