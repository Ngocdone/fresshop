// Cart quantity update functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity increase
    document.querySelectorAll('.btn-plus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.quantity').querySelector('input');
            const productId = this.getAttribute('data-product-id');
            let currentValue = parseInt(input.value);
            currentValue++;
            updateQuantity(productId, currentValue, input);
        });
    });

    // Handle quantity decrease
    document.querySelectorAll('.btn-minus').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.quantity').querySelector('input');
            const productId = this.getAttribute('data-product-id');
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                currentValue--;
                updateQuantity(productId, currentValue, input);
            }
        });
    });

    // Handle manual input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-product-id');
            let value = parseInt(this.value);
            if (value < 1) value = 1;
            updateQuantity(productId, value, this);
        });
    });

    // Function to update quantity via AJAX
    function updateQuantity(productId, quantity, inputElement) {
        fetch('?page=updateCartQuantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update input value
                inputElement.value = quantity;
                
                // Update total price for this item
                const row = inputElement.closest('tr');
                const priceCell = row.querySelector('td:nth-child(3) p');
                const totalCell = row.querySelector('td:nth-child(5) p');
                
                // Cập nhật tổng tiền cho sản phẩm này
                totalCell.textContent = data.itemTotal.toLocaleString('vi-VN') + ' ₫';
                
                // Update cart total - tìm đúng element
                const totalElements = document.querySelectorAll('.bg-light p');
                totalElements.forEach(el => {
                    const text = el.textContent;
                    if (text.includes('₫') && !text.includes('Flat rate')) {
                        el.textContent = data.cartTotal.toLocaleString('vi-VN') + ' ₫';
                    }
                });
                
                // Cập nhật cả subtotal và total
                const subtotalEl = document.querySelector('.bg-light .d-flex.justify-content-between p:last-child');
                const totalEl = document.querySelector('.bg-light .border-top p:last-child');
                if (subtotalEl) subtotalEl.textContent = data.cartTotal.toLocaleString('vi-VN') + ' ₫';
                if (totalEl) totalEl.textContent = data.cartTotal.toLocaleString('vi-VN') + ' ₫';
            } else {
                alert('Có lỗi xảy ra khi cập nhật số lượng');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật số lượng');
        });
    }
});
