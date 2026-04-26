{{-- Simple Livewire Progress Bar - CSS Only --}}
<style>
    #livewire-progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #F6F930;
        box-shadow: 0 0 8px rgba(246, 249, 48, 0.8);
        transform: translateX(-100%);
        transition: transform 0.2s ease;
        z-index: 9997;
        pointer-events: none;
    }
    
    #livewire-progress-bar.loading {
        animation: livewire-progress 2s ease-in-out infinite;
    }
    
    @keyframes livewire-progress {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(-20%); }
        100% { transform: translateX(0%); }
    }
</style>

<div id="livewire-progress-bar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bar = document.getElementById('livewire-progress-bar');
        
        document.addEventListener('livewire:navigating', function() {
            bar.classList.add('loading');
        });
        
        document.addEventListener('livewire:navigated', function() {
            bar.classList.remove('loading');
            setTimeout(function() {
                bar.style.transform = 'translateX(-100%)';
            }, 300);
        });
    });
</script>
