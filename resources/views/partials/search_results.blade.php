<form method="POST" enctype="multipart/form-data" id="imageSearchForm">
    @csrf
    <input type="file" name="image" id="imageSearch" accept="image/*" hidden>
    <label for="imageSearch" class="camera-btn"><i class="fa fa-camera"></i></label>
</form>

<div id="search-results"></div>

<script>
document.getElementById('imageSearch').addEventListener('change', function() {
    const formData = new FormData(document.getElementById('imageSearchForm'));

    fetch("{{ route('image.search') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: formData
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('search-results').innerHTML = html;
    });
});
</script>
