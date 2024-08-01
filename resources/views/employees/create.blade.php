<x-main-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-xl leading-tight">
            {{ __('Create Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Karyawan Baru</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border-b border-gray-200">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="employeeForm" action="{{ route('employees.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="uuid">UUID</label>
                        <input id="uuid" class="form-control" type="text" name="uuid" required autofocus>
                    </div>
                    <div class="mt-4">
                        <label for="name">Name</label>
                        <input id="name" class="form-control" type="text" name="name" required>
                    </div>
                    <div class="mt-4">
                        <label for="DOB">Date of Birth</label>
                        <input id="DOB" class="form-control" type="date" name="DOB" required>
                    </div>
                    <div class="mt-4">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input id="tempat_lahir" class="form-control" type="text" name="tempat_lahir" required>
                    </div>
                    <div class="mt-4">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" required></textarea>
                    </div>
                    <div class="mt-4">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                            <option value="1">Laki-laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center justify-content-end mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmSaveModal">
                            {{ __('Create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-labelledby="confirmSaveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmSaveModalLabel">Confirm Save</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin untuk menyimpan data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmSaveButton">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('confirmSaveButton').addEventListener('click', function() {
            document.getElementById('employeeForm').submit();
        });
    </script>

</x-main-layout>
