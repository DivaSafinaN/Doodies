@extends('index')
@section('title',  $taskGroup->name )
@section('css')
<style>
  .table tbody td .my-day-link{
    text-decoration: none;
    color: black;
  }
  .table tbody td .my-day-link:hover{
    text-decoration: underline;
  }
  .badge.custom-danger{
    background: #f3cccf;
    color: #cd2131;
    font-weight: 500;
  }
  .badge.custom-warning{
    background: #ffecb4;
    color: #997304;
    font-weight: 500;
  }
  .badge.custom-primary{
    background: #b2d7ff;
    color: #0062cc;
    font-weight: 500;
  }
  .badge.custom-none{
    background: #e5e5e5;
    color: #555555;
    font-weight: 500;
  }
</style>
@endsection
@section('content')
<div class="taskgroup-wrap d-flex justify-content-center">
    <form action="{{ route('task_groups.update', $taskGroup) }}" method="post">
        @method('PUT')
        @csrf
        <div class="wrapper d-flex mx-3">
            <div class="input-data">
                    <input type="text" name="name" id="" value="{{ $taskGroup->name }}" class="input-title">
                    <div class="underline"></div>
            </div>
            <button type="submit" class="btn text-dark btn-dark save" style="align-self: flex-end">Save</button>
        </div>
    </form>
    
    <form action="{{ route('task_groups.destroy', $taskGroup) }}" method="POST" onsubmit="return list(this)">
        @csrf
        @method('Delete')
        <button class="btn btn-danger delete" type="submit">
            {{ __('Delete') }}
        </button>
    </form>
</div>

<div class="container-fluid mt-3 d-flex justify-content-center">
    <div class="col-md-10">

      <div class="card-hover-shadow-2x mb-3 card">
        <div class="scroll-area-sm">
          @php
            $taskDisplayed = false;
          @endphp

          <perfect-scrollbar class="ps-show-limits">
            <div style="position: static;" class="ps ps--active-y">
              <div class="ps-content">
                @php
                $incompleteTasks = $taskGroup->tasks()->where('completed', false)->get();
                @endphp
                
                <table class="table" id="group">
                  <tbody>
                    @foreach ($incompleteTasks->sortBy([['due_date','asc']]) as $t)
                    <tr data-priority="{{ $t->priority_id }}" style="height: 60px">
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
                          <form action="{{ route('tasks.complete', $t) }}" id="{{ 'form-complete-'.$t->id }}" 
                            method="POST" style="display: none">
                            @csrf
                            @method('put')
                          </form>
                        </div>
                      </td>
                      <td style="width: 62%;">
                        <span>{{ $t->name }} </span> <br>
                        @if($t->add_to_myday)
                        <a href="/tasks" class="my-day-link">
                        <i class='bx bx-sun' style="color: darkblue;font-size: 12px"></i>
                        <span style="font-size: 12px">My Day</span>
                        </a>
                        @endif
                      </td>
                      <td style="text-align: end; ">
                        @if($t->file)
                        <i class='bx bx-link-alt'style="color: #4c004c;background: #e5cce5;
                        padding: 3px;border-radius: 7px;"></i>
                        @endif
                      </td>
                      <td style="text-align: end; ">
                        @if($t->notes)
                        <i class='bx bx-note'style="color: #66102f;background: #ffd4e3;
                        padding: 3px;border-radius: 7px;"></i>
                        @endif
                      </td>
                      <td style="text-align: end; ">
                        @if($t->reminder)
                        <i class='bx bx-alarm' style="color: #50002f;background: #f4cce3;
                        padding: 3px;border-radius: 7px;"></i>
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
                        <button class="editbtn" onclick="edit({{ $t->id }})" title="Edit Task"><i class='bx bx-edit'></i></button>
                      </td>
                      <td style="width: 5%; text-align: center;">
                        <div class="dropdown">
                          <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                          <i class='bx bx-dots-vertical-rounded'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon" style="width: 180px">
                            <li class="drop-custom">
                              <form action="{{ route('tasks.destroy', $t) }}" method="POST">
                                @csrf
                                @method('Delete')
                                <button type="submit" style="border: none; background:none;" class="ms-2">
                                  <i class='bx bx-trash' style="text-align: center"></i>
                                    <span class="ms-1">Delete</span>
                                </button>
                                </form>
                            </li>
                            <li class="drop-custom mt-1">
                              @if($t->add_to_myday)
                              <button style="color: #dc3545; background:none; border: none"
                                onclick="event.preventDefault(); document.getElementById('remove-fr-md-{{ $t->id }}').submit()">
                                <i class='bx bx-x ms-2'></i>
                                <span class="ms-1">Added to My Day</span>
                              </button>
                              <form action="{{ route('tasks.removefrmyday',$t) }}" id="{{ 'remove-fr-md-'.$t->id }}" 
                                method="POST" style="display: none">
                                @csrf
                                @method('delete')
                              </form>
                              @else
                              <button onclick="event.preventDefault(); document.getElementById('add-to-md-{{ $t->id }}').submit()"
                               style="border: none;background: none">
                                <i class='bx bx-sun ms-2' style="text-align: center;"></i>
                                <span class="ms-1">Add to My Day</span>
                              </button>
                              <form action="{{ route('tasks.addtomyday', $t) }}" id="{{ 'add-to-md-'.$t->id }}" 
                                method="POST" style="display: none">
                                @csrf
                                @method('put')
                              </form>
                              @endif
                            </li>


                          <li><hr class="dropdown-divider"></li>
                          <li class="my-2">
                            <span class="ms-3">Move task to: </span>
                          </li>
                          
                            @foreach($tGs as $tG)
                            <li class="drop-custom">
                              <button onclick="event.preventDefault(); document.getElementById('add-{{ $t->id }}-to-tg-{{ $tG->id }}').submit()"
                              style="border: none; background:none; width: 140px; display:flex" class="ms-2">
                                  <span class="ms-2" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                                    {{ $tG->name }}  
                                  </span>
                              </button>
                              <form id="{{ 'add-'.$t->id.'-to-tg-'.$tG->id }}" action="{{ route('tasks.to-taskgroup', $t) }}" method="POST" style="display: none;">
                                @csrf
                                @method('put')
                                <input type="hidden" name="task_group_id" value="{{ $tG->id }}">
                              </form>
                            </li>
                            @endforeach
              
                          </ul>
                        </div>
                      </td>
                    @php
                      $taskDisplayed = true;
                    @endphp
                    </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
              
            </div>
          </perfect-scrollbar>

          @if(!$taskDisplayed)
          <div class="scroll-area d-flex justify-content-center align-items-center flex-column mt-5">
            <img src="{{ asset("img/tasklist.png") }}" style="width:270px">
              <span style="text-align: center; font-size: 20px; color: #a8bbbf">
                A well-planned task list can be the key to <br>
                a productive and successful day. 
              </span>
              
          </div>
          @endif
        </div>

        <div class="d-block text-right card-footer">
          <form action="{{ route('tasks.store_inTG',$taskGroup) }}" method="post" class="row g-3">
            @csrf
            <div class="col">
            <input type="hidden" name="task_group_id" value="{{ $taskGroup->id }}">
            <input type="hidden" name="add_to_myday" value="0">
            <input type="text" class="form-control input" placeholder="ex: Homework" name="name" required autocomplete="name">
            </div>
            <div class="col-auto">
            <button type="submit" class="btn btn-dark">Add Task</button>
            </div>
        </form>
        </div>

      </div>
    </div>

</div>

@endsection

@section('javascript')
  <script>
  @if ($errors->has('TG_name'))
    Swal.fire('A task group with that name already exists.')
  @endif

  var input = document.querySelector('.input-title'); // get the input element
  input.addEventListener('input', resizeInput); // bind the "resizeInput" callback on "input" event
  resizeInput.call(input); // immediately call the function

  function resizeInput() {
    this.style.width = this.value.length + "ch";
  }

  function list(form){
    Swal.fire({
          title: 'Are you sure?',
          text: "All tasks will be deleted permanently.",
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

  function edit(id){
    $.get('/tasks/' + id + '/edit' ,function(data){
      $("#exampleModalLabel").html('Edit Task');
      $("#page").html(data);
      $("#exampleModal").modal('show');
    });
  }

    $(document).ready(function() {
      // Group tasks by priority
      var tasksByPriority = {};
      $('#group tbody tr').each(function() {
          var priorityId = $(this).data('priority');
          var task = $(this).get(0);
          if (!tasksByPriority[priorityId]) {
              tasksByPriority[priorityId] = [];
          }
          tasksByPriority[priorityId].push(this);
      });

      // Append tasks to table in priority order
      var priorities = [4, 3, 2, 1];
      priorities.forEach(function(priorityId) {
          if (tasksByPriority[priorityId]) {
              $('#group tbody').append($('<tr>').addClass('priority-group').append($('<td>').attr('colspan', 10).append($('<span>').
                  addClass('badge ' + getPriorityColor(priorityId)).text(getPriorityName(priorityId)))));
              tasksByPriority[priorityId].forEach(function(row) {
                  $('#group tbody').append(row);
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
            return 'custom-none';
          case 2:
            return 'custom-primary';
          case 3:
            return 'custom-warning';
          case 4:
            return 'custom-danger';
        }
      }
    });

  </script>
@endsection