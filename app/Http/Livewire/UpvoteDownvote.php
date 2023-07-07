<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class UpvoteDownvote extends Component
{
    public Post $post;
    
    public function mount(Post $post)
    {
        $this->post = $post;
        // dd($this->post->id);
    }
    public function render()
    {
        //dd($this->post->id);
        $upvotes = \App\Models\UpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('is_upvote', '=', true)
            ->count();

        $downvotes = \App\Models\UpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('is_upvote', '=', false)
            ->count();

        

        // $user = request()->user();
        // if($user) {
        //     $model = \App\Models\UpvoteDownvote::where('post_id', '=', $this->post->id)
        //         ->where('user_id', '=', $user->id)
        //         ->first();

        //     if($model) {
        //         $this->hasUpvote = !!$model->is_upvote; //!! was used to convert the 0 or 1 from the db to true or false
        //     }
        // }


        
        return view('livewire.upvote-downvote', ['upvotes' => $upvotes, 'downvotes' => $downvotes]);
    }

    public function upvoteDownvote($upvote = true)
    {
        $user = request()->user();
        if(!$user) {
            return $this->redirect('login');
        }

        if(!$user->hasVerifiedEmail()) {
            return $this->redirect(route('verification.notice'));
        }

        $model = \App\Models\UpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('user_id', '=', $user->id)
            ->first();

        if(!$model) {

            //dd($this->post->id);
            \App\Models\UpvoteDownvote::create([
                'is_upvote' => $upvote,
                'post_id' => $this->post->id,
                'user_id' => $user->id
            ]);
            return;
        }


        if ($upvote && $model->is_upvote || !$upvote && !$model->is_upvote) {
            $model->delete();

        } else{
            $model->is_upvote = $upvote;
            $model->save();
        }
    }
}
