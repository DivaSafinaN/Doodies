<style>
    div .files{
    background: #f8f8f8;
    width: 100%;
    border: lightgray solid 1px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
  }
  div .files a{
    align-items: center;
    display: flex;
    color: black;
    text-decoration: underline;
    margin-left: 10px;
  }
</style>

<div class="col">
<form action="{{ route('tasks.update', $task) }}" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
<h5><input class="form-control" type="text" name="task_name" id="name" value="{{ $task->task_name }}" required autocomplete="name"></h5>
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
        @if ($task->file)
            <div class="mb-2 files">
                <a href="{{ asset('storage/file/'.$task->file) }}" target="_blank">{{ $task->file }}</a>
                  <button type="submit" class="btn filebtn text-danger"
                  onclick="event.preventDefault(); document.getElementById('fileT-{{ $task->id }}').submit()">Delete</button>
            </div>
            <form style="visibility: hidden"></form>
            <form action="{{ route('tasks.fileTgone', $task) }}" 
            method="post" id="{{ 'fileT-'.$task->id }}">@csrf @method('put')</form>
            @else
            <input class="form-control" type="file" id="file" name="file">
        @endif
</div>

<div class="form-group mt-3">
    <label for="exampleFormControlTextarea1">Notes :</label>
    <textarea class="form-control" id="notes" name="notes">{{ $task->notes }}</textarea>
</div>
<button type="submit" class="btn my-3" style="width: fit-content; background: #d3f369">Save</button>
</form>
</div>

<script>
  ClassicEditor
      .create( document.querySelector( '#notes' ) )
      .catch( error => {
          console.error( error );
      } );
</script>