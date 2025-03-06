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
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faqs">FAQs</a></li>
                    <li class="nav-item"><a class="nav-link" href="about-us.php">About</a></li>
                    <li class="nav-item">
                    <a href="get-started.php" class="btn get-started">Get Started</a>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <div class="text">
                        <h1>There’s a lot <br>to explore!</h1>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="assets/images/Home.svg" alt="Character, Laptop, and Mobile" class="combined-image">
                </div>
            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section id="features">
        <div class="container">
            <h1 class="text-center mb-5" style="font-weight:900; font-size: 3em; color: #2C4E80">Features to explore</h1>
            <div class="row">
                <!-- Top Row Cards -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/group.png" class="card-img-top" alt="Feature 1">
                        <div class="card-body">
                            <h5 class="card-title">Student & Parent Portal</h5>
                            <p class="card-text">Students and Parents has their own portal to View Profile, Update Information, Manage Account, track and manage student performances. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/user.png" class="card-img-top" alt="Feature 2" style="width: 60px; ">
                        <div class="card-body">
                            <h5 class="card-title">Teacher Portal</h5>
                            <p class="card-text">Teacher has their own portal to manage their account, enroll student, post their grades, attendance and behavior reports. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/best.png" class="card-img-top" alt="Feature 3">
                        <div class="card-body">
                            <h5 class="card-title">Grades</h5>
                            <p class="card-text">Student and Parents can view grades and check academic performance.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Bottom Row Cards -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/available.png" class="card-img-top" alt="Feature 4">
                        <div class="card-body">
                            <h5 class="card-title">Attendance</h5>
                            <p class="card-text">This feature allows students and parents to monitor attendance records, ensuring timely updates on class participation.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/behavior.png" class="card-img-top" alt="Feature 5" style="width: 70px; margin-top: 5px;">
                        <div class="card-body">
                            <h5 class="card-title">Student Behavior</h5>
                            <p class="card-text">Teachers can track and report on student behavior, providing insights into student conduct and progress.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/event.png" class="card-img-top" alt="Feature 6" style="width: 70px; margin-top: 5px;">
                        <div class="card-body">
                            <h5 class="card-title">Calendar of Events</h5>
                            <p class="card-text">A comprehensive calendar displaying upcoming events, holidays, and important school dates.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Bottom Row Cards -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/announcement.png" class="card-img-top" alt="Feature 4">
                        <div class="card-body">
                            <h5 class="card-title">Announcement</h5>
                            <p class="card-text">A featureschool administrators to post announcements, keeping students, teachers, and parents informed.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/schedule.png" class="card-img-top" alt="Feature 5" style="width: 70px; margin-top: 5px;">
                        <div class="card-body">
                            <h5 class="card-title">Schedule</h5>
                            <p class="card-text">Students and parents can view class schedules, helping with time management and planning.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/landingpage/download.png" class="card-img-top" alt="Feature 6">
                        <div class="card-body">
                            <h5 class="card-title">Report Generation</h5>
                            <p class="card-text">Teachers and Parents can generate report that includes student grades. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
<!-- FAQs Section -->
<section id="faqs" class="py-5">
    <div class="container">
        <h1 class="text-center mb-5" style="font-weight:900; font-size: 3em; color: #2C4E80;">Frequently Asked Questions</h1>
        <div class="accordion" id="faqAccordion">
            <!-- FAQ 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                        What is Track4Success?
                    </button>
                </h2>
                <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Track4Success is a tracking and assessment system for academic performance of Junior High School students in Jesus Cares Christian Academy. 
                    </div>
                </div>
            </div>
            <!-- FAQ 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                        How do I access my account?
                    </button>
                </h2>
                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        You can access your account by visiting the login page, where you will be required to enter your username and password. In case ypu don't have an account, go to the sign up page to create one. 
                    </div>
                </div>
            </div>
            <!-- FAQ 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                        Can I update my personal information?
                    </button>
                </h2>
                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, both students, parents, teachers, and school administrators can update their personal information through their respective portals at any time.
                    </div>
                </div>
            </div>
            <!-- FAQ 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                        How can I view my grades?
                    </button>
                </h2>
                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Grades can be accessed by logging into the student portal. You can view grades for each quarter and your overall performance.
                        Parents can login to their respective portals and update student number to view thier childs grades and other related academic performance such as attendance and behavior. 
                    </div>
                </div>
            </div>
            <!-- FAQ 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                        How do I enroll in a subject?
                    </button>
                </h2>
                <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Teachers can enroll students by accessing the teacher portal and uploading student data. Students can then view their enrolled subjects in the student portal.
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
            <a href="#home" class="text-white me-3 text-decoration-none">Home</a>
            <a href="#features" class="text-white me-3 text-decoration-none">Features</a>
            <a href="#faqs" class="text-white me-3 text-decoration-none">FAQs</a>
            <a href="terms.php" class="text-white me-3 text-decoration-none">Terms & Conditions</a>
            <a href="about-us.php" class="text-white me-3 text-decoration-none">Developers</a>
        </p>
    </div>
</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
