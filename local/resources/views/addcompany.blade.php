<!DOCTYPE html>
<html lang="en">
<head>
   @include('style')
</head>
<body>
    <?php 
	$url = URL::to("/"); ?>
    <!-- fixed navigation bar -->
    @include('header')
    <!-- slider -->
	<div class="clearfix"></div>
	<div class="video">
	<div class="clearfix"></div>
	<div class="container">
	 <h1>Company</h1>
	 <div class="clearfix"></div>
	 <?php if($shopcount==0){?>
            @if(Session::has('success'))
                <div class="alert alert-success">
                  {{ Session::get('success') }}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                  {{ Session::get('error') }}
                </div>
            @endif
	
    	<?php $url = URL::to("/"); ?>
	 <form class="form-horizontal" role="form" method="POST" action="{{ route('savecompany') }}" id="formID" enctype="multipart/form-data">
                    {{ csrf_field() }}
            <input type="hidden" name="editid" value="">
            <input type="hidden" name="addresslat" id="addresslat" value="">
            <input type="hidden" name="addresslong" id="addresslong" value="">
            <div class="row profile shop">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="name" class="col-md-12">Company Name <span class="require">*</span></label>
                            <div class="col-md-12">
                                <input id="company_name" type="text" class="form-control validate[required] text-input" name="company_name" value="" autofocus>
                            </div>
                        </div>
                        <style>
                            #address_id{
                                width: 85%;
                                float: left;                                
                            }
                        </style>
                        <div class="form-group">
                            <label for="address" class="col-md-12">Address</label>
                            <div class="col-md-12">
                                <div id="postcode_lookup"></div>
                                <div>Please fetch your address detail using your postcode</div>
                                @if(count($address) == 0)
                                <input id="line1" name="line1" class="trackprogress form-control text-input validate[required]" type="text" placeholder="Address line1" value="">
                                <input id="line2" name="line2" class="trackprogress form-control text-input" type="text" placeholder="Address line2" value="">
                                <input id="line3" name="line3" class="trackprogress form-control text-input" type="text" placeholder="Address line3" value="">  
                                <input id="town" name="town" class="trackprogress form-control text-input validate[required]" type="text" placeholder="Town" value="">             
                                <input id="country" name="country" class="trackprogress form-control text-input  validate[required]" type="text" placeholder="Country" value="">
                                <input id="postcode" name="postcode" class="trackprogress form-control text-input  validate[required]" type="text" placeholder="Postalcode" value="">
                                @endif                                
                                @if(count($address) >0)
                                <input id="line1" name="line1" class="trackprogress form-control text-input validate[required]" type="text" placeholder="Address line1" value="{{$address[0]->line1}}">
                                <input id="line2" name="line2" class="trackprogress form-control text-input" type="text" placeholder="Address line2" value="{{$address[0]->line2}}">
                                <input id="line3" name="line3" class="trackprogress form-control text-input" type="text" placeholder="Address line3" value="{{$address[0]->line3}}">  
                                <input id="town" name="town" class="trackprogress form-control text-input validate[required]" type="text" placeholder="Town" value="{{$address[0]->citytown}}">             
                                <input id="country" name="country" class="trackprogress form-control text-input  validate[required]" type="text" placeholder="Country" value="{{$address[0]->country}}">
                                <input id="postcode" name="postcode" class="trackprogress form-control text-input  validate[required]" type="text" placeholder="Postalcode" value="{{$address[0]->postcode}}">
                                @endif
                            </div>
                        </div>                    

                        <input type="hidden" name="admin_email_id" value="<?php echo $admin_email_id[0]->email;?>">		
                        <div class="form-group">
                            <label for="name" class="col-md-12">Phone Number <span class="require">*</span></label>
                            <div class="col-md-12">
                                <input id="company_phone" type="text" class="form-control validate[required] text-input" name="company_phone" value="">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="company_email" class="col-md-12">Email <span class="require">*</span></label>

                            <div class="col-md-12">
                                <input id="company_email" type="text" class="form-control validate[required] text-input" name="company_email" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category" class="col-md-12">Business Category</label>
                            <div class="col-md-12">
                                    <select name="category" id="category" class="trackprogress form-control text-input">
                                        <option value=""></option>
                                        @if($categories->count())
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" <?php if($category->id==1){?> selected="selected" <?php } ?>>{{$category->name}}</option>                                                    
                                            @endforeach
                                        @endif
                                    </select>                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-12">Business Description <span class="require">*</span></label>

                            <div class="col-md-12">
                                <textarea id="business_desc" class="form-control validate[required] text-input" name="business_desc"></textarea>
                            </div>
                        </div>
                        <?php if(!empty($site_setting[0]->site_logo)){
                        ?>						
                            <input type="hidden" name="site_logo" value="<?php echo $url.'/local/images/settings/'.$site_setting[0]->site_logo;?>">					
                        <?php } else { ?>
                            <input type="hidden" name="site_logo" value="">			
                        <?php } ?>
                            <input type="hidden" name="site_name" value="<?php echo $site_setting[0]->site_name;?>">
	
                        <div class="row">
                            <div class="col-md-12">		                       
                                <a href="<?php echo $url;?>/addcompany" class="btn btn-primary">
                                   Reset
                                </a>
                                <?php if(config('global.demosite')=="yes"){?><button type="button" class="btn btn-success radiusoff btndisable">Add</button> 
                                <span class="disabletxt">( <?php echo config('global.demotxt');?> )</span><?php } else { ?>			
                                    <button type="submit" class="btn btn-success radiusoff">
                                        Add
                                    </button>								
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
	 <?php } ?>
	 <div class="height30"></div>
	 <div class="row"></div>
	</div>
	</div>
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        @include('footer')
</body>
</html>