<?php
//DB接続情報
define( 'DB_HOST', '');
define( 'DB_USER', '');
define( 'DB_PASS', '');
define( 'DB_NAME', '');
$pdo=null;
$sql=null;
$gidai_date=null;
//DB接続
$pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST , DB_USER, DB_PASS);
//最後のID取得
$stmt = $pdo->prepare("SELECT MAX(gidai_id) FROM gidai");
$res= $stmt->execute();
if($res){
  $maxgidai_data = $stmt->fetch();
  $siai_id = $maxgidai_data['MAX(gidai_id)'];
}
$pdo = null;
$token = md5(microtime());
 ?>
<!DOCTYPE html>
<html>
  <head prefix=”og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#”>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/b1.css">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="css/b2.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
　　<script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-238889833-1');
    </script>
    <title>ネット甲子園（試合作成）</title>
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
    <div class="siaisakusei">
      <div class="siaisakusei_haikei">
        <form method="get" action="siai.php" id="siai" name="siaisakusei">
          <div class="gidai">
            <div class="gidai1">
              <div class="gidai3">
                議題
              </div>
              <div class="gidai4">
                (300字以内)
              </div>
            </div>
            <div class="gidai2">
              <textarea class="gidai_text" name="wadai" maxlength="300" required></textarea>
            </div>
          </div>
        <div class="kata3">
          <div class="kata1">
            <div class="kata1a">
              <div class="mk1">
                片方の意見
              </div>
              <div class="mk2">
                (100字以内)
              </div>
            </div>
            <div class="ikena1">
                <textarea class="ikena_text" name="ikenA" maxlength="100" required></textarea>
            </div>
          </div>
          <div class="kata2">
            <div class="kata2a">
              <div class="mk1">
                もう片方の意見
              </div>
              <div class="mk2">
                (100字以内)
              </div>
            </div>
            <div class="ikenb1">
                <textarea class="ikenb_text" name="ikenB" maxlength="100" required></textarea>
            </div>
          </div>
        </div>
        <div class="ketyakuten">
          <div class="ketyakuten1">
            <div class="ke1">
              決着点
            </div>
             <div class="ke2">
               (5点以上10000点以下)
             </div>
          </div>
          <div class="ketyakuten2">
            <input type="number" name="syouritenn"class="syouritenn" value="" min ="5"max="10000" step="1"required>
            <input type="hidden" value="<?php echo $siai_id ?>" name="siai_id">
            <input type="hidden" name="token" value="<?php echo $token;?>">
          </div>
         </div>
         <div class="kaisai">
           <input type="submit" name="btn_kaisai" value="START" class="kaisai_btn">
         </div>
       </form>
      </div>
    </div>
    <script src="index.js"></script>
  </body>
</html>
