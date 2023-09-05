<?php
//DB接続情報
//define( 'DB_HOST1', '');
//define( 'DB_USER1', '');
//define( 'DB_PASS1', '');
//define( 'DB_NAME1', '');
//define( 'DB_HOST2', '');
//define( 'DB_USER2', '');
//define( 'DB_PASS2', '');
//define( 'DB_NAME2', '');
//define( 'DB_HOST3', '');
//define( 'DB_USER3', '');
//define( 'DB_PASS3', '');
//define( 'DB_NAME3', '');

session_start();
date_default_timezone_set('Asia/Tokyo');
$last_id=0;
$table_name1=null;
$table_name2=null;
$pdo1=null;
$pdo2=null;
$view_name=null;
$message=null;
//DB接続
$pdo1 = new PDO('mysql:charset=UTF8;dbname='.DB_NAME1.';host='.DB_HOST1,DB_USER1, DB_PASS1);
$pdo2=new PDO('mysql:charset=UTF8;dbname='.DB_NAME2.';host='.DB_HOST2 , DB_USER2, DB_PASS2);
$pdo3 = new PDO('mysql:charset=UTF8;dbname='.DB_NAME3.';host='.DB_HOST3,DB_USER3, DB_PASS3);
if( !empty($_GET['siai_id']) ){
$last_id = $_GET['siai_id'];
$table_name1 = sprintf( "table_%d", $last_id);
$table_name2 = sprintf( "touhyou_%d", $last_id);
$stmt1 = $pdo1->prepare("SELECT * FROM gidai WHERE gidai_id = :gidai_id");
$stmt1->bindParam( ':gidai_id', $last_id, PDO::PARAM_INT);
$res1 = $stmt1->execute();
if($res1){
  $gidai_date = $stmt1->fetch();
  $etsurannsuu = $gidai_date['etsurannsuu'] + 1;
}
$stmt2 = $pdo1->prepare("UPDATE gidai SET etsurannsuu = :etsurannsuu WHERE gidai_id = :gidai_id");
$stmt2->bindParam( ':gidai_id', $last_id, PDO::PARAM_INT);
$stmt2->bindParam( ':etsurannsuu', $etsurannsuu, PDO::PARAM_INT);
$res2 = $stmt2->execute();
}
if( !empty($_GET['comment_idgati']) ){
  $comment_idgati= $_GET['comment_idgati'];
}
if( !empty($_GET['table_name1']) ){
  $table_name1 = $_GET['table_name1'];
}
if( !empty($_GET['table_name2']) ){
  $table_name2 = $_GET['table_name2'];
}
if( !empty($_GET['gidai_idgati']) ){
  $last_id= $_GET['gidai_idgati'];
}
$stmt3 = $pdo1->prepare("SELECT * FROM gidai WHERE gidai_id = :gidai_id");
$stmt3->bindParam( ':gidai_id', $last_id, PDO::PARAM_INT);
$res3 = $stmt3->execute();
if($res3){
  $gidai_date = $stmt3->fetch();
  $touhyou=$gidai_date['keltsutyaku'];
}
$touhyou_name = $_SERVER['REMOTE_ADDR'];
$touhyou_date = date("Y-m-d H:i:s");

if($touhyou==='ari'){
if(!empty($_GET['btn_dochia'])||!empty($_GET['btn_dochib'])){
  $success_message3= '投票が完了しました。';
  if(!empty($_GET['btn_dochia'])){
    $ikena_hyousuu=1;
    $ikenb_hyousuu=0;
    $color1='red';
  }else if(!empty($_GET['btn_dochib'])){
    $ikena_hyousuu=0;
    $ikenb_hyousuu=1;
    $color1='blue';
  }else{
    $success_message3='投票失敗';
    $color1='black';
  }
  $stmt5 = $pdo3->prepare("INSERT INTO $table_name2 ( touhyou_name, ikena_hyousuu, ikenb_hyousuu, touhyou_date, ikena_tokutenn, ikenb_tokutenn) VALUES ( :touhyou_name, :ikena_hyousuu, :ikenb_hyousuu, :touhyou_date, :ikena_tokutenn, :ikenb_tokutenn)");
  $stmt5->bindParam(':touhyou_name', $touhyou_name, PDO::PARAM_STR);
  $stmt5->bindParam(':ikena_hyousuu', $ikena_hyousuu, PDO::PARAM_INT);
  $stmt5->bindParam(':ikenb_hyousuu', $ikenb_hyousuu, PDO::PARAM_INT);
  $stmt5->bindParam(':touhyou_date', $touhyou_date, PDO::PARAM_STR);
  $stmt5->bindParam(':ikena_tokutenn', $ikena_tokutenn, PDO::PARAM_INT);
  $stmt5->bindParam(':ikenb_tokutenn', $ikenb_tokutenn, PDO::PARAM_INT);
  $res5 = $stmt5->execute();
  $stmt6 = $pdo3->prepare("SELECT * FROM $table_name2 WHERE touhyou_name = :touhyou_name");
  $stmt6->bindParam(':touhyou_name',$touhyou_name, PDO::PARAM_STR);
  $res6 = $stmt6->execute();
  if($res6){
  $touhyou_id1 = $stmt6->fetchall();
  $cnt1 = count($touhyou_id1);
  $touhyou_id2 = $touhyou_id1[0]['touhyou_id'];
}
if($cnt1>1){
$stmt7 = $pdo3->prepare("DELETE FROM $table_name2 WHERE touhyou_id = $touhyou_id2");
$res7 = $stmt7->execute();
}
}
}
if($touhyou==='ari'){
if(!empty($_GET['btn_submit'])){
  if(!empty($_GET['bluegreen2'])){
    $success_message3= '投票が完了しました。';
  $dochi2 = $_GET['bluegreen2'];
  $ikena_tokutenn=0;
  $ikenb_tokutenn=0;
  if($dochi2 == "red"){
    $color1='red';
    $ikena_hyousuu=1;
    $ikenb_hyousuu=0;
  }else if($dochi2 == "blue"){
    $color1='blue';
    $ikena_hyousuu=0;
    $ikenb_hyousuu=1;
  }else{
    $color1='black';
    $success_message3='投票失敗';
  }
  }else{
      $error_message[] = 'どちらかの意見を選択してください';
      $error_message3[] = 'どちらかの意見を選択してください';
  }

  if(!empty($_GET['bluegreen2'])){
    $stmt8 = $pdo3->prepare("INSERT INTO $table_name2 ( touhyou_name, ikena_hyousuu, ikenb_hyousuu, touhyou_date, ikena_tokutenn, ikenb_tokutenn) VALUES ( :touhyou_name, :ikena_hyousuu, :ikenb_hyousuu, :touhyou_date, :ikena_tokutenn, :ikenb_tokutenn)");
    $stmt8->bindParam(':touhyou_name', $touhyou_name, PDO::PARAM_STR);
    $stmt8->bindParam(':ikena_hyousuu', $ikena_hyousuu, PDO::PARAM_INT);
    $stmt8->bindParam(':ikenb_hyousuu', $ikenb_hyousuu, PDO::PARAM_INT);
    $stmt8->bindParam(':touhyou_date', $touhyou_date, PDO::PARAM_STR);
    $stmt8->bindParam(':ikena_tokutenn', $ikena_tokutenn, PDO::PARAM_INT);
    $stmt8->bindParam(':ikenb_tokutenn', $ikenb_tokutenn, PDO::PARAM_INT);
    $res8 = $stmt8->execute();
    $stmt9 = $pdo3->prepare("SELECT * FROM $table_name2 WHERE touhyou_name = :touhyou_name");
    $stmt9->bindParam(':touhyou_name',$touhyou_name, PDO::PARAM_STR);
    $res9 = $stmt9->execute();
    if($res9){
      $touhyou_id1 = $stmt9->fetchall();
      $cnt2 = count($touhyou_id1);
      $touhyou_id2 = $touhyou_id1[0]['touhyou_id'];
    }
    if($cnt2>1){
      $stmt10 = $pdo3->prepare("DELETE FROM $table_name2 WHERE touhyou_id = $touhyou_id2");
      $res10 = $stmt10->execute();
    }
  }
  }
}
if( !empty($_GET['btn_submit']) ) {
  if(!empty($_GET['bluegreen2'])){
    $dochi2=$_GET['bluegreen2'];
    if($dochi2 == "red"){
      $color1='red';
    }
    if($dochi2 == "blue"){
      $color1='blue';
    }
  }
  if (isset($_GET['token1']) && isset($_SESSION['token1'])) {
  if ($_GET['token1'] === $_SESSION['token1']) {
  unset($_SESSION['token1']);
  $view_name = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_GET['view_name']);
  $message = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_GET['message']);
  if( empty($view_name) ) {
    $error_message[] = '仮名を入力してください';
  }elseif( 20 < mb_strlen($view_name, 'UTF-8')) {
      $error_message[] = '仮名は20文字以内で入力してください';
    }else{
      $_SESSION['view_name'] = $view_name;
    }
  if( empty($message) ) {
    $error_message[] = 'コメントを入力してください';
  }elseif( 400 < mb_strlen($message, 'UTF-8') ) {
      $error_message[] = 'コメントは400文字以内で入力してください';
    }
  if( empty($error_message) ) {
    $current_date = date("Y-m-d H:i:s");
    $hensinid=0;
    $hensinname='nasi';
    $hensincolor='black';
    $pdo2->beginTransaction();
    try {
    $stmt11 = $pdo2->prepare("INSERT INTO $table_name1 (color,comment_name, comment, comment_datetime, hensinid, hensinname, hensincolor) VALUES ( :color,:comment_name, :comment, :comment_datetime, :hensinid, :hensinname, :hensincolor)");
    $stmt11->bindParam( ':color', $color1, PDO::PARAM_STR);
    $stmt11->bindParam( ':comment_name', $view_name, PDO::PARAM_STR);
    $stmt11->bindParam( ':comment', $message, PDO::PARAM_STR);
    $stmt11->bindParam( ':comment_datetime', $current_date, PDO::PARAM_STR);
    $stmt11->bindParam( ':hensinid', $hensinid, PDO::PARAM_INT);
    $stmt11->bindParam( ':hensinname', $hensinname, PDO::PARAM_STR);
    $stmt11->bindParam( ':hensincolor', $hensincolor, PDO::PARAM_STR);
    $stmt11->execute();
      $res11 = $pdo2->commit();
    } catch(Exception $e) {
      $pdo2->rollBack();
    }
    if( $res11 ) {
      $success_message = 'コメントを書き込みました。';
    } else {
      $error_message[] = 'コメント書き込みに失敗しました。';
    }
    $stmt11 = null;
  }
  } else {
  $stmt12 = $pdo1->prepare("SELECT * FROM gidai WHERE gidai_id = :gidai_id");
  $stmt12->bindParam( ':gidai_id', $last_id, PDO::PARAM_INT);
  $res12 = $stmt12->execute();
  if($res12){
    $gidai_date = $stmt12->fetch();
    $etsurannsuu = $gidai_date['etsurannsuu'] + 1;
  }
  if( empty($error_message) ) {
    $stmt13 = $pdo1->prepare("UPDATE gidai SET etsurannsuu = :etsurannsuu WHERE gidai_id = :gidai_id");
    $stmt13->bindParam( ':gidai_id', $last_id, PDO::PARAM_INT);
    $stmt13->bindParam( ':etsurannsuu', $etsurannsuu, PDO::PARAM_INT);
    $res13 = $stmt13->execute();
  }
  }
  }
  }
  $stmt14 = $pdo2->prepare("SELECT MAX(comment_id) FROM $table_name1");
  $res14 = $stmt14->execute();
  if($res14){
   $maxcomment_data = $stmt14->fetch();
   $cnt4 = $maxcomment_data['MAX(comment_id)'];
  }
  $stmt15 = $pdo1->prepare("UPDATE gidai SET cnt=:cnt WHERE gidai_id = $last_id;");
  $stmt15->bindParam(':cnt', $cnt4, PDO::PARAM_INT);
  $res15=$stmt15->execute();
  if(!empty($_GET['comment_idhensin'])){
    $comment_idhensin = $_GET['comment_idhensin'];
    $stmt16 = $pdo2->prepare("SELECT * FROM $table_name1 WHERE comment_id = :comment_id");
    $stmt16->bindParam(':comment_id',$comment_idhensin,PDO::PARAM_INT);
    $res16=$stmt16->execute();
    if($res16){
      $comment_data1 = $stmt16->fetch();
      $hensinid = $comment_data1['comment_id'];
      $hensinname = $comment_data1['comment_name'];
      $hensincolor = $comment_data1['color'];
    }
    $stmt17 = $pdo2->prepare("UPDATE $table_name1 SET hensinid=:hensinid, hensinname=:hensinname, hensincolor=:hensincolor WHERE comment_id = $cnt4;");
    $stmt17->bindParam(':hensinid', $hensinid, PDO::PARAM_INT);
    $stmt17->bindParam(':hensinname', $hensinname, PDO::PARAM_STR);
    $stmt17->bindParam(':hensincolor', $hensincolor, PDO::PARAM_STR);
    $res17=$stmt17->execute();
  }
  $stmt18 = $pdo3->prepare("select sum(ikena_hyousuu),sum(ikenb_hyousuu) from $table_name2;");
  $res18 = $stmt18->execute();
  if($res18){
    $touhyou_data = $stmt18->fetch();
    $ikena_tokutenn = $touhyou_data['sum(ikena_hyousuu)'];
    $ikenb_tokutenn = $touhyou_data['sum(ikenb_hyousuu)'];
  }
  $stmt19 = $pdo3->prepare("SELECT MAX(touhyou_id) FROM $table_name2");
  $res19 = $stmt19->execute();
  if($res19){
   $maxtouhyou_data = $stmt19->fetch();
   $maxtouhyou_id = $maxtouhyou_data['MAX(touhyou_id)'];
  }
  $stmt20 = $pdo3->prepare("UPDATE $table_name2 SET ikena_tokutenn=:ikena_tokutenn,ikenb_tokutenn=:ikenb_tokutenn WHERE touhyou_id = $maxtouhyou_id;");
  $stmt20->bindParam(':ikena_tokutenn', $ikena_tokutenn, PDO::PARAM_INT);
  $stmt20->bindParam(':ikenb_tokutenn', $ikenb_tokutenn, PDO::PARAM_INT);
  $res20=$stmt20->execute();
  $stmt21 = $pdo1->prepare("UPDATE gidai SET ikenA_tokutenn=:ikenA_tokutenn,ikenB_tokutenn=:ikenB_tokutenn WHERE gidai_id = $last_id;");
  $stmt21->bindParam(':ikenA_tokutenn', $ikena_tokutenn, PDO::PARAM_INT);
  $stmt21->bindParam(':ikenB_tokutenn', $ikenb_tokutenn, PDO::PARAM_INT);
  $res21=$stmt21->execute();
  $stmt22 = $pdo1->prepare("SELECT * FROM gidai WHERE gidai_id = :gidai_id");
  $stmt22->bindParam( ':gidai_id', $last_id, PDO::PARAM_INT);
  $res22 = $stmt22->execute();
  if( $res22 ) {
   $gidai_data = $stmt22->fetch();
   $kaisaijikokugati = $gidai_data['kaisaijikoku'];
   $gidaigati = $gidai_data['gidai'];
   $ikenagati = $gidai_data['ikenA'];
   $ikenbgati = $gidai_data['ikenB'];
   $gidai_idgati = $gidai_data['gidai_id'];
   $syouritenn = $gidai_data['syouritenn'];
  }
  if($ikenb_tokutenn>=$syouritenn){
    $syouri_messageB= $ikenbgati."の勝利";
    $color2='blue';
    $background='https://netcousienn.com/img/fubukiao.jpg';
    $touhyou='nasi';
  }elseif($ikena_tokutenn>=$syouritenn){
    $syouri_messageA= $ikenagati."の勝利";
    $color2='red';
    $background='https://netcousienn.com/img/fubukired.jpg';
    $touhyou='nasi';
  }else{
    $background='https://netcousienn.com/img/sibafu.jpg';
    $touhyou='ari';
  }
  $stmt23 = $pdo1->prepare("UPDATE gidai SET keltsutyaku=:keltsutyaku WHERE gidai_id = $last_id;");
  $stmt23->bindParam(':keltsutyaku', $touhyou, PDO::PARAM_STR);
  $res23=$stmt23->execute();

  $token1 = md5(microtime());
  $_SESSION['token1'] = $token1;
if($touhyou=='nasi'){
  if(!empty($_GET['bluegreen2'])){
    $dochi2=$_GET['bluegreen2'];
    if($dochi2 == "red"){
      $color1='red';
    }
    if($dochi2 == "blue"){
      $color1='blue';
    }
  }
}
$stmt24 = $pdo2->prepare("SELECT * FROM $table_name1");
$res24= $stmt24->execute();
if($res24){
  $comment_data = $stmt24->fetchall();
  $cnt3 = count($comment_data);
}
$jisuua=mb_strlen($ikenagati);
$jisuub=mb_strlen($ikenbgati);
if($jisuua>10 || $jisuub >10){
  $jisuu='koe';
}
$pdo1 = null;
$pdo2=null;
$pdo3=null;
?>
<!DOCTYPE html>
<html>
  <head　prefix=”og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#”>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/c1.css">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="css/c2.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ネット甲子園（<?php echo $gidaigati; ?>）</title>
    <meta property="og:url" content="https://netcousienn.com/ranking.php?siai_id=<?php echo $last_id?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="ネット甲子園" />
    <meta property="og:description" content="勝敗の付く討論サイトです。" />
    <meta property="og:site_name" content="ネット甲子園" />
    <meta property="og:image" content="https://netcousienn.com/img/netkousienn" />
    <script type="text/javascript">
      function ScrollWindow(elem) {
          var element = document.getElementById(elem);
          var rect = element.getBoundingClientRect();
          var elemtop = rect.top + window.pageYOffset -140;
          document.documentElement.scrollTop = elemtop;
      }
      <?php if(!empty($_GET['btn_submit'])||!empty($_GET['comment_idhensin'])): ?>
      <?php $cnth = $cnt4-1;?>
      window.onload = function(){
 ScrollWindow('tk<?php echo $cnth; ?>');
}
<?php endif;?>
</script>
<script type="text/javascript">
<?php for( $i = 0; $i < $cnt3; $i++) : ?>
$(function() {

  $('.reply-icon<?php echo $i?>').click(
    function() {
       //.showクラスを切り替える
       $('.reply-icon<?php echo $i?>').toggleClass('show');
       //showクラスを持っていれば、ex05-div-areaを表示、持っていなければ非表示
       if($('.reply-icon<?php echo $i?>').hasClass('show')){
           $('.kie<?php echo $i?>').show();
       }else{
           $('.kie<?php echo $i?>').hide();
       }
  });
  });
<?php endfor ;?>
</script>
<script type="text/javascript">

window.addEventListener( "DOMContentLoaded", function(){
var height = document.getElementById('box').clientHeight;
  if(height < 500){
    $("#box").css({
        "background-size": "contain"
    });
  }else if(height >= 500){
    $("#box").css({
        "background-size": "cover"
    });
  }
} );
</script>
<!-- Google tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-238889833-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-238889833-1');
</script>
   </head>
   <body style="background-image: url(<?php echo $background; ?>);">
     <header id="hed">
       <div class="header-left">
         <span class="fa fa-bars menu-icon"></span><a href="https://netcousienn.com/"><img src="https://netcousienn.com/img/netkousienn-home.png" class="head"alt=""></a>
       </div>
       <div class="migi">
         <div class="header-right-right">
           <a href="https://twitter.com/netkousienn" class="btn twitter">
             <span class="fa-brands fa-twitter twitter2 fa-2x"></span>
           </a>
         </div>
         <div class="header-right3">
           <a href="https://netcousienn.com/tsukaikata" class="btn tsukaikata">
             使い方
           </a>
         </div>
        </div>
        <div class="menu">
          <ul>
            <a href="https://netcousienn.com/tsukaikata"><li>使い方</li></a>
            <a href="https://netcousienn.com/siaisakusei"><li>試合作成</li></a>
            <a href="https://twitter.com/netkousienn"><li>twitter</li></a>
          </ul>
        </div>
        <form class="search" action="search.php" method="get">
          <input type="text" class="searchTerm" name = "kennsakunaiyou"placeholder="議題を探す" required>
          <button type="submit" class="searchButton">
            <i class="fa fa-search"></i>
          </button>
        </form>
     </header>
     <div class="koukokupc1">
       <a href="https://px.a8.net/svt/ejp?a8mat=3NGZIB+4CL1NE+4EKC+62U35" rel="nofollow">
       <img border="0" width="936" height="120" alt="" src="https://www23.a8.net/svt/bgt?aid=220822211263&wid=002&eno=01&mid=s00000020550001021000&mc=1"></a>
       <img border="0" width="1" height="1" src="https://www19.a8.net/0.gif?a8mat=3NGZIB+4CL1NE+4EKC+62U35" alt="">
     </div>
     <div class="koukokupad1">
       <a href="https://px.a8.net/svt/ejp?a8mat=3NGZIB+4CL1NE+4EKC+62MDD" rel="nofollow">
       <img border="0" width="640" height="100" alt="" src="https://www25.a8.net/svt/bgt?aid=220822211263&wid=002&eno=01&mid=s00000020550001020000&mc=1"></a>
       <img border="0" width="1" height="1" src="https://www13.a8.net/0.gif?a8mat=3NGZIB+4CL1NE+4EKC+62MDD" alt="">
     </div>
     <div class="koukokusm1">
       <a href="https://px.a8.net/svt/ejp?a8mat=3NGZIB+4CL1NE+4EKC+5ZEMP" rel="nofollow">
       <img border="0" width="320" height="50" alt="" src="https://www27.a8.net/svt/bgt?aid=220822211263&wid=002&eno=01&mid=s00000020550001005000&mc=1"></a>
       <img border="0" width="1" height="1" src="https://www12.a8.net/0.gif?a8mat=3NGZIB+4CL1NE+4EKC+5ZEMP" alt="">
     </div>
     <div class="koukokuga1">
       <a href="https://px.a8.net/svt/ejp?a8mat=3NGZIB+4CL1NE+4EKC+62ENL" rel="nofollow">
       <img border="0" width="234" height="60" alt="" src="https://www25.a8.net/svt/bgt?aid=220822211263&wid=002&eno=01&mid=s00000020550001019000&mc=1"></a>
       <img border="0" width="1" height="1" src="https://www10.a8.net/0.gif?a8mat=3NGZIB+4CL1NE+4EKC+62ENL" alt="">
     </div>
     <div class="siaisakusei">
         <div class="siaisakusei_haikei">
           <div class="gidai">
             <?php if(!empty($syouri_messageA)): ?>
               <div class="yuusyou"style="background-color:<?php echo $color2; ?>;">
                  <div class="t1">
                  </div>
                  <p><span class="syouri_messageA"><?php echo htmlspecialchars($syouri_messageA,ENT_QUOTES,'utf-8'); ?></span></p>
                  <div class="t2">
                  </div>
                </div>
              <?php endif; ?>
              <?php if(!empty($syouri_messageB)): ?>
                <div class="yuusyou"style="background-color:<?php echo $color2; ?>;">
                   <div class="t1">
                   </div>
                   <p><span class="syouri_messageB"><?php echo htmlspecialchars($syouri_messageB,ENT_QUOTES,'utf-8'); ?></span></p>
                   <div class="t2">
                   </div>
                 </div>
              <?php endif; ?>
                 <div class="gidai2" id="box">
                   <div class="gidai1">
                     Q.<?php echo htmlspecialchars($gidaigati,ENT_QUOTES,'utf-8'); ?>
                   </div>
                   <div class="gidai3">
                     (<?php echo $syouritenn; ?>点先取)
                   </div>
                   <?php if($jisuu=='koe'): ?>
                     <div class="ikenagati">
                       A.<?php echo $ikenagati;?>
                     </div>
                     <div class="ikenbgati">
                       B.<?php echo $ikenbgati;?>
                     </div>
                   <?php endif; ?>
                 </div>
                 <?php if( !empty($success_message3) && $touhyou==='ari' ): ?>
                   <div class="bikou" style="background-color:<?php echo $color1; ?>;">
                     <p><span class="success_message3"><?php echo htmlspecialchars( $success_message3, ENT_QUOTES, 'UTF-8'); ?></span></p>
                   </div>
                 <?php endif; ?>
                 <form class="kata3a" action="" method="get">
                   <div class="kata1">
                      <div class="ikena">
                        <?php if($jisuu=='koe'): ?>A<?php else: ?><?php echo $ikenagati; ?><?php endif ;?>
                      </div>
                      <div class="ikena_tokutenn">
                        <?php echo $ikena_tokutenn; ?>
                      </div>
                      <?php if($touhyou==='ari'): ?>
                        <div class="ikena_touhyou">
                          <input type="hidden" name="bluegreena" value="red" class="lavel3" id="select_radio1">
                          <input type="hidden" name="table_name1" value="<?php echo $table_name1; ?>">
                          <input type="hidden" name="table_name2" value="<?php echo $table_name2; ?>">
                          <input type="hidden" name="gidai_idgati" value="<?php echo $gidai_idgati; ?>">
                          <input type="submit" name="btn_dochia" value="投票" class="hyouka2">
                        </div>
                     <?php endif; ?>
                   </div>
                 </form>
                 <form class="kata3b" action="" method="get">
                   <div class="kata2">

                     <div class="ikenb">
                        <?php if($jisuu=='koe'): ?>B<?php else: ?><?php echo $ikenbgati; ?><?php endif ;?>
                     </div>
                    <div class="ikenb_tokutenn">
                      <?php echo $ikenb_tokutenn; ?>
                    </div>
                    <?php if($touhyou==='ari'): ?>
                    <div class="ikenb_touhyou">
                      <input type="hidden" name="bluegreenb" value="blue" class="lavel3" id="select_radio1">
                      <input type="hidden" name="table_name1" value="<?php echo $table_name1; ?>">
                      <input type="hidden" name="table_name2" value="<?php echo $table_name2; ?>">
                      <input type="hidden" name="gidai_idgati" value="<?php echo $gidai_idgati; ?>">
                      <input type="submit" name="btn_dochib" value="投票" class="hyouka2">
                    </div>
                   </div>
                   <?php endif; ?>

                </form>
              </div>
            </div>
            <div class="idou">
              <div class="comment_btn">
                <a onclick="ScrollWindow('index');"><img src="https://netcousienn.com/img/comment.png"></a>
              </div>
            </div>
         <div class="sec">
           <?php if(!($cnt3===0)):?>
           <?php endif; ?>
           <?php if(1===$cnt3):?>
             <div class="info" id="tk0">
               <h2 style="color:<?php echo $comment_data[0]['color']; ?>;"><?php echo $comment_data[0]['comment_id']; ?>.<?php echo htmlspecialchars( $comment_data[0]['comment_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
               <time style="color:<?php echo $comment_data[0]['color']; ?>;"><?php echo date('Y年m月d日 H:i', strtotime($comment_data[0]['comment_datetime'])); ?></time>
               <i class="fa-solid fa-reply reply-icon0"></i><p><?php if($comment_data[0]['hensinid']!==0): ?>⇒<span style="color:<?php echo $comment_data[0]['hensincolor']; ?>;"><?php echo $comment_data[0]['hensinid']?>.<?php echo $comment_data[0]['hensinname']?></span><br><?php endif; ?><?php echo nl2br(htmlspecialchars( $comment_data[0]['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
               <form method="get" action="" class="kie0" style="display:none;"id="kie">
                 <?php if( !empty($error_message) ): ?>
                   <ul class="error_message">
                     <?php foreach( $error_message as $value ): ?>
                       <li><?php echo htmlspecialchars($value,ENT_QUOTES,'utf-8'); ?></li>
                     <?php endforeach; ?>
                   </ul>
                 <?php endif; ?>
                 <?php if(!empty($_GET['colorhensin'])): ?>
                   <p style="color:<?php echo $colorhensin;?>"><?php if(!empty($_GET['comment_idgati'])):?><?php echo $comment_idhensin; ?><?php endif; ?><?php if(!empty($_GET['comment_namehensin'])):?><?php echo $comment_namehensin; ?><?php endif; ?></p>
                 <?php endif; ?>
                   <div class="do">
                     <?php if($touhyou=='ari'): ?>
                       <lavel for="iken">どちら側の意見か(投票兼):</lavel>
                     <?php endif;?>
                     <?php if($touhyou=='nasi'): ?>
                       <lavel for="iken">どちら側の意見か:</lavel>
                     <?php endif;?>
                     <div class="ve1"><input type="radio" name="bluegreen2" value="red" id="select_radio1"><label for="select_radio1"class="agati"><?php if($jisuu=='koe'): ?>A<?php else: ?><?php echo $ikenagati; ?><?php endif ;?></label></div>
                     <div class="ve2"><input type="radio" name="bluegreen2" value="blue" id="select_radio2"><label for="select_radio2"class="bgati"><?php if($jisuu=='koe'): ?>B<?php else: ?><?php echo $ikenbgati; ?><?php endif ;?></label></div>
                   </div>
                 <div class="na">
                   <lavel for="view_name">仮名(20字以内):</lavel>
                   <input id="view_name" type="text" name="view_name" value="<?php if( !empty($_SESSION['view_name']) ){ echo htmlspecialchars( $_SESSION['view_name'], ENT_QUOTES, 'UTF-8'); } ?>">
                 </div>
                 <div class="co">
                   <lavel for="message">コメント(400字以内):</lavel>
                   <textarea id="message" name="message" class="message"></textarea>
                 </div>
                 <input type="hidden" name="comment_idgati" value="<?php echo $comment_idgati; ?>">
                 <input type="hidden" name="gidai_idgati" value="<?php echo $gidai_idgati; ?>">
                 <input type="hidden" name="etsurannsuu" value="<?php echo $etsurannsuu; ?>">
                 <input type="hidden" name="table_name1" value="<?php echo $table_name1; ?>">
                 <input type="hidden" name="table_name2" value="<?php echo $table_name2; ?>">
                 <input type="hidden" name="token1" value="<?php echo $token1;?>">
                 <input type="hidden" name="comment_idhensin" value="<?php echo $comment_data[0]['comment_id']; ?>">
               <input type="hidden" name="comment_namehensin" value="<?php echo htmlspecialchars( $comment_data[0]['comment_name'], ENT_QUOTES, 'UTF-8'); ?>">
               <input type="hidden" name="comment_colorhensin" value="<?php echo $comment_data[0]['color']; ?>">
                 <div class="se">
                   <input type="submit" name="btn_submit" value="返信" id="toukou" class="toukou" onclick="scrollToTop()">
                 </div>
               </form>
             </div>
           <?php endif; ?>
           <?php if(1<$cnt3):?>
             <?php for( $i = 0; $i < $cnt3; $i++) : ?>
               <div class="info" id="tk<?php echo $i; ?>">
                 <h2 style="color:<?php echo $comment_data[$i]['color']; ?>;"><?php echo $comment_data[$i]['comment_id']; ?>.<?php echo htmlspecialchars( $comment_data[$i]['comment_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                 <time style="color:<?php echo $comment_data[$i]['color']; ?>;"><?php echo date('Y年m月d日 H:i', strtotime($comment_data[$i]['comment_datetime'])); ?></time>
                 <i class="fa-solid fa-reply reply-icon<?php echo $i?>"></i><p><?php if($comment_data[$i]['hensinid']!==0): ?>⇒<span style="color:<?php echo $comment_data[$i]['hensincolor']; ?>;"><?php echo $comment_data[$i]['hensinid']?>.<?php echo $comment_data[$i]['hensinname']?></span><br><?php endif; ?><?php echo nl2br(htmlspecialchars( $comment_data[$i]['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
                 <form method="get" action="" class="kie<?php echo $i;?>" style="display:none;"id="kie">
                   <?php if( !empty($error_message) ): ?>
                     <ul class="error_message">
                       <?php foreach( $error_message as $value ): ?>
                         <li><?php echo htmlspecialchars($value,ENT_QUOTES,'utf-8'); ?></li>
                       <?php endforeach; ?>
                     </ul>
                   <?php endif; ?>
                   <?php if(!empty($_GET['colorhensin'])): ?>
                     <p style="color:<?php echo $colorhensin;?>"><?php if(!empty($_GET['comment_idgati'])):?><?php echo $comment_idhensin; ?><?php endif; ?><?php if(!empty($_GET['comment_namehensin'])):?><?php echo $comment_namehensin; ?><?php endif; ?></p>
                   <?php endif; ?>
                     <div class="do">
                       <?php if($touhyou=='ari'): ?>
                         <lavel for="iken">どちら側の意見か(投票兼):</lavel>
                       <?php endif;?>
                       <?php if($touhyou=='nasi'): ?>
                         <lavel for="iken">どちら側の意見か:</lavel>
                       <?php endif;?>
                       <div class="ve1"><input type="radio" name="bluegreen2" value="red" id="sel3<?php echo $i;?>"><label for="sel3<?php echo $i;?>"class="agati"><?php if($jisuu=='koe'): ?>A<?php else: ?><?php echo $ikenagati; ?><?php endif ;?></label></div>
                       <div class="ve2"><input type="radio" name="bluegreen2" value="blue" id="sel4<?php echo $i;?>"><label for="sel4<?php echo $i;?>"class="bgati"><?php if($jisuu=='koe'): ?>B<?php else: ?><?php echo $ikenbgati; ?><?php endif ;?></label></div>
                     </div>
                   <div class="na">
                     <lavel for="view_name">仮名(20字以内):</lavel>
                     <input id="view_name" type="text" name="view_name" value="<?php if( !empty($_SESSION['view_name']) ){ echo htmlspecialchars( $_SESSION['view_name'], ENT_QUOTES, 'UTF-8'); } ?>">
                   </div>
                   <div class="co">
                     <lavel for="message">コメント(400字以内):</lavel>
                     <textarea id="message" name="message" class="message"></textarea>
                   </div>
                   <input type="hidden" name="comment_idgati" value="<?php echo $comment_idgati; ?>">
                   <input type="hidden" name="gidai_idgati" value="<?php echo $gidai_idgati; ?>">
                   <input type="hidden" name="etsurannsuu" value="<?php echo $etsurannsuu; ?>">
                   <input type="hidden" name="table_name1" value="<?php echo $table_name1; ?>">
                   <input type="hidden" name="table_name2" value="<?php echo $table_name2; ?>">
                   <input type="hidden" name="token1" value="<?php echo $token1;?>">
                   <input type="hidden" name="comment_idhensin" value="<?php echo $comment_data[$i]['comment_id']; ?>">
                 <input type="hidden" name="comment_namehensin" value="<?php echo htmlspecialchars( $comment_data[$i]['comment_name'], ENT_QUOTES, 'UTF-8'); ?>">
                 <input type="hidden" name="comment_colorhensin" value="<?php echo $comment_data[$i]['color']; ?>">
                   <div class="se">
                     <input type="submit" name="btn_submit" value="返信" id="toukou" class="toukou" onclick="scrollToTop()">
                   </div>
                 </form>
               </div>

             <?php endfor; ?>
           <?php endif; ?>
           </div>
         </div>
         <div class="comment"id="index">
         <form method="get" action="" >
           <div class="discussion">コメント投稿</div>
           <?php if( !empty($error_message) ): ?>
             <ul class="error_message">
               <?php foreach( $error_message as $value ): ?>
                 <li><?php echo htmlspecialchars($value,ENT_QUOTES,'utf-8'); ?></li>
               <?php endforeach; ?>
             </ul>
           <?php endif; ?>
           <?php if(!empty($_GET['colorhensin'])): ?>
             <p style="color:<?php echo $colorhensin;?>"><?php if(!empty($_GET['comment_idgati'])):?><?php echo $comment_idhensin; ?><?php endif; ?><?php if(!empty($_GET['comment_namehensin'])):?><?php echo $comment_namehensin; ?><?php endif; ?></p>
           <?php endif; ?>
             <div class="do">
               <?php if($touhyou==='ari'): ?>
                 <lavel for="iken">どちら側の意見か(投票兼):</lavel>
               <?php endif;?>
               <?php if($touhyou==='nasi'): ?>
                 <lavel for="iken">どちら側の意見か:</lavel>
               <?php endif;?>
               <div class="ve1"><input type="radio" name="bluegreen2" value="red" id="select_radio5"><label for="select_radio5"class="agati"><?php if($jisuu=='koe'): ?>A<?php else: ?><?php echo $ikenagati; ?><?php endif ;?></label></div>
               <div class="ve2"><input type="radio" name="bluegreen2" value="blue" id="select_radio6"><label for="select_radio6"class="bgati"><?php if($jisuu=='koe'): ?>B<?php else: ?><?php echo $ikenbgati; ?><?php endif ;?></label></div>
             </div>
           <div class="na">
             <lavel for="view_name">仮名(20字以内):</lavel>
             <input id="view_name" type="text" name="view_name" value="<?php if( !empty($_SESSION['view_name']) ){ echo htmlspecialchars( $_SESSION['view_name'], ENT_QUOTES, 'UTF-8'); } ?>">
           </div>
           <div class="co">
             <lavel for="message">コメント(400字以内):</lavel>
             <textarea id="message" name="message" class="message"></textarea>
           </div>
           <input type="hidden" name="comment_idgati" value="<?php echo $comment_idgati; ?>">
           <input type="hidden" name="gidai_idgati" value="<?php echo $gidai_idgati; ?>">
           <input type="hidden" name="etsurannsuu" value="<?php echo $etsurannsuu; ?>">
           <input type="hidden" name="table_name1" value="<?php echo $table_name1; ?>">
           <input type="hidden" name="table_name2" value="<?php echo $table_name2; ?>">
           <input type="hidden" name="token1" value="<?php echo $token1;?>">
           <div class="se">
             <input type="submit" name="btn_submit" value="書き込む" id="toukou" class="toukou" onclick="scrollToTop()">
           </div>
         </form>
       </div>

     <script src="index.js"></script>
   </body>
 </html>
