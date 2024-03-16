<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function items() {
        return $this->hasMany(NoteItem::class);
    }

    public function addItem(array $data) {

        return $this->items()->create($data);
    }

    public function deleteItem(int $id)
    {
        return $this->items()->where('id', $id)->delete();
    }
}
