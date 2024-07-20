<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary btn-sm text-danger']) }}>
    {{ $slot }}
</button>
