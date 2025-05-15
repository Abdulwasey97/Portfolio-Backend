<div>
    <main class="login-wrapper">
        <div class="login-card">
            <h2 class="login-title">Sign In</h2>

            @if($showSuccess)
                <div class="success-message">
                    <p>{{ $successMessage }}</p>
                    <div class="countdown">Redirecting in <span id="countdown">5</span> seconds...</div>
                </div>
            @else
                <form wire:submit.prevent="login" class="login-form">
                    <div class="form-row">
                        <label for="email">Email Address</label>
                        <input
                            wire:model.defer="email"
                            id="email"
                            type="email"
                            placeholder="you@example.com"
                            required
                            autofocus
                        >
                        @error('email') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <label for="password">Password</label>
                        <input
                            wire:model.defer="password"
                            id="password"
                            type="password"
                            placeholder="••••••••"
                            required
                        >
                        @error('password') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="remember-forgot">
                        <label class="remember-me">
                            <input wire:model="remember" type="checkbox">
                            Remember me
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-btn">Login</button>
                </form>
            @endif
        </div>
    </main>
</div>

<script>
    document.addEventListener('livewire:initialized', function () {
        Livewire.on('errorOccurred', function () {
            const form = document.querySelector('.login-form');
            form.classList.add('error');

            // Remove the class after animation completes
            setTimeout(() => {
                form.classList.remove('error');
            }, 500);
        });

        Livewire.on('loginSuccess', function () {
            // Start countdown
            let seconds = 5;
            const countdownElement = document.getElementById('countdown');

            const countdownInterval = setInterval(function() {
                seconds--;
                if (countdownElement) {
                    countdownElement.textContent = seconds;
                }

                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = '/dashboard';
                }
            }, 1000);
        });
    });
</script>
