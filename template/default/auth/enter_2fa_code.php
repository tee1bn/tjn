<?php
$page_title = "2FA Authentication";
include 'includes/auth_header.php';?>


					<h3 class="card-subtitle text-center pt-1"><b>2FA Authentication</b></h3>
				</div>
				<div class="text-center">
					<small>Please enter 6 digit code on your Google Authenticator mobile App.</small>
				</div>
				<p></p>


				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
  						<form data-toggle="validator"  class="form-horizontal form-simple" id="loginform" action="<?=domain;?>/login/submit_2fa" method="post">

		                    <?php if(@$this->inputError('user_login') != '' ):?>
		                       <center class="alert alert-danger" >
		                        <?=$this->inputError('user_login');?>
		                       </center>
		                    <?php endif;?>
		  							
							<fieldset class="form-group position-relative has-icon-left mb-1">
								<label>2FA Code</label>
								<input type="text" class="form-control" 
								placeholder="Enter 2FA code" name="code" >
							</fieldset>


							<button type="submit" class="btn btn-lg btn-block">Submit</button>
						</form>
					</div>


					<p class="text-center">
						<a href="<?=domain;?>/register" class="card-link">Register</a> 
						<a href="<?=domain;?>/login" class="card-link">Login</a>
						<a href="<?=domain;?>/forgot-password" class="card-link"> Forgot Password ?</a>
					</p>
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