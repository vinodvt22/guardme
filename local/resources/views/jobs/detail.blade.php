<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('style')
   
</head>
<body>

<!-- fixed navigation bar -->
@include('header')

    <section class="job-bg page job-details-page">
        <div class="container">
            <div class="breadcrumb-section">
                <ol class="breadcrumb">
                     <li><a href="{{URL::to('/')}}">Home</a></li>
                    <li><a href="{{URL::route('find.jobs')}}">Jobs</a></li>
                    <li>{{$job->title}}</li>
                </ol><!-- breadcrumb -->                        
                <h2 class="title">{{$job->title}}</h2>
            </div>

            <div class="banner-form banner-form-full job-list-form">
                <form method="POST" action="{{ route('post.find.jobs') }}" id="formID">
                    <!-- category-change -->
                    <div class="dropdown category-dropdown">                    {!! csrf_field() !!}    
                        <a data-toggle="dropdown" href="#">
                        <span class="change-text">
                            @if(old('cat_val')!=NULL)
                                {{old('cat_val')}}
                            @else
                                {{'Industry'}}
                            @endif
                        </span> <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu category-change cat">
                            @foreach($b_cats as $cat)
                                <li><a href="#" onclick="set_cat({{$cat->id}},'{{$cat->name}}')" >{{$cat->name}}</a></li>
                            @endforeach
                        </ul>   
                        <input type="hidden" name="cat_id" value="{{old('cat_id')}}" id="cat_id">           
                        <input type="hidden" name="cat_val" value="{{old('cat_val')}}" id="cat_val">                
                    </div><!-- category-change -->
                    
                    <!-- language-dropdown -->
                    <div class="dropdown category-dropdown language-dropdown">
                        <a data-toggle="dropdown" href="#"><span class="change-text" >
                        @if(old('loc_val')!=NULL)
                                {{old('loc_val')}}
                            @else
                                {{'Location'}}
                            @endif
                        </span> <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu category-change language-change loc">
                            @foreach($locs as $loc)
                                <li><a href="#" onclick="set_loc('{{$loc->city_town}}')">{{$loc->city_town}}</a></li>
                            @endforeach
                        </ul>   
                        
                        <input type="hidden" name="loc_val" value="{{old('loc_val')}}" id="loc_val">                        
                    </div><!-- language-dropdown -->
                
                    <input type="text" class="form-control" placeholder="Job search" name="keyword" value="{{old('keyword')}}">
                    <button type="submit" class="btn btn-primary" value="Search">Search</button>
                </form>
            </div>
            <div class="job-details">
                <div class="section job-ad-item">
                    <div class="item-info">
                        <div class="item-image-box">
                            <div class="item-image">
                                <img src="{{URL::to('/')}}/images/img-placeholder.png" alt="{{$job->title}}" class="img-responsive">
                            </div><!-- item-image -->
                        </div>

                        <div class="ad-info">
                            <span><span><a href="#" class="title">{{$job->title}}</a></span> @ <a href="#"> {{$job->poster->company->shop_name}}</a></span>
                            <div class="ad-meta">
                                <ul>
                                    <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i>@if($job->cit_town){{$job->cit_town}},@endif {{$job->country}}</a></li>
                                    <!-- <li><a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i>Full Time</a></li> -->
                                    <li><i class="fa fa-money" aria-hidden="true"></i>${{$job->per_hour_rate}}</li>
                                    <li><a href="#"><i class="fa fa-tags" aria-hidden="true"></i>{{$job->industory->name}}</a></li>
                                    <li><i class="fa fa-hourglass-start" aria-hidden="true"></i>Posted on : {{date('M d, Y',strtotime($job->created_at))}}</li>
                                </ul>
                            </div><!-- ad-meta -->                                  
                        </div><!-- ad-info -->
                    </div><!-- item-info -->
                    <div class="social-media">
                        <div class="button">
                            <a href="{{URL::route('apply.job', $job->id)}}" class="btn btn-primary"><i class="fa fa-briefcase" aria-hidden="true"></i>Apply For This Job</a>
                            <a href="#" class="btn btn-primary bookmark"><i class="fa fa-bookmark-o" aria-hidden="true"></i>Bookmark</a>
                        </div>
                        <ul class="share-social">
                            <li>Share this ad</li>
                            <li><a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-tumblr-square" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>                  
                </div>

                <div class="job-details-info">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="section job-description">
                                <div class="description-info">
                                    <h1>Description</h1>
                                    <p>{{$job->description}}</p>
                                </div>




                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="section job-short-info">
                                <h1>Short Info</h1>
                                <ul>
                                    <li><span class="icon"><i class="fa fa-bolt" aria-hidden="true"></i></span>Posted: {{date('M d, Y',strtotime($job->created_at))}}</li>
                                    <li><span class="icon"><i class="fa fa-user-plus" aria-hidden="true"></i></span> Job poster: <a href="#">{{$job->poster->name}}</a></li>
                                    <li><span class="icon"><i class="fa fa-industry" aria-hidden="true"></i></span>Industry: <a href="#">{{$job->industory->name}}</a></li>
                                    <li><span class="icon"><i class="fa fa-line-chart" aria-hidden="true"></i></span>Experience: <a href="#">Entry level</a></li>
                                    
                                </ul>
                            </div>
                            <div class="section company-info">
                                <h1>Company Info</h1>
                                <ul>
                                    <li>Compnay Name: <a href="#">{{$job->poster->company->shop_name}}</a></li>
                                    <li>Address: @if($job->poster->company->city){{$job->poster->company->city}}@endif
                                        @if($job->poster->company->state){{', '.$job->poster->company->state}}@endif
                                        @if($job->poster->company->country){{', '.$job->poster->company->country}}@endif</li>
                                </ul>
                                <ul class="share-social">
                                    <li><a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                                </ul>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </section>

@include('footer')
<script>
    $(document).ready(function(){

    });
</script>


</body>
</html>