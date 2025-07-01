@extends('layouts.app') {{-- or layouts.app --}}

@section('content')
<div class="container my-4">
    <h2 class="mb-4 text-center">STOCK MANAGEMENT</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-borderless align-middle " style="--bs-table-bg: none">
    <thead>
      <tr>
        <th>Es Teh</th>
        <th class="text-center">Stock</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($menus as $menu)
      <tr>
        <td>{{ str_replace('ES TEH', '', $menu->name) }}</td>
        <td class="text-center">{{ $menu->stock }}</td>
        <td class="text-end">
          <button
            type="button"
            class="btn btn-lg btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#editStockModal"
            data-id="{{ $menu->id }}"
            data-name="{{ $menu->name }}"
            data-stock="{{ $menu->stock }}"
          >
            Edit
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{-- Edit Stock Modal --}}
<div class="modal fade" id="editStockModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form
      id="editStockForm"
      method="POST"
      class="modal-content"
    >
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">Edit Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Stock barang dibawah ini akan anda ubah:</p>
        <p><strong id="modalMenuName"></strong></p>

        <div class="mb-2">
        Stock Saat ini: <span id="modalOldStock"></span>
        </div>

        <div class="mb-3">
          <label for="modalNewStock" class="form-label">Stock Baru:</label>
          <input
            type="number"
            min="0"
            class="form-control"
            id="modalNewStock"
            name="stock"
            required
          >
        </div>
      </div>

      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-secondary"
          data-bs-dismiss="modal"
        >Cancel</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal population script --}}
<script>
  document.getElementById('editStockModal')
    .addEventListener('show.bs.modal', function(event){
      const button = event.relatedTarget;
      const id      = button.getAttribute('data-id');
      const name    = button.getAttribute('data-name');
      const stock   = button.getAttribute('data-stock');

      // Set modal text
      this.querySelector('#modalMenuName').textContent = name;
      this.querySelector('#modalOldStock').textContent = stock;
      this.querySelector('#modalNewStock').value    = stock;

      // Set form action to /stock/{id}
      this.querySelector('#editStockForm')
          .action = `/stock/${id}`;
    });
</script>
@endsection
