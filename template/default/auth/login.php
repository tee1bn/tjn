<?php
$page_title = "Login";
include 'includes/auth_header.php';?>

					<h3 class="card-subtitle text-center pt-1"><b>Login</b></h3>

				</div>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
  						<form data-toggle="validator"  class="form-horizontal form-simple" id="loginform" action="<?=domain;?>/login/authenticate" method="post">

		                    <?php if(@$this->inputError('user_login') != '' ):?>
		                       <center class="alert alert-danger" >
		                        <?=$this->inputError('user_login');?>
		                       </center>
		                    <?php endif;?>
		  							
							<fieldset class="form-group position-relative has-icon-left mb-1">
								<label>Username</label>
								<input type="text" class="form-control" 
								placeholder="Username or Email" name="user" >

							</fieldset>

							<fieldset class="form-group position-relative has-icon-left">
								<label>Password</label>
								<input type="password" class="form-control" name="password" placeholder="Enter Password" required>
								<a href="<?=domain;?>/forgot-password" class="card-link"> Forgot Password ?</a>
							</fieldset>

			
							<fieldset class="form-group position-relative has-icon-left">

								<div 
									class="g-recaptcha form-group" data-sitekey="<?=SiteSettings::site_settings()['google_re_captcha_site_key'];?>">
								</div>


							</fieldset>



							<button type="submit" class="btn btn-dark btn-lg btn-block"> Log in</button>
						</form>
					</div>
					<p class="text-center ">Don't have an account? <a href="<?=domain;?>/register" class="card-link">Register now</a></p>
					<!-- <p class="text-center "> <a href="<?=domain;?>/forgot-password" class="card-link"> Forgot Password ?</a></p> -->
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