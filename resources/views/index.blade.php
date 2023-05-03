<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href={{ asset("assets/style_diva.css") }}>
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    @yield('css')
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="close sidebar">
    <div class="logo-details">
      <img src="{{ asset("img/logo_1.png") }}" alt="" class="logo_img">
      <span class="logo_name">Doodies</span>
    </div>
    <ul class="nav-links">
      @if(auth()->user()->is_admin)
      <li>
        <a href="/manage-user" class="custombtn">
          <i class='bx bx-user-circle' style="color: #252629"></i>
          <span class="link_name">Manage User</span>
        </a>
      </li>
      @else
      <li>
        <a href="/my_day" class="custombtn">
          <i class='bx bx-sun'></i>
          <span class="link_name">My Day</span>
        </a>
      </li>
      <div style="display: flex; justify-content: center; margin-top: -5px">
          <hr style="color: #62625e; width: 230px">
      </div>
      <p class="sub-title">
        <span class="link_name">
          Lists
        </span>
        <button class="btn add-taskbtn" type="button" onclick="create()">
            <i class='bx bx-plus' style="font-size: 15px; font-weight: 600"></i>
        </button>
      </p>
      
      @foreach(App\Models\TaskGroup::where('user_id', Auth::id())->get() as $group)
      <li>
        <a href="{{ route('task_groups.edit',$group->id) }}" class="custombtn">
            <i class='bx bx-list-ul'></i>
            <span class="link_name">{{ $group->name }}</span>
        </a>
      </li>
      @endforeach

      <div style="display: flex; justify-content: center; margin-top: -5px">
        <hr style="color: #62625e; width: 230px">
      </div>

      <li>
        <a href="/completed_tasks" class="custombtn">
          <i class='bx bxs-check-square'></i>          
          <span class="link_name">Completed</span>
        </a>
      </li>
      <li>
        <a href="/trash" class="custombtn">
          <i class='bx bx-trash'></i>
          <span class="link_name">Trash</span>
        </a>
      </li>
      @endif
</ul>
</div>
<!-- Home Section -->
<nav class="navbar navbar-expand-lg navclass" style="padding: 12px; background: #f9faf5;">
  <i class='bx bx-menu'></i>
  <div class="container-fluid">
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class=" collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto ">
        @include('search')
        <li class="nav-item mx-4">
          <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=d3f369&rounded=true" 
          class="user-pic" onclick="toggleMenu()">
            <div class="profile" id="Profile">
              <div class="sub-profile">
                <div class="user-info">
                  <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=d3f369&rounded=true" >
                    <p>{{ Auth::user()->name }}
                      <span>{{ Auth::user()->email }}</span>
                      <span><a href="{{ route('edit-profile') }}"><i class='bx bx-edit' 
                        style="font-size: 15px;color: #54612a;background: #e9f9b4;padding: 2px;border-radius: 6px;"></i></a> | 
                        <a href="{{ route('edit-password') }}" 
                        style="color: #54612a;background: #e9f9b4;padding: 4px;border-radius: 35px;">Change Password</a></span>
                    </p>
                </div>
                <hr>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" class="sub-profile-link">
                    <i class='bx bx-log-out'></i>
                    <p>Log out</p>
                    <span>></span> 
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                </a>
              </div>
            </div>
          </li>    
        </ul>
      </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: #f9faf5">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="page"></div>
      </div>
    </div>
  </div>
</div>



  <div class="home-section">
    <div class="home-content">
      {{-- @if ($errors->has('name'))
        <div class="d-flex justify-content-center">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ $errors->first('name') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
      @endif --}}
        @yield('content')
    </div> 
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src={{ asset("assets/script.js") }}></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function create(){
      $.get('/task_groups/create' ,function(data){
      $("#exampleModalLabel").html('Create New List');
      $("#page").html(data);
      $("#exampleModal").modal('show');
  });
  }
  @if ($errors->has('name'))
    Swal.fire('A task group with that name already exists.')
  @endif

  @if (session()->has('message'))
    Swal.fire(
      'Success!',
      'New Task List has been created.',
      'success'
    )
  @endif

  </script>
  
  @yield('javascript')
</body>
</html>
