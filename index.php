<?php
//DB接続情報
define( 'DB_HOST1', '');
define( 'DB_USER1', '');
define( 'DB_PASS1', '');
define( 'DB_NAME1', '');
$pdo1=null;
$stmt1=null;
$res1=null;
$stmt2=null;
$res2=null;
//DB接続
$pdo1 = new PDO('mysql:charset=UTF8;dbname='.DB_NAME1.';host='.DB_HOST1 , DB_USER1, DB_PASS1);
//新着順
$stmt1 = $pdo1->prepare("SELECT * FROM gidai ORDER BY kaisaijikoku DESC");
$res1 = $stmt1->execute();  
if($res1){
  $saisin_data = $stmt1->fetchall();
}
//人気順
$stmt2 = $pdo1->prepare("SELECT * FROM gidai ORDER BY etsurannsuu DESC");
$res2 = $stmt2->execute();    
if($res2){
  $ranking_data = $stmt2->fetchall();
}
$pdo1=null;
$stmt1=null;
$res1=null;
$stmt2=null;
$res2=null;
 ?>
<!DOCTYPE html>
<html>
 <head prefix=”og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#”>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/a1.css">
    <script type="text/javascript" src="https://netcousienn.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="css/a2.css">
    <link rel="icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ネット甲子園</title>
    <meta property="og:url" content="https://netcousienn.com/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="ネット甲子園" />
    <meta property="og:description" content="勝敗の付く討論サイトです。" />
    <meta property="og:site_name" content="ネット甲子園" />
    <meta property="og:image" content="https://netcousienn.com/img/netkousienn" />
    <script src="index.js"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-238889833-1');
    </script>
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
          <a href="https://netcousienn.com/tsukaikata"><li>使い方</li></a>
          <a href="https://netcousienn.com/siaisakusei"><li>試合作成</li></a>
          <a href="https://twitter.com/netkousienn"><li>twitter</li></a>
        </ul>
      </div>
      <form class="search" action="search.php" method="get">
        <input type="text" class="searchTerm" name = "kennsakunaiyou"placeholder="議題を探す"required>
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
    <div class="making-box">
      <a href="https://netcousienn.com/siaisakusei"><img src="https://netcousienn.com/img/siaisakusei.bmp" class="siaisakuseiimage"></a>
    </div>
    <div class="ranking">
      <img src="https://netcousienn.com/img/netkousienn-tokutennbann.png" class="tokutennban-image">
      <ol class="ranking-tokutennbann" title="人気試合ランキング">
        <?php for( $i = 0; $i < 10; $i++) : ?>
          <li>
            <form name="ranking1" action="ranking.php" method="get" class="">
              <input type="hidden" value="<?php echo $ranking_data[$i]['gidai_id']; ?>" name="siai_id">
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
                  <div class="ve1" style="color:white;"><a href="javascript:document.ranking1[<?php echo $i; ?>].submit()" class="siaikaisai" name="btn_ranking"><?php echo htmlspecialchars($ranking_data[$i]['gidai'] , ENT_QUOTES, 'UTF-8'); ?></a></div>
              </form>
            </li>
          <?php endfor; ?>
        </ol>
      </div>

      <div class="saisinsiai">
        <ul class="saisin" title="最新試合">
          <img src="https://netcousienn.com/img/saisinsiai.jpg"width="102%" class="saisin_img" >
            <?php for($i = 0; $i < 20; $i++) : ?>
              <li>
                <form action="ranking.php" method="get" name="saisin">
                  <input type="hidden" value="<?php echo $saisin_data[$i]['gidai_id']; ?>" name="siai_id">
                  <a href="javascript:document.saisin[<?php echo $i; ?>].submit()" class="siaikaisai" name="btn_saisin1"><?php echo $saisin_data[$i]['gidai']; ?></a>
                  <p><span class="red"><?php echo htmlspecialchars($saisin_data[$i]['ikenA'] , ENT_QUOTES, 'UTF-8'); ?></span>VS<span class="blue"><?php echo htmlspecialchars($saisin_data[$i]['ikenB'] , ENT_QUOTES, 'UTF-8'); ?></span><i class="fa-solid fa-comment-dots"></i></p>
                  <p><span class="jikan"><?php echo htmlspecialchars($saisin_data[$i]['kaisaijikoku'] , ENT_QUOTES, 'UTF-8'); ?></span></p>
                  <i class="fa fa-commenting-o ">   <?php echo $saisin_data[$i]['cnt'];?>件</i>
                  <?php if($saisin_data[$i]['keltsutyaku']==='nasi'): ?><p style="color:black;">決着済み</p><?php endif ;?>
                </form>
              </li>
            <?php endfor; ?>
          </ul>
      </div>
  </body>
</html>
