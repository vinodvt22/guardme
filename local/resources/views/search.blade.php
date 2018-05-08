
<!DOCTYPE html>
<html lang="en">
<head>



	@include('style')

	<style type="text/css">
		.noborder ul,li { margin:0; padding:0; list-style:none;}
		.noborder .label { color:#000; font-size:16px;}
	</style>

	<script >

		function set_loc(id,val)
		{
			$('#loc_id').val(id);
			$('#loc_val').val(val);
		}
		function set_cat(id,val)
		{
			$('#cat_id').val(id);
			$('#cat_val').val(val);
		}


	</script>

</head>
<body>

<?php $url = URL::to("/"); ?>

<!-- fixed navigation bar -->
@include('header')

<section class="job-bg page job-list-page">
	<div class="container">
		<div class="breadcrumb-section">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/')}}">Home</a></li>
				<li>Search</li>
			</ol><!-- breadcrumb -->
			<h2 class="title">Search Security Personnel</h2>
		</div>

		<div class="banner-form banner-form-full job-list-form">
			<form method="get" action="{{ route('post-personnel-search') }}" id="formID">
				<!-- category-change -->
				<div class="dropdown category-dropdown">
					<a data-toggle="dropdown" href="#">
						<span class="change-text">
							@if(old('cat_val')!=NULL)
								{{old('cat_val')}}
							@else
								{{'Category'}}
							@endif
						</span> <i class="fa fa-angle-down"></i></a>
					<ul class="dropdown-menu category-change cat">
						@foreach($cats as $cat)
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
							<li><a href="#" onclick="set_loc({{$loc->id}},'{{$loc->citytown}}')">{{$loc->citytown}}</a></li>
						@endforeach
					</ul>
					<input type="hidden" name="loc_id" value="{{old('loc_id')}}" id="loc_id">
					<input type="hidden" name="loc_val" value="{{old('loc_val')}}" id="loc_val">
				</div><!-- language-dropdown -->

				<input type="text" class="form-control" placeholder="Security Personnel" name="sec_personnel" value="{{old('sec_personnel')}}">
				<button type="submit" class="btn btn-primary" value="Search">Search</button>
			</form>
		</div>

		<div class="category-info">
			<div class="row">
				<div class="col-md-3 col-sm-4">
					<div class="accordion">
						<!-- panel-group -->
						<div class="panel-group" id="accordion">

							<!-- panel -->
							<div class="panel panel-default panel-faq">
								<!-- panel-heading -->
								<div class="panel-heading">
									<div  class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#accordion-one">
											<h4>Gender<span class="pull-right"><i class="fa fa-minus"></i></span></h4>
										</a>
									</div>
								</div><!-- panel-heading -->

								<div id="accordion-one" class="panel-collapse collapse in">
									<!-- panel-body -->
									<div class="panel-body">

									</div><!-- panel-body -->
								</div>
							</div>
						</div>

						<!-- panel -->
						<div class="panel panel-default panel-faq">
							<!-- panel-heading -->
							<div class="panel-heading">
								<div  class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#accordion-three">
										<h4>Available<span class="pull-right"><i class="fa fa-plus"></i></span></h4>
									</a>
								</div>
							</div><!-- panel-heading -->

							<div id="accordion-three" class="panel-collapse collapse">
								<!-- panel-body -->
								<div class="panel-body">

								</div><!-- panel-body -->
							</div>
						</div>

						<!-- panel -->
						<div class="panel panel-default panel-faq">
							<!-- panel-heading -->
							<div class="panel-heading">
								<div class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#accordion-four">
										<h4>Employment Type<span class="pull-right"><i class="fa fa-plus"></i></span></h4>
									</a>
								</div>
							</div><!-- panel-heading -->

							<div id="accordion-four" class="panel-collapse collapse">
								<!-- panel-body -->
								<div class="panel-body">
									<label for="full-time"><input type="checkbox" name="full-time" id="full-time"> Full Time</label>
									<label for="part-time"><input type="checkbox" name="part-time" id="part-time"> Part Time</label>
									<label for="contractor"><input type="checkbox" name="contractor" id="contractor"> Contractor</label>
									<label for="intern"><input type="checkbox" name="intern" id="intern"> Intern</label>
									<label for="seasonal"><input type="checkbox" name="seasonal" id="seasonal"> Seasonal / Temp</label>
								</div><!-- panel-body -->
							</div>
						</div>
						<!-- panel -->
						<div class="panel panel-default panel-faq">
							<!-- panel-heading -->
							<div class="panel-heading">
								<div class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#accordion-five">
										<h4>Star rating<span class="pull-right"><i class="fa fa-plus"></i></span></h4>
									</a>
								</div>
							</div><!-- panel-heading -->

							<div id="accordion-five" class="panel-collapse collapse">
								<!-- panel-body -->
								<div class="panel-body">

								</div><!-- panel-body -->
							</div>
						</div>
						<!-- panel -->
						<div class="panel panel-default panel-faq">
							<!-- panel-heading -->
							<div class="panel-heading">
								<div class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#accordion-six">
										<h4>Distance to<span class="pull-right"><i class="fa fa-plus"></i></span></h4>
									</a>
								</div>
							</div><!-- panel-heading -->

							<div id="accordion-six" class="panel-collapse collapse">
								<!-- panel-body -->
								<div class="panel-body">
									<input type="text" placeholder="Postcode" class="form-control">
								</div><!-- panel-body -->
							</div>
						</div>
					</div>
				</div>


				<!-- recommended-ads -->
				<div class="col-sm-8 col-md-7">
					<div class="section job-list-item">
						<div class="featured-top">

							<div class="dropdown pull-right">
								<div class="dropdown category-dropdown">
									<h5>Sort by:</h5>
									<a data-toggle="dropdown" href="#"><span class="change-text">Most Relevant</span><i class="fa fa-caret-square-o-down"></i></a>
									<ul class="dropdown-menu category-change">
										<li><a href="#">Most Relevant</a></li>
										<li><a href="#">Most Popular</a></li>
									</ul>
								</div><!-- category-change -->
							</div>
						</div><!-- featured-top -->

                        <?php if($sec_personnels->count()>0){?>

                        <?php foreach($sec_personnels as $person){ ?>

						<div class="job-ad-item">
							<div class="item-info">
								<div class="item-image-box">
									<div class="item-image">
                                        <?php

                                        $photo_path ='/local/images/userphoto/'.$person->photo;
                                        if($person->photo!=""){?>
										<a href="{{ route('person-profile',$person->id) }}" ><img src="<?php echo $url.$photo_path;?>" class="img-responsive"></a>
                                        <?php } else { ?>
										<a href="{{ route('person-profile',$person->id) }}" ><img align="center" class="img-responsive" src="<?php echo $url.'/local/images/nophoto.jpg';?>" alt="Profile Photo"/></a>
                                        <?php } ?>



									</div><!-- item-image -->
								</div>

								<div class="ad-info">
					<span><a href="{{ route('person-profile',$person->id) }}" class="title">@if($person->firstname!='')
								{{$person->firstname.' '.$person->lastname}}
							@else
								{{$person->name}}
							@endif</a> </span>
									<div class="ad-meta">
										<ul>
											<li><a href="{{ route('person-profile',$person->id) }}"><i class="fa fa-map-marker" aria-hidden="true"></i>@if($person->person_address){{$person->person_address->citytown}} @endif </a></li>
											<li><a href="{{ route('person-profile',$person->id) }}"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    <?php //echo $stime; ?> - <?php /*echo $etime; */?>
												</a></li>
											<!-- <li><a href="#"><i class="fa fa-money" aria-hidden="true"></i>$25,000 - $35,000</a></li> -->
										</ul>
									</div><!-- ad-meta -->
								</div><!-- ad-info -->
							</div><!-- item-info -->
						</div>

                        <?php } ?>

                        <?php }
                        else{?>

						<div class="col-md-12 noservice" align="center">No personnels found!</div>

                    <?php } ?>



					<!-- pagination  -->
						<div class="text-center">
							{{$sec_personnels->links()}}
						</div><!-- pagination  -->
					</div>
				</div>


				<div class="col-md-2 hidden-xs hidden-sm">
					<div class="advertisement text-center">
						<a href="#"><img src="images/ads/1.jpg" alt="" class="img-responsive"></a>
					</div>
				</div>



			</div>
		</div>


	</div>
</section>


@include('footer')
</body>
</html>