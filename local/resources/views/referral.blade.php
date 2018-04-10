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
        <div class="col-md-12" align="center"><h1>Referrals</h1></div>
    </div>


    <div class="profile">
        <div class="container">
            <div class="clearfix"></div>
            <div class="container">
                <b>Total Earned: </b><span>{{ $user->getBalance() }}</span>
                <a href="/redeem" class="btn btn-primary">Redeem</a>
            </div>
            <div class="container">
                <b>URL: </b><span><input type="text" class="form-control" style="float:right; width: 70%"
                                         value="{{ URL::to('/') . '/?uid=' . base64_encode($user->email) }}"></span>
            </div>
            <div class="clearfix"></div>
            <div class="container">
                <h2>Users</h2>
                <table id="datatable-responsive"
                       class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>E-mail</th>
                        <th>Earned</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $c = 1; ?>
                    @foreach ($referrals as $referral)
                        <tr>
                            <td>{{ $c++ }}</td>
                            <td>{{$referral->email}}</td>
                            <td>10</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="container">
                <h2>Items bought</h2>
                <table class="table">
                    <tr>
                        <td>#</td>
                        <td>Item name</td>
                        <td>price</td>
                    </tr>
                    <?php $c = 1; ?>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $c++ }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->price }}</td>
                        </tr>
                    @endforeach
                </table>
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




