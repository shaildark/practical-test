<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Field: {{ $contact->name }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div id="field_list">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>

                                <tr>
                                    <td>Name</td>
                                    <td>{{ $contact->name }}</td>
                                </tr>

                                <tr>
                                    <td>Email</td>
                                    <td>{{ $contact->email }}</td>
                                </tr>

                                <tr>
                                    <td>Phone</td>
                                    <td>{{ $contact->phone }}</td>
                                </tr>

                                <tr>
                                    <td>Gender</td>
                                    <td>{{ $contact->gender }}</td>
                                </tr>

                                <tr>
                                    <td>Profile</td>
                                    <td><img src="{{ asset($contact->profile_image) }}" alt="Uploaded Image" width="300"></td>
                                </tr>

                                <tr>
                                    <td>Additional File</td>
                                    <td>
                                        @if($contact->additional_file == null)
                                        No File Uploaded
                                        @else
                                        <a href="{{ asset($contact->additional_file) }}" download class="btn btn-success">
                                            Download File
                                        </a>
                                        @endif
                                    </td>
                                </tr>


                                @if(count($contactCustomData) > 0)
                                <tr rowspan="2">
                                    <td colspan="2"></td>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Custom Fields</td>
                                </tr>

                                @foreach($contactCustomData as $customData)
                                <tr>
                                    <td>{{ $customData['name'] }}</td>
                                    <td>{{ $customData['pivot']['data'] }} {{ $customData['pivot']['isMerged'] == 'yes' ? '(merged)' : '' }}</td>
                                </tr>
                                @endforeach

                                @endif


                                @if(count($additionalInfo) > 0)
                                <tr rowspan="2">
                                    <td colspan="2"></td>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Additional Info</td>
                                </tr>

                                @foreach($additionalInfo as $info)
                                <tr>
                                    <td>{{ $info['type'] }}</td>
                                    <td>{{ $info['value'] }}</td>
                                </tr>
                                @endforeach

                                @endif
                            </tbody>
                        </table>
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

    </script>
</x-app-layout>