<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function userPosts(){
        return $this->hasMany(Post::class,'user_id');
    }

    public function userComments(){
        return $this->hasMany(Comment::class,'user_id');
    }

    protected static function booted() // itt állítjuk be a hozzá kapcsolód táblák rekordjait is
    {
        static::deleting(function ($user) {
            $user->userPosts()->delete(); // beállítás a hozzá kapcsolódó táblához is, h annak a rekordjai is "törlődjenek"
            $user->userComments()->delete();
        });

        static::restoring(function ($user) {
            Log::info("User restored: " . $user->id);
            $user->userPosts()->withTrashed()->restore(); //withtrashed biztisít h a törölt rekordok visszaállnak
            $user->userComments()->withTrashed()->restore(); // visszaállítjuk a törölt profilképet



        });
    }


}
