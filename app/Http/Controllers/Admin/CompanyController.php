<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('user')->latest()->paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    public function toggleStatus(\Illuminate\Http\Request $request, Company $company)
    {
        $newStatus = $request->input('status');
        if (!$newStatus) {
            $newStatus = $company->status === 'active' ? 'inactive' : 'active';
        }
        
        $company->update(['status' => $newStatus]);

        // Send email notification if transitioning out of pending, or if explicitly requested
        if ($newStatus === 'active' || $newStatus === 'inactive') {
            try {
                \Illuminate\Support\Facades\Mail::to($company->user->email)->send(new \App\Mail\CompanyStatusUpdatedMail($company, $newStatus));
            } catch (\Exception $e) {
                return back()->with('success', 'Estado actualizado. No se pudo enviar el correo de notificación.');
            }
        }

        return back()->with('success', 'Estado de la empresa actualizado y notificación enviada.');
    }

    public function documentUpdateStatus(\Illuminate\Http\Request $request, Company $company)
    {
        $status = $request->input('document_update_status');
        
        if (!in_array($status, ['granted', 'null'])) {
            return back()->withErrors('Estado no válido.');
        }

        $company->update([
            'document_update_status' => $status === 'null' ? null : $status,
        ]);

        $msg = $status === 'granted' ? 'Edición de documentos habilitada para la empresa.' : 'Solicitud de edición rechazada.';
        return back()->with('success', $msg);
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Empresa eliminada.');
    }
}
