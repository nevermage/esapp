@extends('main')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="form-group">
                    <input
                        id="searchQuery"
                        oninput="search()"
                        type="text"
                        class="form-control"
                        placeholder="Search..."
                    />
                </div>
            </div>
            <br>
            <div class="card-body" id="booksContainer">
                @include('booksList', ['books' => $books])
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">

    async function search() {
        let query = searchQuery.value;
        if (query === '' || query === ' ') return;
        let results = await getResults(query);
        document.getElementById('booksContainer').innerHTML = results;
    }

    async function getResults(query) {
        const response = await fetch('http://elastic.docker/api/search?query=' + query);
        return await response.text();
    }
</script>
