<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Restablecer_contraController;
use App\Http\Controllers\PreferenciasController;
use App\Http\Controllers\UsuarioNaturalController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\CreacionSucursalController;
use App\Http\Controllers\RegistroNegocioControlador;
use App\Http\Controllers\LugaresrecomendadosController;
use App\Http\Controllers\EventosrecomendadosController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\EventoGuardadoController;
use App\Http\Controllers\LugaresGuardadosController;
use App\Http\Controllers\EventoPropioControlador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\UsuarioNegocio;
use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\LugaresController;
use App\Http\Controllers\NegociosController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu_usuario', function () {
    return view('menu_usuario');
})->middleware('auth:usuario_natural');

Route::get('/enblanco', function () {
    return view('enblanco');
})->name('enblanco');

Route::get('/componente', function () {
    return view('componentes_permanentes_negocio');
});

Route::get('/usuarionatural', function () {
    return view('usuario_natural');
});

Route::middleware(['auth:usuario_natural'])->group(function () {
    Route::get('/usuario/perfil', [UsuarioNaturalController::class, 'mostrarPerfil'])->name('usuario_natural.perfil');
    Route::post('/usuario/perfil/logo', [UsuarioNaturalController::class, 'actualizarLogo'])->name('usuario_natural.actualizarLogo');

    Route::get('/preferencias', [PreferenciasController::class, 'mostrarFormulario'])->name('preferencias.formulario');
    Route::post('/preferencias', [PreferenciasController::class, 'guardarPreferencias'])->name('preferencias.guardar');

    Route::get('/vista_usuario', function () {
        return view('vista_usuario');
    })->name('vista_usuario');

    

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/lugares-guardados', [LugaresGuardadosController::class, 'index'])->name('lugares.guardados');
    Route::get('/eventos-guardados', [EventoGuardadoController::class, 'index'])->name('eventos.guardados');

    // CRUD Eventos
    Route::get('/eventos/crear', [EventoController::class, 'create'])->name('eventos.create');
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
    Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');
    Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');

    // CRUD Sucursales
    Route::get('/sucursales', [SucursalController::class, 'index'])->name('sucursales.index');
    Route::get('/sucursales/{sucursal}/editar', [SucursalController::class, 'edit'])->name('sucursales.edit');
    Route::put('/sucursales/{sucursal}', [SucursalController::class, 'update'])->name('sucursales.update');

    // Lugares recomendados
    Route::get('/lugaresrecomendados', [lugaresrecomendadosController::class, 'lugaresRecomendados'])->name('lugares.recomendados');
    Route::post('/buscar', [lugaresrecomendadosController::class, 'buscar'])->name('buscar');
    Route::get('/sucursal/crear', [lugaresrecomendadosController::class, 'create'])->name('sucursal.create');
    Route::post('/sucursal/guardar', [LugaresGuardadosController::class, 'store'])->name('sucursal.store');
    Route::get('/sucursal/{id}', [lugaresrecomendadosController::class, 'show'])->name('sucursal.show');

    // Eventos recomendados
    Route::get('/eventosrecomendados', [EventosrecomendadosController::class, 'index'])->name('eventos.recomendados');
    Route::post('/eventosrecomendados/buscar', [EventosrecomendadosController::class, 'buscar'])->name('evento.buscar');
    Route::get('/Eventosrecomendados/crear', [EventosrecomendadosController::class, 'create'])->name('evento.create');
    Route::post('/eventosrecomendados/guardar', [EventosrecomendadosController::class, 'store'])->name('evento.store');
    Route::get('/eventosrecomendados/{evento}', [EventosrecomendadosController::class, 'show'])->name('evento.show');

    // Confirmar contraseña actual
    Route::get('/validar_contraseña', [UsuarioNaturalController::class, 'mostrarValidarActual'])->name('usuario_natural.validar_actual_form');
    Route::post('/validar_contraseña', [UsuarioNaturalController::class, 'validarActual'])->name('usuario_natural.validar_actual');

    // Formulario nueva contraseña
    Route::get('/nueva_contraseña', [UsuarioNaturalController::class, 'mostrarNuevaContra'])->name('usuario_natural.nueva_contra');
    Route::post('/nueva_contraseña', [UsuarioNaturalController::class, 'guardarNuevaContra'])->name('usuario_natural.guardar_contra');
    
});

// Confirmación de correo
Route::get('/confirmacion_correo', [AuthController::class, 'showConfirmacionCorreo'])->name('confirmacion_correo');
Route::post('/confirmacion_correo', [AuthController::class, 'confirmarCodigo']);

// Registro y login
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Recuperación de contraseña
Route::get('/restablecer_contra', [Restablecer_contraController::class, 'mostrarFormulario'])->name('recuperar.formulario');
Route::post('/recuperar/enviar', [Restablecer_contraController::class, 'enviarCodigo'])->name('recuperar.enviar');
Route::post('/recuperar/validar-codigo', [Restablecer_contraController::class, 'validarCodigo'])->name('recuperar.validar_codigo');
Route::post('/recuperar/actualizar', [Restablecer_contraController::class, 'actualizarContraseña'])->name('recuperar.actualizar');
Route::post('/registro-negocio', [AuthController::class, 'guardarNegocio'])->name('registro.negocio.store');
Route::get('/registro-negocio', function () {
    return view('registro-negocio');
})->name('registro.negocio.create');


Route::get('/confirmar-codigo', function (Request $request) {
    return view('auth.confirmar_codigo_contra', [
        'correo' => $request->correo,
        'tipo' => $request->tipo
    ]);
})->name('confirmar.codigo.contra.vista');

Route::get('/terminosycondiciones', function () {
    return view('terminosycondiciones');
})->name('terminosycondiciones');


Route::middleware('auth:usuario_negocio')->group(function () {

    // ✅ Redirección al iniciar sesión
    Route::get('/', function () {
        return redirect()->route('sucursales.negocio');
    });
    
    Route::get('/sucursales-negocio', [SucursalController::class, 'negocio'])->name('sucursales.negocio');
    Route::get('/sucursales', [SucursalController::class, 'index'])->name('sucursales.index');
    Route::get('/sucursales/create', [CreacionSucursalController::class, 'create'])->name('sucursales.create');
    //RUTA ANTERIOR Route::get('/sucursales/create', [SucursalController::class, 'create'])->name('sucursales.create');
    Route::get('/sucursales/{sucursal}/edit', [CreacionSucursalController::class, 'edit'])->name('sucursales.edit');
    Route::post('/sucursales', [CreacionSucursalController::class, 'store'])->name('sucursales.store');
    // RUTA ANTERIOR Route::post('/sucursales', [SucursalController::class, 'store'])->name('sucursales.store');
    Route::delete('/sucursales/{sucursal}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');
    Route::put('/sucursales/{sucursal}', [CreacionSucursalController::class, 'update'])->name('sucursales.update');
    
    //RUTA EVENO PROPIO
    //Eventos Propios
    
    // Route::get('/evento-propio', [EventoPropioControlador::class, 'index'])->name('evento-propio.index');
    // Route::post('/evento-propio/buscar', [EventoPropioControlador::class, 'buscar'])->name('evento-propio.buscar');
    // Route::get('/evento-propio/crear', [EventoPropioControlador::class, 'create'])->name('eventos.create');
    // Route::post('/evento-propio/guardar', [EventoPropioControlador::class, 'store'])->name('evento-propio.store');
    // Route::get('/evento-propio/{evento}', [EventoPropioControlador::class, 'show'])->name('evento-propio.show');
    // Route::get('/evento-propio/{evento}/editar', [EventoPropioControlador::class, 'edit'])->name('eventos.edit');
    // Route::put('/evento-propio/{evento}', [EventoPropioControlador::class, 'update'])->name('evento-propio.update');
    // Route::delete('/evento-propio/{evento}', [EventoPropioControlador::class, 'destroy'])->name('evento-propio.destroy');

    Route::prefix('eventos')->group(function () {
         Route::get('/', [EventoController::class, 'index'])->name('eventos.index');
        Route::get('/crear', [EventoController::class, 'create'])->name('eventos.create');
        Route::post('/', [EventoController::class, 'store'])->name('eventos.store');
        Route::get('/{evento}/editar', [EventoController::class, 'edit'])->name('eventos.edit');
        Route::put('/{evento}', [EventoController::class, 'update'])->name('eventos.update');
    });

    
    // ✅ Ruta del perfil del negocio
    Route::get('/usuario-negocio', function () {
        $negocio = Auth::guard('usuario_negocio')->user();
        return view('usuario-negocio', compact('negocio'));
    })->name('usuario.negocio');

    // ✅ Ruta para subir logo del negocio
    Route::post('/usuario-negocio/logo', function (Request $request) {
        $negocio = Auth::guard('usuario_negocio')->user();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . $negocio->id_negocio . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/logos/' . $filename;

            $file->move(public_path('uploads/logos'), $filename);

            $negocio->ruta_imagne_logo = $path;
            $negocio->save();

            return redirect()->back()->with('success', 'Logo actualizado.');
        }

        return redirect()->back()->with('error', 'No se seleccionó ningún archivo.');
    })->name('usuario.negocio.logo');
});

Route::middleware(['auth:usuario_administrador'])->group(function () {
    Route::get('/Administradores', [AdministradoresController::class, 'index'])->name('Administradores');
    Route::get('/Administradores/crear', [AdministradoresController::class, 'create'])->name('Administradores.Crear');
    Route::post('/Administradores', [AdministradoresController::class, 'store'])->name('Administradores.Store');
    Route::get('/Administradores/{correo}/editar', [AdministradoresController::class, 'edit'])->name('Administradores.Modificar');
    Route::put('/Administradores/{correo}', [AdministradoresController::class, 'update'])->name('Administradores.Update'); // NUEVA RUTA
    Route::delete('/Administradores/{correo}', [AdministradoresController::class, 'destroy'])->name('Administradores.Eliminar');
    

     Route::get('/Lugares', [LugaresController::class, 'index'])->name('Lugares');
    Route::get('/Lugares/{id}', [LugaresController::class, 'show'])->name('Lugares.Show');
    Route::post('/Lugares/{id}/cambiar-estado', [LugaresController::class, 'cambiarEstado'])->name('Lugares.CambiarEstado');
    Route::post('/Lugares/{id}/aceptar', [LugaresController::class, 'aceptar'])->name('Lugares.Aceptar');
    Route::post('/Lugares/{id}/rechazar', [LugaresController::class, 'rechazar'])->name('Lugares.Rechazar');

    // Eventos
    Route::get('/Eventos', [EventosController::class, 'index'])->name('Eventos');
    Route::get('/Eventos/{id}', [EventosController::class, 'show'])->name('Eventos.Show');
    Route::post('/Eventos/{id}/cambiar-estado', [EventosController::class, 'cambiarEstado'])->name('Eventos.CambiarEstado');
    Route::post('/Eventos/{id}/aceptar', [EventosController::class, 'aceptar'])->name('Eventos.Aceptar');
    Route::post('/Eventos/{id}/rechazar', [EventosController::class, 'rechazar'])->name('Eventos.Rechazar');



    // Negocios
    Route::get('/Negocios', [NegociosController::class, 'index'])->name('Negocios');
    Route::get('/Negocios/{id}', [NegociosController::class, 'show'])->name('Negocios.Show');
    Route::post('/Negocios/{id}/cambiar-estado', [NegociosController::class, 'cambiarEstado'])->name('Negocios.CambiarEstado');
    Route::get('/Negocios/descargar/{archivo}', [NegociosController::class, 'descargarDocumento'])
    ->name('Negocios.DescargarDocumento');
});
