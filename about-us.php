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
            font-family: 'Poppins', sans-serif;
            background-color: #f3f7ff;
        }

        .navbar {
            background-color: white;
            border-bottom: 2px solid #e6e6e6;
            padding: 0.30rem 2rem;
        }

        .navbar-brand img {
            width: 200px;
            height: auto;
        }

        .navbar-nav .nav-link {
            color: #333;
            font-weight: bold;
            margin-right: 1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #ff5733;
        }

        .get-started {
            background-color: #ff5733;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-size: 1em;
            cursor: pointer;
        }

        .get-started:hover {
            background-color: #ff6b4a;
        }

        main {
            background: linear-gradient(180deg, #5D9EFE 45%, #6E92C6 58%, #6E92C6 100%);
            padding: 100px 0;
        }

        .text h1 {
            font-size: 5em;
            color: white;
            font-weight: bolder;
            margin-left: -20px;
        }
        .card{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .combined-image {
            width: 150%;
            height: auto;
            margin-left: -150px;
        }

        /* Features Section */
        #features {
            padding: 60px 0;
            background-color: #fff;
        }

        .card-body h5 {
            font-size: 1.2em;
            font-weight: bold;
        }

        .card-body p {
            font-size: 1em;
            color: #777;
        }

        .card-deck .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .text h1 {
                font-size: 2.5em;
            }
            .combined-image {
                width: 100%;
                height: auto;
                margin-left: 20px;
            }
        }
        .card-title{
            color: #2C4E80;
        }
        .card-img-top{
           width: 80px; 
           margin-left: 5px;
        }
        footer {
    background-color: #2C4E80;
    color: white;
    font-size: 0.9em;
    padding: 20px 0;
}

footer a {
    color: #ff5733;
    transition: color 0.3s ease;
}

footer a:hover {
    color: #ff6b4a;
}

  /* Developer Section Styles */
  #developers .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    #developers .card-img-top {
        width: 100%; /* Ensures the image fills the card's width */
        height: auto; /* Maintains aspect ratio */
    }

    #developers .card-body h5 {
        font-size: 1.2em;
        font-weight: bold;
    }

    #developers .card-body p {
        font-size: 1em;
        color: #777;
    }

    /* Responsive Adjustment for Smaller Screens */
    @media (max-width: 768px) {
        #developers .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/images/track4success-logo.png" alt="Track4Success Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#faqs">FAQs</a></li>
                    <li class="nav-item"><a class="nav-link" href="about-us.php">About</a></li>
                    <li class="nav-item">
                    <a href="get-started.php" class="btn get-started">Get Started</a>
                </li>
                </ul>
            </div>
        </div>
    </nav>
    

<!-- Developers Section -->
<section id="developers" class="py-5" style="margin-top: 50px;">
    <div class="container">
        <h1 class="text-center mb-5" style="font-weight:900; font-size: 3em; color: #2C4E80;">Meet the Developers</h1>
        <div class="row">
            <!-- Developer 1 Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/images/latuna.jpg" class="card-img-top" alt="Developer 1">
                    <div class="card-body">
                        <h5 class="card-title">John Elbert Latuna</h5>
                        <p class="card-text">Back-End Developer</p>
                    </div>
                </div>
            </div>
            <!-- Developer 2 Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/images/developer2.jpg" class="card-img-top" alt="Developer 2">
                    <div class="card-body">
                        <h5 class="card-title">Julie Franz Imperial</h5>
                        <p class="card-text">UI/UX Designer</p>
                    </div>
                </div>
            </div>
            <!-- Developer 3 Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/images/santiago.jpg" class="card-img-top" alt="Developer 3">
                    <div class="card-body">
                        <h5 class="card-title">Francis Santiago</h5>
                        <p class="card-text">Front-End Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <p class="mb-1">&copy; 2024 Track4Success. All Rights Reserved.</p>
        <p class="mb-0">
            <a href="index.php" class="text-white me-3 text-decoration-none">Home</a>
            <a href="index.php" class="text-white me-3 text-decoration-none">Features</a>
            <a href="index.php" class="text-white me-3 text-decoration-none">FAQs</a>
            <a href="terms.php" class="text-white me-3 text-decoration-none">Terms & Conditions</a>
            <a href="about-us.php" class="text-white  me-3 text-decoration-none"> Developers</a>
        </p>
    </div>
</footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
