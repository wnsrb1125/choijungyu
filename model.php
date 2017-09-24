<?php
//model 파일입니다

//로그아웃 할 때 쓰는 함수입니다
function logout() {
    session_destroy();
    echo "<script>location.href='controller.php'</script>";
}

//페이지네이션 할 때 쓰는 함수입니다
function pagination($array,$pagenumber,$choose) {
    $pagelimit = ($pagenumber - 1) * 5;
    if($pagenumber == 1)
        $pagelimit = 0;
    @$link = mysql_connect('localhost', 'root', 'autoset');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if (mysql_select_db("alone", $link)) {
    } else
        print "디비 선택이 실패 되었습니다!!";
    //보통의 게시판 리스트를 출력합니다
    if ($choose == 0) {
        $quer = "select * from  customer  where pid = 0  ORDER by id DESC limit $pagelimit,5 ";
        if (mysql_query($quer)) {
        } else
            print mysql_error($quer) . "쿼리 전송 실패!!!!";

        if ($result = mysql_query($quer)) {

            $sql_num_rows = mysql_num_rows($result);
            $array = array();

            for ($i = 0; $i < $sql_num_rows; $i++) {
                $result_array = mysql_fetch_row($result);
                $array[$i] = $result_array;
            }
        }
        return $array;
    }
    //검색 결과를 출력합니다
    else {
        $returnarray = $array;
        return $returnarray;
    }
    mysql_close($link);
}

//삭제하는 함수입니다
function delete($id) {

    @$link = mysql_connect('localhost', 'root', 'autoset');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if (mysql_select_db("alone", $link)) {
    } else
        print "디비 선택이 실패 되었습니다!!";
    $quer = "delete from  customer where id = '$id' ";
    if (mysql_query($quer)) {
    } else
        print mysql_error($quer) . "쿼리 전송 실패!!!!";
    mysql_close($link);
}

//수정하는 함수입니다 id값 내용, 제목값을 받습니다
function update($id,$uc,$us) {
    @$link = mysql_connect('localhost', 'root', 'autoset');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if (mysql_select_db("alone", $link)) {
    } else
        print "디비 선택이 실패 되었습니다!!";
    $quer = "update customer set subject = '$us', content = '$uc' where id = $id";
    if (mysql_query($quer)) {
    } else
        print mysql_error($quer) . "쿼리 전송 실패!!!!";
    mysql_close($link);
}

//데이터베이스에 넣는 함수입니다 id값 ,내용, 제목을 받습니다
function insert($id,$con,$sub) {
    @$link = mysql_connect('localhost', 'root', 'autoset');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if (mysql_select_db("alone", $link)) {
    } else
        print "디비 선택이 실패 되었습니다!!";
    $date = date("Y-m-d");
    $quer = "insert into  customer VALUES('',0,'$id','$sub','$con',0,'$date') ";
    if (mysql_query($quer)) {
    } else
        print mysql_error($quer) . "쿼리 전송 실패!!!!";
    mysql_close($link);
}

//검색하는 함수입니다 choose는 어떤 방식으로 검색할 지이고,content는 내용, pagenumber는 페이지 넘버입니다

function search($choose,$content,$pagenumber) {

    $pagelimit = ($pagenumber - 1) * 5;
    if($pagenumber == 1)
        $pagelimit = 0;

    @$link = mysql_connect('localhost', 'root', 'autoset');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if (mysql_select_db("alone", $link)) {
    } else
    print "디비 선택이 실패 되었습니다!!";

    if ($choose == 'sub') {
        $quer  = "select * from  customer where (subject LIKE '%$content%')  and (pid = 0) limit $pagelimit,5";
        $quer2 = "select * from  customer where (subject LIKE '%$content%')  and (pid = 0)";
    }
    else if ($choose == 'writer') {
        $quer  = "select * from  customer where (userid LIKE '%$content%') and (pid = 0) limit $pagelimit,5";
        $quer2 = "select * from  customer where (subject LIKE '%$content%')  and (pid = 0)";
    }
    else if ($choose == 'all') {
        $quer  = "select * from  customer where ((subject LIKE '%$content%') or (userid LIKE '%$content%') or (content LIKE '%$content%')) and (pid = 0) limit $pagelimit,5";
        $quer2 = "select * from  customer where ((subject LIKE '%$content%') or (userid LIKE '%$content%') or (content LIKE '%$content%')) and (pid = 0) ";
    }

    if (mysql_query($quer)) {
    } else
        print mysql_error($quer) . "쿼리 전송 실패!!!!";

    if ($result = mysql_query($quer)) {

        $sql_num_rows = mysql_num_rows($result);
        $array = array();
        $numrow =   $sql_num_rows;

        for ($i = 0; $i < $sql_num_rows; $i++) {
            $result_array = mysql_fetch_row($result);
            $array[$i] = $result_array;
        }
    }
    if (mysql_query($quer2)) {
    } else
        print mysql_error($quer2) . "쿼리 전송 실패!!!!";

    if ($result = mysql_query($quer2)) {

        $sql_num_rows = mysql_num_rows($result);
        $count = $sql_num_rows;
        $_SESSION['count'] = $count;

    }
    //검색결과가 없으면 세션변수를 추가합니다
    if($numrow == 0)
        $_SESSION['nothing'] = 'on';
    return $array;
}

//쿼리문에서 select할 때 쓰는 함수입니다
//choose에 따라서 쿼리문을 결정합니다
function select($choose)
{

    @$link = mysql_connect('localhost', 'root', 'autoset');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if (mysql_select_db("alone", $link)) {
    } else
        print "디비 선택이 실패 되었습니다!!";

    if($choose == 0) {
    $quer = "select * from  customer where pid = 0 ORDER by id DESC  ";
    if (mysql_query($quer)) {
    } else
        print mysql_error($quer) . "쿼리 전송 실패!!!!";

    if ($result = mysql_query($quer)) {

        $sql_num_rows = mysql_num_rows($result);
        $array = array();

        for ($i = 0; $i < $sql_num_rows; $i++) {
            $result_array = mysql_fetch_row($result);
            $array[$i] = $result_array;
        }
    }
    return $array;
    }
    if($choose > 0) {
        $beforehit = isset($_SESSION['beforehit']) ? $_SESSION['beforehit'] : 0;
        $_SESSION['nowhitid'] = $choose;
        if(($beforehit != $_SESSION['nowhitid']) || $_SESSION['gumsa'] == 0) {
            $hitsquer = "update customer set hits = hits + 1 where id = $choose";

            if (mysql_query($hitsquer)) {
            } else
                print mysql_error($hitsquer) . "쿼리 전송 실패!!!!";
            $_SESSION['beforehit'] = $choose;
            $_SESSION['gumsa'] = 1;
        }

        $quer = "select * from customer where id = $choose";
        if (mysql_query($quer)) {
        } else
            print mysql_error($quer) . "쿼리 전송 실패!!!!";

        if ($result = mysql_query($quer)) {

            $sql_num_rows = mysql_num_rows($result);

            for ($i = 0; $i < $sql_num_rows; $i++) {
                $result_array = mysql_fetch_row($result);
                $array = $result_array;
            }
        }
        $quer2 = "select * from customer where pid = $choose";
        if (mysql_query($quer2)) {
        } else
            print mysql_error($quer2) . "쿼리 전송 실패!!!!";

        if ($result = mysql_query($quer2)) {

            $sql_num_rows = mysql_num_rows($result);

            $replyarray = array();

            for ($i = 0; $i < $sql_num_rows; $i++) {
                $result_array = mysql_fetch_row($result);
                $replyarray[$i] = $result_array;
            }
            $_SESSION['reply'] = $replyarray;
        }
        return $array;
    }
    mysql_close($link);
}

//댓글을 다는 함수입니다
function reply($id,$con,$writer) {
    @$link = mysql_connect('localhost', 'root', 'autoset');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if (mysql_select_db("alone", $link)) {
    } else
        print "디비 선택이 실패 되었습니다!!";
    $date = date("Y-m-d");
    $quer = "insert into  customer VALUES('',$id,'$writer','','$con',0,'$date') ";
    if (mysql_query($quer)) {
    } else
        print mysql_error($quer) . "쿼리 전송 실패!!!!";
    mysql_close($link);

}

//로그인하는 함수입니다
function login()
{
    $id = $_POST['ide'];
    $pw = $_POST['pw'];
    @$link = mysql_connect('localhost', 'root', 'autoset');
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if (mysql_select_db("alone", $link)) {
    } else
        print "디비 선택이 실패 되었습니다!!";
    $quer = "select userpd from  login where userid = '$id'";
    if (mysql_query($quer)) {
        if ($result = mysql_query($quer)) {

            $sql_num_rows = mysql_num_rows($result);

            for ($i = 0; $i < $sql_num_rows; $i++) {
                $result_array = mysql_fetch_row($result);
                $passwd = $result_array[0];
            }
            if(@$passwd == $pw) {

                $_SESSION['login'] = 'on';
                $_SESSION['iden'] = $id;
            }
            else
                print "잘못된 아이디 혹은 비밀번호 입니다";
        }
    }
    else
    mysql_close($link);
}

?>




