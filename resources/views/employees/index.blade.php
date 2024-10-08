<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI Datepicker CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Employee Management</h2>

    <!-- Form to Add/Edit Employee -->
    <div class="card mb-4">
        <div class="card-header">
            <h4 id="formTitle">Add Employee</h4> <!-- Changed dynamically for edit -->
        </div>
        <div class="card-body">
            <form id="employeeForm" method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
                @csrf <!-- Laravel CSRF token -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter employee name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="dob">Date of Birth</label>
                        <input type="text" class="form-control" id="dob" name="dob" placeholder="Select DOB" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="doj">Date of Joining</label>
                        <input type="text" class="form-control" id="doj" name="doj" placeholder="Select DOJ" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="department">Department</label>
                        <select class="form-control" id="department" name="department_id" required>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="designation">Designation</label>
                        <select class="form-control" id="designation" name="designation_id" required>
                            <!-- Options will be loaded dynamically based on department -->
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="image">Upload Image</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Employee</button>
            </form>

        </div>
    </div>

    <!-- Employee List Table -->
    <h3 class="text-center mb-4">Employee List</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Date of Joining</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->gender }}</td>
                    <td>{{ $employee->mobile }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->department->name }}</td>
                    <td>{{ $employee->designation->name }}</td>
                    <td>{{ $employee->doj }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-success btn-sm edit-employee" data-id="{{ $employee->id }}">Edit</button>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- jQuery, Bootstrap JS, and jQuery UI -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    
    $(function() {
        $("#dob, #doj").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    $('#department').on('change', function() {
        var departmentId = $(this).val();
        $.ajax({
            url: '/get-designations/' + departmentId, 
            method: 'GET',
            success: function(data) {
                var designationSelect = $('#designation');
                designationSelect.empty(); 
                $.each(data, function(index, designation) {
                    designationSelect.append('<option value="' + designation.id + '">' + designation.name + '</option>');
                });
            }
        });
    });

    // Handle form submission via AJAX
    $('#employeeForm').on('submit', function(e) {
        e.preventDefault(); 
        
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'), 
            type: $(this).attr('method'),
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(response) {
                alert('Employee saved successfully!');
                location.reload();
            },
            error: function(response) {
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    alert(value[0]);
                });
            }
        });
    });

    // Handle edit button click
    $('.edit-employee').on('click', function(e) {
        e.preventDefault();
        var employeeId = $(this).data('id'); 

        $.ajax({
            url: '/employees/' + employeeId + '/edit',
            method: 'GET',
            success: function(data) {
                $('#name').val(data.employee.name);
                $('#gender').val(data.employee.gender);
                $('#dob').val(data.employee.dob);
                $('#doj').val(data.employee.doj);
                $('#mobile').val(data.employee.mobile);
                $('#email').val(data.employee.email);
                $('#address').val(data.employee.address);
                $('#department').val(data.employee.department_id).trigger('change'); 

                var designationSelect = $('#designation');
                designationSelect.empty();
                $.each(data.designations, function(index, designation) {
                    designationSelect.append('<option value="' + designation.id + '">' + designation.name + '</option>');
                });
                $('#designation').val(data.employee.designation_id); 

                $('#employeeForm').attr('action', '/employees/' + employeeId);
                $('#employeeForm').append('<input type="hidden" name="_method" value="PUT">'); 
                $('#formTitle').text('Edit Employee'); 
            },
            error: function(response) {
            alert('Failed to load employee data. Please try again.');
        }
        });
    });
</script>

</body>
</html>
