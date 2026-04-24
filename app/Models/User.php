<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function reward()
    {
        return $this->hasOne(Reward::class);
    }

    public function beautyProfile()
    {
        return $this->hasOne(BeautyProfile::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishList()
    {
        return $this->hasMany(WishList::class);
    }

    public function wishListItems()
    {
        return $this->hasManyThrough(Product::class, WishList::class, 'user_id', 'id', 'id', 'product_id');
    }

    public function pointsTransactions()
    {
        return $this->hasMany(PointsTransaction::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Filter by name, email, or mobile (case-insensitive LIKE search).
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $q) use ($search): void {
            $q->where(function (Builder $inner) use ($search): void {
                $inner->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('mobile', 'like', "%{$search}%");
            });
        });
    }

    /**
     * Only users who have placed at least one order.
     */
    public function scopeHasOrders(Builder $query): Builder
    {
        return $query->has('orders');
    }

    /**
     * Only users who have never placed an order.
     */
    public function scopeNoOrders(Builder $query): Builder
    {
        return $query->doesntHave('orders');
    }

    /**
     * Only users who have a beauty profile.
     */
    public function scopeHasBeautyProfile(Builder $query): Builder
    {
        return $query->has('beautyProfile');
    }
}
