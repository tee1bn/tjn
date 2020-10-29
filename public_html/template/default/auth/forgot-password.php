<?php
$page_title = "Forgot Password";
include 'includes/auth_header.php';?>




					<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Reset Password</span></h6>
				</div>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
  						<form data-toggle="validator"  class="form-horizontal form-simple ajax_form" id="loginform" action="<?=domain;?>/forgot-password/send_link" method="post">

		  							
							<fieldset class="form-group position-relative has-icon-left mb-1">
								<input type="text" class="form-control form-control-lg" 
								placeholder="Email" name="user" >
								<div class="form-control-position">
								    <i class="ft-user"></i>
								</div>
								<small>* Enter the email associated with your <?=project_name;?> Profile</small>
							</fieldset>

							<fieldset class="form-group position-relative has-icon-left">

								<div 
									class="g-recaptcha form-group" data-sitekey="<?=SiteSettings::site_settings()['google_re_captcha_site_key'];?>">
								</div>

							</fieldset>

							<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Reset</button>
						</form>
					</div>
					<p class="text-center">Don't have an account ? <a href="<?=domain;?>/register" class="card-link">Register</a></p>
					<p class="text-center"> <a href="<?=domain;?>/login" class="card-link"> Sign In</a></p>
				</div>

			         
    <!-- END: Content-->
<?php include 'includes/auth_footer.php';