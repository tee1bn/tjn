
    <div class="content-body">



      <div class="">
        <div class="content-wrapper">
          <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 ">
              <h3 class="content-header-title mb-0">Publish Course</h3>
              <div class="row breadcrumbs-top">
               <div class="breadcrumb-wrapper col-12">
                 <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="<?=domain;?>">
                   Home</a>
                 </li>
                 <li class="breadcrumb-item"><a href="#">Users</a>
                 </li>
                 <li class="breadcrumb-item active">Publish Course
                 </li>
               </ol>
             </div>
           </div>
         </div>

       </div>
       <div class="content-body">
         <style>
           .course-structure-titles{
             font-weight: bold;
             margin-top: 40px; 
           }
           .lecture {
             margin-bottom: 0px;

           }
           .course-section{
             padding-bottom: 4px;
             padding-top: 4px;
           }
         </style>


         <!-- User Profile Cards -->
         <section id="user-profile-cards" class="row mt-2">

          <?php $this->view('auth/includes/course_nav', compact('course'));?>

          <div class="col-xl-10 col-md-10 col-12" style="padding: 0px;">
           <div class="card card border-teal border-lighten-2">
             <div class="text-center">

              <div class="card-body">
               <div class="card-text">
                 <h4>Publish Course</h4>
                <!--<p>You're on your way to creating a course! The descriptions you write here will help students decide if your course is the one for them.</p> -->
                           </div>
                           <br>
                           <form  class="ajax_form" method="post" enctype="multipart/form-data" action="<?=domain;?>/courses/add_publish_details">
                           <?=$this->csrf_field('publish_details_form');?>
                           <div class="form-body">
                             <div class="row">

                               <div class="form-group col-md-6">
                                <label class="pull-left">Course Title</label>
                                <div class="input-group">
                                 <input type="text" class="form-control" name="title" value="<?=(isset($course))?$course->title :Input::old('title');?>" placeholder="Add a specific Title" required>
                                 <div class="input-group-append" id="button-addon4">
                                 </div>
                               </div>
                             </div>

                             <div class="form-group col-md-2">
                              <label class="pull-left">Price (<b><?=$currency;?></b>)</label>
                              <div class="input-group">
                               <input type="number" class="form-control" name="price" value="<?=(isset($course))?$course->price :Input::old('price');?>" placeholder="Add a Price" step=".01" required>
                               <div class="input-group-append" id="button-addon4">
                               </div>
                             </div>
                           </div>



                             <div class="form-group col-md-2">
                              <label class="pull-left">Regular Price (<b><?=$currency;?></b>)</label>
                              <div class="input-group">
                               <input type="number" class="form-control" name="old_price" value="<?=(isset($course))?$course->old_price :Input::old('old_price');?>" placeholder="Add a Price" step=".01" required>
                               <div class="input-group-append" id="button-addon4">
                               </div>
                             </div>
                           </div>



                             <div class="form-group col-md-12">
                              <label class="pull-left">Offers </label>
                              <select class="form-control" multiple="" name="offers[]">
                                <option >Select Offers</option>
                                <?php foreach ($course->OffersAvailable as  $offer) :?>
                                  <option value="<?=$offer->id;?>"
                                    <?=(@in_array($offer->id, $course->OffersArray)) ? 'selected':'';?>
                                    ><?=$offer->name;?></option>
                                  <?php endforeach ;?>
                                </select>


                           </div>


                         </div>


                           <!-- 
                 <div class="form-group">
                      <label class="pull-left">Course Subtitle</label>
                         <div class="input-group">
                             <input type="text" class="form-control" placeholder="Button on right">
                             <div class="input-group-append" id="button-addon4">
                             </div>
                           </div>
                 </div>
                    
               -->


               <div class="form-group">
                <label class="pull-left">Course Description</label>
                <div class="input-group">
                 <textarea  id="editor1" style="width:100%;" type="text" required class="form-control" rows="5" name="description" 
                 placeholder="Add a concise description"><?=(isset($course))?$course->description :Input::old('description');?></textarea>
                 <div class="input-group-append" id="button-addon4">
                 </div>
               </div>
             </div>



             <script>    
               tinymce.init({
                 selector: '#editor1' ,
                 height : "380",
                 theme: "silver",
                 relative_urls: false,
                 remove_script_host: false,
                 convert_urls: true,
                 statusbar: false,
                 plugins: [
                 "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                 "searchreplace wordcount visualblocks visualchars code fullscreen",
                 "insertdatetime media nonbreaking save table contextmenu directionality",
                 "emoticons template paste textcolor colorpicker textpattern responsivefilemanager"
                 ],
                 toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                 toolbar2: "| responsivefilemanager print preview media | forecolor backcolor emoticons",
                 setup: function (editor) {
                   editor.on('change', function (e) {
                     editor.save();
                   });
                 }

               });

             </script>




             <div>

               <div class="row">

                 <div class="form-group col-md-4">
                  <label class="pull-left">What is primarily taught? </label>
                  <div class="input-group">
                   <input type="" class="form-control" required placeholder="e.g Landscape Photography" name="primarily_taught"
                   value="<?=(isset($course))?$course->primarily_taught :Input::old('primarily_taught');?>">
                   <div class="input-group-append" id="button-addon4">
                   </div>
                 </div>
               </div>
               <input type="hidden" name="course_id" value="<?=$course->id;?>">      
               <?php 
               $levels = ['Beginner', 'Intermediate', 'Expert'];
               ;?>
               <div class="form-group col-md-4">
                <label class="pull-left">Level</label>
                <div class="input-group">
                 <select class="form-control" required name="level" >
                   <option value="" >Select Level</option>
                   <?php foreach ($levels as  $level) :?>
                     <option value="<?=$level;?>"
                       <?=($course->level == $level) ? 'selected':'';?>

                       ><?=$level;?></option>
                     <?php endforeach ;?>
                   </select>
                   <div class="input-group-append" id="button-addon4">
                   </div>
                 </div>
               </div>


               <div class="form-group col-md-4">
                <label class="pull-left">Course Category</label>
                <div class="input-group">
                 <select class="form-control" required>
                   <option >Select Category</option>
                   <?php foreach (Category::all() as  $category) :?>
                     <option value="<?=$category->id;?>"
                       <?=($course->category_id == $category->id) ? 'selected':'';?>
                       ><?=$category->category;?></option>
                     <?php endforeach ;?>
                   </select>
                   <div class="input-group-append" id="button-addon4">
                   </div>
                 </div>
               </div>

             </div>

             <div class="form-group">
              <label class="pull-left">Course Image</label>
              <div class="input-group">
               <input type="file" class="form-control" name="image" placeholder="Button on right" >
               <div class="input-group-append" id="button-addon4">
               </div>
             </div>
             <small class="pull-left">
             Make your course stand out with a great image.</small>
           </div>
           <br>
         </div>    






       </div>

       <div class="form-actions center">
                             <button type="submit" class="btn btn-primary">
                               <i class="fa fa-check-square-o"></i> Save
                             </button>
                           </div>
                         </form>
                       </div>

                     </div>

                   </div>
                 </div>

               </section>
               <!--/ User Profile Cards -->


             </div>
           </div>
         </div>





       </div>