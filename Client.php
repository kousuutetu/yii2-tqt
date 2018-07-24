<?php

namespace ginkgo\tqt;

use yii\base\InvalidConfigException;

class Client extends \yii\httpclient\Client
{
    /**
     * @var string API key.
     */
    $apikey = '';
    /**
     * @var string API secret.
     */
    $secret = '';
    /**
     * @var Transport|array|string|callable HTTP message transport.
     */
    private $_transport = 'yii\httpclient\CurlTransport';
    /**
     * @var array request object configuration.
     */
    public $requestConfig = [
        'options' => [
            'ENCODING' => 'gzip'
        ]
    ];

    public function init()
    {
        if (empty($this->apikey)) {
            throw new InvalidConfigException('Client::apikey cannot be empty.');
        }
        if (empty($this->secret)) {
            throw new InvalidConfigException('Client::secret cannot be empty.');
        }
    }

    public function beforeSend($request)
    {
        $data = $request->getData();
        if (isset($data['sign'])) {
            unset($data['sign']);
        }
        $data['api_key'] = $this->apikey;
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

        $event->request->setData($data);
        parent::beforeSend($request);
    }
}