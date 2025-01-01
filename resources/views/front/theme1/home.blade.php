<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset(asset_path('assets/frontend/favicon.ico')) }}" type="image/x-icon">
    <title>Elequip Tools Private Limited</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.min.js"></script>

    <style>
        .main_wrapper {
            background-image: linear-gradient(to left, #130202f2, #100101d9), url({{ asset(asset_path('assets/frontend/elequip-home-bg-2.jpg')) }});
            background-repeat: no-repeat;
            background-size: cover;
            width: 100vw;
            height: 100vh;
        }

        .logo_wrapper>img {
            max-height: 170px;
            text-align: center;
        }

        .landing_img_wrap {
            /*position:absolute;*/
            top: 0;
            left: 0;
        }

        .landing_text_wrap {
            /*position:absolute;*/
            top: 0;
            left: 0;
            z-index: 11;
        }

        .landing_text_wrap {
            display: flex;
            justify-content: center;
            /*align-items:center;*/
            height: 100%;
            color: #fff;
        }

        .top_text {
            margin-top: 20px;
            color: #fff;
            /* text-shadow: 1px 1px 5px rgb(234 90 36); */
            text-transform: uppercase;
            text-align: center;
            -webkit-animation: glow 1s ease-in-out infinite alternate;
            -moz-animation: glow 1s ease-in-out infinite alternate;
            animation: glow 1s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 10px #ea5b24
            }

            to {
                text-shadow: 0 0 20px #ea5b24, 0 0 30px #ea5b24
            }
        }

        .top_sub_text {
            color: #fff;
            text-align: center;
            font-style: italic;
            font-size: 21px;
        }

        .md_logo_wrap {
            text-align: center;
        }

        .md_logo_wrap>img {
            /* width: 80px; */
            height: 80px;
        }

        .text-wrap p {
            line-height: 35px;
            font-size: 21px;
        }

        .bottom_link_wrapper {
            margin-top: 40px;
        }

        .social_links_wrap {
            background-color: #fff;
            padding: 10px;
        }

        .social_links {
            list-style-type: none;
            display: flex;
            justify-content: space-evenly;
            margin: 0;
            padding: 0;
        }

        .social_links li a img {
            height: 40px;
        }

        .bottom_text {
            color: #fff;
            font-size: 21px;
            text-align: center;
            margin-bottom: 0;
        }

        .bottom_link {
            text-align: right;
        }

        .bottom_link>a {
            color: #ea5b24;
            text-decoration: none;
        }

        @media (max-width:576px) {
            .main_wrapper {
                height: 100%;
            }
        }
    </style>

</head>

<body>
    <div class="main_wrapper">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="col-lg-10 p-0 offset-lg-1">
                    <div class="landing_wrapper">
                        <div class="container">
                            <div class="landing_logo_top">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="logo_wrapper">
                                            <img class="img-fluid" src="{{ asset(asset_path('assets/frontend/logo.png')) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>


                                    <div class="col-sm-8">
                                        <h1 class="top_text">Elequip Tools Private Limited</h1>
                                        <p class="top_sub_text">Leaders in Material Handling Equipments <span
                                                style="color:#ea5a24;">since 1966</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="middle-logo">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <div class="md_logo_wrap">
                                            <img class="img-fluid" src="{{ asset(asset_path('assets/frontend/ISO_9001-2015sm.png')) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="md_logo_wrap">
                                            <img class="img-fluid" src="{{ asset(asset_path('assets/frontend/wGEM-removebg-preview.png')) }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="md_logo_wrap">
                                            <img class="img-fluid" src="{{ asset(asset_path('assets/frontend/50-year.png')) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="md_logo_wrap">
                                            <img class="img-fluid" src="{{ asset(asset_path('assets/frontend/msme.png')) }}" alt="">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="text-wrap my-3">
                                <p class="text-light">Indef Chain pulley blocks | Electric hoists | Overhead Crane |
                                    Goods Elevator | Hydraulic fork Lifts | Scissor Lifts | Automation equipment | Push
                                    button pendants | Cable carrier system | Lifting tools | Crane power transmission |
                                    Manual tow trolley | Service & Spares | Turnkey projects |</p>
                            </div>

                            <div class="bottom_link_wrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="social_links_wrap">
                                            <ul class="social_links">
                                                <li><a href="#"><img class="img-fluid"
                                                            src="{{ asset(asset_path('assets/frontend/linkedin.png')) }}" alt=""></a></li>
                                                <li><a href="#"><img class="img-fluid"
                                                            src="{{ asset(asset_path('assets/frontend/facebook.png')) }}" alt=""></a></li>
                                                <li><a href="#"><img class="img-fluid"
                                                            src="{{ asset(asset_path('assets/frontend/youtube.png')) }}" alt=""></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="bottom_text">Click to visit our website</p>
                                        <h3 class="bottom_link"><a href="https://ehoists.in/">www.ehoists.in</a></h3>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="landing_text_wrap">
                            <div class="text-center">
                                <h1>Welcome to Elequip Tools Private Limited</h1>
                                <h3>19, Pollock Street, 2nd Floor, Kolkata - 700 001 West Bengal - India</h3>
                                <h3>(+91) 96743 22207</h3>
                                <h3>elequipsales@gmail.com</h3>
                            </div>
                        </div> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
