<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notes = [
            [
                'note' => 'Service',
                'description' => 'Pelayanan service Senin-Sabtu, pukul 08.00-17.00 WITA.',
            ],
            [
                'note' => 'Service',
                'description' => 'Barang yang tidak diambil dalam 6 hari kerja, tidak lagi menjadi tanggung jawab kami.',
            ],
            [
                'note' => 'Service',
                'description' => 'Harap menunjukkan nota service ini saat pengambilan barang.'
            ]
        ];

        foreach ($notes as $note) {
            Note::create($note);
        }
    }
}
