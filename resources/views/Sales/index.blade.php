<form action="{{route('sales.upload')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv">
    <button type="submit">Upload</button>
</form>