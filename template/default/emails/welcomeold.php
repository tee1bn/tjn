<?php include 'includes/header.php';?>

                       <?php

                                $message =  CMS::fetch('welcome_email');

                                $message = str_replace("[FIRSTNAME]", "<b>$auth->firstname</b>", $message);
                                $message = str_replace("[LASTNAME]", "<b>$auth->lastname</b>", $message);
                                $message = str_replace("[FULLNAME]", "<b>$auth->fullname</b>", $message);
                                $message = str_replace("[USERNAME]", "<b>$auth->username</b>", $message);

                                echo $message;
                                ?>



<?php include 'includes/footer.php';?>