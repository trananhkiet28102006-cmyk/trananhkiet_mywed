document.querySelectorAll('.img-input').forEach(input => {
    input.addEventListener('change', function () {
        const imgGroup = this.closest('.img-group');
        if (!imgGroup) return;
        
        const preview = imgGroup.querySelector('.img-preview');
        if (!preview) return;

        preview.innerHTML = '';

        Array.from(this.files).forEach(file => {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.width = 150;
            img.style.margin = '5px';
            img.className = 'img-thumbnail';
            preview.appendChild(img);
        });
    });
});
