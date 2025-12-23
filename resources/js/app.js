import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Cart functionality
Alpine.data('cart', () => ({
    count: 0,
    items: [],
    
    init() {
        this.loadCart();
    },
    
    loadCart() {
        // Load from localStorage or API
        const saved = localStorage.getItem('cart');
        if (saved) {
            this.items = JSON.parse(saved);
            this.count = this.items.reduce((sum, item) => sum + item.quantity, 0);
        }
    },
    
    addItem(product, quantity = 1) {
        const existing = this.items.find(item => item.id === product.id);
        if (existing) {
            existing.quantity += quantity;
        } else {
            this.items.push({ ...product, quantity });
        }
        this.saveCart();
    },
    
    removeItem(productId) {
        this.items = this.items.filter(item => item.id !== productId);
        this.saveCart();
    },
    
    updateQuantity(productId, quantity) {
        const item = this.items.find(item => item.id === productId);
        if (item) {
            item.quantity = quantity;
            if (quantity <= 0) {
                this.removeItem(productId);
            }
        }
        this.saveCart();
    },
    
    saveCart() {
        this.count = this.items.reduce((sum, item) => sum + item.quantity, 0);
        localStorage.setItem('cart', JSON.stringify(this.items));
    },
    
    getTotal() {
        return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }
}));

// Product filters
Alpine.data('productFilters', () => ({
    category: '',
    sortBy: 'name',
    searchQuery: '',
    
    applyFilters() {
        const params = new URLSearchParams();
        if (this.category) params.set('category', this.category);
        if (this.sortBy) params.set('sort', this.sortBy);
        if (this.searchQuery) params.set('search', this.searchQuery);
        
        window.location.href = `?${params.toString()}`;
    }
}));

// Mobile menu
Alpine.data('mobileMenu', () => ({
    open: false,
    
    toggle() {
        this.open = !this.open;
    }
}));
