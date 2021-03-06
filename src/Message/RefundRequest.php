<?php

namespace Omnipay\Vantiv\Message;

class RefundRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();
        return $endPoint . '/VoidSaleByRecordNo';
    }

    public function getData()
    {
        $this->validate('amount', 'transactionReference');

        $transactionReference = json_decode($this->getTransactionReference());

        $data = [
            'InvoiceNo' => $transactionReference->InvoiceNo,
            'Name' => 'Refund-'.$transactionReference->InvoiceNo,
            'Purchase' => $this->getAmount(),
            'AuthCode' => $transactionReference->AuthCode,
            'Frequency' => 'Recurring',
            'RecordNo' => $transactionReference->RecordNo,
            'AcqRefData' => $transactionReference->AcqRefData,
            'ProcessData' => $transactionReference->ProcessData
        ];
    
        if (isset($transactionReference->RefNo)) $data['RefNo'] = $transactionReference->RefNo;
        if (isset($transactionReference->Memo)) $data['Memo'] = $transactionReference->Memo;
        if (isset($transactionReference->TerminalName)) $data['TerminalName'] = $transactionReference->TerminalName;
        if (isset($transactionReference->ShiftID)) $data['ShiftID'] = $transactionReference->ShiftID;
        if (isset($transactionReference->OperatorID)) $data['OperatorID'] = $transactionReference->OperatorID;

        return json_encode($data);
    }
}
