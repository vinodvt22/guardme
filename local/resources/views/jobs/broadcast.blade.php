@extends('jobs.template')

@section('bread-crumb')
    <div class="breadcrumb-section">
        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/')}}">Home</a></li>
            <li><a href="{{URL::route('job.create')}}">Create Job</a></li>
            <li>Broadcast Job</li>
        </ol><!-- breadcrumb -->                        
        <h2 class="title">Broadcast Job</h2>
    </div>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('shared.message')
    <form id="broadcast_job" method="POST" action="{{ route('api.broadcast.job', ['id' => $id]) }}">

        <div class="form-group">
            <div class="checkbox">
                <label for="all_personnel">
                    <input type="checkbox" class="visible_to_all_security_personal" name="visible_to_all_security_personal" value="1" id="all_personnel"> All personnel
                    <br>
                    <span class="text-danger error-span"></span>
                </label>
            </div>
            <div class="checkbox">
                <label for="favrt">
                    <input type="checkbox" name="visible_to_favourite" class="visible_to_favourite" value="1" id="favrt"> Favourite security personnel
                    <br>
                    <span class="text-danger error-span"></span>
                </label>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="1" class="specific_area" name="specific_area">Security personnel within : <b>0 to 500km</b>
                <br>
                <span class="text-danger error-span"></span>
                {{--Security personnel within : <b>0 km </b>&nbsp;&nbsp; <input id="ex2"  name="specific_area_min_max" type="text" class="span2" value="" data-slider-min="0" data-slider-max="500" data-slider-step="5" data-slider-value="[0,250]"/> <b>500 km</b>--}}
            </label>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label class="col-md-2">From</label>
                <div class="col-md-10">
                    <input type="text" name="min_area" class="min_area form-control">
                </div>
            </div>
            <div class="col-md-6">
                <label for="" class="col-md-2">To</label>
                <div class="col-md-10">
                    <input type="text" name="max_area" class="max_area form-control">
                    <span class="text-danger error-span"></span>
                </div> 
            </div>
            
            
        </div>

        <div class="form-group row">
            <label for="specific_category_id" class="col-md-3">Security Category</label>
            <div class="col-md-9">
                <select type="text" name="specific_category_id" class="form-control specific_category_id" id="specific_category_id">
                    <option value="">Please Select Category</option>
                    @foreach($all_security_categories as $sec_cat)
                        <option value="{{ $sec_cat->id }}">{{ $sec_cat->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger error-span"></span>
            </div>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" class="terms_conditions" name="terms_conditions"> Agree to terms and conditions
                <br>
                <span class="text-danger error-span"></span>
            </label>
        </div>
        <button type="submit" class="btn btn-primary pull-right">Next</button>
    </form>
@endsection

@section('script')
<script>
    $("#ex2").slider({});
    $(document).ready(function(){

        if(gm_nxturl != null && gm_nxturl!='{{URL::current()}}')
                {
                    //alert('lll');
                    window.location.href = gm_nxturl;

                }
                else{
                    steps_check();
                }

        $("form#broadcast_job").on("submit", function(e){
            formErrors = new Errors();
            e.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    var nextUrl = "{{ route('job.payment.details', ['id' => $id]) }}";

                    var step = JSON.parse(sessionStorage.getItem('steps'));
                    step.wstep3='completed';
                    sessionStorage.setItem('steps',JSON.stringify(step));
                    
                    sessionStorage.setItem('nxturl',nextUrl);
                    sessionStorage.setItem('nxtstep','wstep4');
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
@endsection