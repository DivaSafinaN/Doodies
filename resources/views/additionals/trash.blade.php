@extends('index')
@section('title',  'Trash' )
@section('content')
<div class="container-fluid" style="text-align: center">
    <span class="text">Trash</span> <br>
    <span style="font-size: 17px">Tasks will be deleted permanently after 3 days.</span>
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
                <table class="table">
                    <tbody>
                      {{-- @foreach($taskGroups as $taskGroup)
                      @foreach($taskGroup->tasks->sortBy([['deleted_at','desc']]) as $t)
                      @if ($t->deleted_at)
                      <tr>
                        <div style="display: flex; align-items: center">
                          <td style="width: 3%;"><i class='bx bx-move move'></i></td>
                        </div>
                        <td style="width: 5%;">
                          @if($t->completed)
                          <i class='bx bxs-check-circle checkcol' style="font-size: 20px"></i>
                          @else
                          <i class='bx bx-circle checkcol'style="font-size: 20px"></i>
                          @endif
                        </td>
                        <td style="width: 68%;">
                          <span class="text-muted">{{ $t->name }}</span>
                        </td>
                        <td style="width: 5%; text-align: center;">
                          <div class="dropdown">
                            <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                            <i class='bx bx-dots-vertical-rounded'></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                              <li class="drop-custom">
                                <form action="{{ route('task_groups.tasks.restore', [$taskGroup, $t]) }}" method="POST">
                                  @csrf
                                  @method('put')
                                  <button type="submit" style="border: none; background:none" class="ms-2">
                                    <i class='bx bx-redo' style="text-align: center"></i>
                                      <span class="ms-2">Restore</span>
                                  </button>
                                  </form>
                              </li>
                              <li class="drop-custom">
                                <form action="{{ route('task_groups.tasks.delete', [$taskGroup, $t]) }}" method="POST" onsubmit="return submitForm(this)">
                                  @csrf
                                  @method('delete')
                                  <button type="submit" style="border: none; background:none" class="ms-2" id="trash-btn">
                                    <i class='bx bx-trash' style="text-align: center; color: red"></i>
                                      <span class="ms-2 text-danger">Delete</span>
                                  </button>
                                  </form>
                              </li>
                              
                            </ul>
                          </div>
                        </td>
                        @php
                          $taskDisplayed = true;
                        @endphp
                      </tr>
                      @endif
                      @endforeach
                        @endforeach --}}
                    {{-- </tbody>

                    <tbody> --}}
                      @foreach($tasks->sortBy([['deleted_at','desc']]) as $ct)
                      <tr>
                        <div style="display: flex; align-items: center">
                          <td style="width: 3%;"><i class='bx bx-move move'></i></td>
                        </div>
                        <td style="width: 5%;">
                          @if($ct->completed)
                          <i class='bx bxs-check-circle checkcol' style="font-size: 20px"></i>
                          @else
                          <i class='bx bx-circle checkcol'style="font-size: 20px"></i>
                          @endif
                        </td>
                        <td style="width: 68%;">
                          <span class="text-muted">{{ $ct->name }}</span>
                        </td>
                        <td style="width: 5%; text-align: center;">
                          <div class="dropdown">
                            <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                            <i class='bx bx-dots-vertical-rounded'></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                              <li class="drop-custom">
                                <form action="{{ route('tasks.restore', $ct) }}" method="POST">
                                  @csrf
                                  @method('put')
                                  <button type="submit" style="border: none; background:none" class="ms-2">
                                    <i class='bx bx-redo' style="text-align: end"></i>
                                      <span class="ms-2">Restore</span>
                                  </button>
                                  </form>
                              </li>
                              <li class="drop-custom">
                                <form action="{{ route('tasks.delete', $ct) }}" method="POST" onsubmit="return submitForm(this)">
                                  @csrf
                                  @method('Delete')
                                  <button type="submit" style="border: none; background:none" class="ms-2" id="trash-btn">
                                    <i class='bx bx-trash' style="text-align: end; color: #dc3545"></i>
                                      <span class="ms-2 text-danger">Delete</span>
                                  </button>
                                  </form>
                              </li>
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
            <img src="{{ asset("img/5598.jpg") }}" style="width:320px">
              <span style="text-align: center; font-size: 20px; color: #a8bbbf">
                You can find the deleted task here.<br>
                No deleted task yet. 
              </span>
              
          </div>
          @endif

        </div>
      </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
  function submitForm(form){
      Swal.fire({
        title: 'Are you sure?',
        text: "Task will be deleted permanently.",
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
</script>
@endsection