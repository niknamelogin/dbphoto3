<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;
use Log;

class ImageController extends Controller
{

    protected $dropbox;

    public function __construct()
    {
        $app = new DropboxApp(env('DROPBOX_CLIENT_ID'), env('DROPBOX_CLIENT_SECRET'), env('DROPBOX_ACCESS_TOKEN'));
        $db = new Dropbox($app);
        $this->dropbox = $db;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     $listFolderContents = $this->dropbox->listFolder("/");
     $items = $listFolderContents->getItems();
     $ret = [];
     $json = [];
     foreach ($items as $key => $item) {
        $temporaryLink = $this->dropbox->getTemporaryLink($item->path_lower);
        $file = $temporaryLink->getMetadata();
        $temporaryLink->getLink();
        array_push($ret, $temporaryLink);
        array_push($json, [
            'link' => $temporaryLink->link, 
            'name' => $temporaryLink->metadata['name'],
            'id' => $temporaryLink->metadata['id'],
            'path_lower' => $temporaryLink->metadata['path_lower']
        ]);
    }

    if ($request->ajax() || $request->isJson() || $request->wantsJson()) {
        return response()->json(['data' => $json, 'token' => \Session::token()]);
    } else {
        return view('index', ['ret' => $ret]);
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_image = $request->image;
        $fileStream = fopen($new_image, DropboxFile::MODE_READ);
        $dropboxFile = DropboxFile::createByStream("/".$new_image->getClientOriginalName(), $fileStream);
        $file = $this->dropbox->upload($dropboxFile, "/".$new_image->getClientOriginalName(), ['autorename' => true]);
        $file->getName();

        if ($request->ajax() || $request->isJson() || $request->wantsJson()) {
            return response()->json(['data' => $new_image->getClientOriginalName()]);
        } else {
            return redirect()->route('images.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $image)
    {
        $file = $this->dropbox->getTemporaryLink("/".$image);

        if ($request->ajax() || $request->isJson()) {
            return response()->json(['data' => 
                [
                    'link' => $file->link, 
                    'name' => $file->metadata['name'],
                    'id' => $file->metadata['id'],
                    'path_lower' => $file->metadata['path_lower']
                ]
            ]);
        } else {
            return view('image', ['image' => $file]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit($image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $image)
    {
        $new_image = $request->image;
        $deletedFolder = $this->dropbox->delete("/".$image);
        $deletedFolder->getName();
        $fileStream = fopen($new_image, DropboxFile::MODE_READ);
        $dropboxFile = DropboxFile::createByStream("/".$image, $fileStream);
        $file = $this->dropbox->upload($dropboxFile, "/".$image, ['autorename' => true]);
        $file->getName();

        if ($request->ajax() || $request->isJson() || $request->wantsJson()) {
            return response()->json(['data' => $new_image->getClientOriginalName()]);
        } else {
            return redirect()->route('images.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $image)
    {
        $deletedFolder = $this->dropbox->delete("/".$image);
        $deletedFolder->getName();

        if ($request->ajax() || $request->isJson() || $request->wantsJson()) {
            return response()->json(['status' => 'successful']);
        } else {
            return redirect()->route('images.index');
        }
    }
}
