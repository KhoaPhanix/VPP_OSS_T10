import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

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
    category: new URLSearchParams(window.location.search).get('category') || '',
    sortBy: new URLSearchParams(window.location.search).get('sort') || 'name',
    searchQuery: new URLSearchParams(window.location.search).get('search') || '',
    
    init() {
        console.log('Product Filters Initialized:', {
            category: this.category,
            sortBy: this.sortBy,
            searchQuery: this.searchQuery
        });
    },
    
    applyFilters() {
        console.log('Applying filters:', {
            category: this.category,
            sortBy: this.sortBy,
            searchQuery: this.searchQuery
        });
        
        const params = new URLSearchParams();
        
        if (this.searchQuery && this.searchQuery.trim() !== '') {
            params.set('search', this.searchQuery.trim());
        }
        
        if (this.category && this.category !== '') {
            params.set('category', this.category);
        }
        
        if (this.sortBy && this.sortBy !== 'name') {
            params.set('sort', this.sortBy);
        }
        
        const queryString = params.toString();
        const newUrl = window.location.pathname + (queryString ? '?' + queryString : '');
        
        console.log('Navigating to:', newUrl);
        window.location.href = newUrl;
    }
}));

// Mobile menu
Alpine.data('mobileMenu', () => ({
    open: false,
    
    toggle() {
        this.open = !this.open;
    }
}));

// Start Alpine
Alpine.start();
