<?php

namespace Omnipay\Vantiv\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();
        return $endPoint . '/ZeroAuth';
    }

    public function getData()
    {
        $data = [];
        $this->getCard()->validate();

        if($this->getCard()) {

            $data = [
                'Frequency' => 'Recurring',
                'RecordNo' => 'RecordNumberRequested',
                'AcctNo' => $this->getCard()->getNumber(),
                'ExpDate' => $this->getCard()->getExpiryDate('my'),
                'Address' => $this->getCard()->getBillingAddress1(),
                'Zip' => $this->getCard()->getBillingPostcode(),
                'CVVData' => $this->getCard()->getCvv()
            ];
    
            if ($orderNo = $this->getOrderNumber()) $data['InvoiceNo'] = $orderNo;
            if ($refNo = $this->getRefNo()) $data['RefNo'] = $refNo;
            if ($memo = $this->getMemo()) $data['Memo'] = $memo;
            if ($terminalName = $this->getMemo()) $data['TerminalName'] = $terminalName;
            if ($shiftId = $this->getShiftId()) $data['ShiftID'] = $shiftId;
            if ($operatorId = $this->getOperatorId()) $data['OperatorID'] = $operatorId;
        }

        return json_encode($data);
    }
}
