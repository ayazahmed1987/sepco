<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Banner</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse  ($pages as $key => $page)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->slug }}</td>
                <td>
                    @if ($page->image && file_exists(public_path('storage/' . str_replace('/', DIRECTORY_SEPARATOR, $page->image))))
                        <img src="{{ asset(Storage::url($page->image)) }}" alt="Page Banner Image" width="75"
                            height="75">
                    @else
                        N/A
                    @endif

                </td>
                <td>
                    <label class="switch">
                        <input type="checkbox" class="status-switch" data-id="{{ $page->id }}"
                            {{ $page->status ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </td>
                <td>
                    @can('page-edit')
                        <a class="btn btn-xs btn-dark" href="{{ route('manager.cms.pages.edit', $page) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    @endcan
                    @can('page-delete')
                        <form id="deletepageForm{{ $key }}" method="POST"
                            action="{{ route('manager.cms.pages.destroy', $page) }}" style="display:inline">
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
                <td colspan="5" class="text-center">No pages available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $pages->links('pagination::bootstrap-5') }}
