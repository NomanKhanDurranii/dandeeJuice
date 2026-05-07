import collapse from '@alpinejs/collapse';

// Hook into Livewire's bundled Alpine — do NOT call Alpine.start() ourselves.
document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(collapse);
});
