<?php
session_start();
include 'config.php';
require 'class/hotspotsms.php';

if($_GET['a']=='logout')
	unset($_SESSION['login']);

$hotspot = new hotspotsms($config);

$html = $hotspot->admin($_POST['password'], $_POST['sdate']);

//var_dump($_SESSION);
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>麻香传奇 &middot; 免费无线网络</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Hotspot Auth Page">
		<meta name="revised" content="Leon, 2013/3/6/" />
		<meta name="author" content="Leon Zhuang">

		<!-- Le styles -->
		<link href="../css/bootstrap.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 20px;
				padding-bottom: 40px;
				font-family: "Microsoft YaHei","Trebuchet MS","Myriad Pro",Arial,sans-serif;
			}

			/* Custom container */
			.container-narrow {
				margin: 0 auto;
				max-width: 980px;
			}
			.container-narrow > hr {
				margin: 30px 0;
			}

			/* Main marketing message and sign up button */
			.jumbotron {
				margin: 60px 0;
				text-align: center;
			}
			.jumbotron h1 {
				font-size: 72px;
				line-height: 1;
			}
			.jumbotron .btn {
				font-size: 21px;
				padding: 14px 24px;
			}

			/* Supporting marketing content */
			.marketing {
				margin: 60px 0;
			}
			.marketing p + h4 {
				margin-top: 28px;
			}

			.msginfo {
				color: blue;
			}
			.msgerro {
				color: red;
			}

			.qr {
				height: 130px;
			}

		</style>
		<link href="../css/bootstrap-responsive.css" rel="stylesheet">
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="js/html5shiv.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<!-- 
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="../assets/ico/favicon.png"> -->
	</head>

	<body>

		<div class="container-narrow">

			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
				<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="brand" href="#">麻香传奇 管理</a>
				<div class="nav-collapse collapse">
				<!-- <ul class="nav">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="#contact">Contact</a></li>
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
				<ul class="dropdown-menu">
				<li><a href="#">Action</a></li>
				<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li class="divider"></li>
				<li class="nav-header">Nav header</li>
				<li><a href="#">Separated link</a></li>
				<li><a href="#">One more separated link</a></li>
				</ul>
				</li>
				</ul> -->

				<?php echo $html; ?>

			<hr>

			<div class="footer">
				<p>&copy; 麻香传奇 2013 | Powered by <a href="http://nerrsoft.com" target="_blank">Nerrsoft.com</a></p>
			</div>

			<!-- help modal -->
			<div id="help" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">帮助</h3>
				</div>
				<!-- <div class="modal-body">
					<h4>第一步：获取短信动态密码</h4>
					<p>输入您的手机号码，点击“获取”按钮，等待接受短信密码。</p>
					<h4>第二步：验证密码</h4>
					<p>输入短信中的六位动态密码，点击“登陆”按钮，完成验证。</p>
				</div> -->
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
			</div> <!-- help modal -->

		</div> <!-- /container -->



		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="../js/jquery.js"></script>
		<script src="../js/jquery.md5.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<!-- js -->
		<script type="text/javascript">
			$(document).ready(function(){

			});
		</script>

	</body>
</html>