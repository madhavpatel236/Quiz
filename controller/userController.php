<?php

require('../constant.php');
// include './index.php';
include __APPPATH__ . '/model/userModel.php';
// var_dump($GLOBALS);
class userController
{
    public $userModelObj;
    public $question1;
    public $question2;
    public $question3;
    public $question4;
    public $question5;
    public $errors = ['question1_error' => '', 'question2_error' => '', 'question3_error' => '', 'question4_error' => '', 'question5_error' => ''];

    public function __construct()
    {
        $this->userModelObj = $GLOBALS['userModelObj'];

        // validation
        $this->question1 = isset($_POST['question1']) ? $_POST['question1'] : '';
        $this->question2 = $_POST['question2'];
        $this->question3 = $_POST['question3'];
        $this->question4 = $_POST['question4'];
        $this->question5 = $_POST['question5'];

        if (empty($this->question1)) {
            $this->errors['question1_error'] = "Please enter the answer for submit the quize.";
        }
        if (empty($this->question2)) {
            $this->errors['question2_error'] = "Please enter the answer for submit the quize.";
        }
        if (empty($this->question3)) {
            $this->errors['question3_error'] = "Please enter the answer for submit the quize.";
        }
        if (empty($this->question4)) {
            $this->errors['question4_error'] = "Please enter the answer for submit the quize.";
        }
        if (empty($this->question5)) {
            $this->errors['question5_error'] = "Please enter the answer for submit the quize.";
        }
    }

    public function insertData()
    {
        $data = $this->userModelObj->InsertUserData();
    }

    public function showResult()
    {
        $data = $this->userModelObj->userRankTable();
        echo json_encode($data);
    }

    public function userTestStatus()
    {
        $data =  $this->userModelObj->isTestCompleted();
        echo json_encode($data);
        return $data;
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userControllerObj = new userController();

    if (isset($_POST['logout_btn'])) {
        $_SESSION['isLogin'] = false;
        header("Location: /Game1/index.php");
        exit;
    }

    if (isset($_POST['user_submit_btn'])) {
        $userControllerObj->insertData();
    }


    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'read':
                $userControllerObj->showResult();
                break;
            case 'testStatus':
                $userControllerObj->userTestStatus();
                break;
        }
    }
}


$userControllerObj = new userController();
