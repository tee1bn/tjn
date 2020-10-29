<?php
$page_title = "Login";
include 'includes/auth_header.php';?>




					<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Log in</span></h6>
				</div>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
  						<form data-toggle="validator"  class="form-horizontal form-simple" id="loginform" action="<?=domain;?>/login/authenticateAdmin" method="post">


			                <?php if(@$this->inputError('credentials') != '' ):?>
			                   <center class="alert alert-danger" >
			                    <?=$this->inputError('credentials');?>
			                   </center>
			                <?php endif;?>
                
		  							
							<fieldset class="form-group position-relative has-icon-left mb-1">
								<input type="text" class="form-control form-control-lg" 
								placeholder="Username or Email" name="user" >
								<div class="form-control-position">
								    <i class="ft-user"></i>
								</div>
							</fieldset>

							<fieldset class="form-group position-relative has-icon-left">
								<input type="password" class="form-control form-control-lg" name="password" placeholder="Enter Password" required>
								<div class="form-control-position">
								    <i class="fa fa-key"></i>
								</div>
							</fieldset>

							<fieldset class="form-group position-relative has-icon-left">

								<div 
									class="g-recaptcha form-group" data-sitekey="<?=SiteSettings::site_settings()['google_re_captcha_site_key'];?>">
								</div>


							</fieldset>



							<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Login</button>
						</form>
					</div>
<!-- 					<p class="text-center">Don't have an account ? <a href="<?=domain;?>/register" class="card-link">Register</a></p>
					<p class="text-center"> <a href="<?=domain;?>/forgot-password" class="card-link"> Forgot Password ?</a></p>
 -->				</div>
			</div>
		</div>
	</div>
</section>
        </div>
      </div>
    </div>
    <!-- END: Content-->
<?php include 'includes/auth_footer.php';