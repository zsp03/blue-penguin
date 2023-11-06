<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\AvatarProviders\UiAvatarsProvider;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Color\Rgb;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function lecturer(): HasOne
    {
        return $this->hasOne(Lecturer::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() == 'admin'){
            return $this->role == '0';
        } elseif ($panel->getId() == 'publication') {
            return in_array($this->role, array('0','1','2','3','4'));
        } elseif ($panel->getId() == 'finalProject') {
            return in_array($this->role, array('0','1','2','3','4'));
        }

        return false;
    }

    public function getFilamentDefaultAvatar()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        $backgroundColor = Rgb::fromString('rgb(' . FilamentColor::getColors()['gray'][950] . ')')->toHex();

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=FFFFFF&background=' . str($backgroundColor)->after('#');
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->lecturer->image_url ?? $this->getFilamentDefaultAvatar();
    }
}
