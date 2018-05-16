<!DOCTYPE html>
<html lang="en">
  <head>

   @include('admin.title')

    @include('admin.style')


  </head>

  <body>
    <div class="wrapper">
      <!-- <div class="main_container"> -->
      <div class="sidebar" data-background-color="white" data-active-color="danger">
        <div class="sidebar-wrapper">
            @include('admin.sitename');

            <!-- <div class="clearfix"></div> -->

            <!-- menu profile quick info -->
            @include('admin.welcomeuser')
            <!-- /menu profile quick info -->

            <!-- <br /> -->

            <!-- sidebar menu -->
            @include('admin.menu')




            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->

            <!-- /menu footer buttons -->
          </div>
        </div>

<div class="main-panel">
        <!-- top navigation -->
       @include('admin.top')




        <!-- /top navigation -->

        <!-- page content -->
        <div class="content">
          <!-- top tiles -->






          <div class="container-fluid">
            <div class="card" style="padding:15px;">
                     <div class="row">

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

  <div class="header">
      <h4 class="title">Edit User</h4>
      <!-- <p class="category">Here is a subtitle for this table</p> -->
  </div>

        <form class="form-horizontal form-label-left" role="form" method="POST" action="{{ route('admin.addbalance') }}"novalidate>
          <div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-1">
            <?php
            use Responsive\User;$luser = User::where('id', $users[0]->id)->first();
            ?>
            <span class="section">Current balance: {{ $luser->getBalance() }}</span>
            <div class="form-group">
                <label for="balance">Add points to balance
                </label>

                    <input type="number" min="0" value="0" id="balance" name="balance" required="required" class="form-control  border-input">

            </div>
            <input type="hidden" name="user" value="{{ $users[0]->id }}">
                {{ csrf_field() }}

            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button id="send" type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
                </div>
            </div>
          </div>

        </form>
                   <form class="form-horizontal form-label-left" role="form" method="POST" action="{{ route('admin.edituser') }}" enctype="multipart/form-data" novalidate>
                     <div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-1">
                     {{ csrf_field() }}
                      <!-- <span class="section">Edit User</span> -->

                      <div class="item form-group">
                        <label  for="name">Username <span class="required">*</span>
                        </label>

                          <input id="name" class="form-control border-input"  name="name" value="<?php echo $users[0]->name; ?>" required="required" type="text">
                         @if ($errors->has('name'))
                                    <span class="help-block" style="color:red;">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                      </div>
                      <div class="form-group">
                        <label for="email">Email <span class="required">*</span>
                        </label>

                          <input type="email" id="email" name="email" required="required" value="<?php echo $users[0]->email; ?>" class="form-control border-input">
						  @if ($errors->has('email'))
                                    <span class="help-block" style="color:red;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                      </div>


<?php if($userid==1) {?>
                      <div class="form-group">
                        <label for="password" >Password <span class="required">*</span></label>

                          <input id="password" type="text" name="password" value=""  class="form-control border-input">


                      </div>

<?php } ?>


					  <input type="hidden" name="savepassword" value="<?php echo $users[0]->password;?>">



                      <div class="form-group">
                        <label for="telephone">Phone <span class="required">*</span>
                        </label>

                          <input type="tel" id="phone" name="phone" required="required" data-validate-length-range="8,20" class="form-control border-input" value="<?php echo $users[0]->phone; ?>">

                      </div>
					  <input type="hidden" name="id" value="<?php echo $users[0]->id; ?>">



					   <div class="form-group">
                        <label for="photo">Photo <span class="required">*</span>
                        </label>

                          <input type="file" id="photo" name="photo" class="form-control border-input">
						  @if ($errors->has('photo'))
                                    <span class="help-block" style="color:red;">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                @endif

                      </div>
					   <?php $url = URL::to("/"); ?>
					  <?php
					   $userphoto="/userphoto/";
						$path ='/local/images'.$userphoto.$users[0]->photo;
						if($users[0]->photo!=""){
						?>
					  <div class=" form-group" align="center">

					  <img src="<?php echo $url.$path;?>" class="thumb" width="100">

					  </div>
						<?php } else { ?>
					  <div class="form-group" align="center">

					  <img src="<?php echo $url.'/local/images/nophoto.jpg';?>" class="thumb" width="100">

					  </div>
						<?php } ?>

					  <input type="hidden" name="currentphoto" value="<?php echo $users[0]->photo;?>">





					  <?php if($users[0]->admin!=1){?>
					   <div class="form-group">
                        <label for="usertype">User Type <span class="required">*</span>
                        </label>

						<select name="usertype" required="required" class="form-control border-input">
						<option value=""></option>
							   <option value="0" <?php if($users[0]->admin==0){?> selected="selected" <?php } ?>>Customer</option>
							   <option value="2" <?php if($users[0]->admin==2){?> selected="selected" <?php } ?>>Seller</option>
						</select>


                      </div>
					  <?php } ?>


					  <?php if($users[0]->admin==1){?>

					  <input type="hidden" name="usertype" value="<?php echo $users[0]->admin;?>">

					  <?php } ?>


                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <a href="<?php echo $url;?>/admin/users" class="btn btn-primary btn-fill">Cancel</a>


						  <?php if(config('global.demosite')=="yes"){?><button type="button" class="btn btn-info btn-fill btn-wd">Submit</button>
								<span class="disabletxt">( <?php echo config('global.demotxt');?> )</span><?php } else { ?>
                          <button id="send" type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
						  <?php } ?>
                        </div>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>















        <!-- /page content -->

      @include('admin.footer')
      </div>
    </div>



  </body>
</html>
