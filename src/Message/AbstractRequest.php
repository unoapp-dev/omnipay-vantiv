<?php

namespace  Omnipay\Vantiv\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $host = 'https://w1.mercurypay.com/PaymentsAPI/Credit';
    protected $testHost = 'https://w1.mercurycert.net/PaymentsAPI/Credit';
    protected $endpoint = '';

    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();
    
        return $this->endPoint = $endPoint;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }
    
    public function getSandboxEndPoint()
    {
        return $this->getParameter('sandboxEndPoint');
    }
    
    public function setSandboxEndPoint($value)
    {
        return $this->setParameter('sandboxEndPoint', $value);
    }
    
    public function getProductionEndPoint()
    {
        return $this->getParameter('productionEndPoint');
    }
    
    public function setProductionEndPoint($value)
    {
        return $this->setParameter('productionEndPoint', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function getPaymentProfile()
    {
        return $this->getParameter('payment_profile');
    }

    public function setPaymentProfile($value)
    {
        return $this->setParameter('payment_profile', $value);
    }

    public function getOrderNumber()
    {
        return $this->getParameter('order_number');
    }

    public function setOrderNumber($value)
    {
        return $this->setParameter('order_number', $value);
    }
    
    public function getRefNo()
    {
        return $this->getParameter('ref_no');
    }
    
    public function setRefNo($value)
    {
        return $this->setParameter('ref_no', $value);
    }
    
    public function getMemo()
    {
        return $this->getParameter('memo');
    }
    
    public function setMemo($value)
    {
        return $this->setParameter('memo', $value);
    }
    
    public function getTerminalName()
    {
        return $this->getParameter('terminal_name');
    }
    
    public function setTerminalName($value)
    {
        return $this->setParameter('terminal_name', $value);
    }
    
    public function getShiftId()
    {
        return $this->getParameter('shift_id');
    }
    
    public function setShiftId($value)
    {
        return $this->setParameter('shift_id', $value);
    }
    
    public function getOperatorId()
    {
        return $this->getParameter('operator_id');
    }
    
    public function setOperatorId($value)
    {
        return $this->setParameter('operator_id', $value);
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => base64_encode($this->getUsername() . ':' . $this->getPassword())
        ];

        if (!empty($data)) {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $data);
        }
        else {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers);
        }
    
        try {
            $jsonRes = json_decode($httpResponse->getBody()->getContents(), true);
        }
        catch (\Exception $e){
            info('Guzzle response : ', [$httpResponse]);
            $res = [];
            $res['resptext'] = 'Oops! something went wrong, Try again after sometime.';
            return $this->response = new Response($this, $res);
        }

        return $this->response = new Response($this, $jsonRes);
    }
}

