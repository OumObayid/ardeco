@props([
    'type' => 'button',
    'disabled' => false,
    'class' => 'btn-outligne',
    'style' => ''
])

<button 
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }} 
     class="btn-outligne {{ $class }}"
     style = "{{ $style }}"
  
>
    {{ $slot }}
</button>

@push('styles')
<style>
/* Bouton */
/* Bouton */
.btn-outligne {
    background: transparent;
    color: var(--color-accent);
    padding: 5px 20px;
    font-size: 1rem;
    border-radius: 30px;
    border: 1px solid var(--color-accent);
    transition: 0.3s ease-in-out;
    min-width: 8rem;
}

/* Effet au survol */
.btn-outligne:hover {
    background-color: var(--color-accent);
    color: black;
}

/* Style lorsque le bouton est désactivé */
.btn-outligne:disabled {
    background: #ccc;
    border-color: #ccc;
    cursor: not-allowed;
    color: #666;
}

/* Bouton plein */
.btn-plein {
    background-color: var(--color-accent);
    color: black;
    padding: 5px 20px;
    font-size: 1rem;
    border-radius: 30px;
    border: 1px solid var(--color-accent);
    transition: 0.3s ease-in-out;
    min-width: 8rem;
}

/* Effet au survol */
.btn-plein:hover {
    background-color: var(--color-accent-hover);
}

/* Style lorsque le bouton est désactivé */
.btn-plein:disabled {
    background: #ccc;
    border-color: #ccc;
    cursor: not-allowed;
    color: #666;
}
</style>
@endpush
