<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Components\Services\IFileService;
use App\Components\Services\IUserService;
use App\Components\Services\IEmailService;
use App\Components\Services\ICommandService;
use App\Components\Services\ICustomerService;
use App\Components\Services\IFileTypeService;
use App\Components\Services\IKeyVaultService;
use App\Components\Services\Impl\FileService;
use App\Components\Services\Impl\UserService;

use App\Components\Services\Impl\EmailService;
use App\Components\Services\IEncryptionService;
use App\Components\Services\IUniqueLinkService;
use App\Components\Repositories\IUserRepository;
use App\Components\Services\Impl\CommandService;
use App\Components\Services\Impl\CustomerService;
use App\Components\Services\Impl\FileTypeService;
use App\Components\Services\Impl\KeyVaultService;
use App\Components\Services\ITwoFactorAuthService;
use App\Components\Services\IAuthenticationService;

use App\Components\Services\Impl\EncryptionService;
use App\Components\Services\Impl\UniqueLinkService;
use App\Components\Repositories\ICustomerRepository;
use App\Components\Repositories\IFileTypeRepository;
use App\Components\Repositories\IKeyVaultRepository;
use App\Components\Repositories\Impl\UserRepository;
use App\Components\Services\IRolesPermissionsService;
use App\Components\Repositories\IUniqueLinkRepository;
use App\Components\Services\IEmailNotificationService;
use App\Components\Services\Impl\TwoFactorAuthService;
use App\Components\Repositories\IFileStorageRepository;
use App\Components\Services\Impl\AuthenticationService;

use App\Components\Repositories\Impl\CustomerRepository;
use App\Components\Repositories\Impl\FileTypeRepository;
use App\Components\Repositories\Impl\KeyVaultRepository;
use App\Components\Repositories\IEmailTemplateRepository;
use App\Components\Services\Impl\RolesPermissionsService;
use App\Components\Repositories\Impl\UniqueLinkRepository;
use App\Components\Services\Impl\EmailNotificationService;
use App\Components\Repositories\IEmailAttachmentRepository;
use App\Components\Repositories\Impl\FileStorageRepository;
use App\Components\Repositories\IRolesPermissionsRepository;
use App\Components\Repositories\IEmailNotificationRepository;
use App\Components\Repositories\Impl\EmailTemplateRepository;

use App\Components\Repositories\Impl\EmailAttachmentRepository;
use App\Components\Repositories\INotificationTriggerRepository;
use App\Components\Repositories\Impl\RolesPermissionsRepository;
use App\Components\Repositories\Impl\EmailNotificationRepository;
use App\Components\Repositories\Impl\NotificationTriggerRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // REPOSITORIES

        $this->app->singleton(IUserRepository::class, function ($app)
        {
            return new UserRepository;
        });

        $this->app->singleton(IEmailNotificationRepository::class, function ($app)
        {
            return new EmailNotificationRepository;
        });

        $this->app->singleton(IEmailTemplateRepository::class, function ($app)
        {
            return new EmailTemplateRepository;
        });

        $this->app->singleton(IEmailAttachmentRepository::class, function ($app)
        {
            return new EmailAttachmentRepository;
        });

        $this->app->singleton(INotificationTriggerRepository::class, function ($app)
        {
            return new NotificationTriggerRepository;
        });

        $this->app->singleton(IUniqueLinkRepository::class, function ($app)
        {
            return new UniqueLinkRepository;
        });

        $this->app->singleton(IFileTypeRepository::class, function ($app)
        {
            return new FileTypeRepository;
        });

        $this->app->singleton(IFileStorageRepository::class, function ($app)
        {
            return new FileStorageRepository;
        });

        $this->app->singleton(IKeyVaultRepository::class, function ($app)
        {
            return new KeyVaultRepository;
        });

        $this->app->singleton(IRolesPermissionsRepository::class, function ($app)
        {
            return new RolesPermissionsRepository;
        });

        $this->app->singleton(ICustomerRepository::class, function ($app)
        {
            return new CustomerRepository;
        });

        // SERVICES

        $this->app->singleton(IAuthenticationService::class, function ($app)
        {
            return new AuthenticationService(
                $app->make(IUserService::class),
                $app->make(IUniqueLinkService::class),
                $app->make(IEmailNotificationService::class)
            );
        });

        $this->app->singleton(IUserService::class, function ($app)
        {
            return new UserService(
                $app->make(IUserRepository::class),
                $app->make(IRolesPermissionsService::class),
                $app->make(ITwoFactorAuthService::class),
            );
        });

        $this->app->singleton(IUniqueLinkService::class, function ($app)
        {
            return new UniqueLinkService(
                $app->make(IUniqueLinkRepository::class),
            );
        });

        $this->app->singleton(IEmailNotificationService::class, function ($app)
        {
            return new EmailNotificationService(
                $app->make(IEmailTemplateRepository::class),
                $app->make(INotificationTriggerRepository::class),
                $app->make(IEmailNotificationRepository::class),
                $app->make(IEmailAttachmentRepository::class)
            );
        });

        $this->app->singleton(IEmailService::class, function ($app)
        {
            return new EmailService;
        });

        $this->app->singleton(ICommandService::class, function ($app)
        {
            return new CommandService(
                $app->make(IEmailService::class),
                $app->make(IEmailNotificationService::class),
            );
        });

        $this->app->singleton(ITwoFactorAuthService::class, function ($app)
        {
            return new TwoFactorAuthService;
        });

        $this->app->singleton(IEncryptionService::class, function ($app)
        {
            return new EncryptionService(
                $app->make(IKeyVaultService::class)
            );
        });

        $this->app->singleton(IRolesPermissionsService::class, function ($app)
        {
            return new RolesPermissionsService(
                $app->make(IRolesPermissionsRepository::class),
            );
        });

        $this->app->singleton(IFileService::class, function ($app)
        {
            return new FileService(
                $app->make(IFileStorageRepository::class),
                $app->make(IEncryptionService::class),
                $app->make(IFileTypeService::class)
            );
        });

        $this->app->singleton(IKeyVaultService::class, function ($app)
        {
            return new KeyVaultService(
                $app->make(IKeyVaultRepository::class),
            );
        });

        $this->app->singleton(IFileTypeService::class, function ($app)
        {
            return new FileTypeService(
                $app->make(IFileTypeRepository::class)
            );
        });

        $this->app->singleton(ICustomerService::class, function ($app)
        {
            return new CustomerService(
                $app->make(ICustomerRepository::class)
            );
        });
    }
}
