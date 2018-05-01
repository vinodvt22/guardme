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
        <div class="col-md-12" align="center"><h1>Application Details</h1></div>
    </div>
    <div class="clearfix"></div>
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
        <div class="alert alert-danger hide" role="alert">

        </div>
        <div class="alert alert-success hide" role="alert">

        </div>
        @include('shared.message')
        <div class="row">
            @if (!$application->is_hired)
                <button class="btn btn-info pull-right mark-as-hired">Award Job</button>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h2>Application Details</h2>
                    <h3>Job Title</h3>
                    <h4>{{ $application->job_title }}</h4>
                </div>
                <div class="row">
                    <h3>Job Description</h3>
                    <p>{{ $application->job_description }}</p>
                </div>
                <div class="row">
                    <h3>Applied By</h3>
                    <p>{{ $application->user_name }}</p>
                </div>
                <div class="row">
                    <h3>Application Description</h3>
                    <p>{{ $application->description }}</p>
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
        $(".mark-as-hired").on("click", function(){
            var route = "{{ route('api.mark.hired', ['id' => $application->id]) }}";
            $.ajax({
                url: route,
                type: 'POST',
                success: function(data) {
                    $('.mark-as-hired').fadeOut('slow');
                    $('.alert-success').text(data[0]);
                    $('.alert-success').removeClass('hide');
                },
                error: function(data) {
                    $('.alert-danger').text(data.responseJSON[0]);
                    $('.alert-danger').removeClass('hide');
                }
            })
        });
    });
</script>


</body>
</html>