<?php

namespace App\Http\Controllers;

use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

class addOa extends Controller
{
    function addOaPage()
    {
        return view('addOaPage');

    }

    function getContent($contentData){
        $data = "<p><strong>
                    開發任務</strong></p>
                    <p>-------------------------------------------------------------------------------------------------</p>
                    <p>1. 需求者 </p>
                    <p>2. 詳細內容</p>
                    <ul>
                    {$contentData}
                    </ul>
                    <p>3. 解決方法</p>
                    <p>4. 測試注意事項</p>
                    <p>&nbsp;</p>";
        return $data ;
    }

    function getOaData($data){
        $returnData =[];
        $data  = str_replace(array("\r", "\n", "\r\n", "\n\r"),'',$data);
        $oaDatas = explode('++', $data  );

        foreach ($oaDatas as $oaData){
            $tmpData=  (object)[];
            $oaDataArr = explode('--', $oaData);
            $i = 0;
            foreach ($oaDataArr as $oa){
                switch ($i){
                    case 0:
                        $tmpData->pid = $oa;
                        break;
                    case 1:
                        $oa = $oa*1;
                        $oa= (is_int($oa*1 ))?(string)$oa.'.0':$oa;
                        $tmpData->time = $oa;
                        break;
                    case 2:
                        $tmpData->title = $oa;
                        $tmpData->content = "<li>{$oa}</li>";
                        break;
                    default:
                        $tmpData->content .= "<li>{$oa}</li>";
                }
                $i ++;
            }
            $returnData[]=$tmpData;
        }

        return $returnData;

    }
    /** 开始写oa */
    function doAddOa(Request $request){
        /** 取request資料 */
        $oaDatas = $request->input('oaData');
        /** 組要發送oa的資料 */
        $oaDatas = $this->getOaData($oaDatas);
        $msg = "";
        /** 開始發送 */
        foreach($oaDatas as $oaData){
            $addResult = $this->addOa($oaData);
            $msg .=$addResult;
        }

        return view('addOaPage', ['msg' => $msg]);

    }

    /* 開始發送 */
    function addOa($oaData){
        $pid     = $oaData->pid;
        $title   = $oaData->title;
        $time    = $oaData->time;
        $content = $oaData->content;

        $data = (object)[
            'confirm'   => 'ivan|kelly|',
            'pid'       => $pid ,
            'name'      => $title,
            'work_hour' => $time,
            'content'   => $this->getContent($content),
            'emp_no'    => env('ACCOUNT'),
            'password'  => env('PASSWORD'),
        ];

        logger((array)$data);
        $text = $this->send($data);
        logger($text);
        $message = $text;

        return $message."<br>";
    }

    function send($data)
    {

        $uri = env('API_DOMAIN',false);
        if($uri === false){
            dd('智障,env API_DOMAIN 没设');
        }

        /** @var Client $client */
        $client   = App::make(Client::class);
        $response = $client->request('POST', $uri, [
            'form_params' => [
                'confirm'   => $data->confirm,
                'pid'       => $data->pid,
                'name'      => $data->name,
                'work_hour' => $data->work_hour,
                'content'   => $data->content,
                'emp_no'    => $data->emp_no,
                'password'  => $data->password,
            ],
        ]);


        $body = $response->getBody()->getContents();
        return json_encode(json_decode($body,JSON_UNESCAPED_UNICODE),JSON_UNESCAPED_UNICODE);

    }

}
