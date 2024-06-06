<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>Reader | Hugo Personal Blog Template</title>

    <!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="This is meta description">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Hugo 0.74.3" />

    <!-- theme meta -->
    <meta name="theme-name" content="reader" />

    <!-- plugins -->
    <link rel="stylesheet" href="../../../web/plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../../web/plugins/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../../../web/plugins/slick/slick.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="../../../web/css/style.css" media="screen">

    <!--Favicon-->
    <link rel="shortcut icon" href="web/images/favicon.png" type="image/x-icon">
    <link rel="icon" href="web/images/favicon.png" type="image/x-icon">

    <meta property="og:title" content="Reader | Hugo Personal Blog Template" />
    <meta property="og:description" content="This is meta description" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:updated_time" content="2020-03-15T15:40:24+06:00" />

    <style>
        .recent-blog-img {
            height: 400px;
        }

        .image-container {
            height: 200px;
            /* Adjust as needed */
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    @include('web.layouts.header')

    @yield('contents')

    <footer class="footer">
        <svg class="footer-border" height="214" viewBox="0 0 2204 214" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M2203 213C2136.58 157.994 1942.77 -33.1996 1633.1 53.0486C1414.13 114.038 1200.92 188.208 967.765 118.127C820.12 73.7483 263.977 -143.754 0.999958 158.899"
                stroke-width="2" />
        </svg>



        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 text-center text-md-left mb-4">
                    <ul class="list-inline footer-list mb-0">
                        <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="terms-conditions.html">Terms Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-2 text-center mb-4">
                    <a href="index.html"><img class="img-fluid" width="100px" src="images/logo.png"
                            alt="Reader | Hugo Personal Blog Template"></a>
                </div>
                <div class="col-md-5 text-md-right text-center mb-4">
                    <ul class="list-inline footer-list mb-0">

                        <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a></li>

                        <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a></li>

                        <li class="list-inline-item"><a href="#"><i class="ti-linkedin"></i></a></li>

                        <li class="list-inline-item"><a href="#"><i class="ti-github"></i></a></li>

                        <li class="list-inline-item"><a href="#"><i class="ti-youtube"></i></a></li>

                    </ul>
                </div>
                <div class="col-12">
                    <div class="border-bottom border-default"></div>
                </div>
            </div>
        </div>
    </footer>


    <!-- JS Plugins -->
    <script src="../../../web/plugins/jQuery/jquery.min.js"></script>

    <script src="../../../web/plugins/bootstrap/bootstrap.min.js"></script>

    <script src="../../../web/plugins/slick/slick.min.js"></script>

    <script src="../../../web/plugins/instafeed/instafeed.min.js"></script>


    <!-- Main Script -->
    <script src="../../../web/js/script.js"></script>
</body>

</html>