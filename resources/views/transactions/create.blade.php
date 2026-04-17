@extends('layouts.app')

@section('content')
<div class="p-8 max-w-xl">

    <h1 class="text-xl font-bold mb-6">Tambah Transaksi</h1>

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf

        <div class="mb-4">
            <label>Kategori</label>
            <select name="category_id" class="w-full border rounded p-2">
                @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>Tipe</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="income">Pemasukan</option>
                <option value="expense">Pengeluaran</option>
            </select>
        </div>

        <div class="mb-4">
            <label>Jumlah</label>
            <input type="number" name="amount" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Tanggal</label>
            <input type="date" name="date" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2"></textarea>
        </div>

        <button class="bg-[#A0522D] text-white px-4 py-2 rounded-xl">
            Simpan
        </button>
    </form>

</div>
@endsection