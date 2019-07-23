<?php declare(strict_types=1);

namespace Classic\Secret\Core\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Secret
 * @package App\Model
 *
 * @property int $id
 * @property string $name
 * @property string $message
 * @property int $user_id
 *
 * @property-read User $user
 */
class Secret extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}