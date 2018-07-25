<?php

namespace ginkgo\tqt;

use yii\base\InvalidConfigException;

class Client extends \yii\httpclient\Client
{
    /**
     * @var string appid.
     */
    public $appid;
    /**
     * @var string secret.
     */
    public $secret;
    /**
     * @var array request object configuration.
     */
    public $requestConfig = [
        'options' => [
            'ENCODING' => ''
        ]
    ];

    public function init()
    {
        if (empty($this->appid)) {
            throw new InvalidConfigException('Client::appid cannot be empty.');
        }
        if (empty($this->secret)) {
            throw new InvalidConfigException('Client::secret cannot be empty.');
        }

        $this->setTransport('yii\httpclient\CurlTransport');
        parent::init();
    }

    public function beforeSend($request)
    {
        $data = $request->getData();
        if (isset($data['sign'])) {
            unset($data['sign']);
        }
        $data['api_key'] = $this->appid;
        $data['ts'] = time();

        ksort($data);
        $string = '';
        foreach($data as $key => $val){
            if($string){
                $string .= '&';
            }
            $string .= "$key=$val";
        }
        $string .= $this->secret;

        $data['sign'] = md5($string);

        $request->setData($data);
        parent::beforeSend($request);
    }
}