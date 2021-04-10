<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Audífonos inalámbricos con noise cancelling WH-1000XM4',
            'description' => 'Los intuitivos e inteligentes audífonos WH-1000XM4 te ofrecen nuevas mejoras en la tecnología de noise cancelling líder del sector.',
            'photo' => 'https://cosonyb2c.vteximg.com.br/arquivos/ids/341717-370-370/5d02da5df552836db894cead8a68f5f3.jpg',
            'price' => 1199000,
        ]);

        DB::table('products')->insert([
            'name' => 'Audífonos totalmente inalámbricos WF-XB700 con EXTRA BASS',
            'description' => 'Mejora tu día a día con los audífonos totalmente inalámbricos WF-XB700. Además de la tecnología EXTRA BASS.',
            'photo' => 'https://cosonyb2c.vteximg.com.br/arquivos/ids/323544-370-370/883200845f7cd274bb7faeef27407048.jpg',
            'price' => 329879,
        ]);

        DB::table('products')->insert([
            'name' => 'Audífonos deportivos internos inalámbricos | WI-SP600',
            'description' => 'Disfruta de tus canciones favoritas para entrenar sin distracciones. Los audífonos internos inalámbricos WI-SP600N incluyen el modo sonido ambiente',
            'photo' => 'https://cosonyb2c.vteximg.com.br/arquivos/ids/186307-550-550/99ed12f41bb3a89eb835a55c9bc953d9.jpg',
            'price' => 249900,
        ]);
    }
}
