<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Field
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

                    <form data-action="{{ route('field.update', $field->id) }}" method="POST" enctype="multipart/form-data" id="update-field-form">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $field->name }}">
                            <small class="text-danger" id="err-name"></small>
                        </div>

                        <div class="form-group">
                            <label for="fieldtype">FieldType</label>
                            <small class="text-danger" id="err-fieldtype"></small>
                            @foreach($types as $key =>$type)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="fieldtype" value="{{ $type }}" {{ $field->type == $type ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{$key}}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary" id="update_contact">Update Record</button>
                    </form>
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

            var form = '#update-field-form';

            $(form).on('submit', function(event) {
                event.preventDefault();
                hideErrors();
                hideAlert();

                var url = $(this).attr('data-action');
                var formData = new FormData(this);
                formData.append('_method', 'PUT');
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        hideErrors();
                        displayAlert("success")
                    },
                    error: function(err) {
                        if (err.status == 422 && err.responseJSON) {
                            displayError(err.responseJSON);
                        }
                        displayAlert("fail")
                    }
                });
            });

        });

        function displayError(errors) {

            for (const [key, value] of Object.entries(errors)) {
                var element = $("#err-" + key)
                console.log(element)
                if (element) {
                    element.text(value[0])
                }
            }
        }

        function hideErrors() {
            var errElement = [
                "err-name",
                "err-fieldtype",
            ]

            errElement.forEach(function(element) {
                $("#" + element).text('')
            })
        }

        function displayAlert(alertType) {
            var alertDialog = $("#alert_dialog");
            var alertMessage = $("#alert_message");
            alertDialog.removeClass("d-none")
            if (alertType == 'success') {
                alertDialog.removeClass("alert-danger")
                alertDialog.addClass("alert-success")
                alertMessage.text("Record updated successfully")
            }
            if (alertType == 'fail') {
                alertDialog.removeClass("alert-success")
                alertDialog.addClass("alert-danger")
                alertMessage.text("Something Went Wrong")
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