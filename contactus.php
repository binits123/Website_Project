<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTACT US</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.2/css/fontawesome.min.css"
        integrity="sha384-X8QTME3FCg1DLb58++lPvsjbQoCT9bp3MsUU3grbIny/3ZwUJkRNO8NPW6zqzuW9" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="assets/contactus.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/footer.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,500;1,100;1,200&
family=Roboto:ital,wght@0,100;0,300;1,100&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
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
    <section class="contact">
        <div class="content">
            <h2> CONTACT US</h2>

        </div>
        <div class="content2">
            <div class="contactinfo">
                <div class="box">
                    <div class="icon"> <i class="fa fa-map-marker" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3> Address</h3>
                        <p> Tinkune,Kathmandu</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"> <i class="fa fa-phone" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3> Phone no</h3>
                        <p> 4112252,4112403</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"> <i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3> E-mail</h3>
                        <p> xyz@test.com</p>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <footer class="footer">
        <div class="row">
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Products</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul class="info">
                    <li>
                        <span><i class="bi bi-telephone"></i></span>
                        <p>
                            <a href="#">(555) 123-4567</a>
                        </p>
                    </li>
                    <li>
                        <span><i class="bi bi-envelope-at-fill"></i></span>
                        <p>
                            <a href="#">info@shoeshop.com</a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>