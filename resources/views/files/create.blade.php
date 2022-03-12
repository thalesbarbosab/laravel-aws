@extends('layouts.app')
@section('title','Files')
@section('content_header','Create Image File')
@section('content')
    <a class="btn btn-info btn-xl" href="{{ route('files.index') }}">Go Back</a><br><br>
    <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group col-xl-6 col-lg-6 col-md-8 col-sm-8 col-12">
            <label for="filename">Image File <small>(Only image file is accept) *</small></label>
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
                      name="description" placeholder="Type description about this file">{{ old('description') }}</textarea>
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
