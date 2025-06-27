<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioAdministrador;

class AdministradoresController extends Controller
{
    // Mostrar todos los administradores
    public function index()
    {
        $administradores = UsuarioAdministrador::all();
        return view('Administradores.Administradores', compact('administradores'));
    }

    // Mostrar formulario para crear nuevo administrador
    public function create()
    {
        return view('Administradores.CrearUsuario');
    }

    // Guardar nuevo administrador
    public function store(Request $request)
    {
        $request->validate([
            'correo_electronico_administrador' => 'required|email|unique:usuario_administrador,correo_electronico_administrador',
            'contraseña_administrador' => 'required|min:6|same:confirmar',
            'confirmar' => 'required|min:6',
            'nombre_usuario_administrador' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'numero_documentos_usuario' => ['required', 'digits_between:1,10'],
        ]);


        UsuarioAdministrador::create([
            'nombre_usuario_administrador' => $request->nombre_usuario_administrador,
            'numero_documentos_usuario' => $request->numero_documentos_usuario,
            'correo_electronico_administrador' => $request->correo_electronico_administrador,
            'contraseña_administrador' => bcrypt($request->contraseña_administrador),
            'rol_del_administrador' => 'admin', // valor fijo
        ]);

        return redirect()->route('Administradores')->with('success', '✅ Administrador ' . $request->nombre_usuario_administrador . ' creado correctamente.');

    }

    // Mostrar formulario para editar un administrador existente
    public function edit($correo)
    {
        $admin = UsuarioAdministrador::where('correo_electronico_administrador', $correo)->firstOrFail();
        return view('Administradores.ModificarUsuario', compact('admin'));
    }

    // Actualizar administrador existente
    public function update(Request $request, $correo)
    {
        $admin = UsuarioAdministrador::where('correo_electronico_administrador', $correo)->firstOrFail();

        $request->validate([
            'correo_electronico_administrador' => 'nullable|email|unique:usuario_administrador,correo_electronico_administrador,' . $admin->correo_electronico_administrador . ',correo_electronico_administrador',
            'nombre_usuario_administrador' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'numero_documentos_usuario' => ['nullable', 'digits_between:1,10'],
            'contraseña_administrador' => 'nullable|min:6|same:confirmar',
            'confirmar' => 'nullable|min:6',
        ]);


        // Verificar si hubo cambios
        $modificado = false;

        if ($request->filled('nombre_usuario_administrador') && $request->nombre_usuario_administrador !== $admin->nombre_usuario_administrador) {
            $admin->nombre_usuario_administrador = $request->nombre_usuario_administrador;
            $modificado = true;
        }

        if ($request->filled('numero_documentos_usuario') && $request->numero_documentos_usuario != $admin->numero_documentos_usuario) {
            $admin->numero_documentos_usuario = $request->numero_documentos_usuario;
            $modificado = true;
        }

        if ($request->filled('correo_electronico_administrador') && $request->correo_electronico_administrador !== $admin->correo_electronico_administrador) {
            $admin->correo_electronico_administrador = $request->correo_electronico_administrador;
            $modificado = true;
        }

        if ($request->filled('contraseña_administrador')) {
            $admin->contraseña_administrador = bcrypt($request->contraseña_administrador);
            $modificado = true;
        }

        if (!$modificado) {
            return redirect()->route('Administradores')->with('info', '❌ No se modificó ningún campo.');
        }

        $admin->save();

        return redirect()->route('Administradores')->with('success', '✅ Administrador ' . $admin->nombre_usuario_administrador . ' modificado correctamente.');
    }

    // Eliminar administrador existente (solo para rol líder)
    public function destroy($correo)
    {
        $admin = UsuarioAdministrador::where('correo_electronico_administrador', $correo)->firstOrFail();

        // (opcional) Prevenir que un líder se elimine a sí mismo
        if (auth()->user()->correo_electronico_administrador === $correo) {
            return redirect()->route('Administradores')->with('error', '❌ No puedes eliminar tu propia cuenta.');
        }

        $admin->delete();

        return redirect()->route('Administradores')->with('success', '✅ Administrador  ' .$admin->nombre_usuario_administrador . ' eliminado correctamente.');
    }

}
