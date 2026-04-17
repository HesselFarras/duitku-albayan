<h1>Kategori</h1>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Nama kategori">

    <select name="type">
        <option value="income">Pemasukan</option>
        <option value="expense">Pengeluaran</option>
    </select>

    <button type="submit">Tambah</button>
</form>

<hr>

@foreach($categories as $c)
    <div>
        {{ $c->name }} ({{ $c->type }})
    </div>
@endforeach