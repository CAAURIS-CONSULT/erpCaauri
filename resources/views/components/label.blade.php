@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm ','style'=>'color:#fcd45d']) }}>
    {{ $value ?? $slot }}
</label>
