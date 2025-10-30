<?php

namespace App\Http\Controllers;

use App\Models\SuspensionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SuspensionStatusChanged;

class SuspensionRequestController extends Controller
{
	public function index()
	{
		$requests = SuspensionRequest::latest()->paginate(20);
		return view('suspensions.index', compact('requests'));
	}

	public function create()
	{
		return view('suspensions.create');
	}

	public function store(Request $request)
	{
		$data = $request->validate(['reason' => ['required','string','min:10']]);
		SuspensionRequest::create([
			'user_id' => Auth::id(),
			'reason' => $data['reason'],
			'status' => 'pending',
		]);
		return redirect()->route('suspension-requests.index')->with('status', 'Requête envoyée');
	}

	public function show(SuspensionRequest $suspensionRequest)
	{
		return view('suspensions.show', compact('suspensionRequest'));
	}

	public function approve(SuspensionRequest $suspensionRequest)
	{
		$suspensionRequest->update([
			'status' => 'approved',
			'admin_id' => Auth::id(),
			'reviewed_at' => now(),
		]);
		$suspensionRequest->user->update(['is_suspended' => false]);
		$suspensionRequest->user->notify(new SuspensionStatusChanged($suspensionRequest));
		return back()->with('status', 'Requête approuvée');
	}

	public function reject(SuspensionRequest $suspensionRequest, Request $request)
	{
		$data = $request->validate(['response' => ['nullable','string']]);
		$suspensionRequest->update([
			'status' => 'rejected',
			'admin_id' => Auth::id(),
			'reviewed_at' => now(),
			'response' => $data['response'] ?? null,
		]);
		$suspensionRequest->user->notify(new SuspensionStatusChanged($suspensionRequest));
		return back()->with('status', 'Requête rejetée');
	}
}
