@extends('index')
@section('title', 'Search Results')
@section('content')
@section('css')
<style>
  .table tbody td .group-id{
    text-decoration: none;
    color: black;
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
<h5>Search Results:</h5>


<div class="container-fluid mt-3">
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
                            <form action="{{ route('task_groups.tasks.complete', [$t->taskGroup, $t]) }}" id="{{ 'form-complete-'.$t->id }}" 
                            method="POST" style="display: none">
                            @csrf
                            @method('put')
                            </form>
                        </div>
                        </td>
                        <td style="width: 65%">
                        <span>{{ $t->name }}</span> <br>
                        <span style="font-size: 12px">
                            <i><a href="{{ route('task_groups.edit',$t->taskGroup->id) }}" class="group-id">
                            {{ $t->taskGroup->name }}</a></i>
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
                                <form action="{{ route('task_groups.tasks.destroy', [$t->taskGroup, $t]) }}" method="POST">
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
                                <form action="{{ route('task_groups.tasks.removefrmyday',[$t->taskGroup, $t]) }}" id="{{ 'remove-fr-md-'.$t->id }}" 
                                method="POST" style="display: none">
                                @csrf
                                @method('delete')
                                </form>
                                @else
                                <button onclick="event.preventDefault(); document.getElementById('add-to-md-{{ $t->id }}').submit()">
                                <i class='bx bx-sun ms-2' style="text-align: center"></i>
                                <span class="ms-1">Add to My Day</span>
                                </button>
                                <form action="{{ route('task_groups.tasks.addtomyday',[$t->taskGroup, $t]) }}" id="{{ 'add-to-md-'.$t->id }}" 
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


                @if(count($myDays))
                    @foreach($myDays as $md)
                        <tr data-priority="{{ $md->priority_id }}" style="height: 60px">
                        <div style="display: flex; align-items: center;">
                        <td style="width: 3%; justify-content: center"><i class='bx bx-move move'></i></td>
                        </div>
                        <td style="width: 5%;">
                        <div style="display: flex; align-items: center">
                            <i class='bx bx-circle checkcol
                            @if($md->priority_id == 4)
                                high
                            @elseif($md->priority_id == 3)
                                medium
                            @elseif($md->priority_id == 2)
                                low
                            @else
                                none
                            @endif' 
                            onclick="event.preventDefault(); document.getElementById('form-complete-{{ $md->id }}').submit()"
                            style="font-size: 20px;"></i>
                            <form action="{{ route('my_day.complete', $md) }}" id="{{ 'form-complete-'.$md->id }}" 
                            method="POST" style="display: none">
                            @csrf
                            @method('put')
                            </form>
                        </div>
                        </td>
                        <td style="width: 65%;">
                        <span>{{ $md->name }} <br>
                            <a href="/my_day" class="my-day-link">
                                <i class='bx bx-sun' style="color: darkblue;font-size: 12px"></i>
                                <span style="font-size: 12px">My Day</span>
                            </a>
                        </span>
                        </td>
                        <td style="text-align: end; width: 30px">
                        @if($md->file)
                        <i class='bx bx-link-alt'style="color: lightgray"></i>
                        @endif
                        </td>
                        <td style="text-align: end; width: 30px">
                        @if($md->notes)
                        <i class='bx bx-note' style="color: lightgray"></i>
                        @endif
                        </td>
                        <td style="text-align: end; width: 30px">
                        @if($md->reminder)
                        <i class='bx bx-alarm' style="color: lightgray"></i>
                        @endif
                        </td>
                        <td style="padding-top: 10px;">
                        <div class="duedate">
                            @if ($md->due_date)
                            <span>{{ \Carbon\Carbon::parse($md->due_date)->format('d M')}}</span>
                            @endif
                        </div>
                        </td>
                        <td style="width: 5%; text-align: end;">
                        <button class="editbtn" onclick="editMD({{ $md->id }})"><i class='bx bx-edit'></i></button>
                        </td>
                        <td style="width: 5%; text-align: center;">
                        <div class="dropdown">
                            <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                            <i class='bx bx-dots-vertical-rounded'></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                            <li class="drop-custom">
                                <form action="{{ route('my_day.destroy', $md) }}" method="POST">
                                @csrf
                                @method('Delete')
                                <button type="submit" style="border: none; background:none" class="ms-2">
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

</div>
@endif
@endsection