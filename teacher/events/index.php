<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar of Events</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <style>
        /* Your existing styles */
        .Iclass {
            font-size: 1.3rem;
            cursor: pointer;
            font-weight: 500;
        }

        ul.pagination {
            display: inline-block;
            padding: 0;
            margin: 0;
        }

        ul.pagination li {
            cursor: pointer;
            display: inline;
            color: #3a4651 !important;
            font-weight: 600;
            padding: 4px 8px;
            border: 1px solid #CCC;
        }

        .pagination li:first-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .pagination li:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        ul.pagination li:hover {
            background-color: #3a4651;
            color: white !important;
        }
        .fc-event {
            cursor: pointer;
        }
        .pagination .active {
            background-color: #3a4651;
            color: white !important;
        }

        .table thead th,
        .table th {
            background-color: #9e9e9e !important;
        }

        .swal2-icon {
            margin-bottom: 10px !important;
        }

        .modalpaddingnew {
            padding-left: 5px;
            margin-bottom: 10px;
        }

        /* Responsive FullCalendar */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            #calendar {
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            #calendar {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-bottom: 0px;">
                <div class="card-body" style="padding-top: .5rem; padding-bottom: .5rem; border-radius: 5px; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                    <div class="row page-titles rowpageheaderpadd" style="padding-bottom: 0px;">
                        <div class="col-md-6 col-6 align-self-center" style="padding-left:10px;">
                            <h3 class="mb-0 mt-0 headerfontfont" style="font-weight: 600;">Calendar of Events</h3>
                        </div>
                    </div>
                    <!-- FullCalendar -->
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="contentModal" style="display: none;">
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border-radius: 10px; width: 90%; max-width: 500px;">
            <h2 style="text-align: center;">Event Details</h2>
            <div class="form-group">
                <label for="eventTitleDisplay">Title:</label>
                <p id="eventTitleDisplay"></p>
            </div>
            <div class="form-group">
                <label for="eventDateDisplay">Date:</label>
                <p id="eventDateDisplay"></p>
            </div>
            <div class="form-group">
                <label for="eventContentDisplay">Content:</label>
                <p id="eventContentDisplay"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closecontentModal()">Close</button>
            </div>
        </div>
    </div>
</div>
    <!-- FullCalendar JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('events/get_events.php')
                        .then(response => response.json())
                        .then(data => {
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                dateClick: function(info) {
                    document.getElementById('eventDate').value = info.dateStr;
                    openModal();
                },
                eventClick: function(info) {
                    document.getElementById('eventTitleDisplay').innerText = info.event.title;
                    document.getElementById('eventDateDisplay').innerText = info.event.start.toISOString().split('T')[0];
                    document.getElementById('eventContentDisplay').innerText = info.event.extendedProps.content || 'No content available';
                    opencontentModal();
                }
            });

            calendar.render();
        });

        function opencontentModal() {
            document.getElementById('contentModal').style.display = 'block';
        }

        function closecontentModal() {
            document.getElementById('contentModal').style.display = 'none';
        }

    </script>
</body>
</html>
