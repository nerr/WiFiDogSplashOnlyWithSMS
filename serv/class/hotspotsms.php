<?php
include 'PHPFetion.php';
/**
 * Hotspot auth with SMS
 *
 * @author leon@nerrsoft.com
 * @version 0.0.1
 */
class hotspotsms
{
	/**
     * 发送短信手机号for fetion
     * @var string
     */
    //protected $_mobile;

    /**
     * 发送短信手机号
     * @var string
     */
    protected $_account;

    /**
     * 发送短信密码
     * @var string
     */
    protected $_password;

    /**
     * 发送失败重试次数
     * @var string
     */
    protected $_trytime;

    /**
     * 
     * @var string
     */
    protected $_smsTextPrefix;
    protected $_smsTextSuffix;

    /**
     * MySQL 连接
     * @var object
     */
    protected $_mysqli;


	/**
	* 构造函数
	* @param array $cfg 配置参数
	*/
	public function __construct($cfg)
	{
		$this->_account  = $cfg['smsAccount'];
		$this->_password = $cfg['smsPassword'];
		$this->_trytime  = $cfg['smsTrytime'];
		$this->_smsTextPrefix = $cfg['smsTextPrefix'];
		$this->_smsTextSuffix = $cfg['smsTextSuffix'];

		$this->connect2db($cfg['dbHost'], $cfg['dbUser'], $cfg['dbPass'], $cfg['dbName']);
	}
	/**
     * 析构函数
     */
    public function __destruct()
    {
        $this->_mysqli->close();
    }

	public function step1()
	{
		$logtime = time();
		$mobile  = $_GET['mobile'];
		$client = $_GET['client'];
		//$client = addcslashes($client);
		
		//-- 确认库中是否存在有效验证码 - 
		$sql = "select smspass from log where mobile='$mobile' and logtime+300>$logtime order by logtime desc limit 1";
		$res = mysqli_query($this->_mysqli, $sql);

		if($res->num_rows > 0)
		{
			$row = mysqli_fetch_assoc($res);
			$smspass = $row['smspass'];
		}
		else
		{
			$smspass = $this->getRandCode();
			$sql = "insert into log (mobile, smspass, logtime, clientinfo) 
					values ('$mobile', '$smspass', $logtime, '$client')";
			mysqli_query($this->_mysqli, $sql);
		}

		//

		if($this->sendSms($mobile, $smspass))
		{
			$back['status'] = true;
			$back['md5smspass'] = md5(md5($smspass));
		}
		else
		{
			$back['status'] = false;
			$back['message'] = '短信发送失败,请确认您的手机号码后重新点击<获取>按钮';
		}

		echo $_GET['callback'].'('.json_encode($back).')';
	}

	public function step2()
	{
		$currtime = time();
		$mobile  = $_GET['mobile'];
		$smspass = $_GET['smspass'];

		$sql = "select id from log where mobile='$mobile' and smspass='$smspass' and logtime+300>$currtime order by logtime desc limit 1";
		$res = mysqli_query($this->_mysqli, $sql);
		if($res->num_rows == 1)
		{
			$back['status'] = true;
		}
		else
		{
			$back['status'] = false;
			$back['message'] = '验证失败,请确认您输入的验证码是否正确';
		}

		echo $_GET['callback'].'('.json_encode($back).')';
	}

	public function admin($pass='', $sdate='')
	{
		$html = '';

		if(md5($pass) == md5('sunyu') && !isset($_SESSION['login']))
		{
			$_SESSION['login'] = true;
		}
		
		if(!isset($_SESSION['login']))
		{
			$html = '<div class="row-fluid marketing">
			<div class="span12">
				<form action="admin.php" method="post">
						<input id="password" name="password" type="password" />
					<p>
						<input class="btn btn-success" type="submit" value="登录" />
					</p>
				</form>
			</div>
			</div>';

			$html = '
            <form action="admin.php" method="post" class="navbar-form pull-right">
              <input id="password" name="password" type="password" />
              <input class="btn btn-success" type="submit" value="登录" />
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>';

			return $html;
		}

		if($sdate == '')
			$sdate = date('Y-m-d');

		$tdate_b = strtotime($sdate);
		$tdate_e = $tdate_b + 24 * 3600;

		$sql = "select * from log where logtime>=$tdate_b and logtime<=$tdate_e order by id desc";
		$res = $this->_mysqli->query($sql);
		if($res)
		{
			/*$html = '<div class="row-fluid">
			<div class="span12">
				<form action="admin.php" method="post" class="navbar-search pull-right">
						日期：<input id="sdate" name="sdate" type="text" value="'.$sdate.'" />

						<input class="btn btn-success" type="submit" value="查询" />

				</form>
			</div>
			</div><hr>';*/

			$html = '
            <form action="admin.php" method="post" class="navbar-form pull-right">
              <input id="sdate" name="sdate" type="text" value="'.$sdate.'" />
              <input class="btn btn-success" type="submit" value="查询" />
              <a href="excel.php" class="btn btn-info" target="_blank">导出报表</a>
              <a href="admin.php?a=logout" class="btn btn-danger">退出</a>
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>';
			$html .= '<div class="marketing"><table class="table table-hover">
					<thead>
					<tr>
						<th>#</th>
						<th>时间</th>
						<th>手机号码</th>
						<th>动态密码</th>
						<th>操作系统</th>
						<th>浏览器</th>
						<th>语言</th>
					</tr>
					</thead>
					<tbody>';

			while($row = $res->fetch_object())
			{
				$client = json_decode($row->clientinfo);
				$os = $client->useragent;
				$mobileCode = $this->getMobileCodeInfo($row->mobile);

				$html .= '<tr class="gradeX">';
				$html .= '<td>'.$row->id.'</td>';
				$html .= '<td>'.date('Y-m-d H:i:s', $row->logtime).'</td>';
				$html .= '<td>'.$mobileCode.'</td>';
				$html .= '<td>'.$row->smspass.'</td>';
				$html .= '<td>'.$os.'</td>';
				$html .= '<td>'.$client->browser.' '.$client->version.'</td>';
				$html .= '<td>'.$client->language.'</td>';
				$html .= '</tr>';
			}

			$html .= '</tbody>
					</table></div>';

		}


		return $html;
	}

	/**
	 * 向指定手机号码发送验证码(fetion)
	 * @param string $mobile
	 * @param string $msg
	 */
	public function sendSms($mobile, $text)
	{
		$msg  = $this->_smsTextPrefix.$text.$this->_smsTextSuffix;
		$msg = urlencode($msg);

		$url  = 'http://210.5.158.31/hy/?expid=0&encode=utf8';
		$url .= '&uid='.$this->_account;
		$url .= '&auth='.$this->_password;
		$url .= '&mobile='.$mobile;
		$url .= '&msg='.$msg;
		
		try{

			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
			$statuscode = curl_exec($ch);
			curl_close($ch);

			$code = explode(',', $statuscode);

			if($code[0]==0)
				//echo "Date:".date('Y-m-d H:i:s', time()).";Finished\n";
				return true;
			else
				//echo "Date:".date('Y-m-d H:i:s', time()).";Failed\n";
				return false;
		}
		catch( Exception $e)
		{
			//echo "Date:".date('Y-m-d H:i:s', time()).";ERROR:".$e."\n";
			return false;
		}
	}

    /**
	 * 向指定手机号码发送验证码(fetion)
	 * @param string $mobile
	 * @param string $msg
	 */
	protected function sendSms_fetion($mobile, $msg)
	{
		$fetion = new PHPFetion($this->_mobile, $this->_password);
		try
		{
			$result = $fetion->send($mobile, $this->_smsTextPrefix.$msg.$this->_smsTextSuffix);
			$count = 0;
			while(!$this->checkStatus($result) && $count < $this->_trytime )
			{
				$count++;
				sleep(2);
				//echo "Sleep 2s, Re Send\n";
				$result = $result = $fetion->send($mobile, $this->_smsTextPrefix.$msg.$this->_smsTextSuffix);
			}
			if ($count != ($this->_trytime - 1))
			{
				//echo "Date:".date('Y-m-d H:i:s', time()).";Finished\n";
				return true;
			}
			else
			{
				//echo "Date:".date('Y-m-d H:i:s', time()).";Failed\n";
				return false;
			}
		}
		catch( Exception $e)
		{
			//echo "Date:".date('Y-m-d H:i:s', time()).";ERROR:".$e."\n";
			return false;
		}
	}

	/**
	 * 检测短信发送状态
	 * @param string $status_code
	 */
	protected function checkStatus($status_code)
	{
		preg_match('/^.*HTTP\/1\.1 200 OK.*$/si', $status_code, $status);
		if(isset($status[0]))
			return true;
		else
		{
			//echo "Result:$status_code\n";
			return false;
		}
	}

	/**
	 * 生成随机码
	 * @param string $digits = 6; 随机码位数
	 */
	protected function getRandCode($digits = 6)
	{
		$code = '';
		for($i = 0; $i < $digits; $i++)
		{
			$code .= rand(0,9);
		}
		return $code;
	}

	/**
	 * 链接MySQL
	 * @param string $digits = 6; 随机码位数
	 */
	protected function connect2db($host, $user, $pass, $db)
	{
		$this->_mysqli = new mysqli($host, $user, $pass, $db);
	}

	protected function getMobileCodeInfo($number)
	{
		$url = 'http://webservice.webxml.com.cn/WebServices/MobileCodeWS.asmx/getMobileCodeInfo';   
  
		$ch = curl_init();   
		curl_setopt($ch, CURLOPT_URL, $url);   
		curl_setopt($ch, CURLOPT_POST, true);   
		curl_setopt($ch, CURLOPT_POSTFIELDS, "mobileCode={$number}&userId=");   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
		$data = curl_exec($ch);   
		curl_close($ch); 

		$data = simplexml_load_string($data);   
		return $data;
	}

	public function querydb($sql)
	{
		$res = mysqli_query($this->_mysqli, $sql);

		if($res->num_rows > 0)
		{
			while($row = mysqli_fetch_assoc($res))
			{
				$data[] = $row;
			}

			return $data;
		}else
			return false;
	}
}