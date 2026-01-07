@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="topbar">
        <marquee direction="left" loop="" behavior=scroll class="marque" bgcolor="#000000">Dimsum + Keju = Dimzzy!  
        Setiap Gigitan Lumer, Setiap Suapan Bikin Nagih! | Yang Beli Dimsum Auto Sigma Loh Ya | Mas Rusdi Pernah Beli Mojito Disini
        | Katanya Sayang, Kok Ga Beliin Pacarnya Mojito Sih | Cintaku Hanya Sebatas Dimsum Keju | Musmid Keju</marquee>
</div>

<div class="flex justify-center items-center h-screen bg-gray-900">
    <canvas id="gameCanvas" width="800" height="600" class="bg-black rounded-lg shadow-lg"></canvas>
</div>

<!-- Include Coupon Modal -->
@include('components.coupon-modal')

@vite('resources/js/pingpong.js')
@endsection
