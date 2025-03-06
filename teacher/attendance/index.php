<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar of Events</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        .attendance-highlight .event-title {
            font-size: 12px;
            color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-0 mt-0">Attendance</h3>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Attendance Modal -->
    <div class="modal fade" id="mdladdattendance" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mark Attendance</h5>
                </div>
                <div class="modal-body">
                    <form id="attendanceForm">
                        <input type="hidden" id="selectedDate" name="selectedDate">
                        <div id="studentList"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Attendance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
    function loadAttendanceDates(callback) {
        $.ajax({
            type: 'POST',
            url: 'attendance/get_attendance_dates.php',
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === "success") {
                    const events = res.dates.map(date => ({
                        start: date,
                        display: 'background',
                        title: 'Attendance Checked',
                        backgroundColor: '#88C273',
                        classNames: ['attendance-highlight']
                    }));
                    callback(events);
                } else {
                    console.error('Failed to load attendance dates:', res.message);
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({ title: 'Error!', text: 'An error occurred: ' + error, icon: 'error' });
            }
        });
    }

    var calendarEl = document.getElementById('calendar');

    loadAttendanceDates(function(attendanceEvents) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            dateClick: function(info) {
                $('#selectedDate').val(info.dateStr);
                fetchAttendance(info.dateStr);
            },
            events: attendanceEvents,
            eventContent: function(arg) {
                if (arg.event.title) {
                    return { html: `<div class="event-title">${arg.event.title}</div>` };
                }
            }
        });
        
        calendar.render();
    });

    function fetchAttendance(selectedDate) {
    $.ajax({
        type: 'POST',
        url: 'attendance/get_students.php',
        data: { date: selectedDate },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.status === "success") {
                $('#studentList').empty(); // Clear existing list
                let studentIds = new Set(); // Prevent duplicates

                let studentListHtml = `<table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>AM</th>
                            <th>PM</th>
                        </tr>
                    </thead>
                    <tbody>`;

                res.students.forEach(student => {
                    if (!studentIds.has(student.id)) { // Prevent duplicates
                        studentIds.add(student.id);

                        studentListHtml += `
                            <tr>
                                <td>${student.fullname}</td>
                                <td><input type="checkbox" name="am[${student.id}]" ${student.status_am ? 'checked' : ''}></td>
                                <td><input type="checkbox" name="pm[${student.id}]" ${student.status_pm ? 'checked' : ''}></td>
                            </tr>`;
                    }
                });

                

                studentListHtml += `</tbody></table>`;
                $('#studentList').html(studentListHtml);
                $('#mdladdattendance').modal('show');
            } else {
                Swal.fire({ title: 'Error!', text: res.message, icon: 'error' });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({ title: 'Error!', text: 'An error occurred: ' + error, icon: 'error' });
        }
    });
}


    $('#attendanceForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'attendance/save_attendance.php',
            data: formData,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === "success") {
                    Swal.fire({ title: 'Success!', text: res.message, icon: 'success' })
                    .then(() => {
                        $('#mdladdattendance').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({ title: 'Error!', text: res.message, icon: 'error' });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({ title: 'Error!', text: 'An error occurred: ' + error, icon: 'error' });
            }
        });
    });
});

    </script>


</body>
</html>
