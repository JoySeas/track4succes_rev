<?php
include("../connect.php");

// Get the announcement ID from the URL
$announcement_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the details of the selected announcement
$sql = "SELECT * FROM announcements WHERE id = $announcement_id";
$result = mysqli_query($connection, $sql);
$announcement = mysqli_fetch_assoc($result);

if (!$announcement) {
    echo "<p>Announcement not found.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins|Montserrat' rel='stylesheet'>
    <style type="text/css">
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .announcement-container {
            display: flex;
            flex-direction: row;
            margin: 1rem;
            border-radius: 5px;
            overflow: hidden;
        }
        .announcement-image {
            flex: 1;
            min-width: 150px;
            position: relative;
        }
        .announcement-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .announcement-content {
            flex: 2;
            padding: 1rem;
        }
        .announcement-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .announcement-date {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 1rem;
        }
        .announcement-text {
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .see-more {
            color: #007bff;
            cursor: pointer;
            text-align: right;
            display: block;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
            justify-content: center;
            align-items: center;
            padding-left: 240px;
            padding-top: 65px;
        }
        .modal-content {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
        }
        .close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .announcement-container {
                flex-direction: column;
            }
            .announcement-image {
                min-width: 100%;
            }
            .announcement-content {
                padding: 0.5rem;
            }
            .modal {
                display: none; /* Hide modal on smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="announcement-container">
        <div class="announcement-image">
            <img id="announcementImage" src="<?php echo '../admin/uploads/' . basename($announcement['image_path']); ?>" alt="Announcement Image">
        </div>
        <div class="announcement-content">
            <div class="announcement-title"><?php echo htmlspecialchars($announcement['title']); ?></div>
            <div class="announcement-date"><?php echo date("F j, Y", strtotime($announcement['date'])); ?></div>
            <div class="announcement-text">
                <?php echo nl2br(htmlspecialchars($announcement['content'])); ?>
            </div>
            <a class="see-more" href="./index.php?url=announcement">Back to Announcements</a>
        </div>
    </div>

    <!-- Modal -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("imageModal");

        // Get the image and insert it inside the modal
        var img = document.getElementById("announcementImage");
        var modalImg = document.getElementById("modalImage");
        var span = document.getElementsByClassName("close")[0];

        img.onclick = function(){
            // Only show modal if screen width is greater than 768px
            if (window.innerWidth > 768) {
                modal.style.display = "flex";
                modalImg.src = this.src;
            }
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Hide modal on resize
        window.onresize = function() {
            if (window.innerWidth <= 768) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>

<?php
mysqli_close($connection);
?>
