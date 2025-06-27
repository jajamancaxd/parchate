<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Services\VerificacionService;
use App\Models\UsuarioAdministrador;

class AuthController extends Controller
{
    protected $verificador;

    public function __construct(VerificacionService $verificador)
    {
        $this->verificador = $verificador;
    }

    // Mostrar formularios
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showConfirmacionCorreo()
    {
        return view('auth.confirmacion_correo');
    }

    // Registro inicial con verificación
    public function register(Request $request)
    {
        $request->validate([
            'correo' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $existeNatural = DB::table('usuario_natural')->where('correo_electronico', $value)->exists();
                    $existeNegocio = DB::table('usuario_negocio')->where('correo_electronico_negocios', $value)->exists();
                    $existeAdmin = DB::table('usuario_administrador')->where('correo_electronico_administrador', $value)->exists();

                    if ($existeNatural || $existeNegocio || $existeAdmin) {
                        $fail('Este correo electrónico ya está en uso.');
                    }
                },
            ],
            'password' => ['required', 'min:8'],
            'tipo_persona' => 'required|in:usuario,negocio,administrador',
            'terminos' => 'accepted',
        ], [
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
        ]);

        $codigo = $this->verificador->generarCodigo();

        session([
            'registro_temporal' => [
                'correo' => $request->correo,
                'password' => Hash::make($request->password),
                'tipo' => $request->tipo_persona,
                'codigo' => $codigo,
            ],
            'codigo_verificacion' => $codigo,
        ]);

        $this->verificador->enviarCorreo($request->correo, $codigo);

        return redirect()->route('confirmacion_correo')
            ->with('success', 'Te hemos enviado un código de verificación a tu correo.');
    }

    // Confirmación de código
    public function confirmarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|digits:6',
        ]);

        $codigoIngresado = $request->codigo;
        $codigoGuardado = session('codigo_verificacion');
        $datos = session('registro_temporal');

        if (!$datos || !$codigoGuardado) {
            return redirect()->route('register')->withErrors('No hay registro temporal. Por favor regístrate de nuevo.');
        }

        if ($codigoIngresado != $codigoGuardado) {
            return back()->withErrors(['codigo' => 'Código incorrecto, intenta de nuevo.']);
        }

        switch ($datos['tipo']) {
            case 'administrador':
                DB::table('usuario_administrador')->insert([
                    'correo_electronico_administrador' => $datos['correo'],
                    'contraseña_administrador' => $datos['password'],
                    'codigo_confirmacion_correo_administrador' => $datos['codigo'],
                    'rol_del_administrador' => 'admin',
                    'nombre_usuario_administrador' => 'Administrador',
                    'numero_documentos_usuario' => '0000000000',
                ]);
                break;

            case 'usuario':
                DB::table('usuario_natural')->insert([
                    'correo_electronico' => $datos['correo'],
                    'contraseña' => $datos['password'],
                    'tipo_de_cuenta' => 'usuario',
                    'codigo_de_confirmacion_correo_electronico' => $datos['codigo'],
                ]);
                break;

            case 'negocio':
                session(['codigo_confirmado' => true]);
                return view('registro-negocio');
        }

        session()->forget(['registro_temporal', 'codigo_verificacion']);

        return redirect()->route('login')->with('success', 'Cuenta creada. Ahora puedes iniciar sesión.');
    }

    // Registro de negocio (segunda parte)
    public function guardarNegocio(Request $request)
    {
        $datos = session('registro_temporal');

        if (!$datos || session('codigo_confirmado') !== true || $datos['tipo'] !== 'negocio') {
            return redirect()->route('register')->withErrors('No autorizado.');
        }

            $request->validate([
            'nombre_negocio' => 'required|string|max:255',
         'descripcion_negocio' => 'nullable|string|max:1000',
         'ruta_imagen_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
         'ruta_documentos_negocios' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
]);

        try {
            $logoPath = $request->hasFile('ruta_imagen_logo') 
              ? $request->file('ruta_imagen_logo')->store('logos', 'public') 
                : null;

            $docPath = $request->hasFile('ruta_documentos_negocios') 
                ? $request->file('ruta_documentos_negocios')->store('documentos', 'public') 
                : null;

                 DB::table('usuario_negocio')->insert([
                    'nombre_negocio' => $request->nombre_negocio,
                    'correo_electronico_negocios' => $datos['correo'],
                    'contraseña_negocio' => $datos['password'],
                    'descripcion_negocio' => $request->descripcion_negocio,
                    'ruta_imagen_logo' => $logoPath, // ✅ corregido aquí también
                    'ruta_documentos_negocios' => $docPath,
                    'tipo_de_cuenta' => 'negocio',
                    'codigo_confirmacion_correo_negocio' => $datos['codigo'],
                    'estado_de_cuenta_negocio' => 'en espera',
                ]);


            session()->forget(['registro_temporal', 'codigo_verificacion', 'codigo_confirmado']);

            return redirect()->route('login')->with('success', 'Registro completado. Ahora puedes iniciar sesión.');

        } catch (\Exception $e) {
            Log::error('Error al registrar negocio: ' . $e->getMessage());
            return back()->withInput()->withErrors('Ocurrió un error al guardar los datos.');
        }
    }

    // Login para usuarios, negocios y administradores
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        $correo = $request->correo;
        $password = $request->password;

        // Administrador
        $admin = DB::table('usuario_administrador')
            ->where('correo_electronico_administrador', $correo)
            ->first();

        if ($admin && Hash::check($password, $admin->contraseña_administrador)) {
            session(['admin' => $admin]);
            return redirect()->route('Administradores');
        }

        // Negocio
        $negocio = DB::table('usuario_negocio')
            ->where('correo_electronico_negocios', $correo)
            ->first();

        if ($negocio && Hash::check($password, $negocio->contraseña_negocio)) {
            session(['negocio' => $negocio]);
            return redirect()->route('inicio.negocio');
        }

        // Usuario natural
        $usuario = DB::table('usuario_natural')
            ->where('correo_electronico', $correo)
            ->first();

        if ($usuario && Hash::check($password, $usuario->contraseña)) {
            session(['usuario' => $usuario]);
            return redirect()->route('inicio.usuario');
        }

        return back()->withErrors(['correo' => '❌ Credenciales incorrectas.']);
    }

    // Logout para todos
    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}
