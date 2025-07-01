@extends('layouts.app')

@section('content')
@if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif
<div class="container my-5">
  <div class="card es-bg-desc">
    <div class="card-header d-flex flex-column align-items-center es-bg-desc">
      <img class="img-light" src="{{ asset('images/logo.png') }}" alt="MyApp Logo" height="100">
      <h3 class="es-text">{{ $order->order_number }}</h3>
    </div>
    <div class="card-body">
      <table class="table table-borderless table-sm mt-1" style="--bs-table-bg: none">
        <thead>
          <tr>
            <th>Pesanan</th>
            <th>Uk</th>
            <th class="text-center">Qty</th>
            <th class="text-end">Harga</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->transactions as $txn)
            <tr>
              <td>{{ $txn->menu->name }}</td>
              <td>{{ $txn->size }}</td>
              <td class="text-center">{{ $txn->quantity }}</td>
              <td class="text-end">
                {{ number_format($txn->total_price, 0, ',', '.') }}
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-start">Total:</th>
            <th class="text-end">
              Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </th>
          </tr>
        </tfoot>
      </table>
      <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Tanggal</strong>
          <span>{{ $order->created_at->format('d M Y H:i:s') }}</span>
      </div>
      <div class="d-flex justify-content-between align-items-center">
          <strong>Metode Pembayaran</strong>
          <span>{{ $order->payment_method }}</span>
      </div>
    </div>
          
  </div>
  <div class="d-grid"><button class="btn btn-outline-secondary mt-2" onclick="window.print()">
    Cetak Struk
  </button></div>
</div>
@endsection
