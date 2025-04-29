<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginForm extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    protected $listeners = ['showError'];

    public $message;
    public $successMessage = '';
    public $showSuccess = false;

    public function showError($msg)
    {
        $this->message = $msg;
    }
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            // Show success message
            $this->showSuccess = true;
            $this->successMessage = 'Login successful! Redirecting to dashboard...';

            // Dispatch event for JS countdown
            $this->dispatch('loginSuccess');

            // Redirect after delay (handled in JS)
            return;
        }

        $this->addError('email', 'The provided credentials do not match our records.');
        $this->dispatch('errorOccurred');
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}