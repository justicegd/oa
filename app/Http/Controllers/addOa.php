<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

class addOa extends Controller
{
    function addOaPage()
    {
        $datas = [
            (object)[
                'confirm'   => 'ray|irvin|',
                'pid'       => '96421',
                'name'      => '[GS-web] 0823 新出號機隨機出號功能測試',
                'work_hour' => '2.5',
                'content'   => [
                    "[GS-web] 0823 新出號機隨機出號功能測試",
                    "新出號機隨機出號功能測試完成",
                ],
                'emp_no'    => env('account'),
                'password'  => env('password'),
            ],

        ];

        foreach ($datas as $data) {
            $text = $this->send($data);
            logger($text);
        }

    }

    function send($data)
    {
        $client   = App::make(Client::class);
        $response = $client->request('POST', 'oaoa.tech/index.php?m=&c=AjaxFlowAdd&a=add', [
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

//        $body = $response->getBody();
//
//        return $body;

    }

    function content($contents)
    {
        $content = '';
        foreach ($contents as $vel) {
            $content .= '&nbsp;&nbsp;'.$vel;
        }
        $data = "<p><strong>開發任務</strong></p>
                    <p>-------------------------------------------------------------------------------------------------</p>
                    <p>1. 需求者 ray</p>
                    <p>2. 詳細內容</p>
                    {$content}
                    <p>3. 解決方法</p>
                    <p>4. 測試注意事項</p>
                    <p>&nbsp;</p>
                    ";

        return $data;
    }
}
