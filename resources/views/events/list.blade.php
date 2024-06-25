@extends('layouts.app')
<head>
    <!-- Load jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Load datetimepicker from CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <!-- Load FullCalendar from CDN -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          dateClick: function(info) {
            console.log(info);
            $('#is_all_day').prop('checked', true);
            initializeStartDateEndDateFormat('Y-m-d', true);
            $('#eventModal').modal('show');
          }
        });
        calendar.render();
        
        $('#is_all_day').change(function() {
            let is_all_day = $(this).prop('checked');
            if(is_all_day){
                let start = $('#startDateTime').val().slice(0, 10);
                $('#startDateTime').val(start);
                let end = $('#endDateTime').val().slice(0, 10);
                $('#endDateTime').val(end);
                initializeStartDateEndDateFormat("Y-m-d", is_all_day);
            }else{
                let start = $('#startDateTime').val().slice(0, 10);
                // $('#startDateTime').val(start + " 00:00");
                let end = $('#endDateTime').val().slice(0, 10);
                // $('#endDateTime').val(end + " 00:30");
                initializeStartDateEndDateFormat("Y-m-d H:i", is_all_day);
            }
        });

        function initializeStartDateEndDateFormat(format, allDay){
          let timePicker = !allDay;
          $('#startDateTime').datetimepicker({
              format: format,
              timepicker: timePicker
          });
          $('#endDateTime').datetimepicker({
              format: format,
              timepicker: timePicker
          });
        }
      });
    </script>
</head>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div> 
                    <input type="hidden" id="eventId">
                    <label for="title">Title</label>
                    <input type="text" placeholder="Enter Title" class="form-control" id="title" name="title" value="" required>
                </div>

                <div> 
                    <label for="is_all_day">All Day</label>
                    <input type="checkbox" id="is_all_day" name="is_all_day" checked value="" required>
                </div>

                <div> 
                    <label for="startDateTime">Start Date/Time</label>
                    <input type="text" placeholder="Select Start day" readonly class="form-control" id="startDateTime" name="startDate" value="" required>
                </div>

                <div> 
                    <label for="endDateTime">End Date/Time</label>
                    <input type="text" placeholder="Select End day" readonly class="form-control" id="endDateTime" name="endDate" value="" required>
                </div>

                <div> 
                    <label for="description">Description</label>
                    <textarea placeholder="Enter Description" class="form-control" id="description" name="description" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitEventFormData()">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
