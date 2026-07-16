<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Athlete;
use App\Models\Result;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin (Coach)
        User::create([
            'name' => 'Pelatih BULAVA',
            'username' => 'admin',
            'email' => 'admin@bulava.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Seed Athletes with Biodata and Match Results
        $athletesData = [
            [
                'account' => [
                    'name' => 'Faqih Pratama',
                    'username' => 'faqih',
                    'email' => 'faqih@bulava.com',
                    'password' => Hash::make('password'),
                    'role' => 'atlet',
                ],
                'biodata' => [
                    'nomor_id' => 'ARC-0001',
                    'nama_lengkap' => 'Faqih Pratama',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2008-05-12',
                    'alamat' => 'Jl. Kenanga No. 12, Jakarta Selatan',
                    'nomor_hp' => '081234567890',
                    'tahun_bergabung' => 2022,
                    'divisi' => 'Recurve',
                    'kategori' => 'U-18',
                ],
                'results' => [
                    [
                        'event_name' => 'Kejuaraan Daerah DKI Jakarta',
                        'lokasi' => 'Lapangan Senayan',
                        'tanggal' => '2026-02-10',
                        'score' => 320,
                        'hasil_pertandingan' => 'Juara 1',
                    ],
                    [
                        'event_name' => 'BULAVA Internal Cup',
                        'lokasi' => 'Archery Range BULAVA',
                        'tanggal' => '2026-04-15',
                        'score' => 310,
                        'hasil_pertandingan' => 'Juara 2',
                    ],
                    [
                        'event_name' => 'Piala Kemerdekaan',
                        'lokasi' => 'Stadion Gelora Bung Karno',
                        'tanggal' => '2026-06-20',
                        'score' => 335,
                        'hasil_pertandingan' => 'Juara 1',
                    ],
                ]
            ],
            [
                'account' => [
                    'name' => 'Rian Adi',
                    'username' => 'rian',
                    'email' => 'rian@bulava.com',
                    'password' => Hash::make('password'),
                    'role' => 'atlet',
                ],
                'biodata' => [
                    'nomor_id' => 'ARC-0002',
                    'nama_lengkap' => 'Rian Adi',
                    'tempat_lahir' => 'Bandung',
                    'tanggal_lahir' => '2011-08-20',
                    'alamat' => 'Jl. Melati No. 5, Bandung',
                    'nomor_hp' => '081298765432',
                    'tahun_bergabung' => 2023,
                    'divisi' => 'Compound',
                    'kategori' => 'U-15',
                ],
                'results' => [
                    [
                        'event_name' => 'Kejuaraan Bandung Open',
                        'lokasi' => 'GOR Pajajaran Bandung',
                        'tanggal' => '2026-03-01',
                        'score' => 340,
                        'hasil_pertandingan' => 'Juara 1',
                    ],
                    [
                        'event_name' => 'BULAVA Internal Cup',
                        'lokasi' => 'Archery Range BULAVA',
                        'tanggal' => '2026-04-15',
                        'score' => 338,
                        'hasil_pertandingan' => 'Juara 1',
                    ],
                    [
                        'event_name' => 'Piala Menpora',
                        'lokasi' => 'Bogor Archery Range',
                        'tanggal' => '2026-05-25',
                        'score' => 345,
                        'hasil_pertandingan' => 'Juara 3',
                    ],
                ]
            ],
            [
                'account' => [
                    'name' => 'Siti Rahma',
                    'username' => 'siti',
                    'email' => 'siti@bulava.com',
                    'password' => Hash::make('password'),
                    'role' => 'atlet',
                ],
                'biodata' => [
                    'nomor_id' => 'ARC-0003',
                    'nama_lengkap' => 'Siti Rahma',
                    'tempat_lahir' => 'Surabaya',
                    'tanggal_lahir' => '2006-11-05',
                    'alamat' => 'Jl. Mawar No. 8, Surabaya',
                    'nomor_hp' => '081345678901',
                    'tahun_bergabung' => 2021,
                    'divisi' => 'Standard Bow',
                    'kategori' => 'U-20',
                ],
                'results' => [
                    [
                        'event_name' => 'Kejuaraan Surabaya Mayor',
                        'lokasi' => 'KONI Archery Field',
                        'tanggal' => '2026-01-20',
                        'score' => 290,
                        'hasil_pertandingan' => 'Juara 3',
                    ],
                    [
                        'event_name' => 'BULAVA Internal Cup',
                        'lokasi' => 'Archery Range BULAVA',
                        'tanggal' => '2026-04-15',
                        'score' => 305,
                        'hasil_pertandingan' => 'Juara 3',
                    ],
                    [
                        'event_name' => 'Pekan Olahraga Provinsi',
                        'lokasi' => 'Stadion Gajayana Malang',
                        'tanggal' => '2026-06-10',
                        'score' => 300,
                        'hasil_pertandingan' => 'Tidak Juara',
                    ],
                ]
            ],
            [
                'account' => [
                    'name' => 'Dewi Lestari',
                    'username' => 'dewi',
                    'email' => 'dewi@bulava.com',
                    'password' => Hash::make('password'),
                    'role' => 'atlet',
                ],
                'biodata' => [
                    'nomor_id' => 'ARC-0004',
                    'nama_lengkap' => 'Dewi Lestari',
                    'tempat_lahir' => 'Yogyakarta',
                    'tanggal_lahir' => '2005-02-14',
                    'alamat' => 'Jl. Dahlia No. 4, Sleman Yogyakarta',
                    'nomor_hp' => '081399887766',
                    'tahun_bergabung' => 2020,
                    'divisi' => 'Recurve',
                    'kategori' => 'Senior',
                ],
                'results' => [
                    [
                        'event_name' => 'Jogja Open Archery',
                        'lokasi' => 'Lapangan Panahan Mandala Krida',
                        'tanggal' => '2026-02-28',
                        'score' => 315,
                        'hasil_pertandingan' => 'Juara 2',
                    ],
                    [
                        'event_name' => 'BULAVA Internal Cup',
                        'lokasi' => 'Archery Range BULAVA',
                        'tanggal' => '2026-04-15',
                        'score' => 325,
                        'hasil_pertandingan' => 'Juara 1',
                    ],
                    [
                        'event_name' => 'Kejuaraan Nasional',
                        'lokasi' => 'Senayan Jakarta',
                        'tanggal' => '2026-07-02',
                        'score' => 330,
                        'hasil_pertandingan' => 'Juara 2',
                    ],
                ]
            ],
            [
                'account' => [
                    'name' => 'Budi Hartono',
                    'username' => 'budi',
                    'email' => 'budi@bulava.com',
                    'password' => Hash::make('password'),
                    'role' => 'atlet',
                ],
                'biodata' => [
                    'nomor_id' => 'ARC-0005',
                    'nama_lengkap' => 'Budi Hartono',
                    'tempat_lahir' => 'Semarang',
                    'tanggal_lahir' => '2015-09-30',
                    'alamat' => 'Jl. Flamboyan No. 15, Semarang',
                    'nomor_hp' => '081244556677',
                    'tahun_bergabung' => 2024,
                    'divisi' => 'Standard Bow',
                    'kategori' => 'U-10',
                ],
                'results' => [
                    [
                        'event_name' => 'Kidz Archery Competition',
                        'lokasi' => 'Solo Sports Center',
                        'tanggal' => '2026-03-12',
                        'score' => 260,
                        'hasil_pertandingan' => 'Tidak Juara',
                    ],
                    [
                        'event_name' => 'BULAVA Internal Cup',
                        'lokasi' => 'Archery Range BULAVA',
                        'tanggal' => '2026-04-15',
                        'score' => 280,
                        'hasil_pertandingan' => 'Juara 2',
                    ],
                ]
            ],
        ];

        foreach ($athletesData as $data) {
            $user = User::create($data['account']);
            
            // Set user_id in biodata
            $biodata = $data['biodata'];
            $biodata['user_id'] = $user->id;
            $athlete = Athlete::create($biodata);

            // Set athlete_id in results
            foreach ($data['results'] as $res) {
                $res['athlete_id'] = $athlete->id;
                Result::create($res);
            }
        }
    }
}
