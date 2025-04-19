<?php

     namespace App\Http\Controllers\Auth;

     use App\Http\Controllers\Controller;
     use Illuminate\Http\RedirectResponse;
     use Illuminate\Http\Request;
     use Illuminate\Support\Facades\Auth;
     use Illuminate\Validation\ValidationException;

     class AuthenticatedSessionController extends Controller
     {
         public function create()
         {
             return view('auth.login');
         }

         public function store(Request $request): RedirectResponse
         {
             $request->validate([
                 'email' => ['required', 'email'],
                 'password' => ['required'],
             ]);

             if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                 $request->session()->regenerate();

                 return redirect()->intended(route('home'));
             }

             throw ValidationException::withMessages([
                 'email' => __('auth.failed'),
             ]);
         }

         public function destroy(Request $request): RedirectResponse
         {
             Auth::guard('web')->logout();

             $request->session()->invalidate();

             $request->session()->regenerateToken();

             return redirect('/');
         }
     }
