<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href={{ asset("assets/style.css") }}>
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    @yield('css')
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @livewireStyles
   </head>
<body>
  <div class="sidebar close">
    <div class="logo-details">
      <i class='bx bx-task'></i>
      <span class="logo_name">To Do-ers</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="/my_day" class="custombtn">
          <i class='bx bx-sun'></i>
          <span class="link_name">My Day</span>
        </a>
      </li>
      <li>
        <a href="#" class="custombtn">
          <i class='bx bx-home'></i>
          <span class="link_name">Tasks</span>
        </a>
      </li>
      <div style="display: flex; justify-content: center; margin-top: -5px">
          <hr style="color: #fff; width: 230px">
      </div>
      <p class="sub-title">
        <span class="link_name">
          Lists
        </span>
        <a href="{{ route('task_groups.create') }}" class="add-taskbtn" style="text-decoration: none; color: #fff">
            <i class='bx bx-plus' style="font-size: 15px; font-weight: 600"></i>
        </a>
      </p>

      @foreach(App\Models\TaskGroup::all() as $group)
      <li>
        <a href="{{ route('task_groups.edit',$group->id) }}" class="custombtn">
            <i class='bx bx-list-ul'></i>
            <span class="link_name">{{ $group->name }}</span>
        </a>
      </li>
      @endforeach

      <div style="display: flex; justify-content: center; margin-top: -5px">
        <hr style="color: #fff; width: 230px">
      </div>

      <li>
        <a href="/completed_tasks">
          <i class='bx bxs-check-square'></i>          
          <span class="link_name">Completed</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-trash'></i>
          <span class="link_name">Trash</span>
        </a>
      </li>

</ul>
</div>
<!-- Home Section -->
<nav class="navbar navbar-expand-lg navclass" style="padding: 12px; background: #fff;">
  <i class='bx bx-menu'></i>
  <div class="container-fluid">
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class=" collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto ">
        <li class="nav-item">
          <form class="d-flex input-group" role="search">
            <div class="inner-form">
              <div class="input-field">
                <button class="btn-search" type="button">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                  </svg>
                </button>
                <input id="search" type="text" placeholder="Search" />
              </div>
            </div>
          </form>
        </li>
        <li class="nav-item mx-4">
          <img src={{ asset("assets/image/avt.png") }} class="user-pic" onclick="toggleMenu()">
            <div class="profile" id="Profile">
              <div class="sub-profile">
                <div class="user-info">
                  <img src={{ asset("assets/image/avt.png") }}>
                    <p>Diva Safina
                      <span>diva.novariana@binus.ac.id</span>
                    </p>
                </div>
                <hr>
                <a href="#" class="sub-profile-link">
                    <i class='bx bx-log-out'></i>
                    <p>Log out</p>
                    <span>></span> 
                </a>
              </div>
            </div>
          </li>    
        </ul>
      </div>
    </div>
</nav>

  <div class="home-section">
    <div class="home-content">
        @yield('content')
    </div> 
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src={{ asset("assets/script.js") }}></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  
  @livewireScripts
  @yield('javascript')
</body>
</html>
