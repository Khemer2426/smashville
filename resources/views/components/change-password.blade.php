<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">Change Password</h3>
    </div>
    <form method="post" class="js-validation" action="{{ $action }}">
        <div class="block-content">
            {{ csrf_field() }}
            <div class="form-floating mb-4">
                <input id="current_password" type="password" class="form-control {{ $errors->has('current_password') ? ' is-invalid' : '' }}" name="current_password" data-error="#current-password-invalid-msg" required autocomplete="off" placeholder="Current Password">
                <label for="current_password">Current Password</label>
                <div class="invalid-feedback" id="current-password-invalid-msg"></div>
                @if ($errors->has('current_password'))
                    <div class="invalid-feedback">{{ $errors->first('current_password') }}</div>
                @endif
            </div>
            <div class="form-floating mb-4">
                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="New Password" data-error="#password-invalid-msg" required autocomplete="off">
                <label for="password">New Password</label>
                <div class="invalid-feedback" id="password-invalid-msg"></div>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="form-floating mb-4">
                <input id="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="Password Confirmation" data-error="#password-confirmation-invalid-msg" required autocomplete="off">
                <label for="password_confirmation">Password Confirmation</label>
                <div class="invalid-feedback" id="password-confirmation-invalid-msg"></div>
                @if ($errors->has('password_confirmation'))
                    <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>
        </div>
        <div class="form-group mb-4 border-top px-4 py-3">
            <button type="submit" class="btn btn-primary btn-form-submit">Update Password</button>
        </div>
    </form>
</div>