<?php
//제 나름대로 mvc를 생각해서 짜보았습니다
//controller 파일입니다
include 'list.php';
include 'model.php';

//페이지를 확인할 때 쓰는 문장입니다
$pageNUM = isset($_GET['pagenumber']) ? $_GET['pagenumber'] : 1;
$SpageNUM = isset($_GET['Spagenumber']) ? $_GET['Spagenumber'] : 1;

//댓글을 달 때 쓰는 문장입니다
if(isset($_POST['rid'])) {
    reply($_POST['rid'],$_POST['rcon'],$_POST['ruid']);
}

//글을 볼 때 쓰는 문장입니다
if(isset($_GET['bogi'])) {
   read(select($_GET['bogi']));
}

//글을 쓸 때 쓰는 문장입니다
if (isset($_GET ['write'])) {
    input($_SESSION['iden']);
}

//글을 수정 할 때 쓰는 문장입니다
if(isset($_GET['modify'])) {
    modify2($_GET['modify']);
}

//글을 업데이트 할 때 쓰는 문장입니다
if(isset($_POST['updatec'])) {
   $uc = $_POST['updatec'];
   $us = $_POST['updates'];
   $id = $_POST['updateid'];
   update($id,$uc,$us);
}

//글을 지울 때 쓰는 문장입니다
if(isset($_GET['drop'])) {
    delete($_GET['drop']);
}

//로그아웃할 때 쓰는 문장입니다
if(isset($_GET['logout'])) {
    logout();
}

//로그인 할 때 쓰는 문장입니다
if(isset($_POST['ide'])) {
    login();
}

//값을 데이터베이스에 넣을 때 쓰는 문장입니다
if (isset($_POST['s'])) {
    $sub = $_POST['s'];
    $con = $_POST['c'];
    $id = $_POST['id'];
    insert($id,$con,$sub);
}

// 검색결과를 볼 때 쓰는 문장입니다
if(isset($_POST['search']) || isset($_GET['Spagenumber'])) {
    if(isset($_POST['search'])) {
        $_SESSION['search'] = $_POST['search'];
        $_SESSION['tex'] = $_POST['tex'];
    }
    $_SESSION['sback'] = $SpageNUM;
    view(pagination(search($_SESSION['search'],$_SESSION['tex'],$SpageNUM),0,1));
    identify();
    pagenate(search($_SESSION['search'],$_SESSION['tex'],$SpageNUM),$SpageNUM,$_SESSION['count']);
    searchv();
}
//게시판의 리스트를 볼 때 쓰는 문장입니다
else if(!isset($_GET['write']) && !isset($_GET['bogi'])
    && !isset($_GET['updatec']) && !isset($_GET['modify'])
    && !isset($_POST['search'])){

    $_SESSION['back'] = $pageNUM;
    $selectarray = select(0);
    view(pagination($selectarray,$pageNUM,0));
    identify();
    pagenate($selectarray,$pageNUM,0);
    searchv();

}

?>

