@if ($errors->any())
    <div class="bg-red-800 text-white p-6 shadow-lg rounded-lg my-6">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif
