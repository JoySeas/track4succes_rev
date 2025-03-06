<?php
include("../connect.php");

// Get the current date
$current_date = date('Y-m-d');

// Fetch upcoming (valid) announcements
$sql_upcoming = "SELECT * FROM announcements WHERE date >= ? ORDER BY date DESC";
$stmt_upcoming = $connection->prepare($sql_upcoming);
$stmt_upcoming->bind_param("s", $current_date);
$stmt_upcoming->execute();
$result_upcoming = $stmt_upcoming->get_result();

// Fetch past (done) announcements
$sql_past = "SELECT * FROM announcements WHERE date < ? ORDER BY date DESC";
$stmt_past = $connection->prepare($sql_past);
$stmt_past->bind_param("s", $current_date);
$stmt_past->execute();
$result_past = $stmt_past->get_result();

function truncateContent($content, $wordLimit = 7) {
    $words = explode(' ', $content);
    if (count($words) > $wordLimit) {
        return implode(' ', array_slice($words, 0, $wordLimit)) . '...';
    }
    return $content;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins|Montserrat' rel='stylesheet'>
    <style type="text/css">
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
        .pagination .active {
            background-color: #3a4651;
            color: white !important;
        }
        .table thead th, .table th {
            background-color: #9e9e9e !important;
        }
        .swal2-icon {
            margin-bottom: 10px !important;
        }
        .modalpaddingnew {
            padding-left: 5px;
            margin-bottom: 10px;
        }
        .box img {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
        }
        .fixed-size-card {
            width: 335px; /* Fixed width */
            height: 334px; /* Fixed height */
            margin-bottom: 15px;
            box-shadow: 2px 3px 5px rgb(126, 142, 159);
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Ensure overflow content is hidden */
        }
        .fixed-size-card img {
            height: 150px; /* Fixed height for the image */
            object-fit: cover; /* Ensure the image covers the area */
            width: 100%;
        }
        .box {
            background: #FFFFFF;
            box-shadow: 2px 3px 5px rgb(126, 142, 159);
            padding: 1rem;
            flex: 1; /* Allow box to grow and fill remaining space */
            display: flex;
            flex-direction: column;
        }
        .content {
            overflow: hidden;
            height: 80px; /* Fixed height for content area */
            position: relative;
        }
        .see-more {
            color: #007bff;
            cursor: pointer;
            display: block;
            text-align: right;
            margin-top: 0.5rem;
        }
        @media (max-width: 576px) {
            .card-body {
                padding: 0.5rem;
            }
            .fixed-size-card {
                width: 100%; /* Full width on smaller screens */
            }
            .page-titles {
                padding-bottom: 0;
            }
            h3 {
                font-size: 20px; /* Smaller font size */
                margin-bottom: 1rem; /* Adjust margins */
                margin-top: 0.5rem;
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
                        <div class="col-md-6 col-6" style="padding-left: 1rem;">
                            <h3 style="font-family: 'Poppins'; font-weight: 400; font-size: 25px; margin-bottom: 2rem; margin-top: 1rem;">Announcements</h3>
                        </div>
                        <div class="col-md-6 text-right" style="padding-right: 1rem;">
                        <a href="./index.php?url=announcement">
                        <button class="btn" style="background: #2C4E80; border-radius: 10px; color: #FFFFFF; margin-top: 1rem;margin-bottom: 2rem;">See Newly Posted</button></a>
                    </div>
                    </div>


                    <!-- Past Announcements -->
                    <div class="row">
                        <?php if ($result_past->num_rows > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result_past)): ?>
                                <div class="col-xs-12 col-md-4">
                                    <div class="fixed-size-card">
                                        <img src="<?php echo '../admin/uploads/' . basename($row['image_path']); ?>" alt="">
                                        <div class="box">
                                            <div class="title">
                                                <h5><?php echo $row['title']; ?></h5>
                                            </div>
                                            <div class="content">
                                                <h6>
                                                    <?php echo substr($row['content'], 0, 100); ?>...
                                                    <a class="see-more" href="./index.php?url=announcementdetails&id=<?php echo $row['id']; ?>">See More</a>
                                                </h6>       
                                            </div>
                                            <div class="author">
                                                <h6><?php echo date("F j, Y", strtotime($row['date'])); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>No past announcements available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($connection);
?>
