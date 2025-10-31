<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Services\SmsService;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Gestion des fichiers CNI
        if ($request->hasFile('cni_recto')) {
            if ($user->cni_recto_path && Storage::disk('public')->exists($user->cni_recto_path)) {
                Storage::disk('public')->delete($user->cni_recto_path);
            }
            $data['cni_recto_path'] = $request->file('cni_recto')->store('cni', 'public');
            $data['cni_verified'] = false; // Nécessite re-vérification
        }

        if ($request->hasFile('cni_verso')) {
            if ($user->cni_verso_path && Storage::disk('public')->exists($user->cni_verso_path)) {
                Storage::disk('public')->delete($user->cni_verso_path);
            }
            $data['cni_verso_path'] = $request->file('cni_verso')->store('cni', 'public');
            $data['cni_verified'] = false; // Nécessite re-vérification
        }

        // Si le téléphone change, réinitialiser la vérification
        if ($request->filled('phone') && $user->phone !== $request->input('phone')) {
            $data['phone_verified'] = false;
            $data['phone_verification_code'] = null;
        }

        // Si l'email change, réinitialiser la vérification
        if ($request->filled('email') && $user->email !== $request->input('email')) {
            $data['email_verified_at'] = null;
        }

        $user->fill($data);
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Envoyer le code de vérification par SMS
     */
    public function sendPhoneVerificationCode(Request $request, SmsService $smsService): RedirectResponse
    {
        $request->validate([
            'phone' => ['required', 'string', 'regex:/^(\+221|00221)?[0-9]{9}$/'],
        ]);

        $user = $request->user();
        $phone = preg_replace('/^(\+221|00221)/', '', $request->phone);
        $phone = '+221' . $phone;

        // Générer un code à 6 chiffres
        $code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Enregistrer le code
        $user->update([
            'phone' => $phone,
            'phone_verification_code' => $code,
            'phone_verification_code_expires_at' => now()->addMinutes(10),
            'phone_verified' => false,
        ]);

        // Envoyer le SMS via Twilio
        $result = $smsService->sendVerificationCode($phone, $code);
        
        if ($result !== true) {
            // En cas d'erreur, on garde le code dans la session pour le mode développement
            \Log::warning("Erreur envoi SMS: {$result}");
            return Redirect::route('profile.edit')
                ->with('status', 'phone-code-sent')
                ->with('phone_code', $code)
                ->with('sms_error', 'Erreur lors de l\'envoi du SMS. Code de test: ' . $code);
        }

        return Redirect::route('profile.edit')->with('status', 'phone-code-sent');
    }

    /**
     * Vérifier le code de téléphone
     */
    public function verifyPhone(Request $request): RedirectResponse
    {
        $request->validate([
            'verification_code' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();

        if (!$user->phone_verification_code || 
            $user->phone_verification_code !== $request->verification_code ||
            !$user->phone_verification_code_expires_at ||
            $user->phone_verification_code_expires_at->isPast()) {
            return Redirect::route('profile.edit')
                ->withErrors(['verification_code' => 'Code invalide ou expiré.']);
        }

        $user->update([
            'phone_verified' => true,
            'phone_verification_code' => null,
            'phone_verification_code_expires_at' => null,
        ]);

        return Redirect::route('profile.edit')->with('status', 'phone-verified');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Supprimer les fichiers CNI
        if ($user->cni_recto_path && Storage::disk('public')->exists($user->cni_recto_path)) {
            Storage::disk('public')->delete($user->cni_recto_path);
        }
        if ($user->cni_verso_path && Storage::disk('public')->exists($user->cni_verso_path)) {
            Storage::disk('public')->delete($user->cni_verso_path);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
