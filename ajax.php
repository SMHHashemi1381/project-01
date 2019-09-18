<?php
include_once "functions.php";
if (isset($_GET['action']))
{
    $massage = $_GET['action'];
    $type = explode("-",$massage);
    switch ($type[0])
    {
        case "qmd" :
            deletQ($type[1]);
            echo "با موفقیت حذف شد!";
            break;
        case "qmpu" :
            publishQ($type[1]);
            echo "با موفقیت تائید شد!";
            break;
        case "qmpe" :
            pendingQ($type[1]);
            echo "با موفقیت لغو تائید شد!";
            break;
    }
}

if (isset($_POST["qid"]) && isset($_POST["text"]))
{
    $qid = $_POST["qid"];
    $text = $_POST["text"];
    setAnswer($qid,$text);
    echo "با موفقیت ارسال شد!";
}












