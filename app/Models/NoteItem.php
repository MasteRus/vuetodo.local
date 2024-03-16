<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'text',
        'order',
    ];

    public function note(): HasOne
    {
        return $this->hasOne(Note::class);
    }

    public function check(): void
    {
        $this->checked = 1;
        $this->save();
    }

    public function uncheck(): void
    {
        $this->checked = 0;
        $this->save();
    }
}
