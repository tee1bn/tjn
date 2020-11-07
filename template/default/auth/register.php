<?php
$page_title = "Register";
include 'includes/auth_header.php';?>

					<h3 class="card-subtitle text-center pt-1"><b>Register</b></h3>
				</div>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
                <form data-toggle="validator"  class="form-horizontal form-simple"
                 id="loginform" action="<?=domain;?>/register/register" method="post">


							<div class="row">

							<fieldset class="form-group col-md-12">
								<label>Username</label>
                       			 <input type="" required="" 
                       			 	class="form-control " 
                       			 	value="<?=@Input::old('username');?>" name="username" placeholder="@username">
                        			<span class="text-danger"><?=@$this->inputError('username');?></span>
							</fieldset>

							<!-- <fieldset class="form-group col-md-12">
								<label>Username</label>
                       			 <input type="" required="" 
                       			 	class="form-control " 
                       			 	value="<?=@Input::old('username');?>" name="username" placeholder="User Name">
                        			<span class="text-danger"><?=@$this->inputError('username');?></span>
							</fieldset> -->


						<!-- 	<fieldset class="form-group col-md-12">
							<select class=" form-control" name="gender" required="" >
								<option value="">Select Gender</option>
								<?php foreach (User::$genders as $key => $value) :?>
									<option <?=(Input::old('gender') == $key)?'selected' : '';?>  value="<?=$key;?>"><?=$value;?></option>
								<?php endforeach ;?>
							</select>
                    		<span class="text-danger"><?=@$this->inputError('gender');?></span>
							</fieldset>



								 -->

								<fieldset class="form-group col-md-6">
									<label>First name</label>
									<input type="" required="" class="form-control " value="<?=@Input::old('firstname');?>" name="firstname" placeholder="First Name">
	                        		<span class="text-danger"><?=@$this->inputError('firstname');?></span>
								</fieldset>



								<fieldset class="form-group col-md-6">
									<label>Last name</label>
	                     		   <input type="" required="" class="form-control " value="<?=@Input::old('lastname');?>" name="lastname" placeholder="Last Name">
	                       			<span class="text-danger"><?=@$this->inputError('lastname');?></span>
								</fieldset>

					
								<fieldset class="form-group col-md-12">
								<label>E-mail</label>
	                     		    <input type="email" required="" class="form-control " value="<?=@Input::old('email');?>" name="email" placeholder="Email">
	                        		<span class="text-danger"><?=@$this->inputError('email');?></span>
								</fieldset>

								
								<fieldset class="form-group col-md-12">
								<label>Phone</label>
	                     		    <input type="" required="" class="form-control " value="<?=@Input::old('phone');?>" name="phone" placeholder="Phone">
	                        		<span class="text-danger"><?=@$this->inputError('phone');?></span>
								</fieldset>	

<!-- 
								<fieldset class="form-group col-md-12">
	                     		    <input type="date" required="" class="form-control " value="<?=@Input::old('birthdate');?>" name="birthdate" placeholder="Birth Date">
	                        		<span class="text-danger"><?=@$this->inputError('birthdate');?></span>
								</fieldset> -->


								<?php
							        $cookie_name = Config::cookie_name();
									if (isset($_COOKIE[$cookie_name])) {
										$introduced_by = $_COOKIE[$cookie_name];
										$readonly   ="readonly='readonly'";

									}else{

										$introduced_by = Input::old('introduced_by');
									}
								;?>
									

<!-- 

								<fieldset class="form-group col-md-12">
									<label>Sponsor</label>
	                     		    <input type="text" required="" <?=$readonly??'';?> class="form-control " 
	                     		    value="<?=$introduced_by;?>" name="introduced_by" placeholder="Sponsor">
	                        		<span class="text-danger"><?=@$this->inputError('introduced_by');?></span>
								</fieldset>
 -->

<!-- 
								<fieldset class="form-group col-md-12">
								   <select class="form-control " name="country" required="">
								    <option value="">Select Country</option>
								    <?php foreach (World\Country::all() as $key => $country) :?>
								      <option <?=(Input::old('country') == $country->id)?'selected' : '';?> value="<?=$country->id;?>"><?=$country->name;?></option>
								    <?php endforeach ;?>
								  </select>
	                        		<span class="text-danger"><?=@$this->inputError('country');?></span>

								</fieldset>
 -->


									
								<fieldset class="form-group col-md-12 ">
									<label>Password</label>
									<input type="password" name="password" class="form-control " placeholder="Enter Password" required>
								</fieldset>

		
								<fieldset class="form-group col-md-12 ">
<!-- 									<label>Confirm Password</label>
									<input type="password" name="confirm_password" class="form-control " placeholder="Confirm Your Password" required>
 -->								<label>

									<input type="checkbox" name="agreement" required="" value="i_agree">
									I agree with the <a href="#">User agreement</a> 
								</label>
								</fieldset>


								<fieldset class="form-group col-md-12 ">
									  <div class="g-recaptcha form-group" data-sitekey="<?=SiteSettings::site_settings()['google_re_captcha_site_key'];?>"></div>

								</fieldset>
							</div>

							<button type="submit" class="btn btn-primary btn-lg btn-block"> Register</button>


						</form>
					</div>
					<p class="text-center">Already have an account ? <a href="<?=domain;?>/login" class="card-link">Login</a></p>
				</div>
			</div>
		</div>
	</div>
</section>
        </div>
      </div>
    </div>
    <!-- END: Content-->
<?php include 'includes/auth_footer.php';