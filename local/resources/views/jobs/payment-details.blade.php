<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('style')
    <style type="text/css">
        .noborder ul,li { margin:0; padding:0; list-style:none;}
        .noborder .label { color:#000; font-size:16px;}
        .update{
            margin-top:10px
        }
    </style>
</head>
<body>

<!-- fixed navigation bar -->
@include('header')

        <!-- slider -->
<div class="clearfix"></div>

<div class="video">
    <div class="clearfix"></div>
    <div class="headerbg">
        <div class="col-md-12" align="center"><h1>Payment Details</h1></div>
    </div>
    <div class="container" >
        <div style="margin-top: 20px;"></div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif

        @include('shared.message')

        <div class="row">
            <div class="col-md-12">
                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation"><a href="javascript:void(0)">Create job</a></li>
                        <li role="presentation"><a href="javascript:void(0)">Create Schedule</a></li>
                        <li role="presentation"><a href="javascript:void(0)">Broadcast Job</a></li>
                        <li role="presentation" class="active"><a href="javascript:void(0)">Payment Details</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="height30"></div>
                        <div role="tabpanel" class="tab-pane active" id="job_payment_details_panel">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Daily working hours</td>
                                    <td>{{ $jobDetails['daily_working_hours'] }}</td>
                                </tr>
                                <tr>
                                    <td>Monthly working days</td>
                                    <td>{{ $jobDetails['monthly_working_days'] }}</td>
                                </tr>
                                <tr>
                                    <td>Per hour rate</td>
                                    <td>{{ $jobDetails['per_hour_rate'] }}</td>
                                </tr>
                                <tr>
                                    <td>Total working hours per month</td>
                                    <td>{{ $jobDetails['total_working_hours_per_month'] }}</td>
                                </tr>
                                <tr>
                                    <td>Basic Total</td>
                                    <td>{{ $jobDetails['basic_total'] }}</td>
                                </tr>
                                <tr>
                                    <td>VAT Fee 20%</td>
                                    <td>{{ $jobDetails['vat_fee'] }}</td>
                                </tr>
                                <tr>
                                    <td>Admin Fee 14.99%</td>
                                    <td>{{ $jobDetails['admin_fee'] }}</td>
                                </tr>
                                <tr>
                                    <td>Grand Total</td>
                                    <td>{{ $jobDetails['grand_total'] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($available_balance < $jobDetails['grand_total'])
                        <form action="{{ route('create.paypal.payment', ['id' => $id]) }}" method="post">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-success" value="Pay with Paypal">
                        </form>
                    @else
                        <form method="post" id="activate_job" action="{{ route('api.activate.job', ['id' => $id]) }}">
                            <input type="submit" class="btn btn-success" value="Activate Job">
                        </form>
                    @endif
                </div>

            </div>
        </div>

        <div class="height30"></div>
        <div class="row">

        </div>

    </div>
</div>

<div class="clearfix"></div>
@include('footer')
<script>
    $(document).ready(function(){
        $("form#activate_job").on("submit", function(e){
            formErrors = new Errors();
            e.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    var nextUrl = "{{ route('job.confirmation') }}";
                    window.location.href = nextUrl;
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    formErrors.record(errors);
                    formErrors.load();
                }
            });
        });
    });
</script>


</body>
</html>