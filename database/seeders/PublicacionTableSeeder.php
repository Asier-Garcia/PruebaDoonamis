<?php

namespace Database\Seeders;

use App\Models\Publicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class PublicacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('json/data.json');
		$publicaciones = json_decode($json, true);
		
		foreach($publicaciones as $publicacion){
			Publicacion::query()->updateOrCreate([
				'userId' => $publicacion['userId'],
				'title' => $publicacion['title'],
				'body' => $publicacion['body'],
			]);
		}
    }
}
