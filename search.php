<?php
//DB接続情報
define( 'DB_HOST1', '');
define( 'DB_USER1', '');
define( 'DB_PASS1', '');
define( 'DB_NAME1', '');
session_start();
//DB接続
$pdo1 = new PDO('mysql:charset=UTF8;dbname='.DB_NAME1.';host='.DB_HOST1 , DB_USER1, DB_PASS1);
//検索内容取得
if(!empty($_GET['kennsakunaiyou'])){
  $kennsaku = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_GET['kennsakunaiyou']);
}
$gidai = '%'.$kennsaku.'%';
//データ取得
if(!empty($_GET['hyouji1'])){
  $hyouji1=$_GET['hyouji1'];
}else{
  $hyouji1='no';
}
if(!empty($_GET['hyouji2'])){
  $hyouji2=$_GET['hyouji2'];
}else{
  $hyouji2='no';
}

//データ範囲
if(!empty($_GET['ai'])){
  if($_GET['ai']=='すべて'){
      $hyouji1='sube';
    }
  if($_GET['ai']=='議論中'){
      $hyouji1='tyuu';
    }
  if($_GET['ai']=='決着済み'){
      $hyouji1='sumi';
  }
}
//データ順番
if(!empty($_GET['bi'])){
  if($_GET['bi']=='人気順'){
      $hyouji2='ninki';
      $hyouji3='人気順';
    }
  if($_GET['bi']=='新着順'){
      $hyouji2='sin';
      $hyouji3='新着順';
    }
  if($_GET['bi']=='古い順'){
      $hyouji2='furui';
      $hyouji3='古い順';
  }
}else{
  $hyouji3='新着順';
}
//決着判断
if($hyouji1=='tyuu'){
  $touhyou='ari';
}
if($hyouji1=='sumi'){
  $touhyou='nasi';
}
//あてはまる単語があるか
if($hyouji1=='no'||$hyouji1=='sube'){
    $sql1 = "SELECT * FROM gidai WHERE  gidai LIKE :gidai ";
    $stmt1 = $pdo1->prepare($sql1);
    $stmt1->bindParam( ':gidai', $gidai, PDO::PARAM_STR);
    $res1 = $stmt1->execute();
  if($res1){
    $search_data2 = $stmt1->fetchall();
    $cnt = count($search_data2);
  }
  foreach($search_data2 as $fruit) {
    $gidai_id[] = $fruit['gidai_id'];
    $gidai_etsurannsuu[] = $fruit['etsurannsuu'];
  }
}
//決着判断データ抽出
if($hyouji1=='tyuu'||$hyouji1=='sumi'){
    $stmt2 = $pdo1->prepare("SELECT * FROM gidai WHERE  gidai LIKE :gidai AND keltsutyaku = :keltsutyaku");
    $stmt2->bindParam( ':keltsutyaku', $touhyou, PDO::PARAM_STR);
    $stmt2->bindParam( ':gidai', $gidai, PDO::PARAM_STR);
    $res2 = $stmt2->execute();
  if($res2){
    $search_data2 = $stmt2->fetchall();
    $cnt = count($search_data2);
  }
  foreach($search_data2 as $fruit) {
      $gidai_id[] = $fruit['gidai_id'];
      $gidai_etsurannsuu[] = $fruit['etsurannsuu'];
  }


}
if($cnt>=1){
  
  //データ範囲が指定なし、データ順番が指定なし
  if($hyouji1=='no'&&$hyouji2=='no'){
    array_multisort($gidai_id,SORT_DESC,$search_data2);
  }
  //データ範囲がすべて、データ順番が指定なし
  if($hyouji1=='sube'&&$hyouji2=='no'){
    array_multisort($gidai_id,SORT_DESC,$search_data2);
  }
  //データ範囲が議論中、データ順番が指定なし
  if($hyouji1=='tyuu'&&$hyouji2=='no'){
    array_multisort($gidai_id,SORT_DESC,$search_data2);
  }
  //データ範囲が決着済み、データ順番が指定なし
  if($hyouji1=='sumi'&&$hyouji2=='no'){
    array_multisort($gidai_id,SORT_DESC,$search_data2);
  }
  //データ範囲が指定なし、データ順番が人気順
  if($hyouji1=='no'&&$hyouji2=='ninki'){
    array_multisort($gidai_etsurannsuu,SORT_DESC,$search_data2);
  }
  //データ範囲が指定なし、データ順番が新着順
  if($hyouji1=='no'&&$hyouji2=='sin'){
    array_multisort($gidai_id,SORT_DESC,$search_data2);
  }
  //データ範囲が指定なし、データ順番が古い順
  if($hyouji1=='no'&&$hyouji2=='furui'){
    array_multisort($gidai_id,SORT_ASC,$search_data2);
  }
  //データ範囲がすべて、データ順番が人気順
  if($hyouji1=='sube'&&$hyouji2=='ninki'){
    array_multisort($gidai_etsurannsuu,SORT_DESC,$search_data2);
  }
  //データ範囲がすべて、データ順番が新着順
  if($hyouji1=='sube'&&$hyouji2=='sin'){
    array_multisort($gidai_id,SORT_DESC,$search_data2);
  }
  //データ範囲が指定なし、データ順番が古い順
  if($hyouji1=='sube'&&$hyouji2=='furui'){
    array_multisort($gidai_id,SORT_ASC,$search_data2);
  }
  //データ範囲が議論中、データ順番が人気順
  if($hyouji1=='tyuu'&&$hyouji2=='ninki'){
    array_multisort($gidai_etsurannsuu,SORT_DESC,$search_data2);
  }
  //データ範囲が議論中、データ順番が新着順
  if($hyouji1=='tyuu'&&$hyouji2=='sin'){
    array_multisort($gidai_id,SORT_DESC,$search_data2);
  }
  //データ範囲が議論中、データ順番が古い順
  if($hyouji1=='tyuu'&&$hyouji2=='furui'){
    array_multisort($gidai_id,SORT_ASC,$search_data2);
  }
  //データ範囲が決着済み、データ順番が人気順
  if($hyouji1=='sumi'&&$hyouji2=='ninki'){
    array_multisort($gidai_etsurannsuu,SORT_DESC,$search_data2);
  }
  //データ範囲が決着済み、データ順番が新着順
  if($hyouji1=='sumi'&&$hyouji2=='sin'){
    array_multisort($gidai_id,SORT_DESC,$search_data2);
  }
  //データ範囲が決着済み、データ順番が古い順
  if($hyouji1=='sumi'&&$hyouji2=='furui'){
    array_multisort($gidai_id,SORT_ASC,$search_data2);
  }
}
$top='66px';
//人気順
$stmt3 = $pdo1->prepare("SELECT * FROM gidai ORDER BY etsurannsuu DESC");
$res3 = $stmt3->execute();
if($res3){
  $ranking_data = $stmt3->fetchall();
}
$pdo1 = null;
?>
<!DOCTYPE html>
<html>
<head prefix=”og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#”>
   <meta charset="utf-8">
   <link rel="stylesheet" href="css/e1.css">
   <script type="text/javascript" src="https://netcousienn.com/jquery-3.6.0.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <link rel="stylesheet" href="css/e2.css">
   <link rel="icon" href="favicon.ico">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta property="og:url" content="https://netcousienn.com/search.php" />
   <meta property="og:type" content="article" />
   <meta property="og:title" content="ネット甲子園" />
   <meta property="og:description" content="勝敗の付く討論サイトです。" />
   <meta property="og:site_name" content="ネット甲子園" />
   <meta property="og:image" content="https://netcousienn.com/img/netkousienn" />
   <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-238889833-1');
   </script>
   <title>ネット甲子園</title>
</head>
<body>
 <header>
   <div class="header-left">
     <span class="fa fa-bars menu-icon"></span><a href="https://netcousienn.com/"><img src="https://netcousienn.com/img/netkousienn-home.png" class="head"alt=""></a>
   </div>
   <div class="migi">
     <div class="header-right-right">
       <a href="https://twitter.com/netkousienn" class="btn twitter">
       <span class="fa fa-twitter twitter2 fa-2x"></span>
       </a>
     </div>
     <div class="header-right3">
       <a href="https://netcousienn.com/tsukaikata" class="btn tsukaikata">使い方</a>
     </div>
   </div>
   <div class="menu">
     <ul>
       <a href="https://netkousienn.com/tsukaikata"><li>使い方</li></a>
       <a href="https://netcousienn.com/siaisakusei"><li>試合作成</li></a>
       <a href="https://twitter.com/netcousienn"><li>twitter</li></a>
     </ul>
   </div>
   <form class="search" action="search.php" method="get"style="margin-top:<?php echo $top ;?>">
     <input type="text" class="searchTerm" name = "kennsakunaiyou"placeholder="議題を探す"required>
     <button type="submit" class="searchButton">
       <i class="fa fa-search"></i>
     </button>
   </form>
 </header>

 <?php if($cnt >= 1):?>
   <div class="koukokupc1" style="margin-top:140px;">
     <a href="https://px.a8.net/svt/ejp?a8mat=3NGZIB+4CL1NE+4EKC+62U35" rel="nofollow">
     <img border="0" width="936" height="120" alt="" src="https://www23.a8.net/svt/bgt?aid=220822211263&wid=002&eno=01&mid=s00000020550001021000&mc=1"></a>
     <img border="0" width="1" height="1" src="https://www19.a8.net/0.gif?a8mat=3NGZIB+4CL1NE+4EKC+62U35" alt="">
   </div>
   <div class="koukokupad1" style="margin-top:140px;">
     <a href="https://px.a8.net/svt/ejp?a8mat=3NGZIB+4CL1NE+4EKC+62MDD" rel="nofollow">
     <img border="0" width="640" height="100" alt="" src="https://www25.a8.net/svt/bgt?aid=220822211263&wid=002&eno=01&mid=s00000020550001020000&mc=1"></a>
     <img border="0" width="1" height="1" src="https://www13.a8.net/0.gif?a8mat=3NGZIB+4CL1NE+4EKC+62MDD" alt="">
   </div>
   <div class="koukokusm1" style="margin-top:140px;">
     <a href="https://px.a8.net/svt/ejp?a8mat=3NGZIB+4CL1NE+4EKC+5ZEMP" rel="nofollow">
     <img border="0" width="320" height="50" alt="" src="https://www27.a8.net/svt/bgt?aid=220822211263&wid=002&eno=01&mid=s00000020550001005000&mc=1"></a>
     <img border="0" width="1" height="1" src="https://www12.a8.net/0.gif?a8mat=3NGZIB+4CL1NE+4EKC+5ZEMP" alt="">
   </div>
   <div class="koukokuga1" style="margin-top:140px;">
     <a href="https://px.a8.net/svt/ejp?a8mat=3NGZIB+4CL1NE+4EKC+62ENL" rel="nofollow">
     <img border="0" width="234" height="60" alt="" src="https://www25.a8.net/svt/bgt?aid=220822211263&wid=002&eno=01&mid=s00000020550001019000&mc=1"></a>
     <img border="0" width="1" height="1" src="https://www10.a8.net/0.gif?a8mat=3NGZIB+4CL1NE+4EKC+62ENL" alt="">
   </div>
   <div class="keltsuka1">
     <div class="keltsuka2">
        検索結果
     </div>
     <ul class="result">
     <?php if($cnt > 1): ?>
       <?php for($i = 0; $i < $cnt; $i++): ?>
         <li>
           <form action="ranking.php" name="saisin20" method="get">
           <input type="hidden" value="<?php echo $search_data2[$i]['gidai_id']; ?>" name="siai_id">
           <input type="hidden" name="token1" value="<?php echo $token1;?>">
           <a href="javascript:document.saisin20[<?php echo $i; ?>].submit()"><?php echo $search_data2[$i]['gidai']; ?></a>  <?php if($search_data2[$i]['keltsutyaku']==='nasi'): ?><span>決着済み</span><?php endif ;?>
           </form>
         </li>
       <?php endfor;?>
     <?php endif; ?>
     <?php if($cnt == 1): ?>
       <li>
       <form action="ranking.php" name="saisin20" method="get">
       <input type="hidden" value="<?php echo $search_data2[0]['gidai_id']; ?>" name="siai_id">
       <input type="hidden" name="token1" value="<?php echo $token1;?>">
       <a href="javascript:document.saisin20.submit()"><?php echo $search_data2[0]['gidai']; ?></a>  <?php if($search_data2[0]['keltsutyaku']==='nasi'): ?><span>決着済み</span><?php endif ;?>
       </form>
       </li>
      <?php endif; ?>
    </ul>
  </div>
  <div class="siborikomi1">
    <div class="siborikomi2">
      検索条件
    </div>
    <div class="siborikomi3">
      <form method="get" name="form1" action="search.php">
        <input type="hidden" name="ai" value="すべて">
                    <input type="hidden" name="hyouji1" value="<?php echo $hyouji1;?>">
                    <input type="hidden" name="hyouji2" value="<?php echo $hyouji2;?>">
                  <input type="hidden" name="kennsaku" value="<?php echo $kennsaku;?>">
          <a href="javascript:form1.submit()">すべて</a>
       </form>
       <form method="get" name="form2" action="search.php">
         <input type="hidden" name="ai" value="議論中">
                     <input type="hidden" name="hyouji1" value="<?php echo $hyouji1;?>">
                     <input type="hidden" name="hyouji2" value="<?php echo $hyouji2;?>">
                   <input type="hidden" name="kennsaku" value="<?php echo $kennsaku;?>">
           <a href="javascript:form2.submit()">議論中</a>
        </form>
        <form method="get" name="form3" action="search.php">
          <input type="hidden" name="ai" value="決着済み">
                      <input type="hidden" name="hyouji1" value="<?php echo $hyouji1;?>">
                      <input type="hidden" name="hyouji2" value="<?php echo $hyouji2;?>">
                    <input type="hidden" name="kennsaku" value="<?php echo $kennsaku;?>">
            <a href="javascript:form3.submit()">決着済み</a>
         </form>
       <form name="" id="submit_form"action="" method="get"class="cp_ipselect cp_sl01">
         <select class="" id="submit_select "name="bi"onchange="submit(this.form)">
           <option value="" hidden><?php echo $hyouji3 ;?></option>
           <option value="新着順">新着順</option>
           <option value="古い順">古い順</option>
           <option value="人気順">人気順</option>
         </select>
         <input type="hidden" name="hyouji1" value="<?php echo $hyouji1;?>">
         <input type="hidden" name="hyouji2" value="<?php echo $hyouji2;?>">
         <input type="hidden" name="kennsaku" value="<?php echo $kennsaku;?>">
       </form>
    </div>
   </div>
 <?php endif;?>
 <?php if($cnt == 0): ?>
       <div class="nai">検索結果はありませんでした</div>
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
       <div class="ranking">
         <img src="https://netcousienn.com/img/netkousienn-tokutennbann.png" class="tokutennban-image">
         <ol class="ranking-tokutennbann" title="人気試合ランキング">
           <?php for( $i = 0; $i < 10; $i++) : ?>
             <li>
               <form name="ranking1" action="ranking.php" method="get" class="">
                 <input type="hidden" value="<?php echo $ranking_data[$i]['gidai_id']; ?>" name="siai_id">
                 <input type="hidden" name="token" value="<?php echo $token;?>">
                 <div class="ve1" style="color:white;"><a href="javascript:document.ranking1[<?php echo $i; ?>].submit()" class="siaikaisai" name="btn_ranking"><?php echo htmlspecialchars($ranking_data[$i]['gidai'] , ENT_QUOTES, 'UTF-8'); ?></a></div>
               </form>
             </li>
            <?php endfor; ?>
          </ol>
        </div>
        <div class="ranking2">
          <img src="https://netcousienn.com/img/ninkisiai.bmp" class="ranking2_img">
            <ol class="ranking-tokutennbann2" title="人気試合ランキング">
              <?php for( $i = 0; $i < 10; $i++) : ?>
                <li>
                  <form name="ranking1" action="ranking.php" method="get" class="">
                     <input type="hidden" value="<?php echo $ranking_data[$i]['gidai_id']; ?>" name="siai_id">
                     <input type="hidden" name="token" value="<?php echo $token;?>">
                     <div class="ve1" style="color:white;"><a href="javascript:document.ranking1[<?php echo $i; ?>].submit()" class="siaikaisai" name="btn_ranking"><?php echo htmlspecialchars($ranking_data[$i]['gidai'] , ENT_QUOTES, 'UTF-8'); ?></a></div>
                  </form>
                </li>
              <?php endfor; ?>
            </ol>
         </div>
     <?php endif; ?>
     <script src="index.js"></script>
   </body>
 </html>
