<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track4Success Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f0ff;
            color: #333;
        }
        .navbar {
            background-color: white;
        }
        .navbar-brand {
            font-weight: bold;
            color: #ff6600;
        }
        .navbar-brand span {
            color: #4d4dff;
        }
        .navbar-nav .nav-link {
            color: #333;
            font-weight: bold;
        }
        .hero-section {
            background-color: #b3daff;
            padding: 100px 20px;
            text-align: center;
            position: relative;
        }
        .hero-text {
            font-size: 48px;
            font-weight: bold;
            color: white;
        }
        .hero-image {
            position: absolute;
            bottom: -20px;
            right: 10%;
            max-width: 400px;
        }
        .hero-image img {
            width: 100%;
            max-width: 300px;
        }
        .get-started-btn {
            background-color: #ff6600;
            color: white;
            font-weight: bold;
            padding: 10px 30px;
            border-radius: 50px;
            border: none;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
            <img src="assets/images/track4success-logo.png" alt="Track4Success Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
                <button class="btn get-started-btn ms-3">Get Started</button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex flex-column justify-content-center align-items-center">
        <div class="container text-center">
            <h1 class="hero-text">There's a lot to explore!</h1>
            <div class="d-flex justify-content-center mt-4">
            <img src="assets/images/home.png" alt="Character, Laptop, and Mobile" class="combined-image">
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
