<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        $nominals = [50000, 100000, 75000, 150000, 200000, 125000, 80000, 60000, 175000, 90000];

        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'tanggal'    => date('Y-m-d', strtotime("+$i day")),
                'nominal'    => $nominals[$i],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('discount')->insertBatch($data);
    }
}
