@extends('layouts.app')

@section('content')

<div class="topbar">
        <marquee direction="left" loop="" behavior=scroll class="marque" bgcolor="#000000">Dimsum + Keju = Dimzzy!  
        Setiap Gigitan Lumer, Setiap Suapan Bikin Nagih! | Yang Beli Dimsum Auto Sigma Loh Ya | Mas Rusdi Pernah Beli Mojito Disini
        | Katanya Sayang, Kok Ga Beliin Pacarnya Mojito Sih | Cintaku Hanya Sebatas Dimsum Keju | Musmid Keju</marquee>
</div>

<div class="flex flex-col items-center justify-center h-screen text-center">
    <h1 class="text-4xl font-bold mb-4">Selamat Datang di Mini Game Dimzzy!</h1>
    <p class="text-gray-400 mb-6">Pilih game favoritmu dan dapatkan potongan harga dimsum keju 🥙 🎮</p>

    <div class="flex flex-row gap-4">
        <a href="/pingpong" class="bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition">
            Main Pingpong 🏓
        </a>
        <a href="/dimzzsnake" class="bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition">
            Kasih Makan Uler 🐍
        </a>
    </div>
</div>
@endsection
