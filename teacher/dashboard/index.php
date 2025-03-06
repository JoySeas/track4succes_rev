<?php
include("connection.php");
session_start();

// Check if user is logged in (you should implement your own authentication logic)
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Get username from session
$username = $_SESSION['username'];
// Query to get announcements where the date is not finished
$query = "SELECT id, title, date, content 
          FROM announcements 
          WHERE date >= CURDATE() 
          ORDER BY created_at DESC 
          LIMIT 3";
$result = $conn->query($query);
// Query to get the latest two events
$eventQuery = "SELECT title, start_date FROM events ORDER BY start_date ASC LIMIT 3";
$eventResult = $conn->query($eventQuery);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="dashboard/dashboard.css" />
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>

<link rel="stylesheet" type="text/css" href="dashboard/dashboard.css" />

<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }
    .row {
        margin-top: -20px;
        margin-bottom: 50px;
        position: relative;
    }
    .row img {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        margin-top: -20px;
    }
    .welcome-message {
        position: absolute;
        top: 50%;
        left: 5%;
        transform: translateY(-50%);
        color: white;
        font-size: 30px;
        font-family: 'Poppins', sans-serif;
        text-align: left;
    }
    .welcome-message span {
        font-size: 18px;
    }
    .title{
        font-size: 20px;
    }
    @media (max-width: 768px) {
        .welcome-message {
            font-size: 24px;
            left: 5%;
        }
        .welcome-message span {
            font-size: 16px;
        }
    }
    @media (max-width: 480px) {
        .welcome-message {
            font-size: 15px;
            left: 5%;
        }
        .title{
            font-size: 25px;
        }
        .welcome-message span {
            font-size: 14px;
        }
    }
    .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-head .title {
            color: #000000;
            margin-bottom: 15px;
        }
        .card-head .view-users-btn {
            background-color: #5598FB;
            color: #FFFFFF;
            border: none;
            padding: 5px 10px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 12px;
        }
    .box-content {
    position: relative; /* Ensure the box is positioned relative to allow absolute positioning of the button */
    box-shadow: 2px 3px 5px rgb(126, 142, 159);
    background-color: #679DFF;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
}
.read-btn {
    position: absolute;
    top: 50%;
    right: 15px; /* Adjust as needed */
    transform: translateY(-50%);
    background-color: #F0EDFF;
    color: #000;
    border: none;
    padding: 5px 10px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.read-btn:hover {
    background-color: #fff; /* Darker shade on hover */
}
.box-event {
    position: relative;
    box-shadow: inset 0 0 0 0.5px #BAB9B9, 2px 3px 5px #BAB9B9; /* Inner stroke and outer shadow */
    background-color: #FFFFFF;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
}


.event-btn {
    background-color: #679DFF;
    color: #FFFFFF;
    border: none;
    padding: 5px 10px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.event-details {
    margin-left: 15px; /* Adds space between the event button and the details */
    color: #000;
}

</style>
</head>
<body>
    <div class="row">
        <img src="..//assets/images/admin/admin-banner.png" alt="banner">
        <div class="welcome-message">
            Welcome back, Teacher <?php echo htmlspecialchars($firstname); ?>!<br>
            <span>Manage students academic performances.</span>
        </div>
    </div>



<div class="row">
    <div class="col-md-12">
        <div class="row">

            <div class="col-xs-12 col-md-4">
    <div class="card" style="margin-bottom: 15px; position: relative;">
        <div class="box bg-info" style="box-shadow: inset 0 0 0 0.5px #BAB9B9, 2px 3px 5px rgb(126, 142, 159); position: relative;">
            <div class="card-head" style="margin-bottom: 10px;">
                <h5 class="font-light title" style="color: #4C644B;">Upcoming Events</h5>
                <button class="view-users-btn" onclick="window.location.href='index.php?url=events';">View More</button>
            </div>

            <?php if ($eventResult->num_rows > 0): ?>
    <?php while($event = $eventResult->fetch_assoc()): ?>
        <div class="box-event" style="display: flex; align-items: center; margin-top: 10px;">
            <div class="event-btn" style="display: flex; flex-direction: column; align-items: center;">
                <h5 style="font-weight: 400; color: #FFFFFF;"><?= strtoupper(date('M', strtotime($event['start_date']))) ?></h5>
                <h5 style="font-family:'Poppins'; font-size: 40px; font-weight: 600; color: #FFFFFF;"><?= date('j', strtotime($event['start_date'])) ?></h5>
            </div>
            <div class="event-details" style="margin-left: 15px;">
                <h5 class="details" style="color: #000;"><?= htmlspecialchars($event['title']) ?></h5>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="box-event">
        <h5 style="color: #000;">No events added</h5>
    </div>
<?php endif; ?>

        </div>
    </div>
</div>


            <div class="col-xs-12 col-md-4"> 
              <div class="card" style="margin-bottom: 15px;">
                      <div class="box bg-info" style="background: #FFFFFF;  box-shadow: inset 0 0 0 0.5px #BAB9B9, 2px 3px 5px rgb(126, 142, 159);">
                      <div class="card-head">
                          <h5 class="font-light title" style="color: #4C644B;">Today's Attendance</h5>
                          <button class="view-users-btn" onclick="window.location.href='./index.php?url=attendance';">View Details</button>
                      </div>    
                          <canvas id="attendanceChart" style="width: 80%; height: auto;"></canvas>
                  </div>
              </div>

              <?php
// PHP to fetch attendance data and pass to JavaScript
include("../connect.php");

$selectedDate = date('Y-m-d');
$teacher_id = $_SESSION['user_id'];

$query = "SELECT 
              SUM(CASE WHEN status_am = 'Present' OR status_pm = 'Present' THEN 1 ELSE 0 END) AS present_count,
              SUM(CASE WHEN status_am = 'Absent' AND status_pm = 'Absent' THEN 1 ELSE 0 END) AS absent_count
          FROM attendance 
          WHERE attendance_date = ? AND teacher_id = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param("ss", $selectedDate, $teacher_id);
$stmt->execute();
$stmt->bind_result($presentCount, $absentCount);
$stmt->fetch();
$stmt->close();

$totalCount = $presentCount + $absentCount;
$presentPercentage = $totalCount > 0 ? round(($presentCount / $totalCount) * 100) : 0;
$absentPercentage = $totalCount > 0 ? round(($absentCount / $totalCount) * 100) : 0;

echo "<script>
    const attendanceData = {
        present: $presentPercentage,
        absent: $absentPercentage
    };
</script>";
?>


    
      </div>
<div class="col-xs-12 col-md-4">
        <div class="card" style="margin-bottom: 15px;">
            <div class="box bg-info" style="box-shadow: inset 0 0 0 0.5px #BAB9B9, 2px 3px 5px rgb(126, 142, 159);">
                <div class="card-head" style="margin-bottom: 10px;">
                    <h5 class="font-light title" style="color: #4C644B;">Announcements</h5>
                    <button class="view-users-btn" onclick="window.location.href='index.php?url=announcement';">View More</button>
                </div>
                <?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="box-content">
            <h5 class="details" style="color: #fff;"><?= htmlspecialchars($row['title']) ?></h5>
            <h6 class="posted" style="color: #fff;">Posted by: Admin</h6>
            <h6 class="date" style="color: #fff; font-size: 10px"><?= date('F j, Y', strtotime($row['date'])) ?></h6>
            <a href="./index.php?url=announcementdetails&id=<?php echo $row['id']; ?>" class="read-btn">Read</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="box-content">
        <h5 style="color: #fff;">No announcements added</h5>
    </div>
<?php endif; ?>

            </div>
        </div>
</div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: 'dashboard/total_users.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var ctx = document.getElementById('pieChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Teachers', 'Students', 'Parents'],
                        datasets: [{
                            label: 'Total Users',
                            data: [data.total_teachers, data.total_students, data.total_parents],
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                display: true,
                                formatter: function(value, context) {
                                    var dataset = context.chart.data.datasets[0];
                                    var total = dataset.data.reduce((a, b) => a + b, 0);
                                    var percentage = (value / total * 100).toFixed(2) + '%';
                                    return percentage; // Display percentage
                                },
                                font: {
                                    weight: 'bold',
                                    size: 14
                                },
                                anchor: 'center',
                                align: 'center',
                                padding: 4
                            }
                        }
                    },
                    plugins: [ChartDataLabels] // Register the plugin
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error - Status:', status);
                console.error('AJAX Error - Error:', error);
                console.error('AJAX Error - Response Text:', xhr.responseText);
                console.error('AJAX Error - Status Code:', xhr.status);
                console.error('AJAX Error - Headers:', xhr.getAllResponseHeaders());
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('attendanceChart').getContext('2d');

        // Custom plugin to center the percentage and add additional text
        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw(chart) {
                const { width, height } = chart; // Chart dimensions
                const ctx = chart.ctx;
                ctx.save();

                const presentPercentage = attendanceData.present; // Percentage from PHP

                // Calculate the center of the canvas
                const centerX = chart.getDatasetMeta(0).data[0].x;
                const centerY = chart.getDatasetMeta(0).data[0].y;

                // Draw the percentage text
                ctx.font = 'bold 36px Arial'; // Font size and style
                ctx.fillStyle = '#4C644B'; // Text color
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(`${presentPercentage}%`, centerX, centerY - 10); // Shift slightly up

                // Draw the additional text below
                ctx.font = '16px Arial'; // Smaller font for "Present"
                ctx.fillStyle = '#4C644B'; // Match color with percentage
                ctx.fillText('Present', centerX, centerY + 25); // Position below percentage

                ctx.restore();
            }
        };

        // Register the plugin
        Chart.register(centerTextPlugin);

        // Render the chart
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent'],
                datasets: [{
                    data: [attendanceData.present, attendanceData.absent],
                    backgroundColor: ['#0092D1', '#f5b041'], // Colors
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.label}: ${context.raw}%`;
                            }
                        }
                    }
                },
                cutout: '75%', // Controls hollow area size
                layout: {
                    padding: 20
                }
            }
        });
    });
</script>


</body>
</html>
