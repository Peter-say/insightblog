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
    {{-- <title>Reader | Hugo Personal Blog Template</title>

    <!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="This is meta description">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Hugo 0.74.3" />
    <meta property="og:title" content="Reader | Hugo Personal Blog Template" />
    <meta property="og:description" content="This is meta description" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:updated_time" content="2020-03-15T15:40:24+06:00" /> --}}

    <title>{{ $metaData->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{{ $metaData->description }}">
    <meta name="keywords" content="{{ $metaData->keywords }}">
    <meta property="og:title" content="{{ $metaData->title }}">
    <meta property="og:description" content="{{ $metaData->description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $metaData->og_url }}">
    <meta property="og:image" content="{{ $metaData->og_image }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">


    <!-- theme meta -->
    <meta name="theme-name" content="reader" />

    <!-- plugins -->
    <link rel="stylesheet" href="{{ asset('web/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/plugins/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('web/plugins/slick/slick.css') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}" media="screen">

    <!--Favicon-->
    <link rel="shortcut icon" href="{{ asset('web/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('web/images/favicon.png') }}" type="image/x-icon">

   
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

        .avatar-img-fluid-container img {
            height: 60px;
            width: 60px;
        }

        .avatar-img-fluid {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <style>
        #popup-message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            text-align: center;
            z-index: 9999;
        }

        .popup-message.success {
            background-color: green;
            color: #ffffff
        }

        .popup-message.error {
            background-color: red;
        }

        #cancel-popup {
            font-size: 24px;
            color: #ffffff;
            cursor: pointer;
        }
    </style>
</head>

<body>
   
    @include('web.layouts.header')

    @include('notifications.pop-up')
    
   
   
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
                    <a href="index.html"><img class="img-fluid" width="100px" src="{{ asset('web/images/logo.png') }}"
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

    <script>
        var popup = document.getElementById('popup-message');

        if (popup) {
            setTimeout(function() {
                popup.style.display = 'none';
            }, 8000);

            // Hide the pop-up when clicking the close button
            var closeButton = document.getElementById('cancel-popup');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    popup.style.display = 'none';
                });
            }
        }

        window.addEventListener('load', function() {
            document.getElementById('search-query').addEventListener('keyup', function() {
                var currentSearchResultsHtml = $('#search-results').html(); // Save current search results
                var query = this.value;
                if (query.length > 0) { // Check if query is not empty
                    if (query.length > 2) {
                        $.ajax({
                            url: '{{ route('search') }}',
                            type: 'GET',
                            data: { search_terms: query },
                            success: function(data) {
                                $('#search-results').html(data.html);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    } else {
                        $('#search-results').empty();
                    }
                } else {
                    $('#search-results').empty();
                }
            });
        });
    </script>
    <!-- JS Plugins -->
    <script src="{{ asset('web/plugins/jQuery/jquery.min.js') }}"></script>

    <script src="{{ asset('web/plugins/bootstrap/bootstrap.min.js') }}"></script>

    <script src="{{ asset('web/plugins/slick/slick.min.js') }}"></script>

    <script src="{{ asset('web/plugins/instafeed/instafeed.min.js') }}"></script>


    <!-- Main Script -->
    <script src="{{ asset('web/js/script.js') }}"></script>
</body>

</html>
