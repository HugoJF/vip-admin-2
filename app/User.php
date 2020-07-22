<?php

namespace App;

use App\Services\UserCurrentVipService;
use App\Warnings\AgreedToTerms;
use App\Warnings\MissingAffiliateCode;
use App\Warnings\MissingEmailAlert;
use App\Warnings\MissingTradeLinkAlert;
use App\Warnings\OrderPendingActivationAlert;
use HugoJF\ModelWarnings\Traits\HasWarnings;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, Searchable
{
    use HasWarnings;
    use Notifiable;

    protected $fillable = [
        'name',
        'tradelink',
        'email',
        'password',
        'username',
        'avatar',
        'terms',
        'hidden_flags',
        'affiliate_code',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'admin'             => 'boolean',
        'affiliate'         => 'boolean',
        'terms'             => 'boolean',
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime:c',
        'updated_at'        => 'datetime:c',
    ];

    protected $warnings = [
        AgreedToTerms::class,
        MissingTradeLinkAlert::class,
        MissingEmailAlert::class,
        OrderPendingActivationAlert::class,
        MissingAffiliateCode::class,
    ];

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class);
    }

    public function referees()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    public function reason()
    {
        return $this->morphOne(Token::class, 'reason');
    }

    public function currentVip()
    {
        /** @var UserCurrentVipService $service */
        $service = app(UserCurrentVipService::class);

        return $service->handle($this);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->name ?? $this->username,
            route('users.show', $this)
        );
    }
}
