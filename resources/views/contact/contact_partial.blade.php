<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resources as $resource)
        <tr>
            <td>{{ $resource->name }}</td>
            <td>{{ $resource->email }}</td>
            <td>{{ $resource->phone }}</td>
            <td>{{ $resource->gender }}</td>
            <td>
                <a href="{{ route('contact.show', $resource->id) }}" class="btn btn-info">View</a>
                <a href="{{ route('contact.edit', $resource->id) }}" class="btn btn-primary">Edit</a>
                <button type="button" class="btn btn-danger" data-action="delete" data-id="{{ $resource->id }}">Delete</button>
                <button type="button" class="btn btn-secondary" data-action="merge" data-id="{{ $resource->id }}">Merge Contact</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $resources->links() !!}