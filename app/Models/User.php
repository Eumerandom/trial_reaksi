<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use HasRoles;
    use InteractsWithMedia;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photos')
            ->useDisk('public')
            ->useFallbackUrl($this->defaultProfilePhotoUrl())
            ->singleFile();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->hasMedia('profile_photos')) {
            $media = $this->getFirstMedia('profile_photos');

            return $media?->getUrl() ?? $this->defaultProfilePhotoUrl();
        }

        return $this->defaultProfilePhotoUrl();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->hasMedia('profile_photos')) {
            $media = $this->getFirstMedia('profile_photos');

            return $media?->getUrl();
        }

        return null;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if (app()->environment('local')) {
            return true;
        }

        if ($panel->getId() === 'admin') {
            return $this->hasVerifiedEmail() && (
                $this->hasAnyRole(['admin', 'super_admin'])
            );
        }

        return true;
    }
}
