


<style>
  #gitstar-notification, #gitstar-notice {
    position: fixed;
    top: 10px;
    z-index: 99999999999999;
    width:400px;
    margin-left: -200px;
    left: 50%;
    display: none;
    padding: 5px 50px 5px 24px;
  }
</style>




<div id="page_preloader" style="
background: #65323230;
position: fixed;
top: 0px;
right: 0px;
width: 100%;
height: 100%;
padding-top: 22%;
text-align:center;
display: none;
z-index: 9;">

<i class="fa fa-circle-notch fa-spin" style="
z-index: 99999;
font-size: 90px;">
</i>

</div>



<center class="text-center wrapper">  
  <div id="gitstar-notification"  class="alert alert-info alert-dismissible" >
    <a href="javascript:void;" class="close" onclick="document.getElementById('gitstar-notification').style.display='none'">&times;</a>
    <!-- <strong><i class='fa fa-bell pull-left'> </i></strong>  -->

    <span id="error_note"> </span>    
  </div>
</center>





<script>


  perform_automatching = function() {

    $.ajax({
      type: "POST",
      url: '<?=domain;?>'+"/auto-match/auth_cron",
      cache: false,
      success: function(data) {
        console.log(data);
      },
      error: function (data) {}
    });
  }

  perform_automatching();


  notify = function () {
    $.ajax({
      type: "POST",
      url: '<?=domain;?>'+"/home/flash_notification/",
      cache: false,
      success: function(data) {


        let $error_note = '';
        let $error_type = '';
        for (var i = 0; i < data.length; i++) {
          $error_note += data[i]['message'] +'<br>';
          $error_type = data[i]['title'] ;

        }

        if ($error_note != '') {

          show_notification($error_note, $error_type);
        }




      },
      error: function (data) {
                 //alert("fail"+data);
               }



             });

  }


  show_notification = function ($notification, $error_type='info') {
    $('#error_note').html($notification);
    $('#gitstar-notification').css('display', 'block');


    $('#gitstar-notification').hover(
      function () {
        $(this).stop();
      });

    document.getElementById('gitstar-notification').setAttribute("class","alert alert-"+$error_type+" alert-dismissible");
  }

  notify();



  $(document).ready(function(){
   $("body").on("submit", "#newsletter_form", function (e) {
    e.preventDefault();

    $datastring = $('#newsletter_form').serialize();

    $.ajax({

      type: "POST",
      url: '<?=domain;?>'+"/contact/add_to_news_letter/",
      data: $datastring,
      cache: false,
      success: function(data) {

        show_notification(data);

      },
      error: function (data) {
                 //alert("fail"+data);
               },



             });


  });
 });

</script>


<script>
  add_to_new_letters = function ($input) {

   var form_data = new FormData();

   form_data.append("newsletter" , $input.value);

   $.ajax({
     type: "POST",
     url: '<?=domain;?>/home/add_to_new_letters',
           data: form_data, // 
           contentType: false,
           cache:false,
           processData:false,
           success: function(data)
           {
            notify();

          }
        });


 }
</script> 

<script type="text/javascript">

  function copy_text($text) {
    var copyText = document.createElement('input');
    copyText.setAttribute('readonly', '');
    copyText.style = {position: 'absolute', left: '-9999px'};
    document.body.appendChild(copyText);
    copyText.value = $text;
    copyText.select();
    (  document.execCommand("copy"));
    // Remove temporary element
    document.body.removeChild(copyText);
    show_notification("<code>Copied</code> "+ $text, "dark");
  }


  send_email_code = function(){

    $form = new FormData;
    $form.append('page', "<?=MIS::current_url();?>");
    $("#page_preloader").css('display', 'block');

    $.ajax({
        type: "POST",
        url: $base_url+"/user/send_email_code",
        data: $form,
        contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
        processData: false, // NEEDED, DON'T OMIT THIS
        cache: false,
        success: function(data) {
        $("#page_preloader").css('display', 'none');
          window.notify();
        },
        error: function (data) {
        },
        complete: function(){

        }
    });
  }
  



</script>





