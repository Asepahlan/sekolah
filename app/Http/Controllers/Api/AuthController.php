<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(title="API Sekolah", version="1.0")
 */

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(response="200", description="Berhasil login"),
     *     @OA\Response(response="401", description="Kredensial salah")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name,
                'class' => $user->class?->name
            ]
        ]);
    }

    /**
     * @OA\Schema(
     *     schema="LoginRequest",
     *     type="object",
     *     @OA\Property(property="email", type="string", format="email"),
     *     @OA\Property(property="password", type="string"),
     *     @OA\Property(property="device_name", type="string")
     * )
     */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil logout']);
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()->load('role', 'class')
        ]);
    }
}
