<?php
//    $title = "MyPersonalErrorPage";
//    $message = "MyPersonal ErrorMessage";
    require_once("layouts/top.php");
?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-3"><?php print htmlentities($title) ?></h1>
        <p class="lead"> <?php print htmlentities($message) ?></p>
        <hr class="my-2">
    </div>
</div>

</body>
</html>
