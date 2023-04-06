@extends('index')
@section('title',  'Completed Task' )
@section('content')
<div class="container-fluid">
    <span class="text">Completed Tasks</span>
</div>
<div class="container-fluid mt-3">
    <div class="col-md-10">
      <div class="card-hover-shadow-2x mb-3 card">
        <div class="scroll-area-sm">
          <perfect-scrollbar class="ps-show-limits">
            <div style="position: static;" class="ps ps--active-y">
              <div class="ps-content">
                <table class="table">
                    <tbody>
                      @foreach($taskGroups as $taskGroup)
                      @foreach($taskGroup->tasks->where('completed', true) as $t)
                      <tr>
                        <div style="display: flex; align-items: center">
                          <td style="width: 3%;"><i class='bx bx-move move'></i></td>
                      </div>
                      <td style="width: 5%;">
                        <i class='bx bxs-check-circle checkcol'
                          onclick="event.preventDefault(); document.getElementById('form-incomplete-{{ $t->id }}').submit()"
                          style="font-size: 20px"></i>
                        <form action="{{ route('task_groups.tasks.incomplete', [$taskGroup, $t]) }}" id="{{ 'form-incomplete-'.$t->id }}" 
                          method="POST" style="display: none">
                          @csrf
                          @method('delete')
                        </form>
                      </td>
                      <td style="width: 68%;">
                        <span class="text-muted">{{ $t->name }}</span>
                      </td>
                      <td style="text-align: end; width: 30px">
                        @if($t->notes)
                        <i class='bx bx-note'style="color: lightgray"></i>
                        @endif
                      </td>
                      <td style="padding-top: 10px;">
                        <div class="duedate">
                          @if ($t->due_date)
                          <span class="text-muted">{{ \Carbon\Carbon::parse($t->due_date)->format('d M')}}</span>
                          @endif
                        </div>
                      </td>
                      <td style="width: 5%; text-align: end;">
                        <button onclick="edit({{ $t->id }})"><i class='bx bx-edit' style="color: lightgray"></i></button>
                      </td>
                      <td style="width: 5%; text-align: center;">
                        <div class="dropdown">
                          <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                          <i class='bx bx-dots-vertical-rounded'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                            <li class="drop-custom">
                              <form action="{{ route('task_groups.tasks.destroy', [$taskGroup, $t]) }}" method="POST">
                                @csrf
                                @method('Delete')
                                <button type="submit" onclick="return confirm('Are you sure?')" style="border: none; background:none" class="ms-2">
                                  <i class='bx bx-trash' style="text-align: center"></i>
                                    <span class="ms-2">Delete</span>
                                </button>
                                </form>
                            </li>
                          </ul>
                        </div>
                      </td>
                      </tr>
                      @endforeach
                        @endforeach
                    </tbody>

                    <tbody>
                      @foreach($myDayTasks as $ct)
                      <tr>
                      <div style="display: flex; align-items: center">
                        <td style="width: 3%;"><i class='bx bx-move move'></i></td>
                      </div>
                      <td style="width: 5%;">
                        <i class='bx bxs-check-circle checkcol' 
                          onclick="event.preventDefault(); document.getElementById('form-incomplete-{{ $ct->id }}').submit()"
                          style="font-size: 20px"></i>
                        <form action="{{ route('my_day.incomplete', $ct) }}" id="{{ 'form-incomplete-'.$ct->id }}" 
                          method="POST" style="display: none">
                          @csrf
                          @method('delete')
                        </form>
                      </td>
                      <td style="width: 68%;">
                        <span class="text-muted">{{ $ct->name }}</span>
                      </td>
                      <td style="text-align: end; width: 30px">
                        @if($ct->notes)
                        <i class='bx bx-note'style="color: lightgray"></i>
                        @endif
                      </td>
                      <td style="padding-top: 10px;">
                        <div class="duedate">
                          @if ($ct->due_date)
                          <span class="text-muted">{{ \Carbon\Carbon::parse($ct->due_date)->format('d M')}}</span>
                          @endif
                        </div>
                      </td>
                      <td style="width: 5%; text-align: end;">
                        <button onclick="editMD({{ $ct->id }})"><i class='bx bx-edit' style="color: lightgray"></i></button>
                      </td>
                      <td style="width: 5%; text-align: center;">
                        <div class="dropdown">
                          <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                          <i class='bx bx-dots-vertical-rounded'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                            <li class="drop-custom">
                              <form action="{{ route('my_day.destroy', $ct) }}" method="POST">
                                @csrf
                                @method('Delete')
                                <button type="submit" onclick="return confirm('Are you sure?')" style="border: none; background:none" class="ms-2">
                                  <i class='bx bx-trash' style="text-align: center"></i>
                                    <span class="ms-2">Delete</span>
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