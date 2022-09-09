<?php

namespace Database\Seeders;

use App\Models\Publicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class PublicacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$publicaciones = Publicacion::all();
		
		if($publicaciones->isEmpty()){ //check if publicaciones table is empty
			
			// fill publicaciones table from json data file
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
		
		// add odd or even to description row
		foreach($publicaciones as $publicacion){
			$description = ($publicacion->id % 2 == 0) ?  'par' : 'impar';
			
			DB::table('publicaciones')->where('id', $publicacion->id)
			->update(array('description' => $description));
		}
    }
}
