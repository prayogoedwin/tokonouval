<x-layouts.app>

    <div class="container">
        <h2>Pilih Toko untuk Kasir</h2>

        <div class="row">
            @foreach($tokos as $toko)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $toko->name }}</h5>
                        <p>{{ $toko->alamat }}</p>
                        <form action="{{ route('kasir.simpantoko') }}" method="POST">
                            @csrf
                            <input type="hidden" name="toko_id" value="{{ $toko->id }}">
                            <button type="submit" class="btn btn-primary">
                                Pilih Toko Ini
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>