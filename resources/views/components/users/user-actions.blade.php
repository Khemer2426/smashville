<div class="dropdown d-inline-block ml-2">
    <button type="button" class="btn btn-primary dropdown-toggle" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
        </button>
    <div class="dropdown-menu dropdown-menu-left p-0 border-0 font-size-sm" aria-labelledby="page-header-user-dropdown">
        <div class="p-2">
            <a href="{{ $routes['edit'] ?? '' }}" class="dropdown-item d-flex align-items-center justify-content-between">
                <span>Modify</span>
                <i class="si si-pencil ml-3"></i>
            </a>
            @if ($user->active && $user->is_verified)
                <a href="javascript:void(0)" class="dropdown-item d-flex align-items-center justify-content-between btn-disable" data-target="#disable-form">
                    <span>Disable</span>
                    <i class="si si-user-unfollow ml-3"></i>
                </a>
                <form id="disable-form" action="{{ $routes['disable'] ?? '' }}" method="post" class="d-none">
                    @csrf
                </form>
            @elseif ($user->is_verified && !$user->active)
                <a href="javascript:void(0)" class="dropdown-item d-flex align-items-center justify-content-between btn-enable" data-target="#enable-form">
                    <span>Enable</span>
                    <i class="si si-user-following ml-3"></i>
                </a>
                <form id="enable-form" action="{{ $routes['enable'] ?? '' }}" method="post" class="d-none">
                    @csrf
                </form>
            @elseif (!$user->is_verified)
                <a href="javascript:void(0)" class="dropdown-item d-flex align-items-center justify-content-between btn-re-send-activation" data-target="#resend-activation-form">
                    <span>Resend Activation Email</span>
                    <i class="si si-envelope ml-3"></i>
                </a>
                <form action="{{ $routes['resend-verification'] ?? '' }}" method="POST" id="resend-activation-form">
                    @csrf
                </form>
            @endif
            
            @if ($user->active && $user->is_verified)
                <a href="javascript:void(0)" class="dropdown-item d-flex align-items-center justify-content-between btn-reset-password" data-target="#reset-password-form">
                    <span>Reset Password</span>
                    <i class="si si-reload ml-3"></i>
                </a>
                <form action="{{ $routes['reset-password'] ?? '' }}" method="POST" id="reset-password-form">
                    @csrf
                </form>
            @endif
            
            @if ($user->id != Auth::id())
                <a href="javascript:void(0)" class="dropdown-item d-flex align-items-center justify-content-between btn-delete-user" data-target="#delete-form">
                    <span>Delete</span>
                    <i class="si si-trash ml-3"></i>
                </a>
                <form id="delete-form" action="{{ $routes['delete'] ?? '' }}" method="post" class="d-none">
                    @method('DELETE')
                    @csrf
                </form>
            @endif
        </div>
    </div>
</div>