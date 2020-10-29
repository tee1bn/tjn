<?php
$page_title = "Register";
include 'includes/auth_header.php';?>

					<!-- <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Create Account</span></h6> -->
				</div>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
                <form data-toggle="validator"  class="form-horizontal form-simple"
                 id="loginform" action="<?=domain;?>/register/register" method="post">


							<div class="row">

							<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
                       			 <input type="" required="" 
                       			 	class="form-control form-control-lg" 
                       			 	value="<?=@Input::old('username');?>" name="username" placeholder="User Name">
                        			<span class="text-danger"><?=@$this->inputError('username');?></span>
								<div class="form-control-position">
								    <i class="ft-user"></i>
								</div>
							</fieldset>

							<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
							<select class="form-control-lg form-control" name="gender" required="" >
								<option value="">Select Gender</option>
								<?php foreach (User::$genders as $key => $value) :?>
									<option <?=(Input::old('gender') == $key)?'selected' : '';?>  value="<?=$key;?>"><?=$value;?></option>
								<?php endforeach ;?>
							</select>
                    		<span class="text-danger"><?=@$this->inputError('gender');?></span>
							</fieldset>



								
								<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
									<input type="" required="" class="form-control form-control-lg" value="<?=@Input::old('firstname');?>" name="firstname" placeholder="First Name">
	                        		<span class="text-danger"><?=@$this->inputError('firstname');?></span>
									<div class="form-control-position">
									    <i class="ft-user"></i>
									</div>
								</fieldset>



								<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
	                     		   <input type="" required="" class="form-control form-control-lg" value="<?=@Input::old('lastname');?>" name="lastname" placeholder="Last Name">
	                       			<span class="text-danger"><?=@$this->inputError('lastname');?></span>
									<div class="form-control-position">
									    <i class="ft-user"></i>
									</div>
								</fieldset>

							</div>




							<div class="row">

								<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
	                     		    <input type="email" required="" class="form-control form-control-lg" value="<?=@Input::old('email');?>" name="email" placeholder="Email">
	                        		<span class="text-danger"><?=@$this->inputError('email');?></span>
									<div class="form-control-position">
									    <i class="ft-mail"></i>
									</div>
								</fieldset>

								
								<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
	                     		    <input type="" required="" class="form-control form-control-lg" value="<?=@Input::old('phone');?>" name="phone" placeholder="Phone">
	                        		<span class="text-danger"><?=@$this->inputError('phone');?></span>
									<div class="form-control-position">
									    <i class="ft-phone"></i>
									</div>
								</fieldset>	


								<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
	                     		    <input type="date" required="" class="form-control form-control-lg" value="<?=@Input::old('birthdate');?>" name="birthdate" placeholder="Birth Date">
	                        		<span class="text-danger"><?=@$this->inputError('birthdate');?></span>
									<div class="form-control-position">
									    <i class="ft-calendar"></i>
									</div>
								</fieldset>


								<?php

									if (isset($_COOKIE['referral'])) {
										$introduced_by = $_COOKIE['referral'];
										$readonly   ="readonly='readonly'";

									}else{

										$introduced_by = Input::old('introduced_by');
									}
								;?>
									



								<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
	                     		    <input type="text" required="" <?=$readonly;?> class="form-control form-control-lg" 
	                     		    value="<?=$introduced_by;?>" name="introduced_by" placeholder="Sponsor">
	                        		<span class="text-danger"><?=@$this->inputError('introduced_by');?></span>
									<div class="form-control-position">
									    <i class="ft-user"></i>
									</div>
								</fieldset>



								<fieldset class="form-group col-md-6 position-relative has-icon-left mb-1">
								   <select class="form-control form-control-lg" name="country" required="">
								    <option value="">Select Country</option>
								    <?php foreach (World\Country::all() as $key => $country) :?>
								      <option <?=(Input::old('country') == $country->id)?'selected' : '';?> value="<?=$country->id;?>"><?=$country->name;?></option>
								    <?php endforeach ;?>
								  </select>
	                        		<span class="text-danger"><?=@$this->inputError('country');?></span>

								</fieldset>


									
								<fieldset class="form-group col-md-6 position-relative has-icon-left">

									<!-- <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter Password" required>
									<div class="form-control-position">
									    <i class="fa fa-key"></i>
									</div> -->




								<div class="input-group">
								                   <input placeholder="Enter Password" required="required" type="password" class="form-control form-control-lg" id="password" name="password">
								                   <div class="input-group-btn">
								                     <span class="btn btn-default btn-lg" style="height: 52px; cursor: pointer;" onclick="viewPassword()">
								                       <i class="fa fa-eye-slash" style="font-size: 12px; color: white;"></i>
								                     </span>
								                   </div>
								               </div>
								</fieldset>


								<script>
								    function viewPassword(){
								        $password = document.getElementById('password');
								        if ($password.type == 'password') {
								            $password.type = 'text';
								        }else{
								            $password.type = 'password';           
								        }
								    }
								</script>
<!-- 


		
								<fieldset class="form-group col-md-6 position-relative has-icon-left">
									<input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="Confirm Your Password" required>
									<div class="form-control-position">
									    <i class="fa fa-key"></i>
									</div>
								</fieldset>
 -->

							</div>
							
						

							<div class="row">
							

								<fieldset class="form-group col-md-6 position-relative has-icon-left">
									  <div class="g-recaptcha form-group" data-sitekey="<?=SiteSettings::site_settings()['google_re_captcha_site_key'];?>"></div>

								</fieldset>
							</div>

							<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Register</button>


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