@extends('index')
@section('title', 'My Day')
@section('css')
<style>
  .table tbody td .group-id{
    text-decoration: none;
    color: #395200;
    background: #e8f5cc;
    border-radius: 10px;
    padding: 0 12px;
  }
  .table tbody td .group-id:hover{
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
<div class="container-fluid" style="text-align: center">
  <span class="text">Hi, {{ Auth::user()->name }}</span>
</div>

<div class="container-fluid mt-3" style="display: flex; justify-content: center">
  <div class="col-md-10">
    <div class="card-hover-shadow-2x mb-3 card">
      <div class="scroll-area-sm">
        @php
            $taskDisplayed = false;
          @endphp

        <perfect-scrollbar class="ps-show-limits">
          <div style="position: static;" class="ps ps--active-y">
            <div class="ps-content">
              <table class="table" id="my-day-table">
                <tbody>
                  @foreach($tasks->sortBy([['due_date','asc']]) as $ts)
                  <tr data-priority="{{ $ts->priority_id }}" style="height: 60px">
                    <div style="display: flex; align-items: center;">
                      <td style="width: 3%; justify-content: center"><i class='bx bx-move move'></i></td>
                    </div>
                    <td style="width: 5%;">
                      <div style="display: flex; align-items: center">
                        <i class='bx bx-circle checkcol
                        @if($ts->priority_id == 4)
                            high
                        @elseif($ts->priority_id == 3)
                            medium
                        @elseif($ts->priority_id == 2)
                            low
                        @else
                            none
                        @endif' 
                        onclick="event.preventDefault(); document.getElementById('t-complete-{{ $ts->id }}').submit()"
                          style="font-size: 20px;"></i>
                        <form action="{{ route('tasks.complete', $ts) }}" id="{{ 't-complete-'.$ts->id }}" 
                          method="POST" style="display: none">
                          @csrf
                          @method('put')
                        </form>
                      </div>
                    </td>
                    <td style="width: 62%;">
                      <span>{{ $ts->task_name }}</span> <br>
                      @if ($ts->taskGroup)
                      <span style="font-size: 12px">
                        <i>
                          <a href="{{  route('task_groups.edit',$ts->taskGroup->id) }}" class="group-id">
                            {{ $ts->taskGroup->name }}
                          </a>
                        </i>
                      </span>
                      @endif
                    </td>
                    <td style="text-align: end; ">
                      @if($ts->file)
                      <i class='bx bx-link-alt'style="color: #4c004c;background: #e5cce5;
                      padding: 3px;border-radius: 7px;"></i>
                      @endif
                    </td>
                    <td style="text-align: end; ">
                      @if($ts->notes)
                      <i class='bx bx-note' style="color: #66102f;background: #ffd4e3;
                      padding: 3px;border-radius: 7px;"></i>
                      @endif
                    </td>
                    <td style="text-align: end; ">
                      @if($ts->reminder)
                      <i class='bx bx-alarm' style="color: #50002f;background: #f4cce3;
                      padding: 3px;border-radius: 7px;"></i>
                      @endif
                    </td>
                    <td style="padding-top: 10px;">
                      <div class="duedate">
                        @if ($ts->due_date)
                        <span>{{ \Carbon\Carbon::parse($ts->due_date)->format('d M')}}</span>
                        @endif
                      </div>
                    </td>
                    <td style="width: 5%; text-align: end;">
                      <button class="editbtn" onclick="edit({{ $ts->id }})" title="Edit Task"><i class='bx bx-edit'></i></button>
                    </td>
                    <td style="width: 5%; text-align: center;">
                      <div class="dropdown">
                        <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                        <i class='bx bx-dots-vertical-rounded'></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                          <li class="drop-custom">
                            <form action="{{ route('tasks.destroy', $ts) }}" method="POST">
                              @csrf
                              @method('Delete')
                              <button type="submit" style="border: none; background:none" class="ms-2">
                                <i class='bx bx-trash' style="text-align: center"></i>
                                  <span class="ms-2">Delete</span>
                              </button>
                              </form>
                          </li>
                          @if(!$taskGroups->isEmpty())
                          <li><hr class="dropdown-divider"></li>
                          <li class="my-2">
                            <span class="ms-3">Add task to: </span>
                          </li>
                          
                            @foreach($taskGroups as $taskGroup)
                            <li class="drop-custom">
                              <button onclick="event.preventDefault(); document.getElementById('add-{{ $ts->id }}-to-tg-{{ $taskGroup->id }}').submit()"
                              style="border: none; background:none; width: 140px; display:flex" class="ms-2">
                                  <span class="ms-2" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                                    {{ $taskGroup->name }}  
                                  </span>
                              </button>
                              <form id="{{ 'add-'.$ts->id.'-to-tg-'.$taskGroup->id }}" action="{{ route('tasks.to-taskgroup', $ts) }}" method="POST" style="display: none;">
                                @csrf
                                @method('put')
                                <input type="hidden" name="task_group_id" value="{{ $taskGroup->id }}">
                              </form>
                            </li>
                            @endforeach
              
                            @if($ts->task_group_id)
                            <li class="drop-custom">
                              <button style="color: #dc3545;border: none;background: none"
                              onclick="event.preventDefault(); document.getElementById('remove-{{ $ts->id }}-fr-{{ $taskGroup->id }}').submit()">
                                <i class='bx bx-x ms-2'></i>
                                <span class="ms-3">Remove </span>
                              </button>
                              <form action="{{ route('tasks.no-taskgroup', $ts) }}" id="{{ 'remove-'.$ts->id.'-fr-'.$taskGroup->id }}" 
                                method="POST" style="display: none">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="task_group_id" value="{{ $taskGroup->id }}">
                                <input type="hidden" name="id" value="{{ $ts->id }}">
                              </form>
                            </li>
                            @endif
                          @endif
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
            <img src="{{ asset("img/8264.jpg") }}" style="width:350px">
              <span style="text-align: center; font-size: 20px; color: #a8bbbf">
                Take control of your day by prioritizing your <br>
                tasks and staying focused. 
              </span>
              
          </div>
          @endif

      </div>
      <div class="d-block text-right card-footer">
        <form action="{{ route('tasks.store') }}" method="post" class="row g-3">
          @csrf
          <div class="col">
          <input type="text" class="form-control input" placeholder="ex: Homework" name="task_name" required autocomplete="task_name">
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
      $('#my-day-table tbody tr').each(function() {
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
              $('#my-day-table tbody').append($('<tr>').addClass('priority-group').append($('<td>').attr('colspan', 10).append($('<span>').
                  addClass('badge ' + getPriorityColor(priorityId)).text(getPriorityName(priorityId)))));
              tasksByPriority[priorityId].forEach(function(row) {
                  $('#my-day-table tbody').append(row);
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