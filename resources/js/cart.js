document.addEventListener("submit", function (e) { 
    const form = e.target.closest(".form-add-cart"); 
    if (!form) return; 
    e.preventDefault(); // chặn reload 
    addToCart(form); // thêm vào giỏ hàng 
}); 
 
document.addEventListener("click", function (e) { 
    const btn = e.target.closest(".btn-remove-cart"); 
    if (!btn) return; 
    e.preventDefault(); 
    removeCart(btn); // xóa khỏi giỏ hàng 
}); 

// Hàm hiển thị thông báo Toast nổi tự tắt (không cần bấm OK)
function showToast(message, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    const isError = type === 'error';
    const bg = isError 
        ? 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)' 
        : 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
    const icon = isError ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill';

    toast.style.cssText = `
        background: ${bg};
        color: white;
        padding: 12px 22px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 10px;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.4s ease;
        opacity: 0;
        pointer-events: auto;
    `;
    
    toast.innerHTML = `<i class="bi ${icon} fs-5"></i> <span>${message}</span>`;
    container.appendChild(toast);

    // Xuất hiện mượt mà
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
        toast.style.opacity = '1';
    }, 10);

    // Tự động biến mất sau 2.5 giây KHÔNG CẦN BẤM OK
    setTimeout(() => {
        toast.style.transform = 'translateX(120%)';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 400);
    }, 2500);
}
 
function addToCart(form) { 
    const url = form.action; 
    const formData = new FormData(form); 
    fetch(url, { 
        method: "POST", 
        body: formData, 
        headers: { 
            "Accept": "application/json" 
        } 
    }) 
        .then(res => { 
            if (!res.ok) throw new Error("HTTP " + res.status); 
            return res.json(); 
        }) 
        .then(data => { 
            // update cart count 
            const cartCount = document.getElementById("cart-count"); 
            if (cartCount && data.cartCount !== undefined) { 
                cartCount.innerText = data.cartCount; 
            } 
            // Hiển thị Toast thông báo tự tắt mượt mà (không cần bấm OK)
            showToast(data.message || 'Đã thêm sản phẩm vào giỏ hàng!'); 
        }) 
        .catch(err => { 
            console.error("Lỗi:", err); 
            showToast("Không thể thêm vào giỏ hàng!", "error");
        }); 
} 
 
function removeCart(btn) { 
    if (!confirm("Bạn có chắc muốn xóa sản phẩm này?")) { 
        return; 
    } 
    const url = btn.dataset.url; 
    fetch(url, { 
        method: "DELETE", 
        headers: { 
            "Accept": "application/json", 
            "X-CSRF-TOKEN": document 
                .querySelector('meta[name="csrf-token"]') 
                .content 
        } 
    }) 
        .then(res => { 
            if (!res.ok) { 
                throw new Error("HTTP " + res.status); 
            } 
            return res.json(); 
        }) 
        .then(data => { 
            if (!data.status) { 
                showToast(data.message, "error"); 
                return; 
            } 
            // Xóa dòng sản phẩm 
            btn.closest("tr").remove(); 
            // Cập nhật số lượng trên Navbar 
            const cartCount = document.getElementById("cart-count"); 
            if (cartCount) { 
                cartCount.innerText = data.cartCount; 
            } 
            // Cập nhật tổng số lượng 
            const totalQuantity = document.getElementById("totalQuantity"); 
            if (totalQuantity) { 
                totalQuantity.innerText = data.cartCount; 
            } 
            // Cập nhật tổng tiền 
            const total = document.getElementById("total"); 
            if (total) { 
                total.innerText = 
                    Number(data.total).toLocaleString("vi-VN") + " đ"; 
            } 
            
            showToast(data.message || 'Đã xóa sản phẩm khỏi giỏ hàng!');

            // Nếu giỏ hàng trống thì tải lại trang 
            if (data.isEmpty) { 
                setTimeout(() => location.reload(), 1000); 
            } 
        }) 
        .catch(err => { 
            console.error(err); 
            showToast("Có lỗi xảy ra khi xóa sản phẩm!", "error"); 
        }); 
}
