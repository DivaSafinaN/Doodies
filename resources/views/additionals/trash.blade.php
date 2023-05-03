@extends('index')
@section('title',  'Trash' )
@section('content')
<div class="container-fluid" style="text-align: center">
    <span class="text">Trash</span> <br>
    <span style="font-size: 17px">Tasks will be deleted permanently after 3 days.</span>
</div>
<div class="container-fluid mt-3" style="display: flex; justify-content: center">
    <div class="col-md-10">
      <div class="card-hover-shadow-2x mb-3 card">
        <div class="scroll-area-sm">
          <perfect-scrollbar class="ps-show-limits">
            <div style="position: static;" class="ps ps--active-y">
              <div class="ps-content">
                <table class="table">
                    <tbody>
                      @foreach($taskGroups as $taskGroup)
                      @foreach($taskGroup->tasks->sortBy([['deleted_at','desc']]) as $t)
                      @if ($t->deleted_at)
                      <tr>
                        <div style="display: flex; align-items: center">
                          <td style="width: 3%;"><i class='bx bx-move move'></i></td>
                      </div>
                      <td style="width: 5%;">
                        <i class='bx bxs-check-circle checkcol' style="font-size: 20px"></i>
                      </td>
                      <td style="width: 68%;">
                        <span class="text-muted">{{ $t->name }}</span>
                      </td>
                      <td style="width: 5%; text-align: center;">
                        <div class="dropdown">
                          <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                          <i class='bx bx-dots-vertical-rounded'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                            <li class="drop-custom">
                              <form action="{{ route('task_groups.tasks.restore', [$taskGroup, $t]) }}" method="POST">
                                @csrf
                                @method('put')
                                <button type="submit" style="border: none; background:none" class="ms-2">
                                  <i class='bx bx-redo' style="text-align: center"></i>
                                    <span class="ms-2">Restore</span>
                                </button>
                                </form>
                            </li>
                            <li class="drop-custom">
                              <form action="{{ route('task_groups.tasks.delete', [$taskGroup, $t]) }}" method="POST" onsubmit="return submitForm(this)">
                                @csrf
                                @method('delete')
                                <button type="submit" style="border: none; background:none" class="ms-2" id="trash-btn">
                                  <i class='bx bx-trash' style="text-align: center; color: red"></i>
                                    <span class="ms-2 text-danger">Delete</span>
                                </button>
                                </form>
                            </li>
                            
                          </ul>
                        </div>
                      </td>
                      </tr>
                      @endif
                      @endforeach
                        @endforeach
                    </tbody>

                    <tbody>
                      @foreach($myDayTasks->sortBy([['deleted_at','desc']]) as $ct)
                      <tr>
                      <div style="display: flex; align-items: center">
                        <td style="width: 3%;"><i class='bx bx-move move'></i></td>
                      </div>
                      <td style="width: 5%;">
                        <i class='bx bxs-check-circle checkcol' style="font-size: 20px"></i>
                      </td>
                      <td style="width: 68%;">
                        <span class="text-muted">{{ $ct->name }}</span>
                      </td>
                      <td style="width: 5%; text-align: center;">
                        <div class="dropdown">
                          <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                          <i class='bx bx-dots-vertical-rounded'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                            <li class="drop-custom">
                              <form action="{{ route('my_day.restore', $ct) }}" method="POST">
                                @csrf
                                @method('put')
                                <button type="submit" style="border: none; background:none" class="ms-2">
                                  <i class='bx bx-redo' style="text-align: end"></i>
                                    <span class="ms-2">Restore</span>
                                </button>
                                </form>
                            </li>
                            <li class="drop-custom">
                              <form action="{{ route('my_day.delete', $ct) }}" method="POST" onsubmit="return submitForm(this)">
                                @csrf
                                @method('Delete')
                                <button type="submit" style="border: none; background:none" class="ms-2" id="trash-btn">
                                  <i class='bx bx-trash' style="text-align: end; color: #dc3545"></i>
                                    <span class="ms-2 text-danger">Delete</span>
                                </button>
                                </form>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                      @endforeach
                    </tbody>
                </table>

              </div>
            </div>
          </perfect-scrollbar>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="page"></div>
        </div>
      </div>
    </div>
  </div>
  

@endsection

@section('javascript')
<script>
  function submitForm(form){
      Swal.fire({
        title: 'Are you sure?',
        text: "Task will be deleted permanently.",
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
      return false;
    }
    // )
  // }

  @if(isset($taskGroup))
    function edit(id){
      $.get('/task_groups/{{ $taskGroup->id }}/tasks/' + id + '/edit' ,function(data){
        $("#exampleModalLabel").html('Edit Task');
        $("#page").html(data);
        $("#exampleModal").modal('show');
      });
    }
  @endif
function editMD(id){
  $.get('/my_day/' + id + '/edit' ,function(data){
    $("#exampleModalLabel").html('Edit Task');
    $("#page").html(data);
    $("#exampleModal").modal('show');
  });
}
</script>
@endsection