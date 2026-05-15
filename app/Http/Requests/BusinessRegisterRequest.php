<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // We allow anyone to submit this registration form
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $section = $this->input('section', 'all');

        if ($section === 'general') {
            return [
                'name'        => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'category'    => ['nullable', 'string', 'max:100'],
                'logo'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'banner'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,bmp', 'max:15360'],
            ];
        }

        if ($section === 'legal') {
            return [
                'tipo_negocio' => ['required', 'in:formal,informal'],
                'habeas_data_accepted' => ['accepted'],
                'direccion_fisica' => ['required', 'string', 'max:255'],
                'razon_social' => ['required_if:tipo_negocio,formal', 'nullable', 'string', 'max:255'],
                'nit' => ['required_if:tipo_negocio,formal', 'nullable', 'string', 'regex:/^[0-9]+-[0-9]$/'],
                'camara_comercio_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
                'rut_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
                'nombre_representante' => ['required_if:tipo_negocio,formal', 'nullable', 'string', 'max:255'],
                'email_representante' => ['required_if:tipo_negocio,formal', 'nullable', 'email', 'max:255'],
                'nombre_comercial' => ['required_if:tipo_negocio,informal', 'nullable', 'string', 'max:255'],
                'cedula_propietario' => ['required', 'string', 'max:20'],
                'rut_personal_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            ];
        }

        if ($section === 'contact') {
            return [
                'phone'       => ['nullable', 'string', 'max:20'],
                'email'       => ['nullable', 'email'],
                'instagram'   => ['nullable', 'string', 'max:100'],
                'facebook'    => ['nullable', 'string', 'max:100'],
                'website'     => ['nullable', 'url'],
                'latitude'    => ['nullable', 'numeric'],
                'longitude'   => ['nullable', 'numeric'],
            ];
        }

        // Default (all)
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category'    => ['nullable', 'string', 'max:100'],
            'address'     => ['nullable', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'email'       => ['nullable', 'email'],
            'instagram'   => ['nullable', 'string', 'max:100'],
            'facebook'    => ['nullable', 'string', 'max:100'],
            'website'     => ['nullable', 'url'],
            'logo'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'banner'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,bmp', 'max:15360'],
            'tipo_negocio' => ['required', 'in:formal,informal'],
            'habeas_data_accepted' => ['accepted'],
            'direccion_fisica' => ['required', 'string', 'max:255'],
            'razon_social' => ['required_if:tipo_negocio,formal', 'nullable', 'string', 'max:255'],
            'nit' => ['required_if:tipo_negocio,formal', 'nullable', 'string', 'regex:/^[0-9]+-[0-9]$/'],
            'camara_comercio_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'rut_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'nombre_representante' => ['required_if:tipo_negocio,formal', 'nullable', 'string', 'max:255'],
            'email_representante' => ['required_if:tipo_negocio,formal', 'nullable', 'email', 'max:255'],
            'nombre_comercial' => ['required_if:tipo_negocio,informal', 'nullable', 'string', 'max:255'],
            'cedula_propietario' => ['required', 'string', 'max:20'],
            'rut_personal_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'tipo_negocio.required' => 'Debe seleccionar el tipo de negocio.',
            'habeas_data_accepted.accepted' => 'Debe aceptar la política de tratamiento de datos (Ley 1581).',
            
            'razon_social.required_if' => 'La razón social es obligatoria para empresas formales.',
            'nit.required_if' => 'El NIT es obligatorio para empresas formales.',
            'nit.regex' => 'El NIT debe tener el formato válido (ej. 123456789-1).',
            'camara_comercio_file.required_if' => 'El certificado de Cámara de Comercio es obligatorio.',
            'camara_comercio_file.max' => 'El archivo de Cámara de Comercio no debe pesar más de 5MB.',
            'rut_file.required_if' => 'El RUT es obligatorio para empresas formales.',
            'rut_file.max' => 'El archivo RUT no debe pesar más de 5MB.',

            'nombre_comercial.required_if' => 'El nombre comercial es obligatorio para emprendimientos informales.',
            'nombre_representante.required_if' => 'El nombre del representante legal es obligatorio.',
            'email_representante.required_if' => 'El correo del representante legal es obligatorio.',
            'cedula_propietario.required' => 'La cédula del representante / propietario es obligatoria.',
            'rut_personal_file.max' => 'El RUT personal no debe pesar más de 5MB.',
        ];
    }
}
