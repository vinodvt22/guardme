<!DOCTYPE html>
<html lang="en">
<head>
    @include('style')
</head>
<body>
<!-- fixed navigation bar -->
@include('header')


<div class="clearfix"></div>


<div class="video">
    <div class="clearfix"></div>
    <div class="headerbg">
        <div class="col-md-12" align="center"><h1>Referrals - Redeem</h1></div>
    </div>


    <div class="profile">
        <div class="clearfix"></div>
        <div class="container">
            <div class="container">
                <b>Total Earned: </b><span>{{ $user->getBalance() }}</span>
                <a href="/redeem" class="btn btn-primary">Redeem</a>
            </div>
            <div class="clearfix"></div>
            <div class="container">
                <div class="row">
                    @foreach ($items as $item)
                        <div class="col-md-3">
                            <div class="shop-list-page">
                                <div class="shop_pic">
                                    <img src="{{ URL::to('/') }}/local/images/{{ $item->image }}"
                                         class="img-responsive imgservice">
                                </div>
                                <div class="col-lg-12 shop_content">
                                    <h4 class="sv_shop_style"><a
                                                href="{{ URL::to('/redeem/' . $item->id) }}">{{ $item->title }}</a></h4>
                                    {{--<img src="http://guardme3.loc/local/images/nostar.png" alt="rated 0 stars" class="star_rates">--}}
                                    <h3>{{ $item->price }} points</h3>

                                    <div align="center"><a href="{{ URL::to('/redeem/' . $item->id) }}"
                                                           class="btn btn-success radiusoff">Redeem</a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div class="height30"></div>
    <div class="row">


    </div>

</div>


<div class="clearfix"></div>
<div class="clearfix"></div>

@include('footer')
</body>
</html>




