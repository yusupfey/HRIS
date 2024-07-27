<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
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

            <div class="p-3 bg-white border-bottom border-gray-200">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="employeeForm" action="{{ route('employees.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" class="form-control form-control-lg" type="text" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="DOB" class="form-label">Tanggal lahir</label>
                        <input id="DOB" class="form-control form-control-lg" type="date" name="DOB" value="{{ old('DOB') }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input id="tempat_lahir" class="form-control form-control-lg" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control form-control-lg" rows="3" required>{{ old('alamat') }}</textarea>
                    </div>
                    <div class="mb-2">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select form-select-lg" required>
                            <option value="1" {{ old('jenis_kelamin') == 1 ? 'selected' : '' }}>Laki-laki</option>
                            <option value="2" {{ old('jenis_kelamin') == 2 ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#confirmSaveModal">
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

    <style>
        .form-control-lg, .form-select-lg {
            border-width: 1px;
            border-color: #e3e3e3; /* Lighter border color for minimalistic look */
            border-radius: 0.2rem; /* Smaller border-radius for a sharper look */
            padding: 0.5rem 1rem; /* Larger padding for bigger input fields */
            font-size: 1.25rem; /* Larger font size for better readability */
        }
        .form-control-lg {
            height: calc(1.5em + 1rem + 2px); /* Adjust height for larger input fields */
        }
        .btn-lg {
            padding: 0.5rem 1rem; /* Larger padding for bigger buttons */
            font-size: 1.25rem; /* Larger font size for better readability */
        }
    </style>

    <script>
        document.getElementById('confirmSaveButton').addEventListener('click', function() {
            document.getElementById('employeeForm').submit();
        });
    </script>

</x-main-layout>
