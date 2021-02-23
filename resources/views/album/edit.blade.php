@extends('layouts.main')

@section('title')
    Editing {{ $album->title }}
@endsection

@section('content')
    <form action="{{ route('album.update', [ 'id' => $album->id ]) }}" method="POST">
        {{-- put csrf directive otherwise will get 419 page expired --}}
        {{-- generates a token that the backend will keep track of and when u submit form, it's gonna submit token to server and server will check if token submitted in form matches what was generated. --}}
        @csrf
        <div class="mb-3">
            {{-- for and id attribute go hand in hand. name attribute is for server side stuff --}}
            {{-- added value old to input so it saves/persists what user typed if request didn't go thru --}}
            {{-- old data that user types that's saved is called flashed session data --}}
            <label for="title" class="form-label">Title</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="form-control" 
                value="{{ old('title', $album->title) }}" 
                {{-- 2nd value is default val --}}
            > 
            @error('title')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="artist" class="form-label">Artist</label>
            <select name="artist" id="artist" class="form-select">
                <option value="">-- Select Artist --</option>
                @foreach($artists as $artist)
                    <option 
                        value="{{$artist->id}}"
                        {{-- ternary statement to keep old data that user typed --}}
                        {{-- use double equal so it doesn't compare type or convert to string --}}
                        {{ (int) $artist->id === (int) old('artist', $album->artist_id) ? "selected" : "" }}
                    >
                        {{$artist->name}}
                    </option>
                @endforeach
            </select>
            @error('artist')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </form>
@endsection