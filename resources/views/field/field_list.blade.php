<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Field
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
                        <a href="{{ route('field.create') }}" class="btn btn-primary">Add Field</a>
                    </div>

                    <div id="field_list">
                        @include('field.field_partial')
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

        $('button[data-action="delete"]').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('field.destroy', ':id') }}".replace(':id', id);
            var token = $('meta[name="csrf-token"]').attr('content');

            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: token
                },
                success: function(response) {

                    loadRecords(page || 1)
                },
                error: function(xhr, status, error) {

                }
            });
        });

        function loadRecords(page) {
            $.ajax({
                url: "{{ route('field.index') }}?page=" + page,
                type: "GET",
                success: function(data) {
                    $("#field_list").html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function displayAlert(alertType) {
            var alertDialog = $("#alert_dialog");
            var alertMessage = $("#alert_message");
            alertDialog.removeClass("d-none")
            if (alertType == 'success') {
                alertDialog.removeClass("alert-danger")
                alertDialog.addClass("alert-success")
                alertMessage.text("Record added successfully")
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