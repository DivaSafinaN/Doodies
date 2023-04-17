<div class="col">
    <form action="{{ route('my_day.update', $myDay )}}" method="post">
        @method('PUT')
        @csrf
    <h5><input class="form-control" type="text" name="name" id="name" value="{{ $myDay->name }}"></h5>
    <select class="form-select" style="width: auto" name="priority_id" id="priority_id">
      @foreach($priority as $p)
      <option value="{{ $p->id }}" {{ $myDay->priority_id == $p->id ? 'selected' : '' }}>
        {{ $p->priority }}
      </option>
      @endforeach
    </select>
    <div class="mt-3">
      <div class="form-group mb-1 mt-3">
        <label for="reminder" class="form-label"><i class='bx bx-alarm'></i>
          Reminder</label>
          @if($myDay->reminder)
        <input type="datetime-local" class="form-control" name="reminder" id="reminder" value="{{ \Carbon\Carbon::parse($myDay->reminder)->format('Y-m-d H:i') }}">
        @else
        <input type="datetime-local" class="form-control" name="reminder" id="reminder">
        @endif
    </div>
          
        <div class="form-group mb-1 mt-3">
            <label for="due_date" class="form-label">Add Due Date</label>
            @if($myDay->due_date)
            <input type="date" class="form-control" name="due_date" id="due_date" 
            value="{{ \Carbon\Carbon::parse($myDay->due_date)->format('Y-m-d') }}">
            @else
            <input type="date" class="form-control" name="due_date" id="due_date" >
            @endif
        </div>
    
        <div class="mb-1 mt-3">
          <label for="formFile" class="form-label">
            <i class='bx bx-link-alt'></i>Attach File</label>
          <input class="form-control" type="file" id="formFile">
        </div>
      </div>
    <div class="form-group mt-3">
        <label for="exampleFormControlTextarea1">Notes :</label>
        <textarea class="form-control" id="notes" name="notes">{{ $myDay->notes }}</textarea>
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