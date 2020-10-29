	
<script>

function show_phone_modal() {
			 if( window.$ ) {
$('#phone_verification').modal('show');
		} else {
        // wait 50 milliseconds and try again.
        window.setTimeout( show_phone_modal, 1000 );
    }

}
show_phone_modal();


function send_phone_verification_code() {

		 if( window.$ ) {
        // do your action that depends on jQuery.  
     $("#phone_spiner").html('<i class="fa fa-spinner fa-spin"></i>');

  $.ajax({
      type: "POST",
      url: "<?=$this->domain;?>/register/verify_phone",
      cache: false,
      success: function(response) {


},error: function(response) {

}

});

     $("#phone_spiner").html('<i class="fa fa-spinner fa-spin"></i>');

  } else {
        // wait 50 milliseconds and try again.
        window.setTimeout( send_phone_verification_code, 1000 );
    }
	}




</script>



<!-- Modal -->
<div id="phone_verification" data-backdrop="static" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Phone Verification</h4>
      </div>
      <div class="modal-body">
        <p>Hello <?=$this->auth()->firstname;?>! We have sent a code to your phone. kindly check and enter the code to continue.</p>

      <form method="POST" action="<?=$this->domain;?>/register/confirm_phone/">
        <input type="text" name="phone_code" placeholder="Enter Phone code" class="form-control">
        <?=$this->inputError('phone_code');?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="send_phone_verification_code();">
          <span id="phone_spiner"></span>Resend</button>

           <button type="submit" class="btn btn-default" >
        	Confirm</button>
      </div>
            </form>

    </div>

  </div>
</div>
	