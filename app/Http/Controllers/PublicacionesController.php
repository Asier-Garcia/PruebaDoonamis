<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicacionesController extends Controller
{
	public function index()
	{
		$publicaciones = Publicacion::all();
		return response()->json($publicaciones); // Devolver JSON
	}
}
