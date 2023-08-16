<form action="{{ url('/import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv_file">
    <button type="submit">Import</button>
</form>

<a href="{{ url('/export') }}">Export</a>