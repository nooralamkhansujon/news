<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Amarbangla</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{asset("images/ab-icon.jpg")}}">
    <link href="{{ asset('css/style.css?v=1.0.1') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('js/jquery.rwdImageMaps.min.js')}}"></script>
    <script src="{{asset('js/jquery.maphilight.min.js')}}"></script>
</head>
<body>
    <div class="header-container">
        <header class="container">
            <div style="position: relative; height: 130px">
                <img src="{{asset('images/logo.jpg')}}" style="position: absolute; left: -192px;"/>
                <div class="social-links-top">
                    <a href="#" >
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            
        </header>
    </div>
    
    <div class="header-redbar">
        <div class="container">
            <div class="mega-menu">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{url('about/ruhul-amin')}}">
                            <img src="{{asset('images/menu-img/02.png')}}" width="100%"/>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <!--<a href="{{url('about/nurul-alam')}}">-->
                        <!--    <img src="{{asset('images/menu-img/01.png')}}" width="100%"/>-->
                        <!--</a>-->
                    </div>
                    <div class="col-md-4">
                        <!--<a href="{{url('about/arif-sohel')}}">-->
                        <!--    <img src="{{asset('images/menu-img/03.png')}}"/>-->
                        <!--</a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('content')

    <div class="footer-container">
        <footer class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{asset('images/footer-logo.jpg')}}" class="img-fluid"/>
                    <div style="text-transform: uppercase;" class="contact-text">
                        <h6>Daily Amar Bangla</h6>
                        <p style="line-height: 1.5; font-size: 14px">
                            Bellview Tower<br>
                            71 Bir Uttam CR Dutta Road, <br> Hatirpool 
                            Dhaka-1205<br>
                            <b style="border-right: solid 2px #cf595e; width: 55px; display: inline-block">Phone</b> +88 02 41060270 <br>
                            <span style="margin-left: 59px">+88 02 41060271 </span><br>
                            <span style="font-size: 14px;"><b style="border-right: solid 2px #cf595e; width: 55px; display: inline-block">Email</b> <span style="text-transform: lowercase">info@amarbanglabd.com</span><br></span>
                            <span style="margin-left: 55px;"><a href="http://amarbanglabd.com" style="font-size: 14px">www.amarbanglabd.com</a><br></span>

                            
                            <p style="line-height: 1; font-size: 14px"><b>Editor</b> <br>Amlan Dewan</p>
                        </p>
                    </div>
                    <!--<table class="mt-3">-->
                        <!--<tr>-->
                        <!--    <td style="padding-right: 25px">সম্পাদকমন্ডলী সভাপতি:</td>-->
                        <!--    <td>ড. নূহ-উল-আলম লেনিন</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                        <!--    <td>প্রধান সম্পাদক :</td>-->
                        <!--    <td>আরিফ সোহেল</td>-->
                        <!--</tr>-->
                    <!--    <tr>-->
                    <!--        <td>সম্পাদক : </td>-->
                    <!--        <td>এম এম রুহুল আমীন</td>-->
                    <!--    </tr>-->
                    <!--</table>-->
                    <!--{{-- <p>-->
                    <!--    কর্তৃক শরীয়তপুর প্রিন্টিং প্রেস, ২৩৪ ফকিরাপুল, <br>-->
                    <!--    মতিঝিল থেকে মুদ্রিত ও বেলভিউ টাওয়ার, ৭ম তলা, <br>-->
                    <!--    ৭১ বীর উত্তম সি আর দত্ত রোড হাতিরপুল, ঢাকা থেকে প্রকাশিত।<br>-->
                        
                    <!--</p> --}}-->
                    <!--<table class="mb-4">-->
                    <!--    <tr>-->
                    <!--        <th>ফোন :</th>-->
                    <!--        <td>০২-৪১০৬০২৭০-৭১ </td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--        <th>মোবাইল :</th>-->
                    <!--        <td>০১৭৩৯-৪২২৮২২</td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--        <th>ই-মেইল :<br><br><br><br></th>-->
                    <!--        <td>-->
                    <!--            <b>সংবাদ </b><br>-->
                    <!--            amarbangladaily@gmail.com<br>-->
                    <!--            <b>বিজ্ঞাপন </b><br>-->
                    <!--            ad.amarbangla@gmail.com-->
                    <!--        </td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--        <th>ওয়েব : </th>-->
                    <!--        <td>-->
                    <!--            www.amarbanglabd.com-->
                    <!--        </td>-->
                    <!--    </tr>-->
                    <!--</table>-->
                    <img src="{{asset('images/copywright-logo.png')}}" class="img-fluid"/>
                </div>
                <div class="col-md-8">
                    <img src="{{asset('images/07.png')}}" class="img-fluid"/>
                </div>
            </div>
            
            
        </footer>
    </div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@yield('footer_script')
</body>
</html>