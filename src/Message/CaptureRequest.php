<?php

namespace Omnipay\Vantiv\Message;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();
        return $endPoint . '/PreAuthCaptureByRecordNo';
    }

    public function getData()
    {
        $this->validate('transactionReference');

        $transactionReference = json_decode($this->getTransactionReference());

        $data = [
            'InvoiceNo' => $transactionReference->InvoiceNo,
            'Name' => 'Capture-'.$transactionReference->InvoiceNo,
            'Purchase' => $transactionReference->Purchase,
            'Authorize' => $transactionReference->Authorize,
            'AuthCode' => $transactionReference->AuthCode,
            'Frequency' => 'Recurring',
            'RecordNo' => $transactionReference->RecordNo,
            'AcqRefData' => $transactionReference->AcqRefData
        ];
        
        if (isset($transactionReference->RefNo)) $data['RefNo'] = $transactionReference->RefNo;
        if (isset($transactionReference->Memo)) $data['Memo'] = $transactionReference->Memo;
        if (isset($transactionReference->TerminalName)) $data['TerminalName'] = $transactionReference->TerminalName;
        if (isset($transactionReference->ShiftID)) $data['ShiftID'] = $transactionReference->ShiftID;
        if (isset($transactionReference->OperatorID)) $data['OperatorID'] = $transactionReference->OperatorID;

        return json_encode($data);
    }
}
