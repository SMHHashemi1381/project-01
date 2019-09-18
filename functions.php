<?php
include_once "config.php";

function createQuestion($n,$e,$p,$t)
{
    global $mySql;
    $mySql->query("INSERT INTO questions (id, uname, umail, umobile, text, status, create_date) VALUES (NULL, '$n', '$e', '$p', '$t', 'pending' , CURRENT_TIMESTAMP)");
}

function getAdminTab()
{
    if (isAdmin())
    {
        ?>
        <div>
            <span>سلام <?php echo ADMIN_USERNAME; ?></span><br>
            <a href="?exeit" style="color: red">خروج</a>
        </div>
        <?php
    }
}

function getCountPage ()
{
    $countPage = ceil(count(getQuestion()) / QUESTION_PER_PAGE);
    return $countPage;
}

function getQuestion($DESC = true)
{
    global $mySql;
    $quest = [];
    if (isset($_REQUEST['search']))
    {
        $like = $_REQUEST['search'];
        if ($DESC == true)
        {
            $ques = $mySql->query("SELECT * FROM questions WHERE text LIKE '%$like%' ORDER BY questions.id DESC");
            $question = $ques->fetchAll(2);
        } else
        {
            $ques = $mySql->query("SELECT * FROM questions WHERE text  LIKE '%$like%' ORDER BY questions.id");
            $question = $ques->fetchAll(2);
        }

        if (isset($_REQUEST["status"]) && $_REQUEST["status"] != "all")
        {
            $questi = [];
            foreach ($question as $getquestion)
            {
                if ($getquestion["status"] == $_REQUEST["status"])
                {
                    $questi[] = $getquestion;
                }
            }
            $quest = $questi;
        } else
        {
            $quest = $question;
        }
    }
    else
    {
        if ($DESC == true)
        {
            $ques = $mySql->query("SELECT * FROM questions ORDER BY questions.id DESC");
            $question = $ques->fetchAll(2);
        } else
        {
            $ques = $mySql->query("SELECT * FROM questions ORDER BY questions.id");
            $question = $ques->fetchAll(2);
        }
        if (isset($_REQUEST["status"]) && $_REQUEST["status"] != "all")
        {
            $ques = [];
            foreach ($question as $getquestion)
            {
                if ($getquestion["status"] == $_REQUEST["status"])
                {
                    $ques[] = $getquestion;
                }
            }
            $quest = $ques;
        } else
        {
            $quest = $question;
        }
    }
    return $quest;
}

function getAnswers($DESC = false)
{
    global $mySql;
    if ($DESC == true)
    {
        $ans = $mySql->query("SELECT * FROM answers ORDER BY answers.create_date DESC");
        $answers = $ans->fetchAll(2);
    } else
    {
        $ans = $mySql->query("SELECT * FROM answers ORDER BY answers.create_date");
        $answers = $ans->fetchAll(2);
    }
    return $answers;
}

function deletQ ($a)
{
    global $mySql;
    $del = $mySql->prepare("DELETE FROM `questions` WHERE `questions`.`id` = ?");
    $del->execute(array($a));
}

function publishQ ($a)
{
    global $mySql;
    $pub = $mySql->prepare("UPDATE `questions` SET `status` = 'publish' WHERE `questions`.`id` = ?");
    $pub->execute(array($a));
}

function answerdQ ($a)
{
    global $mySql;
    $pub = $mySql->prepare("UPDATE `questions` SET `status` = 'answered' WHERE `questions`.`id` = ?");
    $pub->execute(array($a));
}

function pendingQ ($a)
{
    global $mySql;
    $pen = $mySql->prepare("UPDATE `questions` SET `status` = 'pending' WHERE `questions`.`id` = ?");
    $pen->execute(array($a));
}

function createAnsver($a,$b)
{
    global $mySql;
    $mySql->exec("INSERT INTO answers (id, qid, text, create_date) VALUES (NULL, '$a', '$b', CURRENT_TIMESTAMP)");
    publishQ($a);
    answerdQ($a);
}

function loginAdmin ()
{
    if (!isAdmin())
    {
        if (isset($_POST["username"]) && isset($_POST["password"]) && $_POST["username"] === ADMIN_USERNAME && $_POST["password"] === ADMIN_PASSWORD) {
            setcookie('username', $_POST["username"],time() + ( 60 * 60 * 24 * 7 ));
            setcookie('password', $_POST["password"],time() + ( 60 * 60 * 24 * 7 ));
            return true;
        }
    } else
    {
        return false;
    }
}

function getQuestionForm ()
{
    ?>
    <div class="pure-u-1-5 sidebar">
            <div class="inner">
                <div class="menu">
                    <div class="menu-title">طرح سوال :</div>
                    <div class="menu-content">
                        <form action="" method="post" class="pure-form searchform">
                            <input type="text" name="uName" placeholder="نام کامل شما"/>
                            <input type="text" name="uMail" class="ltr" placeholder="ایمیل شما"/>
                            <input type="text" name="uMobile" class="ltr" placeholder="شماره موبایل شما"/>
                            <textarea type="text" name="uQuestion" placeholder="متن سوال شما"></textarea>
                            <input type="submit" name="submitQuestion" value="ارسال سوال"
                                   class="pure-button button-green">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

function isAdmin ()
{
    if (isset($_COOKIE["username"]) && isset($_COOKIE["password"]) && $_COOKIE["username"] === ADMIN_USERNAME && $_COOKIE["password"] === ADMIN_PASSWORD)
    {
        return true;
    } else
    {
        return false;
    }
}

function getBCP($page)
{
    if (isset($_REQUEST["status"]))
    {
        $search = '';
        if (isset($_REQUEST['search']))
        {
            $search = $_REQUEST['search'];
        }
        $status = $_REQUEST["status"];
        echo "<a href=\"?page=$page&status=$status&search=$search\">$page</a>";
    } else {
        echo "<a href=\"?page=$page\">$page</a>";
    }
}

function getCounterPage()
{
    ?>
    <div class="pagination clearfix">
        <?php
        if (isset($_REQUEST["status"])) {
            $status = $_REQUEST["status"];
            $search = '';
            if (isset($_REQUEST['search'])) {
                $search = $_REQUEST['search'];
            }
            echo "<a href=\"?page=first&status=$status&search=$search\">«</a>";
        } else {
            echo "<a href=\"?page=first\">«</a>";
        }
        for ($in = 0 ; $in < getCountPage() ; $in ++)
        {
            $page = 1 + $in;
            if ($_GET["page"] && $_GET["page"] == $page) {
                echo "<strong>$page</strong>";
            } elseif ($_GET["page"] == "first") {
                if ($page == 1)
                {
                    echo "<strong>$page</strong>";
                }else {
                    getBCP($page);
                }
            } elseif ($_GET["page"] == "last") {
                if ($page != 5)
                {
                    getBCP($page);
                }else {
                    echo "<strong>$page</strong>";
                }
            }
            else {
                getBCP($page);
            }
        }
        if (isset($_REQUEST["status"])) {
            $status = $_REQUEST["status"];
            $search = '';
            if (isset($_REQUEST['search'])) {
                $search = $_REQUEST['search'];
            }
            echo "<a href=\"?page=last&status=$status&search=$search\">»</a>";
        } else {
            echo "<a href=\"?page=last\">»</a>";
        }
        ?>
    </div>
    <?php
}

function getQuestions() {
    $page = $_GET['page'];
    if ($page > getCountPage())
    {
        $page = 1;
    }
    if ($page == 'first') {
        $page = 1;
    }
    if ($page == "last") {
        $page = getCountPage();
    }
    if ($page == getCountPage()){
        $maxP = count(getQuestion());
    } else {
        $maxP = QUESTION_PER_PAGE * $page;
    }
    if (count(getQuestion()) > 0)
    {
        for ($i = QUESTION_PER_PAGE * ($page - 1) ; $i < $maxP ; $i ++ ) {
            ?>
            <div class="question <?php echo getQuestion()[$i]["status"]; ?>" id="q-<?php echo $i + 1; ?>">
                <?php
                if (isAdmin())
                {
                    {
                        ?>
                        <div class="qManage br5">
                            <span class="qmr">افزودن پاسخ</span> &nbsp; &nbsp;
                            <span class="qm" id="qmd-<?php echo getQuestion()[$i]["id"]; ?>">حذف</span> &nbsp;
                            &nbsp;
                            <span class="qm" id="qmpu-<?php echo getQuestion()[$i]["id"]; ?>">تائید</span>
                            &nbsp; &nbsp;
                            <span class="qm" id="qmpe-<?php echo getQuestion()[$i]["id"]; ?>">لغو تائید</span>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="q"><span class="i">+</span><?php echo getQuestion()[$i]["text"]; ?></div>
                <div class="r">
                    <form action="" method="post" class="pure-form replyForm">
                        <input name="qid" value="<?php echo getQuestion()[$i]["id"]; ?>" type="hidden"/>
                        <textarea name="text" rows="5" placeholder="پاسخ دهید ..."></textarea>
                        <input type="submit" name="submitAnswer" class="pure-button button-green submit"
                               value="ارسال پاسخ"/>
                        <div class="clear"></div>
                    </form>
                </div>
                <?php
                foreach (getAnswers() as $answer) {
                    if ($answer["qid"] == getQuestion()[$i]["id"]) {
                        echo "<div class=\"a\">" . $answer["text"] . "</div>";
                    }
                }
                ?>
            </div>
            <?php
        }
    } else {
        echo "<span>هیچ سوالی وجود ندارد!</span>";
    }
}

function getSearchForm()
{
    ?>
    <form action="" method="post" class="pure-form searchform">
        <select name="status">
            <option value="all">همه</option>
            <option value="pending" <?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == "pending") {echo 'selected';} ?>>منتظر تائید</option>
            <option value="publish" <?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == "publish") {echo 'selected';} ?>>بدون پاسخ</option>
            <option value="answered" <?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == "answered") {echo 'selected';} ?>>پاسخ داده شده</option>
        </select>
        <input type="text" name="search" id="s" <?php if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) { echo "value=\"" . $_REQUEST['search'] . "\"";} ?>/>
        <button class="pure-button button-green">جستجو</button>
    </form>
    <?php
}

function setAnswer ()
{
    if (isset($_POST['text']) && isset($_POST['qid']))
    {
        $qid = $_POST['qid'];
        $text = $_POST['text'];
        createAnsver($qid,$text);
    }
}

function createAnswers ($a,$b)
{
    global $mySql;
    $mySql->exec("INSERT INTO answers VALUES (NULL, '$a', '$b', CURRENT_TIMESTAMP);");

}

function setQuestion ()
{
    if (isset($_POST['uName']) && isset($_POST['uMail']) && isset($_POST['uMobile']) && isset($_POST['uQuestion']))
    {
        $name = $_POST['uName'];
        $email = $_POST['uMail'];
        $phone = $_POST['uMobile'];
        $text = $_POST['uQuestion'];
        createQuestion($name,$email,$phone,$text);
        ?>
        <script>
            alert("سوال شما با موفقیت ایجاد شد؟");
            window.location = <?php echo "\"" . HOME_URL . "\"" ?>;
        </script>
        <?php
    }
}

function nPage ()
{
    if (!isset($_GET['page']) && !isset($_REQUEST["status"]))
    {
        ?>
        <script>
            window.location = <?php echo "\"" . HOME_URL . "\""; ?> + "?page=1&status=all";
        </script>
        <?php
    }
}

function getFooter ()
{
    ?>
    <div class="pure-g" style="width: 100%;">
        <div class="pure-u-1 footer">
            <div class="inner">تمامی حقوق محفوظ است <?php echo WEB_TITLE; ?></div>
        </div>
    </div>
    <?php
}

function getLoginForm ()
{
    ?>
    <div class="pure-u-4-5 content">
        <div class="inner">
            <form action="" method="post" class="ltr pure-form loginform">
                <input type="text" name="username" class="ltr" placeholder="Username"><br>
                <input type="password" name="password" class="ltr" placeholder="Password"><br>
                <input type="submit" name="login" value="Login" class="pure-button button-green">
            </form>
        </div>
    </div>
    <?php
}