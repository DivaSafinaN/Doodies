@extends('index')
@section('title', 'Search Results')
@section('content')
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

  .table tbody td .my-day-link{
    text-decoration: none;
    color: black;
  }
  .table tbody td .my-day-link:hover{
    text-decoration: underline;
  }
</style>
@endsection
<div class="container-fluid" style="text-align: center">
    <h5>Search Results for "{{ $q }}"</h5>
</div>


<div class="container-fluid mt-3" style="display: flex; justify-content: center">
    <div class="col-md-10">
      <div class="card-hover-shadow-2x mb-3 card">
        <div class="scroll-area-sm">
          <perfect-scrollbar class="ps-show-limits">
            <div style="position: static;" class="ps ps--active-y">
              <div class="ps-content">
                <table class="table" id="my-day-table">
                <tbody>
                    @if(count($tasks))
                    @foreach($tasks as $t)
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
                            <form action="{{ route('tasks.complete', $t) }}" id="{{ 'form-complete-'.$t->id }}" 
                            method="POST" style="display: none">
                            @csrf
                            @method('put')
                            </form>
                        </div>
                        </td>
                        <td style="width: 65%">
                        <span>{{ $t->task_name }}</span> <br>
                        <span style="font-size: 12px">
                            @if ($t->taskGroup)
                                <i><a href="{{ route('task_groups.edit', $t->taskGroup->id) }}" class="group-id">
                                    {{ $t->taskGroup->name }}
                                </a></i>
                            @else
                                <a href="/tasks" class="my-day-link">
                                    <i class='bx bx-sun' style="color: darkblue;font-size: 12px"></i>
                                    <span style="font-size: 12px">My Day</span>
                                </a>
                            @endif
                        </span>
                        </td>
                        <td style="text-align: end; width: 30px">
                        @if($t->file)
                        <i class='bx bx-link-alt'style="color: lightgray"></i>
                        @endif
                        </td>
                    <td style="text-align: end; width: 30px">
                        @if($t->notes)
                        <i class='bx bx-note' style="color: lightgray"></i>
                        @endif
                        </td>
                    <td style="text-align: end; width: 30px">
                        @if($t->reminder)
                        <i class='bx bx-alarm' style="color: lightgray"></i>
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
                        <button class="editbtn" onclick="edit({{ $t->id }})"><i class='bx bx-edit'></i></button>
                        </td>
                    <td style="width: 5%; text-align: center;">
                        <div class="dropdown">
                            <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                            <i class='bx bx-dots-vertical-rounded'></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon" style="width: 200px">
                            <li class="drop-custom">
                                <form action="{{ route('tasks.destroy', $t) }}" method="POST">
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
                                <form action="{{ route('tasks.removefrmyday',$t) }}" id="{{ 'remove-fr-md-'.$t->id }}" 
                                method="POST" style="display: none">
                                @csrf
                                @method('delete')
                                </form>
                                @else
                                <button onclick="event.preventDefault(); document.getElementById('add-to-md-{{ $t->id }}').submit()">
                                <i class='bx bx-sun ms-2' style="text-align: center"></i>
                                <span class="ms-1">Add to My Day</span>
                                </button>
                                <form action="{{ route('tasks.addtomyday',$t) }}" id="{{ 'add-to-md-'.$t->id }}" 
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
                @endif
                </table>
              </div>
            </div>
          </perfect-scrollbar>
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
</script>
@endsection