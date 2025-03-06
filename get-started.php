<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="assets/images/JCCA-LOGO.png">
    <title>Track4Success</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            background-color: #f3f7ff;
        }

        #features {
            text-align: center;
        }

        h1 {
            font-weight: 900;
            font-size: 2rem;
            color: #2C4E80;
        }

        @media (min-width: 768px) {
            h1 {
                font-size: 3rem;
            }
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
        }

        .card-body h5 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2C4E80;
            text-align: center;
            margin-top: 10px;
        }

        .card a {
            text-decoration: none !important; /* Removes underline from links */
            color: inherit;                  /* Ensures the original text color */
            display: block;                  /* Makes the entire card clickable */
        }

        .card-title {
            text-decoration: none; /* Explicitly remove underline */
        }

        @media (min-width: 576px) {
            .card img {
                height: 250px;
            }

            .card-body h5 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <section id="features">
        <div class="container">
            <h1 class="text-center mb-5">Login as</h1>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
                <!-- Student Card -->
                <div class="col">
                    <a href="student/login.php" style="text-decoration: none;">
                        <div class="card">
                            <img src="assets/images/students/student-login.png" class="card-img-top" alt="Student Login">
                            <div class="card-body">
                                <h5 class="card-title">STUDENT</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Parent Card -->
                <div class="col">
                    <a href="parent/login.php" style="text-decoration: none;">
                        <div class="card">
                            <img src="assets/images/parent/parent-login.png" class="card-img-top" alt="Parent Login">
                            <div class="card-body">
                                <h5 class="card-title">PARENT</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Teacher Card -->
                <div class="col">
                    <a href="teacher/login.php" style="text-decoration: none;">
                        <div class="card">
                            <img src="assets/images/teacher/teacher.png" class="card-img-top" alt="Teacher Login">
                            <div class="card-body">
                                <h5 class="card-title">TEACHER</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
