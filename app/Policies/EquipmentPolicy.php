<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;

class EquipmentPolicy
{
	public function viewAny(User $user): bool
	{
		return $user !== null;
	}

	public function view(User $user, Equipment $equipment): bool
	{
		return true;
	}

	public function create(User $user): bool
	{
		return $user->hasRole('equipment_owner');
	}

	public function update(User $user, Equipment $equipment): bool
	{
		return $user->id === $equipment->user_id;
	}

	public function delete(User $user, Equipment $equipment): bool
	{
		return $user->id === $equipment->user_id;
	}
}
