<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\TweetFile;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TweetController extends Controller
{
    public function index()
    {
        return Tweet::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'tweet' => 'required|string|max:255',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,ppt,pptx,xls,xlsx|max:2048'
        ]);

        $tweet = $request->user()->tweets()->create([
            'tweet' => $request->tweet
        ]);


        if ($request->files) {
            foreach ($request->files as $file) {
                $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = 'public/tweet';
                $storeFile = Storage::put($path, new File($file->getPathname()));
                
                $tweetFile = new TweetFile();
                $tweetFile->tweet_id = $tweet->id;
                $tweetFile->file = $storeFile;
                $tweetFile->save();
                
            }
        }

        return response()->json([
            'message' => 'Your tweet was sent.',
            'tweet' => $tweet
        ], 201);
    }

    public function show(Tweet $tweet)
    {
        return $tweet;
    }

    public function update(Request $request, $id)
    {

        $tweet = Tweet::findOrFail($id);


        $tweet->update([
            'tweet' => $request->tweet
        ]);

        return response()->json([
            'message' => 'Your tweet was updated.',
            'tweet' => $tweet
        ]);
    }

    public function destroy($id)
    {
        $tweet = Tweet::findOrFail($id);

        $tweet->delete();

        return response()->json([
            'message' => 'Your tweet was deleted.'
        ]);
    }
}
