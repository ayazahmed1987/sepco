                    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Table Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse  ($customposts as $key => $custompost)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $custompost->table_name }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="status-switch" data-id="{{ $custompost->id }}"
                                                {{ $custompost->status ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        @can('custompost-edit')
                                            <a class="btn btn-xs btn-dark"
                                                href="{{ route('manager.cms.customposts.edit', $custompost) }}"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('custompost-delete')
                                            <form id="deletecustompostForm{{ $key }}" method="POST"
                                                action="{{ route('manager.cms.customposts.destroy', $custompost) }}"
                                                style="display:inline">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-xs btn-danger"
                                                    onclick="deleteFunction({{ $key }})"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No customposts available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $customposts->links('pagination::bootstrap-5') }}
