<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_level')->insert([
            ['level_id' => 1, 'level_kode' => 'ADM', 'level_nama' => 'Administrator'],
            ['level_id' => 2, 'level_kode' => 'MNG', 'level_nama' => 'Manager'],
            ['level_id' => 3, 'level_kode' => 'STF', 'level_nama' => 'Staff/Kasir'],
        ]);

        DB::table('m_kategori')->insert([
            ['kategori_id' => 1, 'kategori_kode' => 'MKN', 'kategori_nama' => 'Makanan'],
            ['kategori_id' => 2, 'kategori_kode' => 'MNM', 'kategori_nama' => 'Minuman'],
            ['kategori_id' => 3, 'kategori_kode' => 'ATK', 'kategori_nama' => 'Alat Tulis Kantor'],
            ['kategori_id' => 4, 'kategori_kode' => 'ELK', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 5, 'kategori_kode' => 'PBR', 'kategori_nama' => 'Perabot'],
        ]);

        DB::table('m_supplier')->insert([
            ['supplier_id' => 1, 'supplier_kode' => 'SUP001', 'supplier_nama' => 'PT Sumber Makmur', 'supplier_alamat' => 'Jl. Industri No. 10, Surabaya'],
            ['supplier_id' => 2, 'supplier_kode' => 'SUP002', 'supplier_nama' => 'CV Maju Jaya', 'supplier_alamat' => 'Jl. Raya Malang No. 25, Malang'],
            ['supplier_id' => 3, 'supplier_kode' => 'SUP003', 'supplier_nama' => 'UD Sejahtera', 'supplier_alamat' => 'Jl. Pahlawan No. 5, Sidoarjo'],
        ]);

        DB::table('m_user')->insert([
            ['user_id' => 1, 'level_id' => 1, 'username' => 'admin', 'nama' => 'Administrator', 'password' => Hash::make('admin123')],
            ['user_id' => 2, 'level_id' => 2, 'username' => 'manager', 'nama' => 'Manager Toko', 'password' => Hash::make('manager123')],
            ['user_id' => 3, 'level_id' => 3, 'username' => 'kasir1', 'nama' => 'Kasir Satu', 'password' => Hash::make('kasir123')],
            ['user_id' => 4, 'level_id' => 3, 'username' => 'kasir2', 'nama' => 'Kasir Dua', 'password' => Hash::make('kasir123')],
        ]);

        DB::table('m_barang')->insert([
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Mie Instan Goreng', 'harga_beli' => 2500, 'harga_jual' => 3500],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Roti Tawar', 'harga_beli' => 12000, 'harga_jual' => 15000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'BRG003', 'barang_nama' => 'Air Mineral 600ml', 'harga_beli' => 2000, 'harga_jual' => 3000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'BRG004', 'barang_nama' => 'Teh Botol 500ml', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'BRG005', 'barang_nama' => 'Pulpen Pilot', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Buku Tulis A5', 'harga_beli' => 4000, 'harga_jual' => 6000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'BRG007', 'barang_nama' => 'Kabel USB Type-C', 'harga_beli' => 15000, 'harga_jual' => 25000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'BRG008', 'barang_nama' => 'Mouse Wireless', 'harga_beli' => 50000, 'harga_jual' => 75000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'BRG009', 'barang_nama' => 'Gantungan Baju', 'harga_beli' => 5000, 'harga_jual' => 8000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'BRG010', 'barang_nama' => 'Rak Mini Plastik', 'harga_beli' => 20000, 'harga_jual' => 35000],
        ]);

        DB::table('t_stok')->insert([
            ['stok_id' => 1, 'supplier_id' => 1, 'barang_id' => 1, 'user_id' => 1, 'stok_tanggal' => '2026-04-01 08:00:00', 'stok_jumlah' => 100],
            ['stok_id' => 2, 'supplier_id' => 1, 'barang_id' => 2, 'user_id' => 1, 'stok_tanggal' => '2026-04-01 08:15:00', 'stok_jumlah' => 50],
            ['stok_id' => 3, 'supplier_id' => 2, 'barang_id' => 3, 'user_id' => 1, 'stok_tanggal' => '2026-04-02 09:00:00', 'stok_jumlah' => 200],
            ['stok_id' => 4, 'supplier_id' => 2, 'barang_id' => 4, 'user_id' => 1, 'stok_tanggal' => '2026-04-02 09:30:00', 'stok_jumlah' => 150],
            ['stok_id' => 5, 'supplier_id' => 3, 'barang_id' => 5, 'user_id' => 2, 'stok_tanggal' => '2026-04-03 10:00:00', 'stok_jumlah' => 80],
            ['stok_id' => 6, 'supplier_id' => 3, 'barang_id' => 6, 'user_id' => 2, 'stok_tanggal' => '2026-04-03 10:30:00', 'stok_jumlah' => 60],
            ['stok_id' => 7, 'supplier_id' => 1, 'barang_id' => 7, 'user_id' => 1, 'stok_tanggal' => '2026-04-04 11:00:00', 'stok_jumlah' => 30],
            ['stok_id' => 8, 'supplier_id' => 1, 'barang_id' => 8, 'user_id' => 1, 'stok_tanggal' => '2026-04-04 11:30:00', 'stok_jumlah' => 20],
            ['stok_id' => 9, 'supplier_id' => 2, 'barang_id' => 9, 'user_id' => 2, 'stok_tanggal' => '2026-04-05 08:00:00', 'stok_jumlah' => 40],
            ['stok_id' => 10, 'supplier_id' => 3, 'barang_id' => 10, 'user_id' => 2, 'stok_tanggal' => '2026-04-05 08:30:00', 'stok_jumlah' => 25],
        ]);

        DB::table('t_penjualan')->insert([
            ['penjualan_id' => 1, 'user_id' => 3, 'pembeli' => 'Budi Santoso', 'penjualan_kode' => 'PJ-20260410-001', 'penjualan_tanggal' => '2026-04-10 10:00:00'],
            ['penjualan_id' => 2, 'user_id' => 3, 'pembeli' => 'Siti Aminah', 'penjualan_kode' => 'PJ-20260410-002', 'penjualan_tanggal' => '2026-04-10 11:30:00'],
            ['penjualan_id' => 3, 'user_id' => 4, 'pembeli' => 'Agus Wijaya', 'penjualan_kode' => 'PJ-20260411-001', 'penjualan_tanggal' => '2026-04-11 09:15:00'],
            ['penjualan_id' => 4, 'user_id' => 4, 'pembeli' => 'Dewi Lestari', 'penjualan_kode' => 'PJ-20260411-002', 'penjualan_tanggal' => '2026-04-11 14:00:00'],
            ['penjualan_id' => 5, 'user_id' => 3, 'pembeli' => 'Rudi Hartono', 'penjualan_kode' => 'PJ-20260412-001', 'penjualan_tanggal' => '2026-04-12 16:45:00'],
        ]);

        DB::table('t_penjualan_detail')->insert([
            ['detail_id' => 1, 'penjualan_id' => 1, 'barang_id' => 1, 'harga' => 3500, 'jumlah' => 5],
            ['detail_id' => 2, 'penjualan_id' => 1, 'barang_id' => 3, 'harga' => 3000, 'jumlah' => 3],
            ['detail_id' => 3, 'penjualan_id' => 2, 'barang_id' => 5, 'harga' => 5000, 'jumlah' => 10],
            ['detail_id' => 4, 'penjualan_id' => 2, 'barang_id' => 6, 'harga' => 6000, 'jumlah' => 5],
            ['detail_id' => 5, 'penjualan_id' => 3, 'barang_id' => 8, 'harga' => 75000, 'jumlah' => 1],
            ['detail_id' => 6, 'penjualan_id' => 3, 'barang_id' => 7, 'harga' => 25000, 'jumlah' => 2],
            ['detail_id' => 7, 'penjualan_id' => 4, 'barang_id' => 2, 'harga' => 15000, 'jumlah' => 2],
            ['detail_id' => 8, 'penjualan_id' => 4, 'barang_id' => 4, 'harga' => 5000, 'jumlah' => 4],
            ['detail_id' => 9, 'penjualan_id' => 5, 'barang_id' => 9, 'harga' => 8000, 'jumlah' => 3],
            ['detail_id' => 10, 'penjualan_id' => 5, 'barang_id' => 10, 'harga' => 35000, 'jumlah' => 1],
        ]);
    }
}
