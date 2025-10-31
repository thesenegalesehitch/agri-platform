@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label-agri']) }}>
    {{ $value ?? $slot }}
</label>
