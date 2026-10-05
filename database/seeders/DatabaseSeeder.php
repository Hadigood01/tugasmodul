<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(

            [
                'username' => 'admin'
            ],

            [

                'name' =>
                    'Administrator TITL',

                'email' =>
                    'admin@titl.test',

                'password' =>
                    Hash::make('password'),

                'role' =>
                    'admin',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | PENGGUNA
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(

            [
                'username' => 'siswa'
            ],

            [

                'name' =>
                    'Siswa TITL',

                'email' =>
                    'siswa@titl.test',

                'password' =>
                    Hash::make('password'),

                'role' =>
                    'pengguna',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | BARANG CONTOH
        |--------------------------------------------------------------------------
        */

        $barang = [

            [
                'kode_barang' =>
                    'TITL-001',

                'nama_barang' =>
                    'Multimeter Digital',

                'kategori' =>
                    'Alat Ukur',

                'stok' =>
                    10,

                'satuan' =>
                    'unit',

                'kondisi' =>
                    'baik',

                'keterangan' =>
                    'Multimeter untuk praktik TITL',
            ],


            [
                'kode_barang' =>
                    'TITL-002',

                'nama_barang' =>
                    'Tang Ampere',

                'kategori' =>
                    'Alat Ukur',

                'stok' =>
                    5,

                'satuan' =>
                    'unit',

                'kondisi' =>
                    'baik',

                'keterangan' =>
                    'Tang ampere praktik listrik',
            ],


            [
                'kode_barang' =>
                    'TITL-003',

                'nama_barang' =>
                    'Solder',

                'kategori' =>
                    'Peralatan',

                'stok' =>
                    10,

                'satuan' =>
                    'unit',

                'kondisi' =>
                    'baik',

                'keterangan' =>
                    'Solder untuk praktik elektronika',
            ],


            [
                'kode_barang' =>
                    'TITL-004',

                'nama_barang' =>
                    'Kabel NYM',

                'kategori' =>
                    'Bahan Praktik',

                'stok' =>
                    50,

                'satuan' =>
                    'meter',

                'kondisi' =>
                    'baik',

                'keterangan' =>
                    'Kabel untuk praktik instalasi',
            ],

        ];


        foreach (
            $barang
            as $data
        ) {

            Barang::updateOrCreate(

                [
                    'kode_barang' =>
                        $data['kode_barang']
                ],

                $data
            );

        }
    }
}