@extends('index')
@section('title',  $taskGroup->name )
@section('css')
<style>
</style>
@endsection
@section('content')
<div class="taskgroup-wrap d-flex">
    <form action="{{ route('task_groups.update', $taskGroup) }}" method="post">
        @method('PUT')
        @csrf
        <div class="wrapper d-flex mx-3">
            <div class="input-data">
                    <input type="text" name="name" id="" value="{{ $taskGroup->name }}" class="input-title">
                    <div class="underline"></div>
            </div>
            <button type="submit" class="btn btn-dark save" style="align-self: flex-end">Save</button>
        </div>
    </form>
    
    <form action="{{ route('task_groups.destroy', $taskGroup) }}" method="POST">
        @csrf
        @method('Delete')
        <button class="btn btn-danger delete" type="submit" onclick="return confirm('Are you sure?')">
            {{ __('Delete') }}
        </button>
    </form>
</div>

<div class="container-fluid mt-3">
    <div class="col-md-10">
      <div class="card-hover-shadow-2x mb-3 card">
        <div class="scroll-area-sm">
          <perfect-scrollbar class="ps-show-limits">
            <div style="position: static;" class="ps ps--active-y">
              <div class="ps-content">
                @php
                $incompleteTasks = $taskGroup->tasks()->where('completed', false)->get();
                @endphp
                
                <table class="table">
                  <tbody>
                    @foreach ($incompleteTasks->sortBy([['due_date','asc']]) as $t)
                    <tr data-priority="{{ $t->priority_id }}">
                      <div style="display: flex; align-items: center">
                        <td style="width: 3%;"><i class='bx bx-move move'></i></td>
                      </div>
                      <td style="width: 5%;">
                        <div style="display: flex; align-items: center">
                          <i class='bx bx-circle checkcol
                          @if($t->priority_id == 4)
                              high
                          @elseif($t->priority_id == 3)
                              medium
                          @elseif($t->priority_id == 2)
                              low
                          @else
                              none
                          @endif' 
                          onclick="event.preventDefault(); document.getElementById('form-complete-{{ $t->id }}').submit()"
                            style="font-size: 20px;"></i>
                          <form action="{{ route('task_groups.tasks.complete', [$taskGroup, $t]) }}" id="{{ 'form-complete-'.$t->id }}" 
                            method="POST" style="display: none">
                            @csrf
                            @method('put')
                          </form>
                        </div>
                      </td>
                      <td style="width: 68%;">
                        <span>{{ $t->name }} </span> <br>
                        @if($t->add_to_myday)
                        <i class='bx bx-sun' style="color: darkblue;font-size: 12px"></i>
                        <span style="font-size: 12px">My Day</span>
                        @endif
                      </td>
                      <td style="text-align: end; width: 30px">
                        @if($t->notes)
                        <i class='bx bx-note'style="color: lightgray"></i>
                        @endif
                      </td>
                      <td style="padding-top: 10px;">
                        <div class="duedate">
                          @if ($t->due_date)
                          <span>{{ \Carbon\Carbon::parse($t->due_date)->format('d M')}}</span>
                          @endif
                        </div>
                      </td>
                      <td style="width: 5%; text-align: end;">
                        <button onclick="edit({{ $t->id }})"><i class='bx bx-edit'></i></button>
                      </td>
                      <td style="width: 5%; text-align: center;">
                        <div class="dropdown">
                          <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                          <i class='bx bx-dots-vertical-rounded'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon" style="width: 200px">
                            <li class="drop-custom">
                              <form action="{{ route('task_groups.tasks.destroy', [$taskGroup, $t]) }}" method="POST">
                                @csrf
                                @method('Delete')
                                <button type="submit" onclick="return confirm('Are you sure?')" style="border: none; background:none" class="ms-2">
                                  <i class='bx bx-trash' style="text-align: center"></i>
                                    <span class="ms-1">Delete</span>
                                </button>
                                </form>
                            </li>
                            <li class="drop-custom mt-1">
                              @if($t->add_to_myday)
                              <button style="color: #dc3545"
                                onclick="event.preventDefault(); document.getElementById('remove-fr-md-{{ $t->id }}').submit()">
                                <i class='bx bx-x ms-2'></i>
                                <span class="ms-1">Added to My Day</span>
                              </button>
                              <form action="{{ route('task_groups.tasks.removefrmyday',[$taskGroup, $t]) }}" id="{{ 'remove-fr-md-'.$t->id }}" 
                                method="POST" style="display: none">
                                @csrf
                                @method('delete')
                              </form>
                              @else
                              <button onclick="event.preventDefault(); document.getElementById('add-to-md-{{ $t->id }}').submit()">
                                <i class='bx bx-sun ms-2' style="text-align: center"></i>
                                <span class="ms-1">Add to My Day</span>
                              </button>
                              <form action="{{ route('task_groups.tasks.addtomyday',[$taskGroup, $t]) }}" id="{{ 'add-to-md-'.$t->id }}" 
                                method="POST" style="display: none">
                                @csrf
                                @method('put')
                              </form>
                              @endif
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

        <div class="d-block text-right card-footer">
          <form action="{{ route('task_groups.tasks.store',$taskGroup) }}" method="post" class="row g-3">
            @csrf
            <div class="col">
            <input type="text" class="form-control input" placeholder="ex: Homework" name="name" >
            </div>
            <div class="col-auto">
            <button type="submit" class="btn btn-dark">Add Task</button>
            </div>
        </form>
        </div>

      </div>
    </div>

</div>
<!-- Modal -->
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
var input = document.querySelector('.input-title'); // get the input element
input.addEventListener('input', resizeInput); // bind the "resizeInput" callback on "input" event
resizeInput.call(input); // immediately call the function

function resizeInput() {
  this.style.width = this.value.length + "ch";
}

function edit(id){
  $.get('/task_groups/{{ $taskGroup->id }}/tasks/' + id + '/edit' ,function(data){
    $("#exampleModalLabel").html('Edit Task');
    $("#page").html(data);
    $("#exampleModal").modal('show');
  });
}


$(document).ready(function() {
    // Group tasks by priority
    var tasksByPriority = {};
    $('table tbody tr').each(function() {
      var priorityId = $(this).data('priority');
      var completed = $(this).find('.checkcol').hasClass('completed');
      var task = $(this).get(0);
      if (!tasksByPriority[priorityId]) {
        tasksByPriority[priorityId] = [];
      }
      tasksByPriority[priorityId].push(this);
    });

    // Append tasks to table in priority order
    var priorities = [4, 3, 2, null];
    priorities.forEach(function(priorityId) {
      if (tasksByPriority[priorityId]) {
        $('table tbody').append($('<tr>').addClass('priority-group').append($('<td>').attr('colspan', 6).append($('<span>').
          addClass('badge bg-' + getPriorityColor(priorityId)).text(getPriorityName(priorityId)))));
        tasksByPriority[priorityId].forEach(function(row) {
          $('table tbody').append(row);
        });
      }
    });

    function getPriorityName(priorityId) {
      switch (priorityId) {
        default:
          return 'No Priority';
        case 2:
          return 'Low Priority';
        case 3:
          return 'Medium Priority';
        case 4:
          return 'High Priority';
      }
    }

    function getPriorityColor(priorityId) {
      switch (priorityId) {
        default:
          return 'light text-dark';
        case 2:
          return 'primary';
        case 3:
          return 'warning';
        case 4:
          return 'danger';
      }
    }
  });

</script>
@endsection