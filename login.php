<?php

include_once "functions.php";

setQuestion();

$redir = false;

if (isAdmin() or loginAdmin())
{
    $redir = true;
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ورود به سیستم</title>
    <link rel="stylesheet" href="css/pure.css" type="text/css"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <?php
    if ($redir == true)
    {
        ?>
            <script>
                window.location = <?php echo "\"" . HOME_URL . "\"" ?>;
            </script>
        <?php
    }
    ?>
</head>
<body>
<div class="main">
    <div class="pure-g">
        <div class="pure-u-1 header">
            <div class="inner">
                <a href="#"><h1>ورود به سیستم</h1></a>
            </div>
        </div>
    </div>

    <div class="pure-g">

        <?php
        getQuestionForm();
        getLoginForm();
        ?>
    </div>
    <?php getFooter() ?>

</div>
<script src="js/jquery.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>