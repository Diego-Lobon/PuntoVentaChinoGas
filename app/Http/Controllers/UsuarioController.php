<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class UsuarioController extends Controller
{   

    public function index(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        $usuarios = DB::select("CALL sp_users_listar_user()");
        $usuarios = json_decode(json_encode($usuarios), true);
 
        return view('sistema.usuarios.usuario', ['usuarios' => $usuarios]);
    
    }

    public function create(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        return view('sistema.usuarios.crearUsuarios');
    }

    public function store(Request $request){

        $username = $request->username;
        $nombreUsuario = $request->nombreUsuario;
        $password = bcrypt($request->password);
        $rol = $request->rol;

        DB::statement('CALL sp_usuarios_crear_usuario(?, ?, ?, ?)', [
            $username, 
            $nombreUsuario, 
            $password,
            $rol
        ]);

        return redirect()->route('sistema.usuarios.index');

    }

    public function validarCrearNombreUsuario(Request $request){

        $inputValue = $request->input('inputValue');

        $resultado = DB::select('CALL sp_users_validacion_crear_user(?, @encontrado)', [$inputValue]);
        $encontrado = DB::select('SELECT @encontrado')[0]->{'@encontrado'};
        
        // Verificar el valor de $encontrado para depurar el código
        
        return $encontrado;

    }

    public function validarEditNombreUsuario(Request $request){

        $inputValue = $request->input('inputValue');
        $idUsuario = $request->input('idUsuario');
        $password = $request->input('password');
        
        $resultado = DB::select('CALL sp_users_buscar_nombre_user_por_id(?)', [$idUsuario]);
        $nombreUsuario = $resultado[0]->username;

        $resultadoPassword = DB::select('CALL sp_users_buscar_password_user_por_id(?)', [$idUsuario]);
        $passwordUsuario = $resultadoPassword[0]->password;

        $resultado = DB::select('CALL sp_users_validacion_buscar_user(?, ?, @encontrado)', [$inputValue, $nombreUsuario]);
        $encontrado = DB::select('SELECT @encontrado')[0]->{'@encontrado'};
        
        if (Hash::check($password, $passwordUsuario)) {
            $resultadoPassword = true;
        }
        else
        {
            $resultadoPassword = false;
        }

        // Verificar el valor de $encontrado para depurar el código
        
        return response()->json(['data' => $encontrado, 'resultadoPassword' => $resultadoPassword]) ;

    }



    public function edit($id){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }
        
        $usuario = DB::select('CALL sp_users_buscar_user_por_id(?)', [$id]);
        $usuario = json_decode(json_encode($usuario), true);

        return view('sistema.usuarios.editarUsuarios', ['usuario' => $usuario]);

    }

    public function update(Request $request, $id){
        
        $password = bcrypt($request->password_new);

        DB::statement('CALL sp_users_actualizar_user(?, ?, ?, ?, ?)', [
            $id, 
            $request->username, 
            $request->nombreUsuario,
            $password,
            $request->rol
        ]);
    
        return redirect()->route('sistema.usuarios.index');
    }

    public function destroy($id){

        DB::statement('CALL sp_users_eliminar_user(?)', [$id]);

        return redirect()->route('sistema.usuarios.index')->with('eliminar', 'ok')->with('dato', 'El usuario se eliminó con éxito');

    }

    
    
}
