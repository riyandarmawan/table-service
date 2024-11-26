window.formatToIdr = (value) => {
    if (!value) return '';

    value = String(value).replace(/[^\d]/g, '');

    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
    }).format(value);
}

window.gender = (value) => {
    const gender = {
        l: 'Laki-laki',
        p: 'Perempuan'
    }

    return gender[value] || 'Tidak diketahui';
}

window.chairCapacity = (value) => {
    if (!value) return '';

    value = String(value).replace(/[^\d]/g, '');

    return `${value} Orang`
}