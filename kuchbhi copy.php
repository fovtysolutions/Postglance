<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Footer</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .footer {
            background-image: url('path-to-your-image/footer-01.png');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 40px 0;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer .content {
            max-width: 1200px;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            text-align: left;
        }

        .footer .subscribe,
        .footer .links,
        .footer .shop,
        .footer .contact {
            flex: 1 1 200px;
            margin: 10px 20px;
        }

        .footer h4 {
            margin-bottom: 15px;
            font-size: 18px;
            text-transform: uppercase;
        }

        .footer .subscribe input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .footer .subscribe input[type="submit"] {
            padding: 10px 20px;
            background-color: #fff;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
        }

        .footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer ul li {
            margin: 8px 0;
        }

        .footer ul li a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
        }

        .footer ul li a:hover {
            opacity: 1;
        }

        .footer .contact p {
            margin: 8px 0;
        }

        .footer .contact p i {
            margin-right: 10px;
        }

        .footer .social-media {
            margin-top: 20px;
            text-align: center;
        }

        .footer .social-media a {
            color: white;
            font-size: 20px;
            margin: 0 10px;
            text-decoration: none;
            opacity: 0.8;
        }

        .footer .social-media a:hover {
            opacity: 1;
        }

        .footer .copyright {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .footer {
                padding: 20px 0;
            }

            .footer .content {
                flex-direction: column;
                align-items: center;
            }

            .footer .subscribe input[type="email"],
            .footer .subscribe input[type="submit"] {
                width: 100%;
                max-width: 300px;
            }

            .footer .social-media {
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="content">
            <div class="subscribe">
                <h4>Subscribe</h4>
                <input type="email" placeholder="Email ID">
                <input type="submit" value="Submit">
            </div>
            <div class="links">
                <h4>Important Links</h4>
                <ul>
                    <li><a href="#">Track your order</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Privacy & Policy</a></li>
                    <li><a href="#">Terms & Condition</a></li>
                    <li><a href="#">Return policy</a></li>
                </ul>
            </div>
            <div class="shop">
                <h4>Shop</h4>
                <ul>
                    <li><a href="#">Face wash</a></li>
                    <li><a href="#">Face serum</a></li>
                    <li><a href="#">Face mist</a></li>
                    <li><a href="#">Face moisturiser</a></li>
                </ul>
            </div>
            <div class="contact">
                <h4>Contact Us</h4>
                <p><i class="fa fa-phone"></i> (+91) - 1234 567800</p>
                <p><i class="fa fa-envelope"></i> email@gmail.com</p>
                <p><i class="fa fa-map-marker"></i> SCO 69, Huda Market, Sector 40 Rd, Sector 40, Gurugram</p>
            </div>
        </div>
        <div class="social-media">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <div class="copyright">
            &copy; RAMAERI All Rights Reserved © 2024
        </div>
    </footer>
</body>
</html>
