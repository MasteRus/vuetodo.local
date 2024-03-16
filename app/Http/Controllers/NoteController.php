<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteStoreRequest;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteResource;
use App\Models\Note;
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

    public function show(Note $note)
    {
        //
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
}
