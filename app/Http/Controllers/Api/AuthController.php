<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
class AuthController extends Controller
{
    /**
     * STEP 1: Request OTP via email
     */
public function requestVerificationCode(Request $request)
{
    $request->validate([
        'email' => 'required|email|max:255',
    ]);

    $user = User::where('email', $request->email)->first();

    /**
     * CASE 1: Already verified user
     */
    if ($user && $user->email_verified_at) {
        return response()->json([
            'success' => false,
            'message' => 'Email already verified. Please login.'
        ], 409);
    }

    /**
     * CASE 2: Check existing OTP still valid
     */
    if ($user && $user->verification_code && $user->code_expires_at) {

        // ensure safe comparison (works even if cast fails)
        if (now()->lt($user->code_expires_at)) {

            return response()->json([
                'success' => false,
                'message' => 'OTP already sent. Please check your email or wait until it expires.',
                'expires_at' => $user->code_expires_at
            ], 429);
        }
    }

    /**
     * Generate OTP
     */
    $code = rand(100000, 999999);

    $user = User::updateOrCreate(
        ['email' => $request->email],
        [
            'verification_code' => $code,
            'code_expires_at' => now()->addMinutes(10),
            'is_active' => false,
        ]
    );

    /**
     * Send email
     */
    Mail::raw(
        "Your OTP verification code is: $code\n\nThis code will expire in 10 minutes.",
        function ($message) use ($request) {
            $message->to($request->email)
                ->subject('RTPS Commission - OTP Verification Code');
        }
    );

    return response()->json([
        'success' => true,
        'message' => 'OTP sent successfully to your email',
        'email' => $request->email,
        'expires_in' => '10 minutes'
    ]);
}

    /**
     * STEP 2: Verify OTP
     */
public function verifyCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'verification_code' => 'required|digits:6',
    ]);

    $user = User::where('email', $request->email)
        ->where('verification_code', $request->verification_code)
        ->where('code_expires_at', '>', now())
        ->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired OTP'
        ], 422);
    }

    /**
     * Mark email as verified
     */
    $user->update([
        'email_verified_at' => now(),
        'verification_code' => null,
        'code_expires_at' => null,
    ]);

    /**
     * Assign role only if not already assigned
     */
    if (!$user->hasRole('citizen')) {
        $user->assignRole('citizen');
    }

    return response()->json([
        'success' => true,
        'message' => 'OTP verified successfully',
        'email' => $user->email,
        'role' => $user->getRoleNames()
    ]);
}

    /**
     * STEP 3: Complete Registration (CITIZEN ONLY)
     */
   public function completeRegistration(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'firstname' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
        'lastname' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
        'father_name' => 'required|string|max:100',
        'cnic_no' => 'required|string|size:15|unique:users,cnic_no|regex:/^\d{5}-\d{7}-\d{1}$/',
        'contact_no' => 'required|string|max:20|regex:/^03\d{9}$/',
        'gender' => ['required', Rule::in(['male','female','other'])],
        'age' => 'required|integer|min:18|max:120',
        'address' => 'required|string|max:500',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = User::where('email', $request->email)
        ->whereNotNull('email_verified_at')
        ->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Email not verified. Please verify your email first.'
        ], 403);
    }

    if ($user->firstname !== null && $user->password !== null) {
        return response()->json([
            'success' => false,
            'message' => 'Registration already completed.'
        ], 409);
    }

    $user->update([
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'father_name' => $request->father_name,
        'cnic_no' => $request->cnic_no,
        'contact_no' => $request->contact_no,
        'gender' => $request->gender,
        'age' => $request->age,
        'address' => $request->address,
        'password' => Hash::make($request->password),
        'is_active' => true,
    ]);

    

    /**
     * Sanctum Token
     */
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Registration completed successfully',
        'data' => [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->only([
                'id',
                'firstname',
                'lastname',
                'email',
                'cnic_no',
                'contact_no',
                'age',
                'gender'
            ]),
            'roles' => $user->getRoleNames()
        ]
    ], 201);
}

    /**
     * Login for citizens only
     */
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    /**
     * Invalid credentials
     */
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * ROLE CHECK (Spatie)
     */
    if (!$user->hasRole('citizen')) {
        return response()->json([
            'success' => false,
            'message' => 'Access denied. Only citizens can login from this portal.'
        ], 403);
    }

    /**
     * Email verification check
     */
    if (!$user->email_verified_at) {
        return response()->json([
            'success' => false,
            'message' => 'Please verify your email first.'
        ], 403);
    }

    /**
     * Active account check
     */
    if (!$user->is_active) {
        return response()->json([
            'success' => false,
            'message' => 'Your account has been deactivated.'
        ], 403);
    }

    /**
     * Revoke old tokens
     */
    $user->tokens()->delete();

    /**
     * Create new Sanctum token
     */
    $token = $user->createToken('auth_token', ['citizen'])->plainTextToken;

    /**
     * Update last login
     */
    $user->update([
        'last_login_at' => now()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Login successful',
        'data' => [
            'token' => $token,
            'token_type' => 'Bearer',
            'roles' => $user->getRoleNames(),
            'user' => $user->only([
                'id',
                'firstname',
                'lastname',
                'email',
                'cnic_no',
                'contact_no'
            ])
        ]
    ]);
}

    /**
     * Resend OTP code
     */
    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email already verified.'
            ], 400);
        }

        if ($user->firstname && $user->password) {
            return response()->json([
                'success' => false,
                'message' => 'Registration already completed. Please login.'
            ], 400);
        }

        // Generate new code
        $code = rand(100000, 999999);

        $user->update([
            'verification_code' => $code,
            'code_expires_at' => now()->addMinutes(10),
        ]);

        // Send email
        Mail::raw("Your new OTP verification code is: $code\n\nThis code will expire in 10 minutes.", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('RTPS Commission - New OTP Verification Code');
        });

        return response()->json([
            'success' => true,
            'message' => 'New OTP sent successfully',
            'email' => $request->email
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get authenticated user profile
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }
}