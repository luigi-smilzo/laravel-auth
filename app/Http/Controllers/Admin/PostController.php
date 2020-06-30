<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\NewPost;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validation());
        
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'], '-');

        // Image store
        if (!empty($data['img_path'])) {
            $data['img_path'] = Storage::disk('public')->put('img', $data['img_path']);
        }

        $newPost = new Post();
        $newPost->fill($data);
        $saved = $newPost->save();

        if ($saved) {
            //Send success notification via mail
            Mail::to('sempronio@caio.it')->send(new NewPost($newPost));

            return redirect()->route('admin.posts.show', $newPost->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validation($post->id));
        
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');

        if (!empty($data['img_path'])) {
            
            // Delete old image
            if (!empty($post->img_path)) {
                Storage::disk('public')->delete($post->img_path);
            }

            // Store new image
            $data['img_path'] = Storage::disk('public')->put('img', $data['img_path']);
        }

        $updated = $post->update($data);

        if ($updated) {
            return redirect()->route('admin.posts.show', $post->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (empty($post)){
            abort('404');
        }

        $title = $post->title;

        // Delete stored image
        if (!empty($post->img_path)) {
            Storage::disk('public')->delete($post->img_path);
        }

        $deleted = $post->delete();

        if ($deleted) {
            return redirect()->route('admin.posts.index')->with('del_success', $title);
        }
    }

    /**
     * Validation utlity
     */
    private function validation($id = null)
    {
        return [
            'title' => [
                'required',
                Rule::unique('posts')->ignore($id)
            ],
            'body' => 'required',
            'img_path' => 'image'
        ];
    }
}
