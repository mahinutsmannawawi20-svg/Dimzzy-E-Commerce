@extends('layouts.app')

@section('content')
<style>
    html, body {
        overflow: hidden;
        height: 100%;
    }
</style>

<div class="topbar">
        <marquee direction="left" loop="" behavior=scroll class="marque" bgcolor="#000000">Dimsum + Keju = Dimzzy!  
        Setiap Gigitan Lumer, Setiap Suapan Bikin Nagih! | Yang Beli Dimsum Auto Sigma Loh Ya | Mas Rusdi Pernah Beli Mojito Disini
        | Katanya Sayang, Kok Ga Beliin Pacarnya Mojito Sih | Cintaku Hanya Sebatas Dimsum Keju | Musmid Keju</marquee>
</div>

<div class="flex justify-center items-center h-screen bg-gray-900">
    <canvas id="snakeCanvas" width="800" height="600" class="bg-black rounded-lg shadow-lg"></canvas>
</div>

@vite('resources/js/dimzzsnake.js')
@endsection
