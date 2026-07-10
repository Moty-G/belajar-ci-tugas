<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiscountModel;

class Diskon extends BaseController
{
    protected $discountModel;

    public function __construct()
    {
        helper(['form', 'number']);
        $this->discountModel = new DiscountModel();
    }

    public function index()
    {
        $data = [
            'discounts' => $this->discountModel->orderBy('tanggal', 'DESC')->findAll(),
        ];

        return view('diskon/index', $data);
    }

    public function store()
    {
        $rules = [
            'tanggal' => 'required|valid_date|is_unique[discount.tanggal]',
            'nominal' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('diskon')->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->discountModel->insert([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
        ]);

        return redirect()->to('diskon')->with('success', 'Data diskon berhasil ditambahkan.');
    }

    public function update($id)
    {
        // Only update nominal — tanggal is read-only
        $data = ['nominal' => $this->request->getPost('nominal')];

        $this->discountModel->update($id, $data);

        return redirect()->to('diskon')->with('success', 'Data diskon berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->discountModel->delete($id);

        return redirect()->to('diskon')->with('success', 'Data diskon berhasil dihapus.');
    }
}
