<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="Agri Platform API", version="1.0.0")
 * @OA\SecurityScheme(
 *   securityScheme="sanctum",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 * )
 *
 * @OA\Schema(
 *   schema="Product",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="title", type="string"),
 *   @OA\Property(property="description", type="string"),
 *   @OA\Property(property="price", type="number"),
 *   @OA\Property(property="stock", type="integer"),
 * )
 *
 * @OA\Schema(
 *   schema="Equipment",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="title", type="string"),
 *   @OA\Property(property="description", type="string"),
 *   @OA\Property(property="daily_rate", type="number"),
 *   @OA\Property(property="is_available", type="boolean"),
 * )
 *
 * @OA\Schema(
 *   schema="Order",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="status", type="string"),
 *   @OA\Property(property="total", type="number"),
 * )
 *
 * @OA\Schema(
 *   schema="Rental",
 *   type="object",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="status", type="string"),
 *   @OA\Property(property="start_date", type="string", format="date"),
 *   @OA\Property(property="end_date", type="string", format="date"),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
