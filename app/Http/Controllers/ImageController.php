<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

class ImageController extends Controller
{

    private $dropbox;

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
    public function index()
    {

        $listFolderContents = $this->dropbox->listFolder("/");
        $items = $listFolderContents->getItems();
        $ret = [];
        foreach ($items as $key => $item) {
            $temporaryLink = $this->dropbox->getTemporaryLink($item->path_lower);
            $file = $temporaryLink->getMetadata();
            $temporaryLink->getLink();
            array_push($ret, $temporaryLink);
        }

// dd($ret);
        return view('index', ['ret' => $ret]);
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
        $fileStream = fopen($_FILES["image"]["tmp_name"], DropboxFile::MODE_READ);
        $dropboxFile = DropboxFile::createByStream("/".$_FILES["image"]["name"], $fileStream);
        $file = $this->dropbox->upload($dropboxFile, "/".$_FILES["image"]["name"], ['autorename' => true]);
        $file->getName();
        return redirect()->route('images.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show($image)
    {
        $file = $this->dropbox->getTemporaryLink("/".$image);

        return view('image', ['image' => $file]);
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
        $deletedFolder = $this->dropbox->delete("/".$image);
        $deletedFolder->getName();
        $fileStream = fopen($_FILES["image"]["tmp_name"], DropboxFile::MODE_READ);
        $dropboxFile = DropboxFile::createByStream("/".$image, $fileStream);
        $file = $this->dropbox->upload($dropboxFile, "/".$image, ['autorename' => true]);
        $file->getName();
        return redirect()->route('images.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy($image)
    {
        $deletedFolder = $this->dropbox->delete("/".$image);
        $deletedFolder->getName();
        return redirect()->route('images.index');
    }
}
