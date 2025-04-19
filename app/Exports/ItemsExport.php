<?php

  namespace App\Exports;

  use App\Models\Item;
  use Maatwebsite\Excel\Concerns\FromCollection;
  use Maatwebsite\Excel\Concerns\WithHeadings;
  use Maatwebsite\Excel\Concerns\WithMapping;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Storage; // Ensure this is the correct namespace for the Storage facade

  class ItemsExport implements FromCollection, WithHeadings, WithMapping
  {
      public function collection()
      {
          return Auth::user()->is_admin ? Item::with('brand', 'category')->get() : Auth::user()->items()->with('brand', 'category')->get();
      }

      public function headings(): array
      {
          return [
              'Code',
              'Name',
              'Brand',
              'Category',
              'Status',
              'Attachment',
              'Created At',
          ];
      }

      public function map($item): array
      {
          return [
              $item->code,
              $item->name,
              $item->brand->name,
              $item->category->name,
              $item->status,
              $item->attachment ? Storage::disk('public')->url($item->attachment) : 'N/A',
              $item->created_at->toDateTimeString(),
          ];
      }
  }
