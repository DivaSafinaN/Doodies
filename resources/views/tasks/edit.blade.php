<div class="col">
<form action="{{ route('task_groups.tasks.update', [$taskGroup, $task]) }}" method="post">
    @method('PUT')
    @csrf
<h5><input class="form-control" type="text" name="name" id="name" value="{{ $task->name }}"></h5>
<select class="form-select" style="width: auto" name="priority_id" id="priority_id">
  @foreach($priority as $p)
  <option value="{{ $p->id }}" {{ $task->priority_id == $p->id ? 'selected' : '' }}>
    {{ $p->priority }}
  </option>
  @endforeach
</select>
<div class="mt-3">
    <ul class="list-group">
      <li class="list-group-item editbtn">
        <a href="">
          <i class='bx bx-alarm'></i>
          <span>Set Reminder</span>  
        </a>
      </li>
    </ul>
      
    <div class="form-group mb-1 mt-3">
        <label for="due_date" class="form-label">Add Due Date</label>
        <input type="datetime-local" class="form-control" name="due_date" id="due_date" value="{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d\TH:i') }}">
    </div>

    <div class="mb-1 mt-3">
      <label for="formFile" class="form-label">
        <i class='bx bx-link-alt'></i>Attach File</label>
      <input class="form-control" type="file" id="formFile">
    </div>
  </div>
<div class="form-group">
    <label for="exampleFormControlTextarea1">Notes :</label>
    <textarea class="form-control" id="notes" rows="3" name="notes">{{ $task->notes }}</textarea>
</div>
<button type="submit" class="btn btn-primary my-3" style="width: fit-content">Save</button>
</form>
</div>