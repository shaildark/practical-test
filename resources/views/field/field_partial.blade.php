<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resources as $resource)
        <tr>
            <td>{{ $resource->name }}</td>
            <td>{{ $resource->type }}</td>
            <td>
                <a href="{{ route('field.show', $resource->id) }}" class="btn btn-info">View</a>
                <a href="{{ route('field.edit', $resource->id) }}" class="btn btn-primary">Edit</a>
                <button type="button" class="btn btn-danger" data-action="delete" data-id="{{ $resource->id }}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $resources->links() !!}