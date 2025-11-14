@php
    use Illuminate\Support\Arr;
@endphp
@foreach ($fields as $field)
    <div class="form-group mb-3">
        <label for="{{ $field['name'] }}">
            {{ $field['label'] }}
            @if (!empty($field['required']))
                <span class="text-danger">*</span>
            @endif
        </label>
        @php
            $fieldName = $field['name'];
            $fieldValue = is_array($existingData ?? null) ? Arr::get($existingData, $fieldName, '') : '';
        @endphp

        @if ($field['type'] === 'text')
            <input type="text" name="{{ $fieldName }}" id="{{ $fieldName }}" class="form-control"
                @if (!empty($field['required'])) required @endif placeholder="{{ $field['label'] }}"
                value="{{ $fieldValue }}">
        @elseif ($field['type'] === 'textarea')
            <textarea name="{{ $fieldName }}" id="{{ $fieldName }}" @if (!empty($field['required'])) required @endif
                placeholder="{{ $field['label'] }}" class="form-control {{ $field['advance'] ? 'advance-editor' : '' }}">
                @if ($field['advance'])
{{ $fieldValue ?? '' }}
@else
{!! $fieldValue ?? '' !!}
@endif
</textarea>
        @elseif ($field['type'] === 'number')
            <input type="number" name="{{ $fieldName }}" id="{{ $fieldName }}" class="form-control"
                @if (!empty($field['required']) && !$fieldValue) required @endif value="{{ $fieldValue }}">
		@elseif ($field['type'] === 'date')
            <input type="date" name="{{ $fieldName }}" id="{{ $fieldName }}" class="form-control"
                @if (!empty($field['required']) && !$fieldValue) required @endif value="{{ $fieldValue }}">		
        @elseif ($field['type'] === 'datetime')
            <input type="datetime-local" name="{{ $fieldName }}" id="{{ $fieldName }}" class="form-control"
                @if (!empty($field['required']) && !$fieldValue) required @endif value="{{ $fieldValue }}">	
		@elseif ($field['type'] === 'dropdown')
		
                <select name="{{ $fieldName }}" id="{{ $fieldName }}" 
                        class="form-control" {{ !empty($field['required']) ? 'required' : '' }}>
                    <option value="">Select {{ $field['label'] }}</option>
                    @foreach($field['options'] as $option)
                        <option value="{{ $option }}"
                            {{ (isset($custompostdata->fields_data[$field['name']]) && $custompostdata->fields_data[$field['name']] == $option) ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>

		@elseif ($field['type'] === 'file')
            <input type="file" name="{{ $fieldName }}" id="{{ $fieldName }}" class="form-control"
                @if (!empty($field['required']) && !$fieldValue) required @endif>

            @if ($fieldValue)
                @php
                    $mediaFile = $fieldValue;
                    $mediaPath = asset(Storage::url($mediaFile));
                    $extension = strtolower(pathinfo($mediaFile, PATHINFO_EXTENSION));

                    $mediaType = match (true) {
                        in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => 'image',
                        in_array($extension, ['mp4', 'webm', 'ogg']) => 'video',
                        default => null,
                    };
                @endphp

                @if ($mediaType && $mediaPath)
                    <div class="card mb-3 mt-3 shadow-sm" style="max-width: 400px;">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <strong>Submitted {{ ucfirst($mediaType) }}</strong>
                            <a href="{{ route('manager.cms.custompostdata.media-remove', [$custompostdata->id, $fieldName]) }}"
                                class="btn btn-sm btn-outline-danger" title="Remove Media"
                                onclick="submitMediaRemoveForm('{{ $custompostdata->id }}', '{{ $fieldName }}')">
                                <i class="fas fa-trash-alt"></i> Remove
                            </a>
                        </div>
                        <div class="card-body text-center">
                            @if ($mediaType === 'image')
                                <img src="{{ $mediaPath }}" alt="Submitted Image" class="img-fluid rounded"
                                    style="max-height: 250px;">
                            @elseif($mediaType === 'video')
                                <video controls class="w-100 rounded" style="max-height: 250px;">
                                    <source src="{{ $mediaPath }}" type="video/{{ $extension }}">
                                </video>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
			@elseif ($field['type'] === 'files')
			<input type="file" name="{{ $fieldName }}[]" id="{{ $fieldName }}" class="form-control"
                @if (!empty($field['required']) && !$fieldValue) required @endif multiple >
				@if ($fieldValue)
                
			
			                          @if(is_array($fieldValue))
<div class="row">										  
									  @foreach($fieldValue as $val)
									      
										  @php
											$mediaFile = $val;
											$mediaPath = asset(Storage::url($mediaFile));
											$extension = strtolower(pathinfo($mediaFile, PATHINFO_EXTENSION));

											$mediaType = match (true) {
												in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => 'image',
												in_array($extension, ['mp4', 'webm', 'ogg']) => 'video',
												default => null,
											};
										@endphp

										@if ($mediaType && $mediaPath)
											<div class="col-md-3">
											<div class="card mb-3 mt-3 shadow-sm">
												<div class="card-header d-flex justify-content-between align-items-center bg-light">
													<strong>Gallery {{ ucfirst($mediaType) }}</strong>
													<a href="{{ route('manager.cms.custompostdata.specific-media-remove', [$custompostdata->id, encrypt($mediaFile)]) }}"
														class="btn btn-sm btn-outline-danger" title="Specific Remove Media"
														onclick="submitMediaRemoveForm('{{ $custompostdata->id }}', '{{ encrypt($mediaFile) }}')">
														<i class="fas fa-trash-alt"></i> Remove
													</a>
												</div>
												<div class="card-body text-center">
													@if ($mediaType === 'image')
														<img src="{{ $mediaPath }}" alt="Submitted Image" class="img-fluid rounded"
															style="max-height: 100px;">
													@elseif($mediaType === 'video')
														<video controls class="w-100 rounded" style="max-height: 100px;">
															<source src="{{ $mediaPath }}" type="video/{{ $extension }}">
														</video>
													@endif
												</div>
											</div>
											</div>
										@endif
										  
                                      @endforeach
									  </div>
                                      @endif									  
                @endif
				
				
				
				
        @endif
    </div>
@endforeach