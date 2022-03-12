@extends('layouts.app')
@section('title','Files')
@section('content_header','Update Image File')
@section('content')
    <a class="btn btn-info btn-xl" href="{{ route('files.index') }}">Go Back</a><br><br>
    <form action="{{ route('files.update',$file->id) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group col-xl-6 col-lg-6 col-md-8 col-sm-8 col-12">
            <label for="file">Current Image File</small></label>
            <img src="{{ $file->file_url }}" style="width: 100%;"><br><br>
            <a class="btn btn-outline-success" href="{{ $file->file_url }}"><i class="fa-solid fa-cloud-arrow-down"></i> Download file</a><br><br>
        </div>
        <div class="form-group col-xl-6 col-lg-6 col-md-8 col-sm-8 col-12">
            <label for="filename">Change Image File <small>(Only image file is accept) *</small></label>
            <input type="file" class="form-control @error('filename') is-invalid @enderror" name="filename">
            @if ($errors->has('filename'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('filename') }}</strong>
                </span>
            @endif
        </div>
        <br>
        <div class="form-group col-xl-6 col-lg-6 col-md-8 col-sm-8 col-12">
            <label for="description">Description *</label>
            <textarea type="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                      name="description" placeholder="Type description about this file">{{ old('description',$file->description) }}</textarea>
            @if ($errors->has('description'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <br>
            <button class="btn btn-primary btn-xl"><i class="fa-solid fa-share"></i> Submit</button>
        </div>
    </form>
@endsection
