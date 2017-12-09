<?php

namespace app\api\controller;


use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use think\Controller;

class Common extends Controller {
    public $header = [];

    public function _initialize() {
        $this->checkRequestAuth();
    }

    /*检查每次app请求是否合法*/
    public function checkRequestAuth() {
        $header = request()->header();
        if (empty($header['sign'])) {
            throw new ApiException('sign不存在', 400);
        }
        if (!in_array($header['apptype'], config('app.apptypes'))) {
            throw new ApiException('app_type类型不合法', 400);
        }
        if (!IAuth::checkSignPass($header)) {
            throw new ApiException('授权码sign失败', 401);
        }
        $this->header = $header;
    }

    public function testss() {
        $data = [
            'did'  => 213,
            'name' => 'yangze'
        ];
        echo IAuth::setSign($data);


        echo((new Aes())->decrypt(IAuth::setSign($data)));
    }
}