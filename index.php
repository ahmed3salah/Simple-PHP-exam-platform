<?php
    SESSION_START();
?>

<HTML>
<HEAD>
<TITLE>EXAM</TITLE>

    <link href="./inc/bootstrap.min.css" rel="stylesheet">

</HEAD>
    <body style="text-align:center;">
<div ><img src="inc/img.jpg" height="160" width='150' style='display:inline-block;border-radius:1000px;margin:-100px 30px 0px 0px;'> <div class='text-center p-3' style='display:inline-block;'><H1>بسم الله الرحمن الرحيم</H1>
<H2>جامعة كرري</H2>
<H3>كلية علوم الحاسوب وتقانة المعلومات</H3>
</div><img src="inc/img.jpg" height="160" width='150' style='display:inline-block;border-radius:1000px;margin:-100px 0px 0px 30px;'> </div>
<div class="container">
            <div class="row">
                <div class="col-md-12 border shadow p-3 m-4 text-center">


<?php

if(isset($_POST['logout']))
{
    session_unset();
    session_destroy();
    echo "<meta http-equiv='refresh' content='0;URL=index.php'>";

}

if(isset($_POST['Search']))
{
    if($_POST['Search'] == TRUE)
    {
        $ID=$_POST["ID"];
        $mysqli = new Mysqli("localhost","root","","Exams");
        $mysqli->set_charset("utf8");
        $stmt = $mysqli->prepare("SELECT * FROM Students WHERE ID = ?");
        $stmt-> bind_param("i",$ID);
        $stmt->execute();


        $result = $stmt->get_result();

        if($result->num_rows < 1)
            die("cannot find the student");

        echo "<table class='table text-center'>
                <tbody>";

        while($row = $result->fetch_assoc())
        {
        echo "<tr><th class='border-0' style='font-size: 20px;' scope=''>".$ID  ."</th><th class='border-0'  scope='col'>". $row['name'] ."</th></tr>";
        echo "<tr><th style='font-size: 20px;' scope=''>"."Specialization :" ."</th><td>". $row['specialization'] ."</td></tr>";
        echo "<tr><th style='font-size: 20px;' scope=''>"."Level :" ."</th><td>". $row['level'] ."</td></tr>";
        echo "<tr><th style='font-size: 20px;' scope=''>"."Class :" ."</th><td>". $row['class'] . "</td></tr>";
        echo "<tr><th style='font-size: 20px;' scope=''>"."Year :" ."</th><td>". $row['year'] . "</td></tr>";



        $_SESSION['logged'] = TRUE;
        $_SESSION['StuName'] = $row['name'];
        $_SESSION['StuID'] = $ID;



        }
        echo "</tbody>
            </table>";

        echo "<a class='btn w-25 btn-success form-control p-1 m-2' href='Exam.php'>اضغط هنا لتبدا امتحان</a>";
        echo "<a class='btn w-25 btn-danger form-control p-1 m-2' href='?logout'>تسجيل الخروج</a>";


    }
}else

{
     echo "

                         <h2>ادخل الرقم الجامعي</h2>
                    <form action=# method=\"post\">
                    <input class=\"form-control  w-75 m-1 mt-4 text-center\" style=\"display: inline-block;\" type=\"number\"name=\"ID\" placeholder=\"ID\"><br>
                    <input class=\"form-control w-75 btn btn-primary p-1 m-1 mt-4\" type=\"Submit\" value=\"Search\" name=\"Search\">
                    </form>
     ";
}
?>



                </div>
            </div>
        </div>

    </BODY>

</HTML>