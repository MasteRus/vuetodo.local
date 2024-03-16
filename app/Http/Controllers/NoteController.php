<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteStoreItemRequest;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteFullResource;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\NoteItem;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    public function index(): NoteCollection
    {
        return new NoteCollection(Note::paginate(20));
    }

    public function store(NoteStoreRequest $request): NoteResource
    {
        $post = $request->validated();
        $note = new Note($post);
        $note->saveOrFail();

        return new NoteResource($note);
    }

    public function show(Note $note): NoteFullResource
    {
        return new NoteFullResource($note);
    }

    public function update(NoteStoreRequest $request, Note $note): NoteResource
    {
        $post = $request->validated();
        $note->update($post);

        return new NoteResource($note);
    }

    public function destroy(Note $note): JsonResponse
    {
        $note->delete();

        return response()->json(null, 204);
    }


    public function addItem(NoteStoreItemRequest $request, Note $note): NoteFullResource
    {
        $post = $request->validated();
        $note->addItem($post);

        return new NoteFullResource($note);
    }

    public function deleteItem(Note $note, int $id): NoteFullResource
    {
        $note->items()->findOrFail($id);
        $note->deleteItem($id);

        return new NoteFullResource($note);
    }

    public function updateItem(NoteStoreItemRequest $request, Note $note, int $id): NoteFullResource
    {
        /** @var NoteItem $item */
        $item = $note->items()->findOrFail($id);
        $item->update($request->validated());
        $note->refresh();

        return new NoteFullResource($note);
    }

    public function toggleItem(Note $note, int $id): NoteFullResource
    {
        /** @var NoteItem $item */
        $item = $note->items()->findOrFail($id);
        if (!$item->checked) {
            $item->check();
        } else {
            $item->uncheck();
        }
        $note->refresh();

        return new NoteFullResource($note);
    }
}
