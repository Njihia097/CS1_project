<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class Reactions extends Component
{
    public $model;
    public function mount($model)
    {
        $this->model = $model;
    }
    public function react($type)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }


        $reaction = Reaction::where('user_id', Auth::id())
        ->where(function($query) {
            $query->where('content_id', $this->model->ContentID)
                  ->orWhere('chapter_id', $this->model->ChapterID);
        })
        ->first();
        if ($reaction) {
            if ($reaction->type === $type) {
                $reaction->delete();
            } else {
                $reaction->update(['type' => $type]);
            }
        } else {
            Reaction::create([
                'user_id' => Auth::id(),
                'content_id' => $this->model instanceof \App\Models\Content ? $this->model->ContentID : null,
                'chapter_id' => $this->model instanceof \App\Models\Chapter ? $this->model->ChapterID : null,
                'type' => $type
            ]);
        }

        $this->dispatch('reactionUpdated');
    }

    public function toggleFavorite()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $favorite = Favorite::where('UserID', Auth::id())
            ->where('ContentID', $this->model->ContentID)
            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'UserID' => Auth::id(),
                'ContentID' => $this->model->ContentID,
                'Title' => $this->model->Title,
                'FavoriteDate' => now(),
            ]);
        }

        $this->dispatch('favoriteUpdated');
    }
    
    public function render()
    {
        return view('livewire.reactions', [
            'thumbsUpCount' => $this->model->reactions()->where('type', 'thumbs_up')->count(),
            'thumbsDownCount' => $this->model->reactions()->where('type', 'thumbs_down')->count(),
            'userReaction' => $this->model->reactions()->where('user_id', Auth::id())->first(),
            'isFavorite' => Favorite::where('UserID', Auth::id())->where('ContentID', $this->model->ContentID)->exists()
        ]);
    }
}
