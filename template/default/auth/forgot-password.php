<?php
$page_title = "Forgot Password";
include 'includes/auth_header.php';?>




					<h3 class="card-subtitle text-center pt-1"><b>Forgot Password?</b></h3>
				</div>
				<div class="text-center">
					<small>To reset your password, please enter the email associated with your account.</small>
				</div>
				<p></p>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
  						<form data-toggle="validator"  class="form-horizontal form-simple ajax_for" id="loginform" action="<?=domain;?>/forgot-password/send_link" method="post">

		  							
							<fieldset class="form-group position-relative has-icon-left mb-1">
								<label>Your E-mail Address</label>
								<input type="text" class="form-control" 
								placeholder="Email Address" name="user" >
							</fieldset>

							<fieldset class="form-group position-relative has-icon-left">

								<div 
									class="g-recaptcha form-group" data-sitekey="<?=SiteSettings::site_settings()['google_re_captcha_site_key'];?>">
								</div>

							</fieldset>

							<button type="submit" class="btn btn-primary btn-lg btn-block"> Submit</button>
						</form>
					</div>
					<p class="text-center">Don't have an account ? <a href="<?=domain;?>/register" class="card-link">Register</a></p>
					<p class="text-center">Go back to <a href="<?=domain;?>/login" class="card-link"> Log In</a></p>
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