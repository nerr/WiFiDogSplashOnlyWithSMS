<?php
//--
$action = 'http://'.$_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI'];
//--
$site_name = apAuthpuppyConfig::getConfigOption("site_name","");
//--
$sms_url = apAuthpuppyConfig::getConfigOption("sms_url","");
//--
if ($site_name != '')
    sfContext::getInstance()->getResponse()->setTitle($site_name);

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
        <link href="/authpuppy/web/css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 40px;
                font-family: "Microsoft YaHei","Trebuchet MS","Myriad Pro",Arial,sans-serif;
                background-image: url("/authpuppy/web/img/grey.png");
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
        <link href="/authpuppy/web/css/bootstrap-responsive.css" rel="stylesheet">

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
                    <li class="active"><a href="#help" role="button" data-toggle="modal">帮助</a></li>
                </ul>
                <h3>麻香传奇 &middot; 免费无线网络 &middot; 登录</h3>
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
                        <img src="/authpuppy/web/img/0001.png" alt="">
                        <div class="carousel-caption">
                            <h4>辛香麻辣</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="/authpuppy/web/img/0002.png" alt="">
                        <div class="carousel-caption">
                            <h4>经典火锅</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                    <div class="item">
                        <img src="/authpuppy/web/img/0003.png" alt="">
                        <div class="carousel-caption">
                            <h4>源自山城</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>

            <!-- <hr> -->

            <div class="row-fluid marketing">
                <div class="span6">
                    <form  action="###" autocomplete="on" method="post" id="sendmobile"> 
                        <h4><span class="badge badge-info">1</span>&nbsp;输入手机号码</h4>
                        <p> 
                            <label>用于接收动态短信验证码</label>
                            <input id="mobile" name="mobile" type="text" placeholder=""/>
                        </p>
                        <p>
                            <input class="btn btn-success" id="sendsms" type="submit" value="获取" />
                            <span id="sendstatus"></span>
                        </p>
                    </form>

                    <form action="<?php echo $action; ?>"  autocomplete="on" method="post" id="auth">

                        <h4><span class="badge badge-info">2</span>&nbsp;输入短信验证码</h4>
                        <p> 
                            <label>6位数字</label>
                            <input id="smspass" name="smspass" type="text" placeholder="" disabled="disabled" />
                        </p>
                        <p>
                            <input name="submit[apAuthSplashOnlyConnect]" class="btn btn-success" id="submit" type="submit" value="登陆" disabled="disabled" />
                            <span id="authstatus"></span>
                        </p>

                        <input type="hidden" name="gw_id" value="<?php echo $_GET['gw_id']; ?>" />
                        <input type="hidden" name="gw_address" value="<?php echo $_GET['gw_address']; ?>" />
                        <input type="hidden" name="gw_port" value="<?php echo $_GET['gw_port']; ?>" />
                        <input type="hidden" name="url" value="http://weibo.com/mlyinxiang" />
                        <input type="hidden" id="authenticators" name="authenticator" value="apAuthSplashOnly"/>

                        <input type="hidden" name="md5smspass" id="md5smspass" value="" />
                    </form>
                </div>

                <div class="span6">

                    <div class="row-fluid">
                        <div class="span6">
                            <h4>我们的微信</h4>
                            <img src="/authpuppy/web/img/weixin_qr.png" alt="" class="qr">
                            <p></p>
                        </div>

                        <div class="span6">
                            <h4>我们的新浪微博</h4>
                            <img src="/authpuppy/web/img/weibo_qr.png" alt="" class="qr">
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
                    <h4>第一步：获取短信动态密码</h4>
                    <p>输入您的手机号码，点击“获取”按钮，等待接受短信密码。</p>
                    <h4>第二步：验证密码</h4>
                    <p>输入短信中的六位动态密码，点击“登陆”按钮，完成验证。</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
            </div> <!-- help modal -->

        </div> <!-- /container -->



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php use_javascript('jquery.js') ?>
        <?php use_javascript('jquery.md5.js') ?>
        <?php use_javascript('jquery.client.js') ?>
        <?php use_javascript('bootstrap.min.js') ?>
        <?php include_javascripts() ?>

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

                //-- send mobile phone number
                var mpformat = /(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/;
                $('#sendmobile').submit(function(){
                    var mp = $.trim($('#mobile').val());
                    var client = JSON.stringify($.client);

                    if(!mp.match(mpformat))
                        $('#sendstatus').html('请确认您的手机号码').attr('class', 'msgerro');
                    else
                    {
                        $('#mobile').attr('disabled', 'disabled');
                        $('#sendsms').attr('disabled', 'disabled');
                        $('#sendstatus').text('请稍候').attr('class', 'msginfo');

                        var url = "<?php echo $sms_url; ?>/serv/auth.php?action=step1&mobile="+mp+"&client="+client+"&callback=?";

                        $.getJSON(url, function(data){

                            if(data.status==true)
                            {

                                $('#sendstatus').text('短信发送成功,请查收').attr('class', 'msginfo');

                                $('#md5smspass').val(data.md5smspass);

                                if($('#smspass').attr('disabled')=='disabled')
                                    $('#smspass').attr('disabled', false);
                                if($('#submit').attr('disabled')=='disabled')
                                    $('#submit').attr('disabled', false);
                            }
                        });
                    }
                    return false;
                });

                //-- check sms pass
                var spformat = /(^[0-9]{6}$)/;
                $('#auth').submit(function(){
                    $('#authstatus').text('请稍后').attr('class', 'msginfo');

                    var smspass = $.trim($('#smspass').val());
                    var mp = $.trim($('#mobile').val());

                    if(!smspass.match(spformat))
                    {
                        $('#authstatus').text('验证码格式不正确').attr('class', 'msgerro');
                        return false;
                    }

                    if($.md5($.md5(smspass))!=$('#md5smspass').val())
                    {
                        $('#authstatus').text('验证失败,请检查您的验证码是否正确').attr('class', 'msgerro');
                        return false;
                    }
                });
            });
        </script>

    </body>
</html>
