<?php

namespace Teacher;

    use mysqli;

    class Teacher
    {
        public $teacher_id;
        private $isLogged;
        private $teacher_name;
        private $teacher_exams;

        public function __construct($id = null)
        {
            $this->teacher_id = $id;
        }

        public function Auth()
        {
            $this->getData();
            if ($this->isLogged) return true; else return false;
        }

        public function login()
        {
            if($this->teacher_id != null)
            {

                $sql = "SELECT * FROM teachers WHERE id = $this->teacher_id";
                $mysqli = new Mysqli("localhost","root","","Exams");
                $mysqli->set_charset("utf8");
                $query = $mysqli->query($sql);
                if($query->num_rows > 0)
                {
                    $this->isLogged = true;
                    $_SESSION['isLogged'] = true;
                    $_SESSION['teacher_id'] = $this->teacher_id;

                    while($row = $query->fetch_assoc())
                        $_SESSION['teacher_name'] = $row['name'];

                    $sql = "select * FROM teacherexams WHERE id = $this->teacher_id";
                    $query = $mysqli->query($sql);


                    if($query->num_rows > 0)
                    {
                        $i = 0;
                        while ($row = $query->fetch_assoc())
                        {
                            $_SESSION['teacher_exams'][$i] = $row['name'];
                            $i++;
                        }
                    }
                        else
                            $_SESSION['teacher_exams'] = false;

                    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\" />";
                }else
                    die("cannot find the teacher");

            }

        }


        private function getData()
        {
            @$this->isLogged = $_SESSION['isLogged'];
            @$this->teacher_id = $_SESSION['teacher_id'];
            @$this->teacher_name = $_SESSION['teacher_name'];
            @$this->teacher_exams = $_SESSION['teacher_exams'];
        }

    }