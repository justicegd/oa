<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class createApiWiki extends Controller
{
    function createWikiData(){
        $viewData = $this->getViewData();
        return view("createWikiData",$viewData);
    }

    private function getViewData()
    {
        $name       = "软删除合约备注";
        $method     = "DELETE";
        $url        = "ajax/contract/memo/delete";
        $inDatas    = $this->getInData();
        $returnJson = $this->getReturnData();

        $returnData = [
            "name"       => $name,
            "method"     => $method,
            "url"        => $url,
            "inDatas"    => $inDatas,
            "returnJson" => $returnJson,
        ];

        return $returnData;




    }


    private function getInData()
    {
        $inData = (object)[
            (object)[
                "cloumn"      => "contractId",
                "name"        => "合约ID",
                "discription" => "",
                "necessary"   => "Y",
            ],
        ];
        return $inData ;
    }

    private function getReturnData()
    {
        $data = [
        ];

        $returnData = [
            "result"  => 0,
            "message" => "成功",
            "data"    => $data,
        ];
        return json_encode($returnData);
    }



}
