<?php
include_once "config.php";
include_once "functions.php";
if (isset($_GET["exeit"]) && isAdmin())
{
    setcookie('username',"",time()-1);
    setcookie('password',"",time()-1);
}

setQuestion();

setAnswer();

nPage();

?>
<html lang="fa">
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title><?php echo WEB_TITLE; ?></title>
    <link rel="stylesheet" href="css/pure.css" type="text/css"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
</head>
<body data-url= <?php echo "\"" . HOME_URL . "\""; ?> >
<div class="main">
    <div class="pure-g">
        <div class="pure-u-1 header">
            <div class="inner">
                <a href="<?php echo HOME_URL; ?>"><h1><?php echo WEB_TITLE; ?></h1></a>
                <?php getAdminTab() ?>
                <?php getSearchForm() ?>
            </div>
        </div>
    </div>

    <div class="pure-g">
        <?php getQuestionForm(); ?>
        <div class="pure-u-4-5 content">
            <div class="inner">
                <div class="qTitle">لیست سوالات مطرح شده :</div>
                <?php

                getQuestions();

                getCounterPage();
                ?>

        </div>
    </div>
    <?php getFooter() ?>

</div>
<script src="js/jquery.min.js"></script>
<script src="js/scripts.js"></script>
<?php
if (isAdmin())
{
    ?>
    <script src="js/admin.js"></script>
    <?php
}
?>
</body>
</html>