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

		if ($publicaciones->isEmpty()) { // Verifica si la tabla está vacía

			// Intenta obtener el archivo JSON
			try {
				$json = Storage::disk('local')->get('json/data.json');
				$publicaciones = json_decode($json, true);

				if (is_null($publicaciones)) {
					throw new \Exception('Error decoding JSON');
				}
			} catch (\Exception $e) {
				// Loguea o maneja el error según sea necesario
				echo "Error: " . $e->getMessage();
				return;
			}

			foreach ($publicaciones as $publicacion) {
				Publicacion::query()->updateOrCreate([
					'userId' => $publicacion['userId'],
					'title' => $publicacion['title'],
					'body' => $publicacion['body'],
				]);
			}
		}

		// Añade la descripción (par/impar) a las publicaciones
		foreach (Publicacion::all() as $publicacion) {
			$description = ($publicacion->id % 2 == 0) ? 'par' : 'impar';

			DB::table('publicaciones')->where('id', $publicacion->id)
				->update(['description' => $description]);
		}
	}
}
