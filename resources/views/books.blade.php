@extends('main')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="form-group">
                    <input
                        id="searchQuery"
                        onchange="search()"
                        onkeyup="this.onchange();"
                        onpaste="this.onchange();"
                        oncut="this.onchange();"
                        oninput="this.onchange();"
                        type="text"
                        class="form-control"
                        placeholder="Search..."
                    />
                </div>
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
        document.getElementById('booksContainer').innerHTML = await getResults(query);
    }

    async function getResults(query) {
        const response = await fetch('http://elastic.docker/api/search?query=' + query);
        return await response.text();
    }
</script>
