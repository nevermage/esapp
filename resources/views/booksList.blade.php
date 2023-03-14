
<h1>Books <small>({{ $books->count() }})</small></h1>
@forelse ($books as $book)
    <book class="mb-3">
        <h2>{{ $book->title }} <span style="color: #777777">{{ $book->genre }}</span></h2>
        <h3></h3>
        <p class="m-0">{{ $book->description }}</p>
    </book>
@empty
    <p>No books found</p>
@endforelse
