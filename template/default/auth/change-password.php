<?php
$page_title = "Reset Password";
include 'includes/auth_header.php';?>




					<!-- <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span class="spanntext">Reset Password</span></h6> -->
				</div>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
  						<form data-toggle="validator"  class="form-horizontal form-simple" id="loginform" action="<?=domain;?>/forgot-password/reset_password" method="post">

		  							
                         <div class="form-group">
                             <input type="hidden" class="form-control" id="email" placeholder="Email Address" name="user" value="<?=$_SESSION['change_password_email'];?>" readonly required>
                        </div>



                        <div class="form-group">
                                <input type="Password" class="form-control" id="email" placeholder="New Password" name="new_password" value=""  required>
                             <small class="pull-left" style="color: red;">   <?=@$this->inputError('new_password');?></small>
                        </div>



                        <div class="form-group">
                                <input type="Password" class="form-control" id="email" placeholder="Confirm New Password" name="confirm_new_password" value=""  required>
                             <small class="pull-left" style="color: red;">   <?=@$this->inputError('confirm_new_password');?></small>
                            </div>


							<button type="submit" class="btn btn-lg btn-dark btn-block"><i class="ft-unlock"></i> Reset Password</button>
						</form>
					</div>
					<p class="text-center">Don't have an account ? <a href="<?=domain;?>/register" class="card-link">Register</a></p>
					<p class="text-center"> <a href="<?=domain;?>/login" class="card-link"> Sign In</a></p>
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