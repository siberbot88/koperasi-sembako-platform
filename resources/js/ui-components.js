// Register Alpine.js components
document.addEventListener('alpine:init', () => {
    // Toast Container
    Alpine.data('toastContainer', () => ({
        toasts: [],
        add(message, type, duration) {
            if (type === undefined) type = 'success';
            if (duration === undefined) duration = 4000;
            const id = Date.now() + Math.random();
            this.toasts.push({ id, message, type, progress: 100, removing: false });
            
            const interval = setInterval(() => {
                const toast = this.toasts.find(t => t.id === id);
                if (toast) toast.progress -= (100 / (duration / 50));
            }, 50);
            
            setTimeout(() => {
                clearInterval(interval);
                this.remove(id);
            }, duration);
        },
        remove(id) {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) toast.removing = true;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 300);
        },
        icon(type) {
            const icons = {
                success: "<svg class='w-5 h-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor'><path fill-rule='evenodd' d='M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z' clip-rule='evenodd'/></svg>",
                error:   "<svg class='w-5 h-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor'><path fill-rule='evenodd' d='M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z' clip-rule='evenodd'/></svg>",
                warning: "<svg class='w-5 h-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor'><path fill-rule='evenodd' d='M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z' clip-rule='evenodd'/></svg>",
                info:    "<svg class='w-5 h-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor'><path fill-rule='evenodd' d='M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5A.75.75 0 0 0 12 9Z' clip-rule='evenodd'/></svg>"
            };
            return icons[type] || icons.info;
        },
        colors(type) {
            const map = {
                success: 'bg-koperasi-accent border-koperasi-dark text-koperasi-dark',
                error:   'bg-red-50 border-red-700 text-red-800',
                warning: 'bg-yellow-50 border-yellow-600 text-yellow-800',
                info:    'bg-blue-50 border-blue-600 text-blue-800'
            };
            return map[type] || 'bg-white border-koperasi-dark text-koperasi-dark';
        },
        progressColor(type) {
            const map = {
                success: 'bg-koperasi-dark/30',
                error:   'bg-red-400',
                warning: 'bg-yellow-400',
                info:    'bg-blue-400'
            };
            return map[type] || 'bg-koperasi-dark/30';
        },
        iconColor(type) {
            const map = {
                success: 'text-koperasi-dark',
                error:   'text-red-600',
                warning: 'text-yellow-600',
                info:    'text-blue-600'
            };
            return map[type] || 'text-koperasi-dark';
        }
    }));

    // Offline Banner
    Alpine.data('offlineBanner', () => ({
        offline: false,
        reconnecting: false,
        init() {
            window.addEventListener('online',  () => { this.offline = false; this.reconnecting = false; });
            window.addEventListener('offline', () => { this.offline = true;  this.reconnecting = false; });
        },
        tryReconnect() {
            this.reconnecting = true;
            setTimeout(() => {
                if (!navigator.onLine) this.reconnecting = false;
            }, 3000);
        }
    }));

    // Livewire Progress
    Alpine.data('livewireProgress', () => ({
        loading: false,
        progress: 0,
        timer: null,
        start() {
            this.loading = true;
            this.progress = 15;
            clearInterval(this.timer);
            this.timer = setInterval(() => {
                if (this.progress < 85) this.progress += Math.random() * 8;
            }, 200);
        },
        finish() {
            clearInterval(this.timer);
            this.progress = 100;
            setTimeout(() => { 
                this.loading = false; 
                this.progress = 0; 
            }, 300);
        }
    }));

    // Livewire Error
    Alpine.data('livewireError', () => ({
        show: false,
        type: 'connection',
        retrying: false,
        countdown: 0,
        timer: null,
        init() {
            document.addEventListener('livewire:connection-failed', () => {
                this.type = 'connection';
                this.show = true;
                this.startCountdown(10);
            });
            document.addEventListener('livewire:request-failed', (e) => {
                if (e.detail && e.detail.status >= 500) {
                    this.type = 'server';
                    this.show = true;
                }
            });
        },
        startCountdown(seconds) {
            this.countdown = seconds;
            clearInterval(this.timer);
            this.timer = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) {
                    clearInterval(this.timer);
                    this.retry();
                }
            }, 1000);
        },
        retry() {
            this.retrying = true;
            clearInterval(this.timer);
            window.location.reload();
        },
        dismiss() {
            this.show = false;
            clearInterval(this.timer);
        }
    }));

    // Confirm Dialog
    Alpine.data('confirmDialog', () => ({
        open: false,
        title: '',
        message: '',
        confirmText: 'Ya, Lanjutkan',
        cancelText: 'Batal',
        type: 'danger',
        onConfirm: null,
        show(detail) {
            this.title       = detail.title       || 'Konfirmasi';
            this.message     = detail.message     || 'Apakah Anda yakin?';
            this.confirmText = detail.confirmText || 'Ya, Lanjutkan';
            this.cancelText  = detail.cancelText  || 'Batal';
            this.type        = detail.type        || 'danger';
            this.onConfirm   = detail.onConfirm   || null;
            this.open = true;
        },
        confirm() {
            if (this.onConfirm) eval(this.onConfirm);
            this.open = false;
        },
        cancel() {
            this.open = false;
        },
        btnClass() {
            const map = {
                danger:  'bg-red-600 hover:bg-red-700 text-white border-red-700',
                warning: 'bg-yellow-500 hover:bg-yellow-600 text-koperasi-dark border-yellow-600',
                info:    'bg-blue-600 hover:bg-blue-700 text-white border-blue-700'
            };
            return map[this.type] || 'bg-koperasi-primary text-koperasi-dark border-koperasi-dark';
        },
        iconClass() {
            const map = {
                danger:  'bg-red-100 text-red-600',
                warning: 'bg-yellow-100 text-yellow-600',
                info:    'bg-blue-100 text-blue-600'
            };
            return map[this.type] || 'bg-koperasi-accent text-koperasi-dark';
        }
    }));
});
