<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Meal
 * @package App\Models
 *
 * @property int $id
 * @property int $category_id
 * @property bool $is_active
 * @property bool $is_favorite
 * @property bool $is_ordered
 * @property bool $is_unsuitable
 * @property string $name
 */
class Meal extends Model
{
    use HasFactory;

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
