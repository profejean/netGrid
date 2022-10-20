<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(){
        $favorites = Favorite::where('id_usuario',Auth::id())->get();
        return response()->json([
                'status' => true,
                'data' => $favorites,
            ], 200);
    }

    public function store(Request $request){

        try {
            //Validated
            $validateFavorite = Validator::make($request->all(),
            [
                'ref_api' => 'required|max:255',
            ]);

            if($validateFavorite->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error en la validación',
                    'errors' => $validateFavorite->errors()
                ], 401);
            }

           $favorite = new Favorite();
           $favorite->ref_api = $request->ref_api;
           $favorite->id_usuario = Auth::id();
           $favorite->save();

            return response()->json([
                    'status' => true,
                    'message' => "Favorito creado con éxito!",
                    'data' => $favorite,
                ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function edit($id){
        $favorite = Favorite::where('id',$id)->first();
        return response()->json([
                'status' => true,
                'data' => $favorite,
            ], 200);
    }

    public function update(Request $request,$id){

        try {
            //Validated
            $validateFavorite = Validator::make($request->all(),
            [
                'ref_api' => 'required|max:255',
            ]);

            if($validateFavorite->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error en la validación',
                    'errors' => $validateFavorite->errors()
                ], 401);
            }

            if(Favorite::where('id',$id)->exists()){

                $Favorite = Favorite::where('id',$id)->first();
                $Favorite->fill($request->all())->save();
                return response()->json([
                        'status' => true,
                        'message' => "Favorite editado con éxito!",
                        'data' => $Favorite,
                    ], 200);

            }else{

                return response()->json([
                        'status' => false,
                        'message' => "Favorite no encontrado",
                        'data' => null,
                    ], 404);

            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delete($id){

        if(Favorite::where('id',$id)->exists()){
            $Favorite = Favorite::where('id',$id)->first();
            $Favorite->delete();

            return response()->json([
                    'status' => true,
                    'message' => 'El Favorito ha sido borrado con éxito',
                ], 200);

        }else{

            return response()->json([
                    'status' => false,
                    'message' => "Favorito no encontrado"
                ], 404);

        }
    }
}
