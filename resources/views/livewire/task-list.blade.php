@php
$incompleteTasks = $taskGroup->tasks()->where('completed', false)->get();
@endphp
<table class="table" id="group">
  <tbody wire:sortable="updateTaskOrder">
    @foreach ($incompleteTasks->sortBy([['due_date','asc']]) as $t)
    <tr data-priority="{{ $t->priority_id }}" style="height: 60px"
      wire:sortable.item="{{ $t->id }}" wire:key="task-{{ $t->id }}" >
      <div style="display: flex; align-items: center">
        <td style="width: 3%;"><i class='bx bx-move move' wire:sortable.handle></i></td>
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
      <td style="width: 62%;">
        <span>{{ $t->name }} </span> <br>
        @if($t->add_to_myday)
        <a href="/my_day" class="my-day-link">
        <i class='bx bx-sun' style="color: darkblue;font-size: 12px"></i>
        <span style="font-size: 12px">My Day</span>
        </a>
        @endif
      </td>
      <td style="text-align: end; width: 30px">
        @if($t->file)
        <i class='bx bx-link-alt'style="color: lightgray"></i>
        @endif
      </td>
      <td style="text-align: end; width: 30px">
        @if($t->notes)
        <i class='bx bx-note'style="color: lightgray"></i>
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
              <form action="{{ route('task_groups.tasks.destroy', [$taskGroup, $t]) }}" method="POST">
                @csrf
                @method('Delete')
                <button type="submit" style="border: none; background:none" class="ms-2">
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
              <form action="{{ route('task_groups.tasks.removefrmyday',[$taskGroup, $t]) }}" id="{{ 'remove-fr-md-'.$t->id }}" 
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

    @foreach($myDay as $md)
    <tr data-priority="{{ $md->priority_id }}" style="height: 60px"
      wire:sortable.item="{{ $md->id }}" wire:key="myDay-{{ $md->id }}">
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
      <td style="width: 62%;">
        <span>{{ $md->name }}</span> <br>
        <a href="/my_day" class="my-day-link">
          <i class='bx bx-sun' style="color: darkblue;font-size: 12px"></i>
          <span style="font-size: 12px">My Day</span>
        </a>
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
            
            <li><hr class="dropdown-divider"></li>
            <li class="my-2">
              <span class="ms-3">Add task to: </span>
            </li>
            @foreach(App\Models\TaskGroup::where('user_id', auth()->id())->get() as $tG)
            <li class="drop-custom">
              <button onclick="event.preventDefault(); document.getElementById('add-{{ $md->id }}-to-tg-{{ $tG->id }}').submit()"
              style="border: none; background:none; width: 140px; display:flex" class="ms-2">
                  <span class="ms-2" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                    {{ $tG->name }}  
                  </span>
              </button>
              <form id="{{ 'add-'.$md->id.'-to-tg-'.$tG->id }}" action="{{ route('my_day.no-taskgroup', $md) }}" method="POST" style="display: none;">
                @csrf
                @method('put')
                <input type="hidden" name="task_group_id" value="{{ $tG->id }}">
              </form>
            </li>
            @endforeach

            @if($md->task_group_id)
            <li class="drop-custom">
              <button style="color: #dc3545;border: none;background: none"
              onclick="event.preventDefault(); document.getElementById('remove-{{ $md->id }}-fr-{{ $taskGroup->id }}').submit()">
                <i class='bx bx-x ms-2'></i>
                <span class="ms-3">Remove </span>
              </button>
              <form action="{{ route('my_day.no-taskgroup', $md) }}" id="{{ 'remove-'.$md->id.'-fr-'.$taskGroup->id }}" 
                method="POST" style="display: none">
                @csrf
                @method('delete')
                <input type="hidden" name="task_group_id" value="{{ $taskGroup->id }}">
                <input type="hidden" name="id" value="{{ $md->id }}">
              </form>
            </li>
            @endif
            
          </ul>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@livewireScripts
<script>
  Livewire.on('updateTaskOrder', () => {
      Livewire.emit('refreshLivewire');
  });
  
  Livewire.hook('afterDomUpdate', () => {
      Livewire.emit('checkPendingUpdates');
  });
  
  Livewire.on('savePendingUpdates', () => {
      Livewire.emit('refreshLivewire');
  });
</script>
