<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ImageUpload extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'original_filename',
        'filename',
        'disk',
        'hash',
        'views',
        'max_views',
        'expired',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Create a hash for this link to use.
     *
     * @return int
     */
    public static function createHash()
    {
        $number = Str::random(config('uploader.hash_length')); // better than rand()

        if (self::whereHash($number)->exists()) {
            return self::createHash();
        }

        return $number;
    }


    /**
     * Expire the image.
     *
     * @return void
     */
    public function expire()
    {
        $this->expired = true;
        $this->delete();
    }

    /**
     * Check if the upload has expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return ($this->expired === true);
    }
}
