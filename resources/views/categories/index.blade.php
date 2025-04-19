@extends('layouts.app')

  @section('content')
  <div class="container">
      <h1>Categories</h1>
      <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>
      @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              @forelse ($categories as $category)
                  <tr>
                      <td>{{ $category->code }}</td>
                      <td>{{ $category->name }}</td>
                      <td>{{ $category->status }}</td>
                      <td>
                          <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                          <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('categories.destroy', $category) }}">Delete</button>
                      </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="4" class="text-center">No categories found.</td>
                  </tr>
              @endforelse
          </tbody>
      </table>
      {{ $categories->links() }}

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      Are you sure you want to delete this category?
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
