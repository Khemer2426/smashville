<div class="modal fade modal-v2" id="tfa-modal" tabindex="-1" role="dialog" aria-labelledby="tfa-modal" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded mb-0">
                <div class="block-header px-0">
                    <h3 class="block-title"></h3>
                    <div class="block-options">
                    <button type="button" class="btn-block-option btn-block-close" data-bs-dismiss="modal" aria-label="Close">
                        @lang('Close') <i class="fa fa-fw fa-times"></i>
                    </button>
                    </div>
                </div>
                <div class="block-content py-5 px-5">
                    @if ($errors->has('tfa_message'))
                      <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                          <p class="mb-0">@lang($errors->first('tfa_message'))</p>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif
                    <h6>Please input your password {{ !empty(auth()->user()->tfa_secret) ? 'and verification code to disable' : 'to enable' }} your two-factor authentication.</h6>
                    <form class="js-validation" action="{{ $route }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-floating mb-4">
                          <input type="password" 
                              class="form-control form-control-alt {{ $errors->has('password') ? ' is-invalid' : '' }}" 
                              id="tfa_password"
                              name="tfa_password"
                                placeholder="@lang('Password')"
                              required>
                          <label for="tfa_password">@lang('Password')</label>
                          @error('tfa_password')
                              <div class="col-12 mb-2"><span class="text-danger password">@lang($message)</span></div>
                          @enderror
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" 
                                class="form-control form-control-alt {{ $errors->has('password') ? ' is-invalid' : '' }}" 
                                id="tfa_password_confirmation"
                                name="tfa_password_confirmation"
                                placeholder="@lang('Password Confirmation')"
                                confirm_password="#tfa_password"
                                required>
                            <label for="tfa_password_confirmation">@lang('Password Confirmation')</label>
                            @error('tfa_password_confirmation')
                              <div class="col-12 mb-2"><span class="text-danger password">@lang($message)</span></div>
                            @enderror
                        </div>
                        @if (!empty(auth()->user()->tfa_secret))
                          <div class="form-floating mb-4">
                              <input type="text" 
                                  class="form-control form-control-alt tfa_code {{ $errors->has('verification_code') ? ' is-invalid' : '' }}" 
                                  id="verification_code"
                                  name="verification_code"
                                  placeholder="@lang('Verification Code')"
                                  required>
                              <label for="verification_code">@lang('Verification Code')</label>
                              @error('verification_code')
                                <div class="col-12 mb-2"><span class="text-danger">@lang($message)</span></div>
                              @enderror
                          </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                          <button type="submit" class="btn btn-lg btn-success w-100">@lang('Continue')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>