<x-main-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:font-weight-bold sm:px-6 lg:px-8 lg:font-weight-light">
            <div class=" dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">


                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" style="border-radius:10px;">
                                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom:20px;">
                                    <h5>
                                        <a href="#" id="newEmployeeBtn" class="btn btn-success" style="margin-top: 10px">New Employee</a>
                                    </h5>
                                    <h5 class="card-title" style="margin-right: 20px;">Data Table Karyawan</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Data Karyawan</h5>
                                    <!-- Table with stripped rows -->
                                    <table class="table datatable table-hover table-striped" style="margin-top: 20px;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>UUID</th>
                                                <th>Nama</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Tempat Lahir</th>
                                                <th>Alamat</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Aksi</th>
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
                                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $employee->uuid }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $employee->uuid }}">
                                                            <li>
                                                                <a href="{{ route('employees.edit', $employee->uuid) }}" class="dropdown-item">
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Anda yakin hapus data ini?');">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </div>
        </div>
    </div>


 </x-main-layout>


