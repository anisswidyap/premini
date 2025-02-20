    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Data dosen</h3>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-title">dosen</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#Add_dosen">
                                        Add Data
                                    </button>
                                @else
                                    @if ($existingCustomer)
                                        <p>You have already added your data!</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>nama</th>
                                                <th>jenis kelamin</th>
                                                <th>nidn</th>
                                                <th>foto</th>
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($customers as $row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $row->user->name }}</td>
                                                    <td>{{ $row->phone }}</td>
                                                    <td>{{ $row->address }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $row->photo) }}"
                                                            style="width: 200px; height:auto;">
                                                    </td>
                                                    @if (auth()->user()->isUser())
                                                        <td>
                                                            <label class="badge badge-success" data-bs-toggle="modal"
                                                                data-bs-target="#Edit_Customer{{ $row->id }}">
                                                                Edit
                                                            </label>
                                                            <form action="{{ route('customer.destroy', $row->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="badge badge-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h5>data kosong!</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Placeholder for add, edit, and delete actions
            document.getElementById('addDataButton').addEventListener('click', () => {
                alert('Add Data button clicked!');
            });

            function editData(id) {
                alert('Edit button clicked for ID: ' + id);
            }

            function deleteData(id) {
                if (confirm('Are you sure you want to delete ID: ' + id + '?')) {
                    alert('Deleted ID: ' + id);
                }
            }
        </script>

        <div class="modal fade" id="Add_Customer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add User Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="forms-sample"action="{{ route('customer.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleSelectuser_id">Name</label>
                                <input type="text" class="form-control @error('user_id') is-invalid @enderror"
                                    id="exampleSelectuser_id" name="user_id"
                                    value="{{ old('user_id', Auth::user()->name) }}" readonly>
                                @error('user_id')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail3">Phone</label>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                    id="exampleSelectphone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">addres</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="exampleSelectaddress" name="address" value="{{ old('address') }}">
                                @error('address')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Photo User</label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                    id="exampleSelectphoto" name="photo">
                                @error('photo')
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @foreach ($customers as $row)
            <div class="modal fade" id="Edit_Customer{{ $row->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit User Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="forms-sample" action="{{ route('customer.update', $row->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="exampleSelectuser_id">Name</label>
                                    <input type="text" class="form-control @error('user_id') is-invalid @enderror"
                                        id="exampleSelectuser_id" name="user_id"
                                        value="{{ old('user_id', Auth::user()->name) }}" readonly>
                                    @error('user_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Phone</label>
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                        id="exampleSelectphone" name="phone" value="{{ old('phone', $row->phone) }}">
                                    @error('phone')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputCity1">addresS</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="exampleSelectaddress" name="address"
                                        value="{{ old('address', $row->address) }}">
                                    @error('address')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    @if ($row->photo && Storage::disk('public')->exists($row->photo))
                                        <img src="{{ asset('storage/' . $row->photo) }}"
                                            style="width: 200px; height:auto;"><br>
                                    @else
                                        <p>No photo available</p>
                                    @endif
                                    <label for="exampleInputName1">Photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                        id="exampleSelectphoto" name="photo">
                                    @error('photo')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright &copy; 2025.
                    <!-- partial -->
            </div>
        @endsection
