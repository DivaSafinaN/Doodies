<div class="col">
<form action="{{ route('task_groups.tasks.update', [$taskGroup, $task]) }}" method="post" enctype="multipart/form-data">
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
    <div class="form-group mb-1 mt-3">
      <label for="reminder" class="form-label"><i class='bx bx-alarm'></i>
        Reminder</label>
        @if($task->reminder)
      <input type="datetime-local" class="form-control" name="reminder" id="reminder" value="{{ \Carbon\Carbon::parse($task->reminder)->format('Y-m-d H:i') }}">
      @else
      <input type="datetime-local" class="form-control" name="reminder" id="reminder">
      @endif
  </div>
      
    <div class="form-group mb-1 mt-3">
        <label for="due_date" class="form-label">Due Date</label>
        @if($task->due_date)
        <input type="date" class="form-control" name="due_date" id="due_date" value="{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}">
        @else
        <input type="date" class="form-control" name="due_date" id="due_date">
        @endif
    </div>

    <div class="mb-1 mt-3">
      <label for="formFile" class="form-label">
        <i class='bx bx-link-alt'></i>Attach File</label>
      <input class="form-control" type="file" id="file" name="file" >
    </div>
  </div>
<div class="form-group mt-3">
    <label for="exampleFormControlTextarea1">Notes :</label>
    <textarea class="form-control" id="notes" name="notes">{{ $task->notes }}</textarea>
</div>
<button type="submit" class="btn btn-primary my-3" style="width: fit-content">Save</button>
</form>
</div>

<script>
  ClassicEditor
      .create( document.querySelector( '#notes' ) )
      .catch( error => {
          console.error( error );
      } );
</script>