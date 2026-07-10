<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\DiscountModel;

class Discount extends ResourceController
{
    protected $model;
    private $token;

    public function __construct()
    {
        $this->model = new DiscountModel();
        $this->token = env('MY_API_KEY');
    }

    private function authenticate(): bool
    {
        $header = $this->request->getHeaderLine('Authorization');

        if (empty($header)) {
            return false;
        }

        if (!preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return false;
        }

        return $matches[1] === $this->token;
    }

    private function unauthorized()
    {
        return $this->respond([
            'status'  => false,
            'message' => 'Unauthorized',
        ], 401);
    }

    /**
     * GET /api/discounts
     * Supports ?page=&per_page= for pagination
     */
    public function index()
    {
        if (!$this->authenticate()) {
            return $this->unauthorized();
        }

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        $discounts = $this->model->orderBy('tanggal', 'DESC')->paginate($perPage, 'default', $page);

        return $this->respond([
            'data' => $discounts,
            'pagination' => [
                'current_page' => $page,
                'per_page'     => $perPage,
                'last_page'    => $this->model->pager->getPageCount(),
                'total_data'   => $this->model->pager->getTotal(),
                'has_next'     => $page < $this->model->pager->getPageCount(),
                'has_prev'     => $page > 1,
            ],
        ]);
    }

    /**
     * GET /api/discounts/{id}
     */
    public function show($id = null)
    {
        if (!$this->authenticate()) {
            return $this->unauthorized();
        }

        $discount = $this->model->find($id);

        if (!$discount) {
            return $this->failNotFound('Diskon tidak ditemukan');
        }

        return $this->respond($discount);
    }

    /**
     * POST /api/discounts
     */
    public function create()
    {
        if (!$this->authenticate()) {
            return $this->unauthorized();
        }

        $data = $this->request->getJSON(true);

        // Validate unique tanggal
        $rules = [
            'tanggal' => 'required|valid_date|is_unique[discount.tanggal]',
            'nominal' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $this->model->skipValidation(true)->insert([
            'tanggal' => $data['tanggal'],
            'nominal' => $data['nominal'],
        ]);

        return $this->respondCreated([
            'message' => 'Diskon berhasil ditambahkan',
        ]);
    }

    /**
     * PUT /api/discounts/{id}
     * Only nominal can be updated — tanggal is immutable.
     */
    public function update($id = null)
    {
        if (!$this->authenticate()) {
            return $this->unauthorized();
        }

        if (!$this->model->find($id)) {
            return $this->failNotFound('Diskon tidak ditemukan');
        }

        $data = $this->request->getJSON(true);

        // Hanya update nominal — tanggal tidak boleh diubah
        $this->model->skipValidation(true)->update($id, [
            'nominal' => $data['nominal'] ?? null,
        ]);

        return $this->respond([
            'message' => 'Diskon berhasil diperbarui',
        ]);
    }

    /**
     * DELETE /api/discounts/{id}
     */
    public function delete($id = null)
    {
        if (!$this->authenticate()) {
            return $this->unauthorized();
        }

        if (!$this->model->find($id)) {
            return $this->failNotFound('Diskon tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Diskon berhasil dihapus',
        ]);
    }
}
