<?php

namespace App\Http\Requests;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Staff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "role" => "required",
            "ic" => "required|digits:12",
            "password" => "required"
        ];
    }

    protected function passedValidation()
    {
        switch ($this->role) {
            case "patient":
                $patient = Patient::where('patientIC', $this->ic)->first();
                $authAttempt = Auth::guard('patient')->attempt(['patientIC' => $this->ic, 'password' => $this->password]);
                if (!$patient || !$authAttempt) {
                    throw new ValidationException(
                        validator: validator([], []),
                        response: Redirect::back()->with('error', 'Invalid IC or password.')
                    );
                }

                break;
            case "admin":
                $admin = Staff::where('staffIC', $this->ic)->first();
                $authAttempt = Auth::guard('admin')->attempt(['staffIC' => $this->ic, 'password' => $this->password]);
                if (!$admin || !$authAttempt) {
                    throw new ValidationException(
                        validator: validator([], []),
                        response: Redirect::back()->with('error', 'Invalid IC or password.')
                    );
                }
                break;
            case "staff":
                $staff = Staff::where('staffIC', $this->ic)->first();
                $authAttempt = Auth::guard('staff')->attempt(['staffIC' => $this->ic, 'password' => $this->password]);
                if (!$staff || !$authAttempt) {
                    throw new ValidationException(
                        validator: validator([], []),
                        response: Redirect::back()->with('error', 'Invalid IC or password.')
                    );
                }else if($staff->status == 'pending') {
                    Auth::guard('staff')->logout();
                    throw new ValidationException(
                        validator: validator([], []),
                        response: Redirect::back()->with('error', 'Staff account is not approved yet.')
                    );
                }
                break;
            case "doctor":
                $doctor = Doctor::where('docIC', $this->ic)->first();
                $authAttempt = Auth::guard('doctor')->attempt(['docIC' => $this->ic, 'password' => $this->password]);
                if (!$doctor || !$authAttempt) {
                    throw new ValidationException(
                        validator: validator([], []),
                        response: Redirect::back()->with('error', 'Invalid IC or password.')
                    );
                }else if ($doctor->status == 'pending') {
                    Auth::guard('doctor')->logout();
                    throw new ValidationException(
                        validator: validator([], []),
                        response: Redirect::back()->with('error', 'Doctor account is not approved yet.')
                    );
                }
                break;
            default:
                break;
        }
    }
}
