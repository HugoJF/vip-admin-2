@extends('layouts.app')

@section('content')
    <textarea name="aaaa" id="mde" cols="30" rows="10"></textarea>
@endsection

@push('scripts')
    <script>
        var editor = new Editor({
            element: document.getElementById('mde'),
        });
        editor.render();
    </script>
@endpush