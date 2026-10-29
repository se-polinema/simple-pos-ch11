@props(['product', 'size' => 'w-10 h-10', 'textSize' => 'text-sm'])
@if ($product->image_url)
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
         class="{{ $size }} object-cover rounded-md shrink-0">
@else
    <div class="{{ $size }} rounded-md bg-brass-soft flex items-center justify-center shrink-0">
        <span class="font-display font-semibold text-brass {{ $textSize }}">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($product->name, 0, 1)) }}</span>
    </div>
@endif
