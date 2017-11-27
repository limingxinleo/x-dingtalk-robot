<?php
// +----------------------------------------------------------------------
// | BaseTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test;

use GuzzleHttp\Psr7\Response;
use limx\Support\Collection;
use Tests\TestCase;
use Xin\DingTalk\Application;

class BaseTest extends TestCase
{

    public function testInstance()
    {
        $this->assertEquals($this->ding, Application::getInstance());
    }

    public function testConfig()
    {
        $config = new Collection($this->config);
        $this->assertEquals($config->toArray(), $this->ding->config->toArray());
    }

    public function testHttpClient()
    {
        $client = $this->ding->httpClient;
        $response = $client->post('https://demo.phalcon.lmx0536.cn/test/api/api');
        $result = $response->getBody()->getContents();
        $result = json_decode($result, JSON_UNESCAPED_UNICODE);
        $this->assertEquals(1, $result['status']);
    }

    public function testSend()
    {
        $data = [
            'msgtype' => 'text',
            'text' => [
                "content" => "测试send方法"
            ],
        ];

        $key = 'test';
        /** @var \Psr\Http\Message\ResponseInterface[] $res */
        $res = $this->ding->robot->send($data, [$key]);
        foreach ($res as $item) {
            $result = $item->getBody()->getContents();
            $this->assertEquals(
                [
                    'errcode' => 0,
                    'errmsg' => 'ok'
                ],
                json_decode($result, true)
            );
        }
    }

    public function testSendText()
    {
        /** @var \Psr\Http\Message\ResponseInterface[] $res */
        $res = $this->ding->robot->sendText('测试sendText方法', [], ['test']);

        foreach ($res as $item) {
            $result = $item->getBody()->getContents();
            $this->assertEquals(
                [
                    'errcode' => 0,
                    'errmsg' => 'ok'
                ],
                json_decode($result, true)
            );
        }
    }


}