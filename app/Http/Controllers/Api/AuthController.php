<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
 public function login(Request $request)
 {
 $data = $request->validate([
 'email' => 'required|email',
 'password' => 'required|string',
 'device_name' => 'nullable|string',
 ]);
 $user = User::where('email', $data['email'])->first();
 if (!$user ||
 !Hash::check($data['password'], $user->password)) {
 return response()->json([
 'message' => 'Email ou mot de passe incorrect.'
 ], 401);
 }
 $token = $user
 ->createToken(
 $data['device_name'] ?? 'flutter-mobile'
 )
 ->plainTextToken;
 return response()->json([
 'message' => 'Connexion réussie',
 'token' => $token,
 'user' => [
 'id' => $user->id,
 'name' => $user->name,
 'email' => $user->email,
 'role' => $user->role ?? null,
 ]
 ]);
}
 public function me(Request $request)
 {
 return response()->json(
 $request->user()
 );
 }
 public function logout(Request $request)
 {
 $request
 ->user()
 ->currentAccessToken()
 ?->delete();
 return response()->json([
 'message' => 'Déconnexion réussie'
 ]);
 }
}
