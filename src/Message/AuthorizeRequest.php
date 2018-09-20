<?php

namespace Omnipay\Vantiv\Message;

class AuthorizeRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();
        return $endPoint . '/PreAuthByRecordNo';
    }

    public function getData()
    {
        $this->validate('amount');

        $data = [
            'InvoiceNo' => $this->getOrderNumber(),
            'Name' => 'Authorize-'.$this->getOrderNumber(),
            'Purchase' => $this->getAmount(),
            'Authorize' => $this->getAmount()
        ];
    
        if ($refNo = $this->getRefNo()) $data['RefNo'] = $refNo;
        if ($memo = $this->getMemo()) $data['Memo'] = $memo;
        if ($terminalName = $this->getMemo()) $data['TerminalName'] = $terminalName;
        if ($shiftId = $this->getShiftId()) $data['ShiftID'] = $shiftId;
        if ($operatorId = $this->getOperatorId()) $data['OperatorID'] = $operatorId;

        $paymentMethod = $this->getPaymentMethod();

        switch ($paymentMethod)
        {
            case 'card' :
                break;

            case 'payment_profile' :
                if ($this->getCardReference()) {
                    $data['Frequency'] = 'Recurring';
                    $data['RecordNo'] = $this->getCardReference();
                }
                break;

            case 'token' :
                break;

            default :
                break;
        }

        return json_encode($data);
    }
}

