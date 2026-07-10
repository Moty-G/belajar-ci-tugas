<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Pembelian</th>
                <th>Pembeli</th>
                <th>Waktu Pembelian</th>
                <th>Total Bayar</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $index => $item) : ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $item['id'] ?></td>
                <td><?= esc($item['username']) ?></td>
                <td><?= $item['created_at'] ?></td>
                <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                <td><?= esc($item['alamat']) ?></td>
                <td>
                    <?= ($item['status'] == 1)
                        ? '<span class="badge bg-success">Sudah Selesai</span>'
                        : '<span class="badge bg-warning text-dark">Belum Selesai</span>' ?>
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#detailModal-<?= $item['id'] ?>">
                        Detail
                    </button>
                    <?= form_open('pembelian/status/' . $item['id'], ['style' => 'display:inline']) ?>
                    <button type="submit" class="btn btn-sm <?= $item['status'] == 0 ? 'btn-success' : 'btn-warning' ?>">
                        <?= $item['status'] == 0 ? 'Selesaikan' : 'Batalkan' ?>
                    </button>
                    <?= form_close() ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Detail Modals -->
<?php foreach ($transactions as $item) : ?>
<div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi #<?= $item['id'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Pembeli:</strong> <?= esc($item['username']) ?></p>
                <p><strong>Alamat:</strong> <?= esc($item['alamat']) ?></p>
                <hr>
                <?php if (!empty($products[$item['id']])) : ?>
                    <?php foreach ($products[$item['id']] as $i2 => $detail) : ?>
                        <div class="d-flex align-items-center mb-2">
                            <?php if (!empty($detail['foto']) && file_exists(FCPATH . 'img/' . $detail['foto'])) : ?>
                                <img src="<?= base_url('img/' . $detail['foto']) ?>" width="60" class="img-thumbnail me-2">
                            <?php endif; ?>
                            <div>
                                <strong><?= esc($detail['nama']) ?></strong><br>
                                Harga: <?= number_to_currency($detail['harga'], 'IDR') ?><br>
                                Diskon: <?= number_to_currency($detail['diskon'], 'IDR') ?><br>
                                Jumlah: <?= $detail['jumlah'] ?> pcs<br>
                                Subtotal: <?= number_to_currency($detail['subtotal_harga'], 'IDR') ?>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p><strong>Ongkir:</strong> <?= number_to_currency($item['ongkir'], 'IDR') ?></p>
                <p><strong>Total Bayar:</strong> <?= number_to_currency($item['total_harga'], 'IDR') ?></p>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?= $this->endSection() ?>
