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

    function addOa(Request $request){
        $title = $request->input('title');
        $content = $request->input('content');
        $time = $request->input('time');
        $data =(object)[
                'confirm'   => 'ray|irvin|',
                'pid'       => '96421',
                'name'      => $title ,
                'work_hour' => (float)$time,
                'content'   => $content,
                'emp_no'    => env('ACCOUNT'),
                'password'  => env('PASSWORD'),
            ];

        $text = $this->send($data);
        logger($text);
        $message = $text;
        return view('addOaPage',['msg'=> $message ]);
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

//    function content($contents)
//    {
//        $content = '';
//        foreach ($contents as $vel) {
//            $content .= '<p>&nbsp;&nbsp;'.$vel.'</p>';
//        }
//        $data = "<p><strong>開發任務</strong></p>
//                    <p>-------------------------------------------------------------------------------------------------</p>
//                    <p>1. 需求者 ray</p>
//                    <p>2. 詳細內容</p>
//                    {$content}
//                    <p>3. 解決方法</p>
//                    <p>4. 測試注意事項</p>
//                    <p>&nbsp;</p>
//                    ";
//
//        return $data;
//    }
}
