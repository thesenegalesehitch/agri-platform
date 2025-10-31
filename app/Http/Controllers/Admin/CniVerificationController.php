<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CniVerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CniVerificationController extends Controller
{
    /**
     * Liste des utilisateurs avec CNI en attente de vérification
     */
    public function index(Request $request)
    {
        $query = User::whereNotNull('cni_recto_path')
            ->whereNotNull('cni_verso_path')
            ->with('roles');

        $filter = $request->input('filter', 'pending');
        
        if ($filter === 'pending') {
            $query->where('cni_verified', false);
        } elseif ($filter === 'verified') {
            $query->where('cni_verified', true);
        } elseif ($filter === 'all') {
            // Tous
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.cni.index', compact('users', 'filter'));
    }

    /**
     * Voir les détails de la CNI d'un utilisateur
     */
    public function show(User $user)
    {
        if (!$user->cni_recto_path || !$user->cni_verso_path) {
            return redirect()->route('admin.cni.index')
                ->withErrors(['error' => 'Cet utilisateur n\'a pas encore uploadé ses documents CNI.']);
        }

        return view('admin.cni.show', compact('user'));
    }

    /**
     * Approuver la CNI
     */
    public function approve(Request $request, User $user)
    {
        $request->validate([
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update([
            'cni_verified' => true,
            'cni_verified_at' => now(),
            'cni_verification_notes' => $request->input('notes'),
        ]);

        // Envoyer notification à l'utilisateur
        $user->notify(new CniVerificationStatus($user, 'approved'));

        return redirect()->route('admin.cni.index')
            ->with('status', 'CNI approuvée avec succès. L\'utilisateur a été notifié.');
    }

    /**
     * Rejeter la CNI
     */
    public function reject(Request $request, User $user)
    {
        $request->validate([
            'notes' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $user->update([
            'cni_verified' => false,
            'cni_verified_at' => null,
            'cni_verification_notes' => $request->input('notes'),
        ]);

        // Envoyer notification à l'utilisateur
        $user->notify(new CniVerificationStatus($user, 'rejected', $request->input('notes')));

        return redirect()->route('admin.cni.index')
            ->with('status', 'CNI rejetée. L\'utilisateur a été notifié avec les raisons.');
    }
}
