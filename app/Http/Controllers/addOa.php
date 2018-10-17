<?php

namespace App\Http\Controllers;

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
                    <p>1. 需求者 ray</p>
                    <p>2. 詳細內容</p>
                    {$contentData}
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
                       $oa= (is_int($oa*1 ))?(string)$oa.'.0':$oa ;
                       $tmpData->time = $oa;
                       break;
                   case 1:
                       $tmpData->title = $oa;
                       $tmpData->content = "---- {$oa}</br>";
                       break;
                   default:
                       $tmpData->content .= "---- {$oa}</br>";
               }
                $i ++;
            }
            $returnData[]=$tmpData;
        }

        return $returnData;

    }

    function doAddOa(Request $request){
        $oaDatas = $request->input('oaData');
        $oaDatas = $this->getOaData($oaDatas);
        $msg = "";
        foreach($oaDatas as $oaData){;
            $addResult = $this->addOa($oaData);
            $msg .=$addResult;
        }

        return view('addOaPage', ['msg' => $msg]);

    }

    function addOa($oaData){
        $title   = $oaData->title;
        $time    = $oaData->time;
        $content = $oaData->content;

        $data = (object)[
            'confirm'   => 'ray|irvin|',
            'pid'       => '96421',
            'name'      => $title,
            'work_hour' => $time,
            'content'   => $content,
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
