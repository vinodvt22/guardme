<?php
use Illuminate\Support\Facades\Route;
$currentPaths= Route::getFacadeRoot()->current()->uri();
$url = URL::to("/");
$setid=1;
$setts = DB::table('settings')
    ->where('id', '=', $setid)
    ->get();
?>
        <!DOCTYPE html>
<html lang="en">
<head>



    @include('style')


    <style>

        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
        .banner
        {
            position: relative;
            height: 760px;
            font-size: 1rem;
            color: #333647;
        }

        .banner-class
        {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center 30%;
            position: absolute;
            width: 100%;
            height: 80%;
            transition: opacity .8s;
        }



        body {
            font-family: 'Open Sans', 'sans-serif';
        }
        .mega-dropdown {
            position: static !important;
        }
        .mega-dropdown-menu {
            padding: 20px 0px;
            width: 100%;
            box-shadow: none;
            -webkit-box-shadow: none;
        }
        .mega-dropdown-menu > li > ul {
            padding: 0;
            margin: 0;
        }
        .mega-dropdown-menu > li > ul > li {
            list-style: none;
        }
        .mega-dropdown-menu > li > ul > li > a {
            display: block;
            color: #222;
            padding: 3px 5px;
        }
        .mega-dropdown-menu > li ul > li > a:hover,
        .mega-dropdown-menu > li ul > li > a:focus {
            text-decoration: none;
        }
        .mega-dropdown-menu .dropdown-header {
            font-size: 18px;
            color: #ff3546;
            padding: 5px 60px 5px 5px;
            line-height: 30px;
        }

        .carousel-control {
            width: 30px;
            height: 30px;
            top: -35px;

        }
        .left.carousel-control {
            right: 30px;
            left: inherit;
        }
        .carousel-control .glyphicon-chevron-left,
        .carousel-control .glyphicon-chevron-right {
            font-size: 12px;
            background-color: #fff;
            line-height: 30px;
            text-shadow: none;
            color: #333;
            border: 1px solid #ddd;
        }

        .frontpage-blocks {
            clear:both;
        }

        .navbar-inverse
        {
            background-color: white!important;
            border: none!important;
        }

        .navbar-inverse .sangvish_homepage > li > a
        {
            color: #000!important;
        }

        @media (min-width: 768px){
            .navbar-nav {

                margin-left: 30%;
            }

            .custom-nav>li>a
            {
                font-size: 1.4em;
            }

            .custom-nav>li>a:hover
            {
                border-bottom: 2px solid green;
                border-top: 2px solid green;
            }

            .custom-nav>li>a
            {
                border-bottom: 2px solid steelblue;
                margin-right: 5px;
            }

            .dropdown-menu
            {
                margin-top: 10px;
            }

            .btn-warning
            {
                background: #fff;
            }
        }

        @media screen and (min-width: 768px) {
            .carousel-indicators {
                bottom: -15%;
            }
        }

        .material-icons.md-12 { font-size: 14px; }
        .material-icons.md-24 { font-size: 24px; }
        .material-icons.md-36 { font-size: 36px; }
        .material-icons.md-48 { font-size: 48px; margin-top: 35%;}
        .material-icons.orange600 { color: #FB8C00; }
        .material-icons.green600 { color: #32CD32; }
        .material-icons.blue600 { color: #57C0E1; }
        .material-icons.pink600 { color: #E157CE; }


        .air-card {
            position: relative;
            background-color: #fff;
            margin: 10px -10px;
            padding: 0px;

        }


        .drop-a a:hover
        {
            background-color: #ECF4FD;
            color: #000;
        }


        .drop-b a:hover
        {
            background-color: #ECF4FD;
            color: #000;
            text-decoration: none;
        }


        .drop-b p
        {
            color: #BAACB4;
        }


        @media screen and (max-width: 1920px) and (min-width: 1200px) {
            .dropdown-menu {
                background: white!important;
            }
            .last-row i
            {
                margin-top: 2px;
            }

            .icons
            {
                min-height: unset!important;
            }

            .icons ul
            {
                margin-top: 10%;
            }

            .banner-class
            {
                height: 80%;
            }
        }


        @media screen and (max-width: 1920px) and (min-width: 1400px) {

            .banner-class
            {
                height: 65%;
            }
        }


        .btn-huge
        {
            background-color: #3BAA4D;
            color: #fff;
            padding: 10px 15px;
            font-size: 2.0em;
        }

        @media (min-width: 1200px) {
            .container1 {
                width: 1280px;
            }

            .container1 {
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
        }


        @media screen and (max-width: 1920px) and (min-width: 1200px) {
            #overlays {

                background-color: white;
            }
        }

        .clearfix
        {
            background-color: white;
        }

        @media screen and (max-width: 600px) and (min-width: 400px) {
                .home-font h1
                {
                    font-size: 2.2em!important;
                    font-weight: 600;
                }

            .carousel-inner p
            {
                font-size: 2.0em!important;
            }
        }

        .home-font h1
        {
            font-size: 3.2em;
            font-weight: 600;
        }

        .headerbg
        {
            background-color: white!important;
            border-bottom: unset!important;
        }



    </style>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>
<body>



<!-- fixed navigation bar -->
@include('header')

<!-- slider -->



<div id="banner" class="frontpage-blocks">
    <div id="overlays"></div>
    <?php if(!empty($setts[0]->site_banner)){?>
    <img src="https://gigster.com/assets/ebay-0f9911.jpg" class="img-responsive banner-class backimg" id="b1">
    <?php } else {?>
    <img src="<?php echo $url;?>/img/banner.jpg" class="img-responsive bannerheight">
    <?php } ?>


    <script>
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("backimg");

            var dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
            setTimeout(showSlides, 2000); // Change image every 2 seconds
        }
    </script>
</div>




<div class="clearfix"></div>

<div class="container1" style="margin-top: 10%">
    <div class="clearfix"></div>
    <div class="headerbg">
        <div class="col-md-12 home-font" align="left">
            <h1><strong>Manned Security Freelance Marketplace.
                </strong></h1>

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <p style="font-size: 2.5em;">Looking for security personnel in the UK?</p>
                    </div>

                    <div class="item">
                        <p style="font-size: 2.5em;">Get access to thousands of vetted SIA security personnel.
                        </p>
                    </div>


                </div>
            </div>




            <a href="#"
               title="Start a project" type=""
               class="btn btn-huge blue"
               target="" data-reactid="337">
                <span class="text" title="Start a project" data-reactid="338">Hire Security Personnel</span>
            </a>
        </div>



        <div class="col-md-12" align="left">
            <div class="col-md-7" style="padding-left: 0px">
                <h3 style="font-size: 22px"><strong>GuardME</strong> is a <a href="https://guarddme.com/register&gt;">marketplace for vetted security personnel.</a> Are you SIA licensed or looking for security personnel? Join us by registering </h3>
            </div>
            <div class="col-md-5">

            </div>
        </div>
    </div>

</div>








<script>

    $(document).ready(function(){
        $(".dropdown").hover(
            function() {
                $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("400");
                $(this).toggleClass('open');
            },
            function() {
                $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("400");
                $(this).toggleClass('open');
            }
        );
    });
</script>

<script>
    $(document).ready(function() {
        src = "{{ route('searchajax') }}";
        $("#search_text").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: src,
                    dataType: "json",
                    data: {
                        term : request.term
                    },
                    success: function(data) {
                        response(data);

                    }
                });
            },
            minLength: 1,

        });
    });
</script>







<div class="ashbg">

    <div class="clearfix"></div>





    <!-- main container -->




    <div class="clearfix"></div>

</div>

<div class="clearfix"></div>


<div class="works">
    <div class="container">
        <div class="col-md-12" align="center"><h1>How it works</h1></div>
        <div class="height30"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="col-md-6">
                        <img src="img/how-it-works.png" class="img-responsive" alt="">
                    </div>

                    <div class="col-md-6">
                        <h3 class="">1. Tell us what you need</h3>
                        <p class="">First, select required professional service about what type of pro you’re looking for.</p>
                        <h3 class="">2. Review service providers</h3>
                        <p class="">Within seconds, you’ll receive expert service providers profile with their ratings. choose one among them.</p>
                        <h3 class="">3. Hire the right pro</h3>
                        <p class="">Compare prices, profiles, and reviews, then hire the pro that’s right for you.</p>

                    </div>
                </div>
                <div class="col-md-1"></div>

            </div>

        </div>

    </div>
    <div class="clearfix"></div>
</div>




<div class="clearfix"></div>


<div class="blog">
    <div class="clearfix"></div>
    <div class="container">
        <div class="col-md-12" align="center"><h1>Customers use to get millions of projects done<br/> quickly and easily</h1></div>
        <div class="height30"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-1"></div>




                <div class="col-md-10 nopadding testimons">

                    <div id="flexiselDemotesti">

                        <?php foreach($testimonials as $testimonial){?>
                        <li>
                            <div class="weightbg">
                                <div class="innerbg">
                                    <p><?php echo $testimonial->description;?></p>
                                </div>
                                <div class="user">
                                    <?php
                                    $testimonialphoto="/testimonialphoto/";
                                    $path ='/local/images'.$testimonialphoto.$testimonial->image;
                                    if($testimonial->image!=""){
                                    ?>
                                    <img src="<?php echo $url.$path;?>" class="img-responsive" alt="">
                                    <?php } else {?>
                                    <img src="<?php echo $url.'/local/images/nophoto.jpg';?>"  class="img-responsive">
                                    <?php } ?>
                                    <div class="user-txt">

                                        <h5><?php echo $testimonial->name;?></h5>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php } ?>





                    </div>
                </div>






                <?php /* ?><div class="col-md-10">
	
	<div class="col-md-4">
	<div class="blog-wightbg">
	<img src="img/thumb/p5.jpg" class="img-responsive" alt="">
	<p>Gary was friendly, professional, and his work was incredible. He helped us create a design we loved within our budget. 
	Whole Foods customers say how much the mural brightens our space</p>
	<div class="clear"></div>
	<div class="user">
	<img src="img/thumb/user1.jpg" class="img-responsive" alt="">
	<div class="user-txt">
	<h4>The PRO</h4>
	<h5>Mickey Peter</h5>
	</div>
	</div>
	
	
	</div>
	</div>
	
	
	<div class="col-md-4">
	<div class="blog-wightbg">
	<img src="img/thumb/p5.jpg" class="img-responsive" alt="">
	<p>Gary was friendly, professional, and his work was incredible. He helped us create a design we loved within our budget. 
	Whole Foods customers say how much the mural brightens our space</p>
	<div class="clear"></div>
	<div class="user">
	<img src="img/thumb/user1.jpg" class="img-responsive" alt="">
	<div class="user-txt">
	<h4>The PRO</h4>
	<h5>Mickey Peter</h5>
	</div>
	</div>
	
	
	</div>
	</div>
	
	
	
	<div class="col-md-4">
	<div class="blog-wightbg">
	<img src="img/thumb/p5.jpg" class="img-responsive" alt="">
	<p>Gary was friendly, professional, and his work was incredible. He helped us create a design we loved within our budget. 
	Whole Foods customers say how much the mural brightens our space</p>
	<div class="clear"></div>
	<div class="user">
	<img src="img/thumb/user1.jpg" class="img-responsive" alt="">
	<div class="user-txt">
	<h4>The PRO</h4>
	<h5>Mickey Peter</h5>
	</div>
	</div>
	
	</div>
	</div>
	
	</div><?php */?>















                <div class="col-md-1"></div>
            </div>

        </div>

    </div>
    <div class="clearfix"></div>
    <div class="clearfix"></div>
</div>






<div class="getmore">
    <div class="col-md-12">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <h2>Get more done anytime, anywhere</h2>
                <p>Send project requests, get quotes, and hire the right pro with the free Thumbtack app for iPhone.</p>
                <div class="height40"></div>
                <?php /* ?><div class="">
	<div class="col-md-8 paddingoff">
		
		<input type="text" name="search" class="searchtext" placeholder="Phone Number">
		</div>
		<div class="col-md-4 paddingoff"><input type="button" name="search" class="searchbtn" value="Text me a link"></div>
		</div><?php */?>

                <div class="">
                    <div class="col-md-4 paddingoff clearfixed">
                        <a href="#"><img src="<?php echo $url.'/local/images/google.png';?>" class="img-responsive" alt=""></a>
                    </div>
                    <div class="col-md-4 paddingoff">
                        <a href="#"><img src="<?php echo $url.'/local/images/apple.png';?>" class="img-responsive" alt=""></a>
                    </div>
                    <div class="col-md-4"></div>
                </div>

                <div class="height20"></div>
                <?php /* ?><div class="col-md-12 app">
	<div class="col-md-8"></div>
	<div class="col-md-4 moveright"><img src="img/app.png" class="img-responsive" alt=""></div>
	</div><?php */?>

            </div>
        </div>

        <div class="col-md-1"></div>
    </div>

</div>






<div class="video">
    <div class="clearfix"></div>
    <div class="container">
        <div class="col-md-12" align="center"><h1>Thousands of professionals are growing their<br/> businesses</h1></div>
        <div class="height30"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="col-md-8 paddingoff">
                        <img src="img/v1.jpg" class="img-responsive big firstsize" alt="">
                        <div class="titlesection">
                            <h3>Caitlin Sarah</h3>
                            <span>Designer</span>
                        </div>

                    </div>

                    <div class="col-md-4 paddingoff left10">
                        <div class="justmove"><img src="img/v2.jpg" class="img-responsive" alt="">
                            <div class="titlesection">
                                <h3>Sophie Olivia</h3>
                                <span>Developer</span>
                            </div>
                        </div>
                        <div class="height10"></div>
                        <div class="justmove"><img src="img/v3.jpg" class="img-responsive" alt="">

                            <div class="titlesections">
                                <h3>William Mark</h3>
                                <span>Analyst</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>

            </div>




        </div>

    </div>
</div>




<div class="clearfix"></div>
<div class="clearfix"></div>

@include('footer')
</body>
</html>
