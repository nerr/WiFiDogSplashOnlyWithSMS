<?php
$action = 'http://'.$_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI'];
$user_redirect = $_GET['url'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Hotspot Auth</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Hotspot Auth Page">
        <meta name="revised" content="Leon, 2014/4/2/" />
        <meta name="author" content="Leon Zhuang">

        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 40px;
                font-family: "Microsoft YaHei","Trebuchet MS","Myriad Pro",Arial,sans-serif;
                background-image: url("img/grey.png");
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
        <link href="css/bootstrap-responsive.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="/js/html5shiv.js"></script>
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
                    <li class="active"><a href="#help" role="button" data-toggle="modal">帮助</a></li>
                </ul>
                <h3>慢先生的无线网络接入验证</h3>
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
                        <img src="img/0001.png" alt="">
                        <div class="carousel-caption">
                            <h4>这是一个私有无线网络环境</h4>
                            <p>仅对亲朋好友开放</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="img/0002.png" alt="">
                        <div class="carousel-caption">
                            <h4>请注意</h4>
                            <p>如果你能接入该网络，请自行承担信息安全风险！！！</p>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>

            <!-- <hr> -->

            <div class="row-fluid marketing">
                <div class="span6">
                    <form action="<?php echo $action; ?>"  autocomplete="on" method="post" id="auth">

                        <h4><span class="badge badge-info">1</span>&nbsp;请输入慢先生的手机号码</h4>
                        <p>
                            <label>如果你不知道可以尝试加慢先生的微信，咨询他本人</label>
                            <input id="smspass" name="smspass" type="tel" placeholder="" disabled="disabled" />
                        </p>
                        <p>
                            <input name="submit[apAuthSplashOnlyConnect]" class="btn btn-success" id="submit" type="submit" value="登陆" disabled="disabled" />
                            <span id="authstatus"></span>
                        </p>

                        <input type="hidden" name="gw_id" value="<?php echo $_GET['gw_id']; ?>" />
                        <input type="hidden" name="gw_address" value="<?php echo $_GET['gw_address']; ?>" />
                        <input type="hidden" name="gw_port" value="<?php echo $_GET['gw_port']; ?>" />
                        <input type="hidden" name="url" value="<?php echo $user_redirect; ?>" />
                        <input type="hidden" id="authenticators" name="authenticator" value="apAuthSplashOnly"/>

                        <input type="hidden" name="md5smspass" id="md5smspass" value="" />
                    </form>
                </div>

                <div class="span6">

                    <div class="row-fluid">
                        <div class="span6">
                            <h4>慢先生的微信</h4>
                            <img src="img/weixin_qr.png" alt="" class="qr">
                            <p></p>
                        </div>

                        <div class="span6">
                            <h4>慢先生的新浪微博</h4>
                            <img src="img/weibo_qr.png" alt="" class="qr">
                            <p></p>
                        </div>
                    </div>

                    <h4>你可以通过以上方式关注我</h4>
                    <p>但我未必会加你为好友</p>
                </div>
            </div>

            <hr>

            <div class="footer">
                <p>Powered By &copy; <a href="http://nerrsoft.com" target="_blank">Nerrsoft.com</a> <?php echo date("Y"); ?></p>
            </div>

            <!-- help modal -->
            <div id="help" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">帮助</h3>
                </div>
                <div class="modal-body">
                    <h4>如果你是慢先生的亲朋好友</h4>
                    <p>请输入慢先生的手机号码进行验证即可</p>
                    <h4>否则。。。</h4>
                    <p>自己想办法呗</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
            </div> <!-- help modal -->

        </div> <!-- /container -->


        <script src="js/jquery.js"></script>
        <script src="js/jquery.md5.js"></script>
        <script src="js/jquery.client.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <!-- js -->
        <script type="text/javascript">

            // implement JSON.stringify serialization
            JSON.stringify = JSON.stringify || function (obj) {
                var t = typeof (obj);
                if (t != "object" || obj === null) {
                // simple data type
                if (t == "string") obj = '"'+obj+'"';
                    return String(obj);
                }
                else {
                    // recurse array or object
                    var n, v, json = [], arr = (obj && obj.constructor == Array);
                    for (n in obj) {
                        v = obj[n]; t = typeof(v);
                        if (t == "string") v = '"'+v+'"';
                        else if (t == "object" && v !== null) v = JSON.stringify(v);
                        json.push((arr ? "" : '"' + n + '":') + String(v));
                    }
                    return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
                }
            };

            $(document).ready(function(){

                $('.carousel').carousel({
                    interval: 2000
                });

                $('#myModal').modal({
                    keyboard: false
                })

                //-- auth
                $('#auth').submit(function(){
                    $('#authstatus').text('请稍后').attr('class', 'msginfo');

                    var mp = $.trim($('#mobile').val());

                    if(!mp.match(mpformat))
                    {
                        $('#sendstatus').html('请输入一个有效的手机号码').attr('class', 'msgerro');
                        return false;
                    }

                    if($.md5($.md5(mp))!='677cf234ef778f58105e6a82c10d73b0')
                    {
                        $('#authstatus').text('验证失败').attr('class', 'msgerro');
                        return false;
                    }
                });
            });
        </script>

    </body>
</html>
