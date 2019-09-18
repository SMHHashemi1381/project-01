<?php
session_start();
define("WEB_TITLE" , 'پروژه');
define("HOME_URL" , "http://localhost/Project/project-01/");
define("QUESTION_PER_PAGE" , 4);
define("MIN_QUESTION_LENGHT",10);
define("MIN_USERNAME_LENGHT", 5);
define("DATE_FORMAT","d F Y");

ini_set("display_startup_errors","Off");
ini_set("error_reporting","~E_ALL");
ini_set("track_errors" , "Off");
ini_set('display_errors', 'Off');

define("ADMIN_DISPLAY" , 'مدیر');
define("ADMIN_USERNAME" , "MOHAMMAD");
define("ADMIN_PASSWORD" , "MH13810807");

define("DB_HOST" , "localhost");
define("DB_CONECT" , "project_01");
define("DB_USER" , "root");
define("DB_PASS" , "");