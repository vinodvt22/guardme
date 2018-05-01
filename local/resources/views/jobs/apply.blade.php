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
        <div class="col-md-12" align="center"><h1>Submit Your Application</h1></div>
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
                <div class="row">
                    <h2>Job Details</h2>
                    <h3>Job Title</h3>
                    <h4>{{ $job->title }}</h4>
                </div>
                <div class="row">
                    <h3>Description</h3>
                    <p>{{ $job->description }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('api.apply.job', ['id' => $job->id ]) }}" id="apply_on_job" method="post">
                <div class="form-group">
                    <label for="">Application Description</label>
                    <textarea class="form-control" name="application_description" rows="10"></textarea>
                    <span class="error-span text-danger"></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-info">
                </div>

            </form>
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
        $("form#apply_on_job").on("submit", function(e){
            e.preventDefault();
            $.ajax({
               url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data);
                },
                error: function(data) {
                    console.log('errors');
                }
            });
        });
    });
</script>


</body>
</html>