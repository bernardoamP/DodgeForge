@extends('master')

@section('title', 'Post ressource')
@section('content')

<form method="POST" action="{{ route('postressource') }}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" class="border-gray-600 border-2 block my-2">
    <textarea name="content" cols="30" rows="10" class="border-gray-600 border-2 block my-2"></textarea>

    <label for="avatar">Choose a profile picture:</label>

    <input type="file" class="block my-2"
        id="avatar" name="avatar" 
        accept="image/png, image/jpeg" />

     <button type="submit" class="bg-green-500">Créer</button>
</form>