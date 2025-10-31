@props(['messages'])

@if ($messages)
    <span {{ $attributes->merge(['class' => 'form-error-agri']) }}>
        @foreach ((array) $messages as $message)
            {{ $message }}
        @endforeach
    </span>
@endif
