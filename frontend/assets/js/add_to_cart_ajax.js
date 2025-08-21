// Thêm sản phẩm vào giỏ hàng bằng AJAX
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form[action="?page=addcar"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('?page=addcart', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text();
                }
            })
            .then(data => {
                // Nếu không redirect, có thể hiển thị thông báo hoặc cập nhật giỏ hàng
                console.log('Add to cart response:', data);
                // Reload trang giỏ hàng để cập nhật
                window.location.href = '?page=cart';
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
            });
        });
    });
});
