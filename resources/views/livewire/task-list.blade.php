<div class="d-flex container">
    <div class="col-md-6">
      <div class="card-hover-shadow-2x mb-3 card">
        <div class="scroll-area-sm">
          <perfect-scrollbar class="ps-show-limits">
            <div style="position: static;" class="ps ps--active-y">
              <div class="ps-content">
                <table class="table">
                  <tbody>
                    @foreach($taskGroup->tasks as $t)
                    <tr>
                      <td style="width: 7%"><i class='bx bx-move move'></i></td>
                      <td style="width: 5%"><input class="form-check-input me-1" type="checkbox" value="" aria-label="..."></td>
                      <td style="width: 55%;">
                       {{ $t->name }}
                      </td>
                      <td style="padding-top: 10px;">
                        <div class="priority" style="background-color: lightblue; font-size: 11px; color: white; width: auto; display: flex; border-radius: 12px; justify-content: center">
                          <span>Mid Priority</span>
                        </div>
                      </td>
                      <td style="width: 7%; text-align: center">
                        {{-- <a href="{{ route('task_groups.tasks.edit',[$taskGroup, $t]) }}"> --}}
                            <a href="">
                            <i class='bx bx-edit'></i>
                            </a>
                        {{-- </a> --}}
                      </td>
                      <td style="width: 7%">
                        <div class="dropdown">
                          <a class="dropdown"type="button"data-bs-toggle="dropdown" style="color: black">
                          <i class='bx bx-dots-vertical-rounded'></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                            <li class="drop-custom">
                              {{-- <form action="{{ route('task_groups.tasks.destroy', [$taskGroup, $t]) }}" method="POST"> --}}
                                @csrf
                                @method('Delete')
                                <button type="submit" onclick="return confirm('Are you sure?')" style="border: none; background:none" class="ms-2">
                                  <i class='bx bx-trash' style="text-align: center"></i>
                                    <span class="ms-2">Delete</span>
                                </button>
                                </form>
                            </li>
                            <li class="drop-custom mt-1">
                              <a href="">
                                <i class='bx bx-sun'></i>
                                <span>Add to My Day</span>
                              </a>
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
        <div class="d-block text-right card-footer">
          {{-- <form action="{{ route('task_groups.tasks.store',$taskGroup) }}" method="post" class="row g-3"> --}}
            <form action="" class="row g-3">
            @csrf
            <div class="col">
            <input type="text" class="form-control input" placeholder="ex: Homework" name="name" >
            </div>
            <div class="col-auto">
            <button type="submit" class="btn btn-dark">Add Task</button>
            </div>
        </form>
        </div>
      </div>
    </div>

<div class="col ms-3 edit-form">
    <form>
        <div class="card">
            <div class="card-body">
              <div class="d-flex col-ms-3" style="justify-content: space-between;">
                <div class="d-flex" style="align-items: center">
                    <input type="text" name="name" id="name" value="" class="input-title">
                </div>
                <select style="width: auto">
                  <option selected >None</option>
                  <option value="1">High Priority</option>
                  <option value="2">Mid Priority</option>
                  <option value="3">Low Priority</option>
                </select>
              </div>
                
                <div class="mt-3">
                  <ul class="list-group">
                    <li class="list-group-item editbtn">
                      <a href="">
                        <i class='bx bx-alarm'></i>
                        <span>Set Reminder</span>  
                      </a>
                    </li>
                    <li class="list-group-item editbtn">
                      <a href="">
                        <i class='bx bx-calendar'></i>
                        <span>Add due Date</span>
                      </a>
                    </li>
                  </ul>
                  <div class="mb-1 mt-3">
                    <label for="formFile" class="form-label">
                      <i class='bx bx-link-alt'></i>Attach File</label>
                    <input class="form-control" type="file" id="formFile">
                  </div>
                </div>
                &nbsp;
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Notes :</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="notes"></textarea>
                </div>
              </div>
                <button type="submit" class="btn btn-primary mb-3 ms-3" style="width: fit-content">Save</button>
            </div>
        </form>
    </div>
</div>