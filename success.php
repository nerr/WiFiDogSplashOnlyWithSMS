
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>认证成功, 祝您用餐愉快</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Hotspot Auth Page">
		<meta name="revised" content="Leon, 2013/3/6/" />
		<meta name="author" content="Leon Zhuang">

		<!-- Le styles -->
		<link href="../authpuppy/web/css/bootstrap.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 20px;
				padding-bottom: 40px;
				font-family: "Microsoft YaHei","Trebuchet MS","Myriad Pro",Arial,sans-serif;
				background-image: url("../authpuppy/web/img/grey.png");
			}

			/* Custom container */
			.container-narrow {
				margin: 0 auto;
				max-width: 700px;
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
		<link href="../authpuppy/web/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="/authpuppy/web/js/html5shiv.js"></script>
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

			<div class="masthead">
				<ul class="nav nav-pills pull-right">
					<!-- <li class="active"><a href="#help" role="button" data-toggle="modal">帮助</a></li> -->
				</ul>
				<h2>认证成功, 祝您用餐愉快 <br /><br />麻香传奇 &middot; 免费无线网络</h2>
			</div>

			<!-- <hr> -->

			<div id="myCarousel" class="carousel slide marketing">
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
				</ol>

				<div class="carousel-inner">
					<div class="item active">
						<img src="../authpuppy/web/img/0001.png" alt="">
						<div class="carousel-caption">
							<h4>辛香麻辣</h4>
							<p>全新推出劲爆干锅</p>
						</div>
					</div>
					<div class="item">
						<img src="../authpuppy/web/img/0002.png" alt="">
						<div class="carousel-caption">
							<h4>经典火锅</h4>
							<p>晚市88折, 午市夜宵68折</p>
						</div>
					</div>
					<div class="item">
						<img src="../authpuppy/web/img/0003.png" alt="">
						<div class="carousel-caption">
							<h4>源自山城</h4>
							<p>最重庆, 引爆夏日激情</p>
						</div>
					</div>
				</div>
				<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
			</div>

			<!-- <hr> -->

			<div class="row-fluid marketing">
				<div class="span6">
					<h2>认证成功，祝您用餐愉快。</h2>

					<?php if(strlen($_GET['userurl'])>0){ ?>
					<a href="<?php echo $_GET['userurl']; ?>"><?php echo $_GET['userurl']; ?></a>
					<?php } ?>
				</div>

				<div class="span6">

						<div class="row-fluid">
							<div class="span6">
								<h4>我们的微信</h4>
								<img src="../authpuppy/web/img/weixin_qr.png" alt="" class="qr">
								<p></p>
							</div>

							<div class="span6">
								<h4>我们的新浪微博</h4>
								<img src="../authpuppy/web/img/weibo_qr.png" alt="" class="qr">
								<p></p>
							</div>
						</div>

						<h4>关注我们</h4>
						<p>精彩活动在进行，火锅文化在传承。</p>
				</div>
			</div>

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
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
			</div> <!-- help modal -->

		</div> <!-- /container -->


		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="../authpuppy/web/js/jquery.js"></script>
		<script src="../authpuppy/web/js/jquery.md5.js"></script>
		<script src="../authpuppy/web/js/bootstrap.min.js"></script>

		<!-- js -->
		<script type="text/javascript">
			/*$(document).ready(function(){
				if(navigator.userAgent.match(/iPhone|iPod/i))
				{
					//window.location = "weixin://r/2mpcU1TEV2ooh0Uwnz-_";
					window.location = "dianping://shopinfo?id=9078228";
					setTimeout( function(){ window.location="https://itunes.apple.com/cn/app/da-zhong-dian-ping-tuan-gou/id351091731?mt=8"; } , 1500);
				}
				if(navigator.userAgent.match(/iPad/i))
				{
					//window.location = "weixin://r/2mpcU1TEV2ooh0Uwnz-_";
					window.location = "dianpinghd://shopinfo?id=9078228";
					setTimeout( function(){ window.location="https://itunes.apple.com/cn/app/da-zhong-dian-pinghd/id486691005?mt=8"; } , 1500);
				}
			});
*/		</script>

	</body>
</html>