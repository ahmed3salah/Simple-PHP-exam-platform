<?php @session_start() ?>
<!DOCTYPE HTML>

<hmtl lang="ar">
    <head>
        <title>تسجيل دخول الملعم</title>
        <link rel="stylesheet" href="../inc/bootstrap.min.css">
    </head>



    <body>

        <?php
        include_once 'teacher.php';
        use Teacher\Teacher;

            $teacher = new Teacher();

        $mysqli = new Mysqli("localhost","root","","Exams");
        $mysqli->set_charset("utf8");

            if(!$teacher->Auth())
            {
                echo "
                                    <div class=\"row\">
                        <div class=\"container\">
            
                            <div class=\"bg-light text-dark\">
            
                                <form method=\"post\" class=\"mt-5\">
                                    <input type=\"text\" name=\"teacher_id\" placeholder=\"كود المعلم\" class=\"form-control p-2 m-2\">
                                    <input type=\"submit\" name=\"teacher_login\" class=\"btn btn-primary p-2 m-2 form-control\">
                                </form>
            
                            </div>
            
                        </div>
                    </div>
                ";

                if(isset($_POST['teacher_login']))
                {
                    $teacher_login = new Teacher($_POST['teacher_id']);
                    $teacher_login->login();
                }

            }
            else
            {

                if(isset($_POST['add_que']))
                {
                    $id = $_POST['id'];
                    $que = $_POST['que'];
                    $a = $_POST['a'];
                    $b = $_POST['b'];
                    $c = $_POST['c'];
                    $d = $_POST['d'];
                    $right = $_POST['right'];

                    $sql = "INSERT INTO examquestions (id,examid, question) VALUES ('','$id','$que')";
                    $query = $mysqli->query($sql);

                    if($query === TRUE)
                    {
                        $last_id = $mysqli->insert_id;
                        $sql1 = "INSERT INTO questionanswers (questionid,answer,status) VALUES ('$last_id','$a',0)";
                        $sql2 = "INSERT INTO questionanswers (questionid,answer,status) VALUES ('$last_id','$b',0)";
                        $sql3 = "INSERT INTO questionanswers (questionid,answer,status) VALUES ('$last_id','$c',0)";
                        $sql4 = "INSERT INTO questionanswers (questionid,answer,status) VALUES ('$last_id','$d',0)";

                        switch ($right)
                        {
                            case 'a':
                                $sql1 = "INSERT INTO questionanswers (questionid,answer,status) VALUES ('$last_id','$a',1)";
                                break;
                            case 'b':
                                $sql2 = "INSERT INTO questionanswers (questionid,answer,status) VALUES ('$last_id','$b',1)";
                                break;
                            case 'c':
                                $sql2 = "INSERT INTO questionanswers (questionid,answer,status) VALUES ('$last_id','$c',1)";
                                break;
                            case 'd':
                                $sql2 = "INSERT INTO questionanswers (questionid,answer,status) VALUES ('$last_id','$d',1)";
                                break;

                            default:
                                die("please choose the right answer");
                                break;

                        }

                        if($mysqli->query($sql1) === TRUE && $mysqli->query($sql2) === TRUE && $mysqli->query($sql3) === TRUE && $mysqli->query($sql4))
                        {
                            echo "تمت اضافه السؤال بنجاح";
                            echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\" />";
                        }else
                            die($mysqli->error);

                    }
                }

                if(isset($_POST['edit_que']))
                {
                    $id = $_POST['id'];
                    $que = $_POST['que'];

                    $a = $_POST['id_a'];
                    $aContent = $_POST['a'];
                    $b = $_POST['id_b'];
                    $bContent = $_POST['b'];
                    $c = $_POST['id_c'];
                    $cContent = $_POST['c'];
                    $d = $_POST['id_d'];
                    $dContent = $_POST['d'];

                    $right = $_POST['id_right'];

                    $RightLetter = $_POST['right'];

                    $sql = "Update examquestions SET question = '$que' where id = $id";

                    $sql1;$sql2;$sql3;$sql4;

                    switch ($RightLetter)
                    {
                        case 'a':
                            $sql1 = "UPDATE `questionanswers` SET `answer` = '$aContent' , `status` = '1' WHERE `id` = '$a'";
                            $sql2 = "UPDATE `questionanswers` SET `answer` = '$bContent' , `status` = '0' WHERE `id` = '$b'";
                            $sql3 = "UPDATE `questionanswers` SET `answer` = '$cContent' , `status` = '0' WHERE `id` = '$c'";
                            $sql4 = "UPDATE `questionanswers` SET `answer` = '$dContent' , `status` = '0' WHERE `id` = '$d'";

                            break;
                        case 'b':
                            $sql1 = "UPDATE `questionanswers` SET `answer` = '$aContent' , `status` = '0' WHERE `id` = '$a'";
                            $sql2 = "UPDATE `questionanswers` SET `answer` = '$bContent' , `status` = '1' WHERE `id` = '$b'";
                            $sql3 = "UPDATE `questionanswers` SET `answer` = '$cContent' , `status` = '0' WHERE `id` = '$c'";
                            $sql4 = "UPDATE `questionanswers` SET `answer` = '$dContent' , `status` = '0' WHERE `id` = '$d'";

                            break;
                        case 'c':
                            $sql1 = "UPDATE `questionanswers` SET `answer` = '$aContent', `status` = '0' WHERE `id` = '$a'";
                            $sql2 = "UPDATE `questionanswers` SET `answer` = '$bContent', `status` = '0' WHERE `id` = '$b'";
                            $sql3 = "UPDATE `questionanswers` SET `answer` = '$cContent', `status` = '1' WHERE `id` = '$c'";
                            $sql4 = "UPDATE `questionanswers` SET `answer` = '$dContent', `status` = '0' WHERE `id` = '$d'";

                            break;
                        case 'd':
                            $sql1 = "UPDATE `questionanswers` SET `answer` = '$aContent' , `status` = '0' WHERE `id` = '$a'";
                            $sql2 = "UPDATE `questionanswers` SET `answer` = '$bContent' , `status` = '0' WHERE `id` = '$b'";
                            $sql3 = "UPDATE `questionanswers` SET `answer` = '$cContent' , `status` = '0' WHERE `id` = '$c'";
                            $sql4 = "UPDATE `questionanswers` SET `answer` = '$dContent' , `status` = '1' WHERE `id` = '$d'";

                            break;
                        default:
                            $sql1 = "UPDATE `questionanswers` SET `answer` = '$aContent' WHERE `id` = '$a'";
                            $sql2 = "UPDATE `questionanswers` SET `answer` = '$bContent' WHERE `id` = '$b'";
                            $sql3 = "UPDATE `questionanswers` SET `answer` = '$cContent' WHERE `id` = '$c'";
                            $sql4 = "UPDATE `questionanswers` SET `answer` = '$dContent' WHERE `id` = '$d'";
                            break;
                    }

                    echo "<br>" . $sql . "<br>" . $sql1 . "<br>" . $sql2 . "<br>" . $sql3 . "<br>" . $sql4 . "<br>";

                    if($mysqli->query($sql) === TRUE && $mysqli->query($sql1) === TRUE && $mysqli->query($sql2) === TRUE && $mysqli->query($sql3) === TRUE && $mysqli->query($sql4) === TRUE)
                    {
                        echo "تم التحديث بنجاح";


                        echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\" />";

                    }
                    else
                        die($mysqli->error);


                }else if(isset($_POST['delete']))
                {
                    $que = $_POST['id'];
                    $sql = "DELETE FROM examquestions WHERE id = $que";
                    $query = $mysqli->query($sql);
                    if($query === TRUE)
                        echo "تم حذف السؤال بنجاح";
                    else
                        echo $mysqli->error;
                }


            }



        if($teacher->Auth())
        {

            if(isset($_GET['edit']))
            {



                $exam_id = $_GET['edit'];


                echo "<a href='index.php' class='btn btn-success form-control'>Back</a>";

                $sql = "SELECT * from examquestions WHERE examid = $exam_id";
                $query1 = $mysqli->query($sql);
                if($query1->num_rows > 0)
                {
                    while($row = $query1->fetch_assoc())
                    {
                        $que = $row['question'];
                        $que_id = $row['id'];
                        echo "<hr>";
                        echo "<form method='post' class='m-2 p-2 border'>
                                
                                Question :             
                            <input type='text' class='form-control m-1 border-bottom' name='que' placeholder='السؤال' value='$que'>";

                            
                        $sql2 = "select * FROM questionanswers WHERE questionid = $que_id";
                        $query = $mysqli->query($sql2);
                        if($query->num_rows > 0)
                        {
                            $i = 0;
                            $isRight = false;
                            while($row = $query->fetch_assoc())
                            {
                                $ans[$i] = $row['answer'];
                                $ids[$i] = $row['id'];

                                if($row['status'] == 1)
                                    switch ($i)
                                    {
                                        case'0':
                                            $isRight = 'a';
                                            $right_id = $row['id'];
                                            break;
                                        case '1':
                                            $isRight = 'b';
                                            $right_id = $row['id'];
                                            break;
                                        case '2':
                                            $isRight = 'c';
                                            $right_id = $row['id'];
                                            break;
                                        case '3':
                                            $isRight = 'd';
                                            $right_id = $row['id'];
                                            break;
                                        default:
                                            die("error");
                                            break;


                                    }

                                $i++;

                            }
                            echo "

                            <input type='hidden' name='id' value='$que_id'>
                            <input type='hidden' name='id_a' value='$ids[0]' >
                            <input type='hidden' name='id_b' value='$ids[1]' >
                            <input type='hidden' name='id_c' value='$ids[2]' >
                            <input type='hidden' name='id_d' value='$ids[3]' >
                            <input type='hidden' name='id_right' value='$right_id' >
                            Option a
                            <input type='text' class='form-control m-1' placeholder='a' name='a' value='$ans[0]'> 
                            Option b
                            <input type='text' class='form-control m-1' placeholder='b' name='b' value='$ans[1]'> 
                            Option c
                            <input type='text' class='form-control m-1' placeholder='c' name='c' value='$ans[2]'> 
                            Option d
                            <input type='text' class='form-control m-1' placeholder='d' name='d' value='$ans[3]'> <hr>
                            Right choice<input type='text' class='form-control m-1' name='right' placeholder='السؤال الصح ( ex : a )' value='$isRight'> <hr>
                            <input type='submit' value='تحديث' class='form-control btn btn-success m-1 w-25' name='edit_que'>
                            
                            <input type='submit' value='حذف' class='form-control btn btn-danger m-1 w-25' name='delete'>

                                ";

                        }



                        echo "</form>";
                    }
                }
            }
            else if (isset($_GET['add']) || isset($_POST['add_que']))
            {
                $id = $_GET['add'];
                echo "
                <form method='post' class='form-group container'><br>
                <h1>اضافه سؤال</h1>
                    <input type='hidden' name='id' value='$id'>
                    <input type='text' class='form-control m-1' name='que' placeholder='السؤال'> 
                    <input type='text' class='form-control m-1' placeholder='a' name='a'> 
                    <input type='text' class='form-control m-1' placeholder='b' name='b'> 
                    <input type='text' class='form-control m-1' placeholder='c' name='c'> 
                    <input type='text' class='form-control m-1' placeholder='d' name='d'> <hr>
                    <input type='text' class='form-control m-1' name='right' placeholder='السؤال الصح ( ex : a )' > <hr>
                    <input type='submit' class='form-control btn btn-success m-1' name='add_que'>
</form>";
            }
            else
            {

            echo " <div class='container'><div class=' p-3 border m-1 text-center bg-dark text-light rounded' dir=''>
 <h3>
            مرحبا ".$_SESSION['teacher_name']." <br> <a href='index.php?logout' class='btn btn-danger'>تسجيل الخروج</a></h3>        </div>    
            
            <hr>
            
            <p class='text-center'>الامتحانات الخاصه بك</p>
            
            <table class=\"table table-dark rounded border\">
            <thead>
                <tr>
                    <th>الرقم التعريفي</th>
                    <th>الماده</th>
                    <th>عمليات</th>
                </tr>
                </thead>
                <tbody>";




                $sql = "SELECT * FROM teacherexams WHERE teacherid = $teacher->teacher_id";

                $query = $mysqli->query($sql);
                if($query->num_rows > 0)
                {
                    while ($row = $query->fetch_assoc())
                    {
                        $id = $row['id'];
                        $name = $row['name'];
echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>$name</td>";

                        echo "<td>
                            <a href='?edit=$id' class='btn btn-danger'>تعديل او حذف اسئله</a>
                            <a href='?add=$id' class='btn btn-secondary'>اضافه اسئله</a>
                        </td>";

                    }

                }


                    echo "</tbody></table></div>";
            }
        }

        if(isset($_GET['logout']) && $teacher->Auth())
        {
            session_destroy();
            session_unset();
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\" />";

        }

            ?>







    </body>

</hmtl>