@extends('layouts.app')

  @section('content')
  <div class="container">
      <h1>Items</h1>
      <div class="row mb-3">
          <div class="col-md-6">
              <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Add New Item</a>
              <a href="{{ route('items.export.csv') }}" class="btn btn-success mb-3">Export CSV</a>
              <a href="{{ route('items.export.excel') }}" class="btn btn-success mb-3">Export Excel</a>
              <a href="{{ route('items.export.pdf') }}" class="btn btn-success mb-3">Export PDF</a>
          </div>
          <div class="col-md-6">
              <form method="GET" action="{{ route('items.index') }}" class="row g-3">
                  <div class="col-md-6">
                      <input type="text" name="search" class="form-control" placeholder="Search by code or name" value="{{ request('search') }}">
                  </div>
                  <div class="col-md-4">
                      <select name="status" class="form-control">
                          <option value="">All Statuses</option>
                          <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                          <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                      </select>
                  </div>
                  <div class="col-md-2">
                      <button type="submit" class="btn btn-primary">Filter</button>
                  </div>
              </form>
          </div>
      </div>
      @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Brand</th>
                  <th>Category</th>
                  <th>Attachment</th>
                  <th>Status</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              @forelse ($items as $item)
                  <tr>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->brand->name }}</td>
                      <td>{{ $item->category->name }}</td>
                      <td>
                          @if ($item->attachment)
                              <a href="{{ Storage::url($item->attachment) }}" target="_blank">View</a>
                          @else
                              N/A
                          @endif
                      </td>
                      <td>{{ $item->status }}</td>
                      <td>
                          <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                          <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('items.destroy', $item) }}">Delete</button>
                      </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="7" class="text-center">No items found.</td>
                  </tr>
              @endforelse
          </tbody>
      </table>
      {{ $items->links() }}

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      Are you sure you want to delete this item?
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <form id="deleteForm" method="POST" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function () {
          const deleteModal = document.getElementById('deleteModal');
          deleteModal.addEventListener('show.bs.modal', function (event) {
              const button = event.relatedTarget;
              const url = button.getAttribute('data-url');
              const form = deleteModal.querySelector('#deleteForm');
              form.action = url;
          });
      });
  </script>
  @endsection
