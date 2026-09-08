<?php

namespace App\Http\Livewire;

use App\Models\Post;

use Livewire\Component;

class ShowPosts extends Component
{

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        return view('livewire.show-posts', [
        'posts' => Post::all(),
    ]);


    }

    
}
