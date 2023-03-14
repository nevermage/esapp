
<h1>Books <small>({{ $books->count() }})</small></h1>
@forelse ($books as $book)
    <book class="mb-3">
        <h2>{{ $book->title }}
            <span style="color: #fff; background: #4bb1b1; border-radius: 5px; padding: 0 5px; font-size: 22px">
                {{ $book->genre }}
            </span>
        </h2>
        <p class="m-0" style="color: #555555">{{ $book->description }}</p>
        <br>
    </book>
@empty
    <p>No books found</p>
@endforelse
