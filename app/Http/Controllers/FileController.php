<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\StorageService;
use App\Http\Requests\FileRequest;
use App\Http\Requests\FileUpdateRequest;

class FileController extends Controller
{
    protected readonly File $file;
    protected readonly StorageService $storage_service;
    protected readonly string $file_path;

    public function __construct(File $file, StorageService $storage_service)
    {
        $this->file = $file;
        $this->storage_service = $storage_service;
        $this->file_path = "files/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = $this->file->all();
        if($files->count()>0){
            foreach($files as $item){
                $item->file_url = $this->storage_service->getAwsFile($this->file_path,$item->filename);
                $item->extension = "." .substr(strrchr($item->filename, "."), 1);
            }
        }
        return view('files.index',['files'=>$files]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        $this->storage_service->saveAwsFile($this->file_path,$request->filename);
        $this->file->create([
            'filename'      =>  $request->filename->getClientOriginalName(),
            'description'   =>  $request->description
        ]);
        return redirect()->route('files.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        $file->file_url = $this->storage_service->getAwsFile($this->file_path,$file->filename);
        return view('files.edit',['file'=>$file]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FileUpdateRequest $request, File $file)
    {
        $data = $request->all();
        if($request->filename){
            $this->storage_service->deleteAwsFile($this->file_path,$file->filename);
            $this->storage_service->saveAwsFile($this->file_path,$request->filename);
            $data['filename']=$request->filename->getClientOriginalName();
        }
        $file->update($data);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $this->storage_service->deleteAwsFile($this->file_path,$file->filename);
        $file->delete();
        return redirect()->route('files.index');
    }
}
