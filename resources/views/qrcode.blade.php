@extends('layouts.qrcode')
@section('title', 'Qr Code')

@section('content')
<section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            <div class="page-description">
            </div>
            <div class="page-search">
            {!! DNS2D::getBarcodeHTML($url, 'QRCODE', 12, 10) !!}
            <p>Name: {{ $worker->first_name }} </p>
            <p>Contractor: {{ $user->Worker->workerContractor->first_name }}</p>
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
