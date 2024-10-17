@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $document->name }}</h1>

    <div class="document-content">
        <!-- Assuming the document has a 'content' field or similar -->
        <p>{{ $document->content }}</p>
    </div>

    <a href="{{ route('user.documents.index') }}" class="btn btn-secondary mt-4">Back to Documents</a>
</div>
@endsection
