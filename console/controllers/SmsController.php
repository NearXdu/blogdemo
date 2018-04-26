<?php

namespace console\controllers;

use Crlt\Tools\Unicode2Utf;
use function json_decode;
use function json_encode;
use const JSON_UNESCAPED_UNICODE;
use function mb_convert_encoding;
use const PHP_EOL;
use function var_dump;
use Yii;
use yii\console\Controller;
use common\models\Comment;
use Qcloud\Sms\SmsSingleSender;


/**
 * Created by PhpStorm.
 * User: crlt_
 * Date: 2018/4/23
 * Time: 下午12:06
 */
class SmsController extends Controller
{
    public function actionSend()
    {
        $newCommentCount = Comment::find()->where(['remind' => 0, 'status' => '1'])->count();
        if ($newCommentCount > 0) {
            $content = '有' . $newCommentCount . '条新评论待审核。';

            $result = $this->vendorSmsService($content);

            if ($result['status'] == 'success') {
                Comment::updateAll(['remind' => 1]); //把提醒标志全部设为已提醒
                echo '[' . date("Y-m-d H:i:s", $result['dt']) . '] ' . $content . '[' . $result['length'] . ']' . "\r\n";//记录日志

            }
            return 0;
        }

    }



    protected function vendorSmsService($content)
    {

        $appid = 1400086166;
        $appkey = "69709be517087f7bce3634e9311538fb";
        $phoneNumber = 18710829722;
        try {
            $sender = new SmsSingleSender($appid, $appkey);
            $result = $sender->send(0, "86", $phoneNumber,
                $content, "", "");
           // $rsp = json_decode($resut);
            //echo $this->unicode_to_utf8($result);
            $trans=new Unicode2Utf();
            echo $trans->transform($result).PHP_EOL;
        //    $replacedString = preg_replace("/\\\\u(\w{4})/", "&#x$1;", $result);
         //   $unicodeString = mb_convert_encoding($replacedString, 'UTF-8', 'HTML-ENTITIES');
           // echo $unicodeString.PHP_EOL;
            //var_dump(json_decode($result,true));
        } catch (\Exception $e) {
            echo var_dump($e);
        }

        //实现第三方短信供应商提供的短信发送接口。

        //     	$username = 'companyname';		//用户账号
        //     	$password = 'pwdforsendsms';	//密码
        //     	$apikey = '577d265efafd2d9a0a8c2ed2a3155ded7e01';	//密码
        //     	$mobile	 = $adminuser->mobile;	//号手机码

        //     	$url = 'http://sms.vendor.com/api/send/?';
        //     	$data = array
        //     	(
        //     			'username'=>$username,				//用户账号
        //     			'password'=>$password,				//密码
        //     			'mobile'=>$mobile,					//号码
        //     			'content'=>$content,				//内容
        //     			'apikey'=>$apikey,				    //apikey
        //     	);
        //     	$result= $this->curlSend($url,$data);			//POST方式提交
        //     	return $result;    //返回发送状态，发送时间，字节数等数据
        //     	}

        $result = array("status" => "success", "dt" => time(), "length" => 43);  //模拟数据
        return $result;

    }

}
