<?php

namespace Omnipay\Vantiv;

use Omnipay\Common\AbstractGateway;

/**
 * Vantiv Gateway
 * @link https://developer.vantiv.com/docs/DOC-1338
 */

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Vantiv';
    }

    public function getDefaultParameters()
    {
        return [
            'sandboxEndPoint' => '',
            'productionEndPoint' => '',
            'username' => '',
            'password' => ''
        ];
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

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Vantiv\Message\CreateCardRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Vantiv\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Vantiv\Message\RefundRequest', $parameters);
    }
    
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Vantiv\Message\AuthorizeRequest', $parameters);
    }
    
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Vantiv\Message\CaptureRequest', $parameters);
    }
}

