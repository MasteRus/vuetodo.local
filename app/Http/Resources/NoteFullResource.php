<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteFullResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = [
                'id'      => $item->id,
                'text'    => $item->text,
                'order'   => $item->order,
                'checked' => (bool)$item->checked,

                'created_at' => (string)$item->created_at,
                'updated_at' => (string)$item->updated_at,
            ];
        }

        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'items' => $items,

            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
