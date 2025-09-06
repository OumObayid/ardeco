
<!-- declaration des props -->
 @props([
    'type' => 'info',      // valeur par défaut
    'message' => '',        // valeur par défaut
])
<div class="alert alert-{{ $type }}">
    {{ $message }}
</div>