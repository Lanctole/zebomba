<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class UsersSessions extends Model
{
    use HasFactory;

    protected $table = 'users_sessions';
    protected $guarded = false;
    public $incrementing = false;
    public static string $secretKey;

    protected $fillable = ['access_token'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        self::$secretKey = Config::get('secrets.secret_key', 'default_value_if_not_set');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
