<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contact
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="alert alert-success alert-dismissible d-none" id="alert_dialog">
                        <div id="alert_message"></div>
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" id="dismiss_alert">&times;</a>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Enter search keyword">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-select" aria-label="Default select example">
                                <option value="">Select option</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="search_contact">Search</button>
                        </div>
                    </div>

                    <br>
                    <br>

                    <div>
                        <a href="{{ route('contact.create') }}" class="btn btn-primary">Add Contact</a>
                    </div>
                    <br>
                    <div id="contact_list">
                        @include('contact.contact_partial')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mergeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Merge Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-body-content">
                    <div class="form-group">
                        <input type="hidden" name="child_contact" id="child_contact" value="">
                        <label for="master_contact">Master Contacts</label>
                        <select name="master_contact" id="master_contact" class="form-select" aria-label="Default select example">
                            <option value="">Select option</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="merge_contact">Merge</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#dismiss_alert").click(function() {
                hideAlert()
            })
        });

        $("#search_contact").click(function() {

            const currentPage = new URL(window.location);
            currentPage.searchParams.delete('page');
            window.history.pushState({}, '', currentPage);

            var search = $("#search").val();
            var gender = $('select[name="gender"]').val();
            var url = "{{ route('contact.index') }}";

            if (search == "" && gender == "") {
                return
            }

            if (search != "") {
                url += "?search=" + search;
            }

            if (gender != "") {
                if (search != "") {
                    url += "&gender=" + gender
                } else {

                    url += "?gender=" + gender
                }
            }

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $("#contact_list").html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });

        $('button[data-action="delete"]').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('contact.destroy', ':id') }}".replace(':id', id);
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: token
                },
                success: function(response) {
                    loadRecords()
                },
                error: function(xhr, status, error) {

                }
            });
        });

        $('button[data-action="merge"]').click(function() {
            var id = $(this).data('id');

            $("#child_contact").val(id);
            var modal = new bootstrap.Modal(document.getElementById('mergeModal'));

            var route = "{{ route('contact.getContactList', ':id') }}".replace(':id', id);

            $.ajax({
                url: route,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#master_contact');
                    select.empty();
                    select.append('<option value="">Select option</option>'); // Default option
                    if (data.contacts && data.contacts.length > 0) {
                        data.contacts.forEach(function(item) {
                            select.append('<option value="' + item.id + '">' + item.name + '</option>');
                        });
                        modal.show();
                    }
                },
                error: function() {
                    alert('Failed to fetch contacts.');
                }
            });

        });

        $("#merge_contact").click(function() {
            var child_contact = $("#child_contact").val();
            var master_contact = $("#master_contact").val();
            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('child_contact', child_contact);
            formData.append('master_contact', master_contact);
            var modal = bootstrap.Modal.getInstance(document.getElementById('mergeModal'));

            var url = "{{ route('contact.mergeContact') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    modal.hide();
                    loadRecords()
                    displayAlert("success", "Contact merged successfully.")
                },
                error: function(xhr, status, error) {
                    displayAlert("fail", "Something went Wrong.")
                    modal.hide();
                    console.error(xhr.responseText);
                }
            });
        });

        function loadRecords() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page');
            if (page == null) {
                page = 1
            }

            var url = "{{ route('contact.index') }}?page=" + page;

            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $("#contact_list").html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function displayAlert(alertType, message = "") {
            var alertDialog = $("#alert_dialog");
            var alertMessage = $("#alert_message");
            alertDialog.removeClass("d-none")
            if (alertType == 'success') {
                alertDialog.removeClass("alert-danger")
                alertDialog.addClass("alert-success")
                alertMessage.text(message)
            }
            if (alertType == 'fail') {
                alertDialog.removeClass("alert-success")
                alertDialog.addClass("alert-danger")
                alertMessage.text(message)
            }
        }

        function hideAlert() {
            var alertDialog = $("#alert_dialog");
            alertDialog.addClass("d-none");
            var alertMessage = $("#alert_message");
            alertMessage.text("")
        }
    </script>
</x-app-layout>