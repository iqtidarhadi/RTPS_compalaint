<section class="container py-4">
    <header class="mb-3">
        <h2 class="fs-4 fw-semibold text-dark">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="firstname" class="form-label fw-medium">{{ __('First Name') }}</label>
            <input id="firstname" name="firstname" type="text" class="form-control"
                value="{{ old('firstname', $user->firstname) }}" required autofocus autocomplete="firstname">
            @error('firstname')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
         <div class="mb-3">
            <label for="lastname" class="form-label fw-medium">{{ __('Last Name') }}</label>
            <input id="lastname" name="lastname" type="text" class="form-control"
                value="{{ old('lastname', $user->lastname) }}" required autofocus autocomplete="lastname">
            @error('lastname')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-medium">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="btn btn-link p-0 text-decoration-underline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success fw-medium">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-muted small">
                    {{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
