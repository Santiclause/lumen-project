<?php

namespace App\Http\Controllers;
use App\User;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        $note = new Note;
        $note->title = $request->input('title');
        $note->body = $request->input('body');
        $note->user_id = $request->user()->id;
        $note->save();
        return $note;
    }
    
    public function get(Request $request, $id)
    {
        return Note::find($id) ?: response()->json(['error' => 'not_found'])->setStatusCode(404);
    }
    
    public function delete(Request $request, $id)
    {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['error' => 'not_found'])->setStatusCode(404);
        }
        $note->delete();
        return response()->json(['success' => 'deleted']);
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['error' => 'not_found'])->setStatusCode(404);
        }
        $note->title = $request->input('title');
        $note->body = $request->input('body');
        $note->save();
        return $note;
    }
    
    public function all(Request $request)
    {
        return Note::where('user_id', $request->user()->id)->get();
    }
}
