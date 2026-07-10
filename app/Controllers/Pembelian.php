<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class Pembelian extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->transactionModel       = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        $transactions = $this->transactionModel->orderBy('created_at', 'DESC')->findAll();
        $transactionIds = array_column($transactions, 'id');
        $products = $this->transactionDetailModel->getProductsByTransactionIds($transactionIds);

        $data = [
            'transactions' => $transactions,
            'products'     => $products,
        ];

        return view('pembelian/index', $data);
    }

    public function updateStatus($id)
    {
        $currentStatus = $this->transactionModel->find($id)['status'] ?? 0;
        $newStatus = ($currentStatus == 0) ? 1 : 0;

        $this->transactionModel->update($id, ['status' => $newStatus]);

        return redirect()->to('pembelian')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
