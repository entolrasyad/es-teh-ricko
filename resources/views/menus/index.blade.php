@extends('layouts.app')

@section('content')
<div 
  x-data="cartComponent()"
  class="container my-1"
  style="padding-bottom: 220px;"
>

  {{-- Fixed-bottom Cart Panel --}}
  <div
    x-show="items.length > 0"
    x-cloak
    class="fixed-bottom border-top shadow-sm"
    style="z-index: 1050; background-color: #f1efef"
  >
    <div class="container py-2">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Pesanan ( <span x-text="items.length"></span> )</h5>
        <button @click="items = []" class="btn btn-sm btn-outline-warning btn-orange-outline">Hapus Semua</button>
      </div>
      <div style="max-height: 200px; overflow-y: auto;">
        <table class="table table-sm mb-0" style="--bs-table-bg: none">
          <thead>
            <tr>
              <th>ES TEH</th><th>Uk</th><th>Qty</th><th>Total</th><th></th>
            </tr>
          </thead>
          <tbody class="align-middle">
            <template x-for="(item, index) in items" :key="item.id + item.size">
              <tr>
                <td x-text="item.name.replace('ES TEH ', '').trim()"></td>
                <td x-text="item.size"></td>
                <td x-text="item.quantity"></td>
                <td x-text="new Intl.NumberFormat('id-ID',{ style:'currency',currency:'IDR' }).format(item.total)"></td>
                <td>
                  <button @click="remove(index)" class="btn btn-sm btn-warning btn-orange">×</button>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
        <div class="d-grid align-items-center my-2">
            <button type="button" class="btn btn-lg btn-success btn-green" data-bs-toggle="modal" data-bs-target="#paymentModal">Metode Pembayaran</button>
        </div>
      </div>
    </div>
  </div>
  <h2 class="mb-4 text-center">DAFTAR MENU</h2>

  {{-- Menu Cards --}}
  <div class="row">
    @forelse($menus as $menu)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm es-bg-desc">
          @if($menu->picture)
            <img src="{{ $menu->picture }}" class="card-img-top" alt="{{ $menu->name }}">
          @endif

          <div class="card-body" style="background-color: #f1efef">
            <h4 class="card-title es-menu-name"><strong>{{ $menu->name }}</strong></h4>
            <p class="card-text">{{ $menu->description }}</p>
          </div>
          
          <div class="card-footer text-center h5 es-bg-desc" style="margin-bottom: 0">
            {{-- MEDIUM --}}
            <div class="row align-items-center mb-3">
              <div class="col">Rp {{ number_format($menu->price_medium,0,',','.') }}</div>
              <div class="col"><strong>MEDIUM</strong></div>
              <div class="col-3">
                <button 
                  @click="add(
                    {{ $menu->id }}, 
                    '{{ addslashes($menu->name) }}', 
                    'M', 
                    {{ $menu->price_medium }}
                  )" 
                  class="btn btn-success btn-circle"
                >
                  +
                </button>
              </div>
            </div>
            {{-- LARGE --}}
            <div class="row align-items-center">
              <div class="col">Rp {{ number_format($menu->price_large,0,',','.') }}</div>
              <div class="col"><strong>LARGE</strong></div>
              <div class="col-3">
                <button 
                  @click="add(
                    {{ $menu->id }}, 
                    '{{ addslashes($menu->name) }}', 
                    'L', 
                    {{ $menu->price_large }}
                  )" 
                  class="btn btn-success btn-circle"
                >
                  +
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info">No menu items found.</div>
      </div>
    @endforelse
  </div>

  <form action="{{ route('checkout') }}" method="POST">
    @csrf
    <input type="hidden" name="cart" :value="JSON.stringify(items)">
    <input type="hidden" name="payment_method" x-model="paymentMethod">

     {{-- Payment Method Modal --}}
  <div 
    class="modal fade" 
    id="paymentModal" 
    tabindex="-1" 
    aria-labelledby="paymentModalLabel" 
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header d-flex flex-column align-items-center">
            <img class="img-light" src="{{ asset('images/logo.png') }}" alt="MyApp Logo" height="100">
          <h4 class="modal-title es-text" id="paymentModalLabel" >Pilih Metode Pembayaran</h4>
        </div>
        <div class="modal-body" style="font-size: large">
          {{-- Payment Options --}}
          <div class="mb-3">

            <div>
              <template x-for="method in ['Cash','QRIS','Kartu']" :key="method">
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="radio" 
                    :id="'pm-'+method" 
                    name="payment_method" 
                    :value="method" 
                    x-model="paymentMethod"
                  >
                  <label class="form-check-label" :for="'pm-'+method" x-text="method"></label>
                </div>
              </template>
            </div>
          </div>
          {{-- Grand Total --}}
          <div class="mt-3">
            <strong>Total:</strong>
            <span x-text="new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR'}).format(total())"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button 
            type="button" 
            class="btn btn-secondary" 
            data-bs-dismiss="modal"
          >Cancel</button>
          <button 
            type="submit" 
            class="btn btn-success btn-green" 
            :disabled="!paymentMethod"
          >Konfirmasi Pembayaran</button>
        </div>
      </div>
    </div>
  </div>
</form>
</div>

{{-- Alpine component definition --}}
<script> 
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartComponent', () => ({
            items: [],
            paymentMethod: null,

            add(id, name, size, price) {
                let existing = this.items.find(i => i.id === id && i.size === size);
                console.log(this.items);
                
                if (existing) {
                    existing.quantity++;
                    existing.total = existing.quantity * price;
                } else {
                    this.items.push({ id, name, size, price, quantity: 1, total: price });
                }
            },
            remove(index) {
                this.items.splice(index, 1);
            },
            total() {
                return this.items.reduce((sum, i) => sum + i.total, 0);
            }

        }))
    })
</script>
@endsection