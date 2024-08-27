<x-main-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:font-weight-bold sm:px-6 lg:px-8 lg:font-weight-light">
            <div class="bg-primary dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" style="border-radius:10px;">
                                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title">Data Table Karyawan</h5>
                                    {{-- <a href="{{ route('employees.create') }}" class="btn btn-success" style="margin-top: 10px">New Employee</a> --}}
                                </div>
                                <div class="card-body">
                                    <table class="table datatable table-hover table-striped" style="margin-top: 20px;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>UUID</th>
                                                <th>Name</th>
                                                <th>DOB</th>
                                                <th>Tempat Lahir</th>
                                                <th>Alamat</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <td>{{ $employee->id }}</td>
                                                    <td>{{ $employee->uuid }}</td>
                                                    <td>{{ $employee->name }}</td>
                                                    <td>{{ $employee->DOB }}</td>
                                                    <td>{{ $employee->tempat_lahir }}</td>
                                                    <td>{{ $employee->alamat }}</td>
                                                    <td>{{ $employee->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $employee->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Actions
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $employee->id }}">
                                                                <li>
                                                                    @php
                                                                        $uuid = Session::get('uuid');
                                                                        $employeeExists =  \App\Models\Employee::where('uuid', $uuid)->exists();;

                                                                    @endphp
                                                                    <a href="{{ $employeeExists ? route('employees.edit', ['uuid' => $uuid]) : route('employees.create', ['uuid' => $uuid]) }}" class="dropdown-item">Edit</a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Anda yakin hapus data ini?');">Delete</button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-main-layout>
