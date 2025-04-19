<!DOCTYPE html>
  <html>
  <head>
      <title>Items Report</title>
      <style>
          table {
              width: 100%;
              border-collapse: collapse;
          }
          th, td {
              border: 1px solid black;
              padding: 8px;
              text-align: left;
          }
          th {
              background-color: #f2f2f2;
          }
      </style>
  </head>
  <body>
      <h1>Items Report</h1>
      <table>
          <thead>
              <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Brand</th>
                  <th>Category</th>
                  <th>Status</th>
                  <th>Attachment</th>
                  <th>Created At</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($items as $item)
                  <tr>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->brand->name }}</td>
                      <td>{{ $item->category->name }}</td>
                      <td>{{ $item->status }}</td>
                      <td>{{ $item->attachment ? Storage::url($item->attachment) : 'N/A' }}</td>
                      <td>{{ $item->created_at->toDateTimeString() }}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
  </body>
  </html>
