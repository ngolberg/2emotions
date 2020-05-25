<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ModelKeysTrait;

class Like extends Model
{
    use ModelKeysTrait;

    protected $guarded = [];
    protected $primaryKey = ['user_id', 'word_id'];
    public $incrementing = false;

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
