<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="assets/header.css">
    <title> About us </title>
    <link rel="stylesheet" href="assets/aboutus.css">
</head>

<body>
    <header class="header">
        <a href="#" class="logo">XYZshoe</a>

        <nav class="navbar">
            <a href="welcome.php">HOME</a>
            <a href="index.php">LOG IN</a>
            <a href="shop.php">SHOP</a>
            <a href="contactus.php">CONTACT</a>
            <a href="aboutus.php">ABOUT US</a>

        </nav>

        <div class="navbar-icon" onclick="toggleNavbar()">
            <i class="bi bi-list"></i>
        </div>
    </header>

    <script>
        function toggleNavbar() {
            var navbar = document.querySelector('.navbar');
            navbar.classList.toggle('show');
        }
    </script>



    <section class="course">
        <h1> ABOUT US </h1>
        <p class="intro"> Welcome to Shoe Shop, where we believe that every step matters.
            Our journey began with a passion for quality footwear and a commitment
            to providing our customers with the perfect pair of shoes for every occasion. </p>
        <div class="row">
            <div class="course-col">

                <h3> OUR STORY </h3>
                <p> <b>The Story of XYZ Store </b><br><br>
                    At Shoe Shop, our mission is to help you put your
                    best foot forward. We are dedicated to providing you
                    with comfortable, stylish, and durable shoes that
                    complement your lifestyle. Whether you're heading to work,
                    going for a run, or attending a special event,
                    we have the perfect pair for you.</p>

                </p>

            </div>





            <div class="course-col">
                <h3>OUR MISSION</h3>
                <p><b> The mission of XYZ store</b><br><br>
                    At Shoe Shop, our mission is to help you put your
                    best foot forward. We are dedicated to providing you
                    with comfortable, stylish, and durable shoes that
                    complement your lifestyle. Whether you're heading to work,
                    going for a run, or attending a special event,
                    we have the perfect pair for you.</p>
            </div>

            <div class="course-col">
                <h3> OUR ACHIVEMENT</h3>
                <p> <b>Our Achivement of XYZ Store </b><br><br>
                    At Shoe Shop, our mission is to help you put your
                    best foot forward. We are dedicated to providing you
                    with comfortable, stylish, and durable shoes that
                    complement your lifestyle. Whether you're heading to work,
                    going for a run, or attending a special event,
                    we have the perfect pair for you.</p>

            </div>


        </div>
    </section>

</body>

</html>
</head>