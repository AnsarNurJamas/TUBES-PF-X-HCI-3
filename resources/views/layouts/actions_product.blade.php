<form action="{{ route('Product.destroy', $product) }}" method="POST">
    @csrf
    @method('delete')
    <a style="background-color: rgba(53, 142, 224, 1)" class="btn btn-sm btn-dark far fa-edit" href="{{route('Product.edit', $product)}}"></a>
    <button type="submit" class="mx-3 btn btn-sm btn-primary btn-delete" data-name="{{ $product->kodeproduk.' '.$product->name }}">
        <i class="bi-trash"></i>
    </button>
</form>
