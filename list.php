<?php
//mvc에서 view에 해당하는 파일입니다
session_start();

//내용을 보여주는 함수입니다
function view($array) {
    if (1): ?>
        <!DOCTYPE html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </head>
        <style>
            table {
                margin: 0 auto;
                margin-top: 30px;
            }
        </style>
        <html>
        <a href="controller.php"><h1 align="center"> 최준규 웹페이지</h1></a>
        <body>
        <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead class=""blue-grey lighten-4"">
            <tr>
                <td>번호</td>
                <td>제목</td>
                <td>작성자</td>
                <td>조회수</td>
                <td>날짜</td>
            </tr>
            </thead>
            <tbody>
            <?php   for($tmp=0; $tmp < count($array); $tmp++): ?>
                <tr>
                    <td><?php echo $array[$tmp][0] ?></td>
                    <td><a href="controller.php?bogi=<?php echo $array[$tmp][0] ?>"><?php echo $array[$tmp][3] ?></a></td>
                    <td><?php echo $array[$tmp][2] ?></td>
                    <td><?php echo $array[$tmp][5] ?></td>
                    <td><?php echo $array[$tmp][6] ?></td>
                </tr>
                <?php
            endfor;
            ?>
            </tbody>
        </table>
        </div>
        </body>
        </html>
    <?php endif; } ?>


<?php
//로그인을 확인하는 함수입니다
function identify() {
    $tf =isset($_SESSION['login']) ? $_SESSION['login'] : false;
if ($tf): ?>
    <?php  $iden = $_SESSION['iden'];
    ?>
    <style>
        #div {
            position: absolute;
            top: 10px;
            right: 10px;
            }
    </style>
    <script>
        function writee() {
            location.href = "controller.php?write=on";
        }
        function logoutt() {
            location.href = "controller.php?logout=on";
        }
    </script>
    <div id="div">
    <h3><?php echo "$iden 님으로 접속하였습니다"?></h3>
    <input type="button" value="글쓰기" onclick="writee()">
    <input type="button" value="로그아웃" onclick="logoutt()">
    </div>
<?php
else: ?>
    <style>
        .d {position: absolute;
            top: 10px;
            right: 10px;}
    </style>
    <div class="d">
        <form method='post' action='controller.php' id='send'>
            아이디:   <input type='text' name='ide' id="ide">
            비번:     <input type='password' name='pw' id="pwd">
            <input type='button' value='확인' onclick='verify()'>
        </form>
    </div>
    <script>
        function verify() {
            var id = document.getElementById('ide').value;
            var pw = document.getElementById('pwd').value;
            if(id == '' || pw == '') {
                alert("아이디나 비밀번호를 입력해주세요!");
            }
            else
                document.getElementById('send').submit();
        }
    </script>
<?php endif; } ?>


<?php
//작성할 칸을 보여주는 함수입니다
function  input($id)  {
    echo "
        <script>
            function cancel() {
                history.go(-1);
            }
        </script>
        <form method=\"post\" action=\"controller.php\">
        제목
            <br>
            <input type=\"text\" name=\"s\">
            <br>
        내용
            <br>
            <div>
            <textarea name=\"c\" style=\"width: 500px; height: 500px;\"></textarea>
        <input hidden=\"hidden\" name=\"id\" value=\"<?php echo $id?>\">
            <br>
            <input type=\"submit\" value=\"확인\">
            <input type=\"button\" value=\"취소\" onclick=\"cancel()\">
        </form>";
} ?>


<?php
//글을 보여주는 파일입니다
function read($go) {
    if(isset($_SESSION['sback'])) : ?>
        <script>
            function back() {
                history.go(-1);
            }
        </script>

    <? else : ?>
        <script>
            function back() {
                location.href="controller.php?pagenumber=<?php echo $_SESSION['back']?>";
            }
        </script>
        <? endif;

    if(isset($_SESSION['login'])) : ?>
        <script>
            function modify() {
                location.href="controller.php?modify=<?php echo $go[0]?>";
            }
            function drop() {
                location.href="controller.php?drop=<?php echo $go[0]?>";
            }
        </script>
제목: <input type="text"  readonly="readonly" value="<?php echo $go[3]?>">
작성자: <input type="text" readonly="readonly" value="<?php echo $go[2]?>">
<br>
     <textarea name="c"  readonly="readonly" style="width: 500px; height: 500px;"><?php echo $go[4]?></textarea>
<br>
        <input type="button" value="뒤로가기" onclick="back()">
        <input type="button" value="수정" onclick="modify()">
        <input type="button" value="삭제" onclick="drop()">
<? else: ?>

        제목: <input type="text"  readonly="readonly" value="<?php echo $go[3]?>">
        작성자: <input type="text" readonly="readonly" value="<?php echo $go[2]?>">
        <br>
        <textarea name="c"  readonly="readonly" style="width: 500px; height: 500px;"><?php echo $go[4]?></textarea>
        <br>
        <input type="button" value="뒤로가기" onclick="back()">
<?php endif;
    if(isset($_SESSION['reply'])) {


        for($i = 0; $i < count($_SESSION['reply']); $i++) {
            $contents = $_SESSION['reply'][$i][4];
            $writer = $_SESSION['reply'][$i][2];
            $drid   = $_SESSION['reply'][$i][0];
            echo "
                <script>
                function replydrop() {
                    location.href=\"controller.php?drop=$drid\";
                }
                </script>
                <br>
                작성자:$writer
                <br>
                <textarea style='width: 300px; height: 50px;' name='rcon' readonly='readonly'>$contents</textarea>
                <input type='button' value='삭제' onclick='replydrop()'>";
        }
    }
    echo "<div style='margin-top: 50px;'>  
            <form method='post' action='controller.php?bogi=$go[0]'>
                <input type='text' value='$go[0]' hidden='hidden' name='rid'>
                <input type='text' value='$go[2]' hidden='hidden' name='ruid'>
                <textarea style=\"width: 600px; height: 50px;\" name='rcon'></textarea>
                <input type='submit' value='댓글 작성'>
            </form>
          </div>";
}
?>


<?php
//수정하는 것을 보여주는 파일입니다
function modify2($id)
{
    echo "
     <script>
         function cancel() {
             history.go(-1);
         }
     </script>
     <form method=\"post\" action=\"controller.php\">
         제목: <input type=\"text\" name=\"updates\">
         <br>
         내용: <textarea name=\"updatec\" style=\"width: 500px; height: 500px;\"></textarea>
         <input hidden=\"hidden\" name=\"updateid\" value=\"<?php echo $id?>\">
         <br>
         <input type=\"submit\" value=\"확인\">
         <input type=\"button\" value=\"취소\" onclick=\"cancel()\">
     </form>";
} ?>

<?php
//검색창을 보여주는 함수입니다
function searchv() {
  echo "
        <style>
            #wrapper {
                width: 400px;
                margin: 0 auto;
                margin-top: 30px;
            }
        </style>
        <div id=\"wrapper\">
        <form action=\"controller.php\" method=\"post\">
        <select name=\"search\">
            <option value=\"sub\">제목</option>
            <option value=\"writer\">작성자</option>
            <option value=\"all\">제목,내용,작성자</option>
        </select>
        <input type=\"text\" name=\"tex\">
        <input type=\"submit\" value=\"검색\">
        </form>
        </div>";
} ?>

<?php
//페이지내이션을 보여주는 함수입니다
function pagenate($array,$currentpage,$countt)
{
    if (isset($_SESSION['nothing']))
        echo "<h1 style='text-align: center'>검색 결과가 없습니다</h1>";
    else {
        $count = ceil($countt / 5);
        if ($count == 0) {
            $divide = ceil(count($array) / 5);

            if ($currentpage > 1)
                $pagedown = $currentpage - 1;
            else
                $pagedown = $currentpage;

            echo "<style>
           .page {width: 300px;
                 margin: 0 auto;}
          </style>";
            echo "<div class='page'><ul class=\"pagination\">";
            if ($divide > 5)
                echo "<li><a href='controller.php?pagenumber=$pagedown'><</a></li>";

            if ($currentpage <= 5)
                for ($i = 1; $i <= 5; $i++) {
                    echo "
                 <li><a href='controller.php?pagenumber=$i'>$i</a></li>
                 ";
                }
            else if ($currentpage > 5) {
                for ($i = ($currentpage - 4); $i <= $currentpage; $i++) {
                    echo "
                 <li><a href='controller.php?pagenumber=$i'>$i</a></li>
                 ";
                }
            }
            if ($currentpage < $divide)
                $pageup = $currentpage + 1;
            else
                $pageup = $currentpage;
            if ($divide > 5)
                echo "<li><a href='controller.php?pagenumber=$pageup'>></a></li>";
            echo "</ul></div>";
        } else if ($count > 0) {

            if ($currentpage > 1)
                $pagedown = $currentpage - 1;
            else
                $pagedown = $currentpage;

            echo "<style>
           .page {width: 300px;
                 margin: 0 auto;}
          </style>";
            echo "<div class='page'><ul class=\"pagination\">";
            if ($count > 5)
                echo "<li><a href='controller.php?Spagenumber=$pagedown'><</a></li>";

            if ($currentpage <= 5)
                for ($i = 1; $i < $count; $i++) {
                    echo "
                 <li><a href='controller.php?Spagenumber=$i'>$i</a></li>
                 ";
                }
            else if ($currentpage > 5) {
                for ($i = ($currentpage - 4); $i <= $currentpage; $i++) {
                    echo "
                 <li><a href='controller.php?Spagenumber=$i'>$i</a></li>
                 ";
                }
            }
            if ($currentpage < $count)
                $pageup = $currentpage + 1;
            else
                $pageup = $currentpage;
            if ($count > 5)
                echo "<li><a href='controller.php?Spagenumber=$pageup'>></a></li>";
            echo "</ul></div>";
        }

    }
}
unset($_SESSION['nothing']);
?>


