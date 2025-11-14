<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Thumbnail</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse  ($products as $key => $product)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $product->name ?? '' }}</td>
                <td>{{ $product->slug }}</td>
                <td>
                    @if (
                        $product->thumbnail &&
                            file_exists(public_path('storage/' . str_replace('/', DIRECTORY_SEPARATOR, $product->thumbnail))))
                        <img src="{{ asset(Storage::url($product->thumbnail)) }}" alt="Product thumbnail" width="75"
                            height="75">
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @can('products-create')
                        <a class="btn btn-xs btn-dark" href="{{ route('manager.cms.products.edit', $product) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    @endcan
                    @can('products-delete')
                        <form id="deleteProductForm{{ $key }}" method="POST"
                            action="{{ route('manager.cms.products.destroy', $product) }}" style="display:inline">
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
                <td colspan="5" class="text-center">No products available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $products->links('pagination::bootstrap-5') }}
