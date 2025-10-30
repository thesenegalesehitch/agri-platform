<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
	public function viewAny(User $user): bool
	{
		return $user !== null;
	}

	public function view(User $user, Product $product): bool
	{
		return true;
	}

	public function create(User $user): bool
	{
		return $user->hasRole('producer');
	}

	public function update(User $user, Product $product): bool
	{
		return $user->id === $product->user_id;
	}

	public function delete(User $user, Product $product): bool
	{
		return $user->id === $product->user_id;
	}
}
