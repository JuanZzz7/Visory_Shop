<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|in:user,business,admin',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Si es admin, permitimos el acceso sin importar el rol seleccionado
            // Para otros roles, validamos que coincida con el formulario
            if ($user->role !== 'admin' && $user->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'El rol seleccionado no corresponde a tu cuenta.']);
            }
            $request->session()->regenerate();
            return match($user->role) {
                'admin'    => redirect()->route('admin.dashboard'),
                'business' => redirect()->route('business.dashboard'),
                default    => redirect()->route('user.dashboard'),
            };
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'role'     => 'required|in:user,business',
        ];

        // Reglas condicionales si es Empresario
        if ($request->role === 'business') {
            $businessRules = (new \App\Http\Requests\BusinessRegisterRequest())->rules();
            // Remove the rules that are for edit/general company info and keep only the registration ones
            $businessRulesToMerge = array_intersect_key($businessRules, array_flip([
                'tipo_negocio', 'habeas_data_accepted', 'address',
                'razon_social', 'nit', 'camara_comercio_file', 'rut_file',
                'nombre_comercial', 'cedula_propietario', 'rut_personal_file',
                'nombre_representante', 'email_representante'
            ]));
            $rules = array_merge($rules, $businessRulesToMerge);
        }

        $request->validate($rules, (new \App\Http\Requests\BusinessRegisterRequest())->messages());

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($user->role === 'business') {
            $companyData = $request->only([
                'tipo_negocio', 'razon_social', 'nit', 'nombre_comercial', 'cedula_propietario', 'habeas_data_accepted', 'address', 'nombre_representante', 'email_representante'
            ]);
            $companyData['user_id'] = $user->id;
            
            // Si el name general fue insertado, lo mapeamos si faltó el de la empresa
            if ($companyData['tipo_negocio'] === 'formal') {
                $companyData['name'] = $companyData['razon_social'] ?? $user->name;
            } else {
                $companyData['name'] = $companyData['nombre_comercial'] ?? $user->name;
            }

            if ($request->hasFile('camara_comercio_file')) {
                $companyData['camara_comercio_file'] = $request->file('camara_comercio_file')->store('documents', 'public');
            }
            if ($request->hasFile('rut_file')) {
                $companyData['rut_file'] = $request->file('rut_file')->store('documents', 'public');
            }
            if ($request->hasFile('rut_personal_file')) {
                $companyData['rut_personal_file'] = $request->file('rut_personal_file')->store('documents', 'public');
            }

            \App\Models\Company::create($companyData);
        }

        $newCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        session()->put('google_pending', [
            'name'       => $user->name,
            'email'      => $user->email,
            'google_id'  => null,
            'avatar'     => null,
            'code'       => $newCode,
            'expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        \Illuminate\Support\Facades\Mail::to($user->email)->send(
            new \App\Mail\GoogleVerificationMail($newCode, $user->name)
        );

        return redirect()->route('verify.notice');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
