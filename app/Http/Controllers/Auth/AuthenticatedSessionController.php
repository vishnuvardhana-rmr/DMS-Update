<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
    
        $request->session()->regenerate();
    
        // Get the authenticated user
        $user = $request->user();
    
        // Custom redirection logic based on user role
        if ($user->role == 1) {
            // Redirect admin to admin dashboard
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 2) {
            // Redirect normal user to user dashboard
            return redirect()->route('user.dashboard');
        }
    
        // Default redirection (fallback) if no role is set
        return redirect()->intended(route('welcome'));
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
