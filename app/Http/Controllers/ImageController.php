<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $app = new DropboxApp(env('DROPBOX_CLIENT_ID'), env('DROPBOX_CLIENT_SECRET'), env('DROPBOX_ACCESS_TOKEN'));

        $dropbox = new Dropbox($app);

        $listFolderContents = $dropbox->listFolder("/");
        $items = $listFolderContents->getItems();
        // dd($items);

        $ret = [];
        foreach ($items as $key => $item) {
            $temporaryLink = $dropbox->getTemporaryLink($item->path_lower);
            $file = $temporaryLink->getMetadata();
            $temporaryLink->getLink();
            array_push($ret, $temporaryLink);
        }


        return view('index', ['ret' => $ret]);
        // dd($ret[0]->metadata);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
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
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
