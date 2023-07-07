@extends('index')
@section('title', 'Calendar')
@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="container-fluid" >
          <div id="calendar">
    </div>
    </div>
    <div class="modal fade" id="calModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Task</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="text" class="form-control" id="titleTask">
            <span id="nameError" class="text-danger"></span>
            <div class="row mt-4">
              <div class="col-sm-6">  
                <div class="form-group">
                  <label for="event_start_date">Event start</label>
                  <input type="datetime-local" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Event start date">
                 </div>
              </div>
              <div class="col-sm-6">  
                <div class="form-group">
                  <label for="event_end_date">Event end</label>
                  <input type="datetime-local" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveCal">Save changes</button>
          </div>
        </div>
      </div>
    </div>

@endsection
@section('javascript')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script>
    
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
      })
  
        var tasks = @json($events);
        console.log(tasks)
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month, agendaWeek, agendaDay'
            },
            aspectRatio: 3.5,
            height: 500,
            contentHeight: 500,
            events: tasks,
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDays){
              $("#calModal").modal('toggle');
  
              $('#saveCal').click(function(){
                var name = $('#titleTask').val();
                var start_date = moment(start).format('YYYY-MM-DD')
                var end_date = moment(end).format('YYYY-MM-DD')
                var start_time = $('#event_start_date').val(); // Get the selected start time
                var end_time = $('#event_end_date').val(); // Get the selected end time
                
                var start_datetime = moment(start_date + ' ' + start_time, 'YYYY-MM-DD HH:mm').format();
                var end_datetime = moment(end_date + ' ' + end_time, 'YYYY-MM-DD HH:mm').format();
                
                $.ajax({
                  url:"{{ route('calendar.store') }}",
                  type: "POST",
                  dataType: 'json',
                  data:{ name, start_date, end_date},
                  success: function(response)
                  {
                    $("#calModal").modal("hide")
                    $('#calendar').fullCalendar('renderEvent',{
                      'title' : response.name,
                      'start' : response.start_date,
                      'end' : response.end_date
                    })
                  },
                  error: function(error)
                  {
                    if(error.responseJSON.errors){
                      $('#nameError').html(error.responseJSON.errors.name)
                    }
                  },
                });
              });
            },
            editable: true,
            eventDrop: function(event){
              var id = event.id
              var start_date = moment(event.start).format('YYYY-MM-DD')
              var end_date = moment(event.end).format('YYYY-MM-DD')
              
              $.ajax({
                  url:"{{ route('calendar.update','') }}"+'/'+id,
                  type: "PATCH",
                  dataType: 'json',
                  data:{ start_date, end_date},
                  success: function(response)
                  {
                    console.log(response)
                  },
                  error: function(error)
                  {
                    console.log(error)
                  },
                });
            },
            eventClick: function(event){
              var id = event.id;
  
              if(confirm('Are you sure?')){
                $.ajax({
                    url:"{{ route('calendar.destroy','') }}"+'/'+id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response)
                    {
                      $('#calendar').fullCalendar('removeEvents', response)
                      Swal.fire(
                        'Success!',
                        'Event has deleted.',
                        'success'
                      )
                    },
                    error: function(error)
                    {
                      console.log(error)
                    },
                  });
              }
            },
            selectAllow: function(event)
            {
              return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1,'second').utcOffset(false),'day')
            },
        })

          $("#calModal").on("hidden.bs.modal", function(){
            $("#saveCal").unbind();
        });

        $('.fc-event').css('font-size','13px')
    });
  </script>
  @endsection
  {{-- 
              
              --}}