<?php
session_start();
class Exam extends DatabaseConnection
{


        public function GetExam($id)
    {
        $conn = $this->getDatabaseConnection();

        $stmt = $conn->prepare("SELECT * FROM teacherexams WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows <= 0) {
            echo "كود امتحان خطا.";
            return;
        }

        if($this->canTakeExam($id))
            $this->getANDPrintExamQuestions($id);
        else
        {
            // TODO :: here to change the style of the result page
            echo "عذرا لا يمكنك الخضوع لهذا الامتحان مجددا";
            echo "<br>";
            echo "لقد حصلت علي ";

            $stu_id = $_SESSION['StuID'];
            $sql = "SELECT id FROM studentexamsessions WHERE examid = $id AND studentid = $stu_id";
            $query = $this->getDatabaseConnection()->query($sql);
            if($query->num_rows == 1)
            {
                while($row = $query->fetch_assoc())
                {
                    $sessionID = $row['id'];
                }
            }else die($this->getDatabaseConnection()->error);

            echo $this->getStuPoints($sessionID);


            echo " % ";
            echo "في هذا الاختبار";
        }
    }

        public function DisplayTheExams()
        {
            $conn = $this->getDatabaseConnection();
            $sql = "SELECT * FROM teacherexams ";
            $query = $conn->query($sql);
            if($query->num_rows > 1)
                while($row = $query->fetch_assoc())
                    echo "" . $row['id'] . " - " . $row['name'] . "<br>";
            else
                echo "No available exams for now.";

        }

        private function getANDPrintExamQuestions($exam_id)
        {
            $_SESSION['rightID'] = null;
            $_SESSION['q_i'] = null;

            // Getting the Questions without prepared statement cuz no need to use it here we already know it's safe id!
            $_SESSION['examID'] = $exam_id;
            $conn = $this->getDatabaseConnection();

            // TODO :: here to change how & which que to be displayed in the exam.
            $sql = "SELECT * FROM examquestions WHERE examid = $exam_id  ";
            $_SESSION['currentExamId'] = $exam_id;
            $query = $conn->query($sql);

            echo "<form method='post'>";

                echo "<h1 class='text-center p-3 text-success bg-light border rounded'>امتحان رقم ". $exam_id."</h1>";

                $q_i = 0;

                while($row = $query->fetch_assoc())
                {
                    $que = $row['question'];
                    $que_id = $row['id'];

                    echo "$que";


                    $sql2 = "SELECT * FROM questionanswers WHERE questionid = $que_id";
                    $query2 = $conn->query($sql2);

                    if($query2->num_rows> 0)
                    {
                        $i = 0;

                        while ($row = $query2->fetch_assoc())
                        {


                                $ans[$i] = $row['answer'];
                                $Ques_ids[$i] = $row['id'];

                                if ($row['status'] == 1)
                                    switch ($i) {
                                        case'0':
                                            $right_id = $row['id'];
                                            $right_data = $row['answer'];
                                            break;
                                        case '1':
                                            $right_id = $row['id'];
                                            $right_data = $row['answer'];
                                            break;
                                        case '2':
                                            $right_id = $row['id'];
                                            $right_data = $row['answer'];
                                            break;
                                        case '3':
                                            $right_id = $row['id'];
                                            $right_data = $row['answer'];
                                            break;
                                        default:
                                            die("error");
                                            break;


                                    }

                                $i++;
                        }



                        $_SESSION['q_i'][$q_i] = $que_id;

                        $_SESSION['rightID'][$q_i] = array(
                            'q_i' => array (
                                'i' => $q_i,
                                'id' => $que_id,
                                'right_id' => $right_id,
                                'html' => 'Choice'.$right_id,
                                'data' =>  $right_data
                            ),
                        );




                            echo  "  ".$row['Que'] . "<br>
                             <input type='radio' name='Choice".$q_i."' value='$Ques_ids[0]' checked >
                            " . $ans[0] . "<br>
                              <input type='radio' name='Choice".$q_i."' value='$Ques_ids[1]'>
                            " . $ans[1] . ".<br>
                             <input type='radio' name='Choice".$q_i."' value='$Ques_ids[2]'>
                            " . $ans[2] . "<br>
                              <input type='radio' name='Choice".$q_i."' value='$Ques_ids[3]'>
                            " . $ans[3] . "<br>";



                    }

                    $q_i++;
                }

                echo "<input  class='btn btn-success form-control p-1 m-1 mt-4' type='submit' name='checkAnswers' value='انتهيت'>";
//var_dump($_SESSION['rightChoices']);
            echo "</form>";

        }

        // it's small project no need for student class..

        private function canTakeExam($Exam_ID)
    {
        $conn = $this->getDatabaseConnection();
        $stuID = $_SESSION['StuID'];

        $sql = "SELECT * FROM studentexamsessions WHERE examid = $Exam_ID AND studentid = $stuID";
        $query = $conn->query($sql);
        if($query->num_rows > 0)
            return false;
        else
            return true;

    }

    private function getStuPoints($session_id)
    {
        $sql = "SELECT truefalse FROM studentexamsessionanswers WHERE sessionid = $session_id ";
        $query = $this->getDatabaseConnection()->query($sql);

        $right = 0;
        $false = 0;

        if($query->num_rows > 0)
        {

            while($row = $query->fetch_assoc())
            {
                if($row['truefalse'] == 1)
                    $right++;
                else
                    $false++;
            }
        }

        return (($right/ ($right + $false)) * 100);

    }

}

class ChoicesSystem extends DatabaseConnection
{



    public function SaveSession()
    {
        $_SESSION['session_id'] = null;
        $exam = $_SESSION['examID'];
        $conn = $this->getDatabaseConnection();
        $id = $_SESSION['StuID'];

        $sql = "INSERT INTO studentexamsessions (examid, studentid) VALUES ($exam,$id)";
        $query = $conn->query($sql);
        if($query === true ) {
            $_SESSION['session_id'] = $conn->insert_id;
            return true;
        }else
            return false;

    }


    public function CheckAnswersAndPrint()
    {

        // TODO :: change the style of this page.. (the result page when the user finish the exam.)
        // TODO :: this function might need to be edited to work with the new system (MAX Que. And Rand the Que. for every user).

        $points = 0;

        for ($i = 0; $i <= count($this->RightAnswers) - 1; $i++) {

            $StuAnswer = 'Choice' . $i;

            if ($this->RightAnswers[$i] == $_POST[$StuAnswer]) {

                $points++;
            }
        }

        $max_marks =  count($this->RightAnswers) ;

        echo "نتيجتك  <br>" .

            $points . "/" . $max_marks;

    }

    public function saveStuAnswers()
    {


        $this->SaveSession();

        $_SESSION['session_id'] = 1;

        $conn = $this->getDatabaseConnection();
        $stmt = $conn->prepare("INSERT INTO studentexamsessionanswers (sessionid, questionid, studentanswer, truefalse) values (?,?,?,?)");

        $session_id = $_SESSION['session_id'];
        $QueID = "";
        $StuAnswer = "";
        $trueOrFalse = "";


        $stmt->bind_param("iiii",$session_id,$QueID,$StuAnswer,$trueOrFalse);

        for ($i = 0; $i <= count($_SESSION['q_i']) - 1; $i++) {
//
//            $_SESSION['q_i'][$q_i] = $que_id;
//
//            $_SESSION['rightID'][$q_i] = array(
//                'q_i' => array (
//                    'i' => $q_i,
//                    'id' => $que_id,
//                    'right_id' => $right_id,
//                    'html' => 'Choice'.$right_id,
//                    'data' =>  $right_data
//                ),
//            );

//            echo $_SESSION['rightID'][1]['q_i']['html'];

            $StuAnswer = $_POST['Choice' . $i];

            $rightAnswerID = $_SESSION['rightID'][$i]['q_i']['right_id'];



            $QueID = $_SESSION['rightID'][$i]['q_i']['id'];


            $StuPoints = 0;


            if($rightAnswerID == $StuAnswer)
            {
                $trueOrFalse = 1;
                $StuPoints++;
            }
            else
                $trueOrFalse = 0;

            $stmt->execute();

            $que_id = $_SESSION['rightID'][$i]['q_i']['id'];

            $sql = "INSERT INTO studentexamsessionquestions (sessionid, questionid, correctoption) VALUES ($session_id,$que_id,$rightAnswerID)";
            $query = $conn->query($sql);
            if($query === TRUE)
            {}
            else
                die($conn->error);
}


        $stmt->close(); $conn->close();


    }

}


class DatabaseConnection
{

    public $db_servername = 'localhost';
    public $db_username = 'root';
    public $db_password = '';
    public $db_name = 'exams';


    public function getDatabaseConnection()
    {
        $conn = new mysqli(
            $this->db_servername
            , $this->db_username
            , $this->db_password
            , $this->db_name
        );
        $conn->set_charset('utf8');

        return $conn;
    }
}

?>
<html lang="ar" dir='rtl'>
<head>
<title>EXAM</title>

    <link href="./inc/bootstrap.min.css" rel="stylesheet">
</head>

<?php
    if(isset($_SESSION['logged']))
    {
        if($_SESSION['logged'])
        {


        }else die("يرجي تسجيل الدخول");

    }else die("يرجي تسجيل الدخول");

?>

    <body class="container" >
        <div class="row" style="text-align:Right;">
            <div class="col-md-12 border rounded shadow mt-5 p-3">

        <?php

        $Exam = new Exam();

            if(isset($_POST['getExam']))
            {
                $Exam->GetExam($_POST['id']);



            }else{

?>
               <h1 dir='rtl'>مرحبا بك </h1> <br>

                    <h3>
                      <?php
                   echo $_SESSION['StuName'];
              ?>
                    </h3>

                    <hr>

                        الامتحانات المتوفرة<br>
                        <?php
                        $Exam->DisplayTheExams();
?>
           <hr>

                    <div class="header">ادخل كود الامتحان</div>
                    <form action="" method="post" dir='rtl'>
                        <label>
                            كود الامتحان
                            <input type="number" placeholder="الكود" name="id" required>
                        </label>
                        <input class='form-control btn btn-primary' type="submit" name="getExam">
                    </form>
               <?php

                // TODO :: make sure that the result page will be the only one will be displayed, by editing this section of the code.
                if(isset($_POST['checkAnswers']))
                {
                    $system = new ChoicesSystem();
                    $system->saveStuAnswers();
//                    $system->CheckAnswersAndPrint();
                }

            }
        ?>
            </div>
        </div>

    </body>
</html>