<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cuti>
 */
class CutiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        //  'id_pengguna',
        // 'jenis_cuti',
        // 'tanggal_pengajuan',
        // 'tanggal_mulai',
        // 'tanggal_selesai',
        // 'alasan',
        // 'status',
        // 'file',

        'id_pengguna' => $this->faker->numberBetween(1, 10),
        'name' => $this->faker->name,
        'id_penyetujui'=> $this->faker->numberBetween(1, 10),
        'jenis_cuti' => $this->faker->word,
        'tanggal_pengajuan' => $this->faker->date,
        'tanggal_mulai' => $this->faker->date,
        'tanggal_selesai' => $this->faker->date,
        'alasan' => $this->faker->sentence,
        'status' => $this->faker->word,
        'file' =>  $this->faker->fileExtension(),
        


        ];
    }
}
