                    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Table Name</th>
								<th>Fields</th>
                                <th>Status</th>
								<th>Sorting</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse  ($custompostdatas as $key => $custompostdata)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $custompostdata->custompost->title ?? '' }}</td>
                                    <td>
									@if($custompostdata->fields_data)
<table class="table table-sm">
<tbody>								
@foreach($custompostdata->fields_data as $kkey => $value)
<tr>																			
@if(in_array($kkey, ['gallery', 'images', 'image', 'description']))
        @continue
@endif

@switch($kkey)
        @case('image')
            <th>{{ ucfirst($kkey) }}:</th>
			<td>
			@if(is_array($value))
            @foreach($value as $img)
                <img src="{{ asset('storage/'.$img) }}" width="50">
            @endforeach
			@else
			<img src="{{ asset('storage/'.$value) }}" width="50">							
			@endif
			</td>
            @break

        @case('banner')
            <th>{{ ucfirst($kkey) }}:</th>
            <td><img src="{{ asset('storage/'.$value) }}" width="100"></td>
            @break

        @default
            <th>{{ ucfirst($kkey) }}</th>
			<td>{{ $value }}</td>
    @endswitch
										
										</tr>
										@endforeach
										</tbody>
										</table>
									@else
										Not Data
									@endif
									</td>
									<td>
                                        <label class="switch">
                                            <input type="checkbox" class="status-switch" data-id="{{ $custompostdata->id }}"
                                                {{ $custompostdata->status ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
									<td>{{ $custompostdata->sorting ?? '' }}</td>
                                    <td>
                                        @can('custompost-edit')
                                            <a class="btn btn-xs btn-dark"
                                                href="{{ route('manager.cms.custompostdata.edit', $custompostdata) }}"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('custompost-delete')
                                            <form id="deletecustompostForm{{ $key }}" method="POST"
                                                action="{{ route('manager.cms.custompostdata.destroy', $custompostdata) }}"
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
                                    <td colspan="6" class="text-center">No custompostdata available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $custompostdatas->links('pagination::bootstrap-5') }}
