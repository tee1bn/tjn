	
<script>

function show_email_modal() {
			 if( window.$ ) {
$('#email_verification').modal('show');
		} else {
        // wait 50 milliseconds and try again.
        window.setTimeout( show_email_modal, 2000 );
    }

}
// show_email_modal();


function send_verification_email() {

		 if( window.$ ) {
        // do your action that depends on jQuery.  

  $.ajax({
      type: "POST",
      url: "<?=domain;?>/register/verify_email/<?=$this->auth()->email;?>",
      cache: false,
      success: function(response) {

if (response == 'false') {
		
		send_verification_email();

	}else if(response == 'true'){

		alert('email sent');


	}




},error: function(response) {

}

});

     $("#spiner").html('<i class="fa fa-spinner fa-spin"></i>');

  } else {
        // wait 50 milliseconds and try again.
        window.setTimeout( send_verification_email, 1000 );
    }
	}




</script>



<!-- Modal -->
<div id="email_verification" data-backdrop="static" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Email Verification</h4>
      </div>
      <div class="modal-body">
        <p>Hello <?=$this->auth()->firstname;?>! We have sent you a mail. kindly check your mail box to verify your email.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="send_verification_email();">
        	<span id="spiner"></span>Resend</button>
      </div>
    </div>

  </div>
</div>
	