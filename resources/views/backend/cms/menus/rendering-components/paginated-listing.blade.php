<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Type</th>
			<th>Sorting</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse  ($menus as $key => $menu)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $menu->title }}</td>
                <td>{{ $menu->type == 1 ? 'Header Menu' :
                                       ($menu->type == 2 ? 'Use Links Footer Menu' :
                                       ($menu->type == 3 ? 'Our Services Footer Menu' : 'Unknown Menu')) }}
                                    </td>
				<td>{{ $menu->sorting }}</td>
                <td>
                    <label class="switch">
                        <input type="checkbox" class="status-switch" data-id="{{ $menu->id }}"
                            {{ $menu->status ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </td>
                <td>
                    @can('menu-edit')
                        <a class="btn btn-xs btn-dark" href="{{ route('manager.cms.menus.edit', $menu) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    @endcan
                    @can('menu-delete')
                        <form id="deletemenuForm{{ $key }}" method="POST"
                            action="{{ route('manager.cms.menus.destroy', $menu) }}" style="display:inline">
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
                <td colspan="5" class="text-center">No menus available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $menus->links('pagination::bootstrap-5') }}
