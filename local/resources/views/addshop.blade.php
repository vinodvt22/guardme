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
	 <form class="form-horizontal" role="form" method="POST" action="{{ route('addshop') }}" id="formID" enctype="multipart/form-data">
                        {{ csrf_field() }}
	 
	 
	 <input type="hidden" name="editid" value="">
	 
	 
    <div class="row profile shop">
		<div class="col-md-12">
		
		<div class="form-group">
                            <label for="name" class="col-md-12">Company Name <span class="require">*</span></label>

                            <div class="col-md-12">
                     <input id="shop_name" type="text" class="form-control validate[required] text-input" name="shop_name" value="{{ old('shop_name') }}" autofocus>

                                
                            </div>
        </div>
		
		
		<input type="hidden" name="admin_email_id" value="<?php echo $admin_email_id[0]->email;?>">
                <input type="hidden" name="addresslat" id="addresslat" value="">	
                <input type="hidden" name="addresslong" id="addresslong" value="">
                
                <style>
                    #address_id{
                        width: 85%;
                        float: left;                                
                    }
                    #getaddress_error_message{
                        float:left;
                    }
                </style>
                <div class="form-group">
                    <label for="address" class="col-md-12">Address <span class="require">*</span></label>
                    <div class="col-md-12 littlebit"><span class="require">[Please fetch your address detail using your postcode]</span></div>                    
                    <div class="col-md-12">
                        <div id="postcode_lookup"></div>                        
                        @if(count($address) == 0)
                        <input id="line1" name="line1" class="form-control text-input validate[required]" type="text" placeholder="Address line1" value="{{ old('line1') }}">
                        <input id="line2" name="line2" class="form-control text-input" type="text" placeholder="Address line2" value="{{ old('line2') }}">
                        <input id="line3" name="line3" class="form-control text-input" type="text" placeholder="Address line3" value="{{ old('line3') }}">  
                        <input id="town" name="town" class="form-control text-input validate[required]" type="text" placeholder="Town" value="{{ old('town') }}">             
                        <input id="country" name="country" class="form-control text-input  validate[required]" type="text" placeholder="Country" value="{{ old('country') }}">
                        <input id="postcode" name="postcode" class="form-control text-input  validate[required]" type="text" placeholder="Postalcode" value="{{ old('postcode') }}">
                        @endif                                
                    </div>
                </div>		
		
		
		<div class="form-group {{ $errors->has('shop_phone_no') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-12">Phone Number <span class="require">*</span></label>

                            <div class="col-md-12">
                                <input id="shop_phone_no" type="text" class="form-control validate[required] text-input" name="shop_phone_no" value="{{ old('shop_phone_no') }}">
                                @if ($errors->has('shop_phone_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shop_phone_no') }}</strong>
                                    </span>
                                @endif
                                
                            </div>
        </div>		
		
		<div class="form-group {{ $errors->has('company_email') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-12">Company Email <span class="require">*</span></label>

                            <div class="col-md-12">
                                <input id="company_email" type="text" class="form-control validate[required] text-input" name="company_email" value="{{ old('company_email') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_email') }}</strong>
                                    </span>
                                @endif
                                
                            </div>
        </div>		
		
			
		</div>
		
		<div class="col-md-12 moves20">
            
			   
			   
			   <div class="form-group">
                            <label for="category" class="col-md-12">Business Category <span class="require">*</span></label>
                            <div class="col-md-12">
                                    <select name="category" id="category" class="trackprogress form-control text-input">
                                        <option value=""></option>
                                        @if($categories->count())
                                            @foreach($categories as $category)
                                                @if (Input::old('category') == $category->id)
                                                    <option value="{{ $category->id }}" selected>{{$category->name}}</option>
                                                @else
                                                    <option value="{{ $category->id }}">{{$category->name}}</option>
                                                @endif                                                
                                            @endforeach
                                        @endif
                                    </select>                               
                            </div>
                        </div>
			  <div class="form-group">
                            <label for="name" class="col-md-12">Business Description <span class="require">*</span></label>

                            <div class="col-md-12">
                                <textarea id="shop_desc" class="form-control validate[required] text-input" name="shop_desc">{{ old('shop_desc') }}</textarea>

                                
                            </div>
              </div>					  
                        <?php if(!empty($site_setting[0]->site_logo)){
							 
							?>
						
						<input type="hidden" name="site_logo" value="<?php echo $url.'/local/images/settings/'.$site_setting[0]->site_logo;?>">
					
						<?php } else { ?>
						
						<input type="hidden" name="site_logo" value="">
						
						<?php } ?>
						
						
						<input type="hidden" name="site_name" value="<?php echo $site_setting[0]->site_name;?>">
                     
                    
               
				
				
			   
			   
			   
			   
			   
           
		</div>
		
		
	
		
	</div>
	
    <div class="row">
	<div class="col-md-12">
		                       
							   <a href="<?php echo $url;?>/addshop" class="btn btn-primary">
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
	
	

	 </form>
	 
	 
	 <?php } ?>
	 
	 
	 
	 
	 
	 
	 <div class="height30"></div>
	 <div class="row">
	
	
	
	
	
	</div>
	
	</div>
	</div>
	
	
	

      <div class="clearfix"></div>
	   <div class="clearfix"></div>

      @include('footer')
</body>
</html>