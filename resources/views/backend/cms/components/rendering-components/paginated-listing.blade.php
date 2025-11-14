<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Component Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse  ($components as $key => $component)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $component->component_name }}</td>
                <td>
                    <label class="switch">
                        <input type="checkbox" class="status-switch" data-id="{{ $component->id }}"
                            {{ $component->status ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </td>
                <td>
                    @can('component-edit')
                        <a class="btn btn-xs btn-dark" href="{{ route('manager.cms.components.edit', $component) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    @endcan
                    @can('component-delete')
                        <form id="deletecomponentForm{{ $key }}" method="POST"
                            action="{{ route('manager.cms.components.destroy', $component) }}" style="display:inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="deleteFunction({{ $key }})"><i class="fa fa-trash"></i></button>
                        </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No components available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $components->links('pagination::bootstrap-5') }}
